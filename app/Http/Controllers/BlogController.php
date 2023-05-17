<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\DeleteBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    public function index(Request $request, Blog $blog)
    {
        $this->authorize('view', $blog);

        $blogs = Blog::query();

        // If a search query is present, filter the results
        if ($request->input('search')) {
            $searchQuery = $request->input('search');
            $blogs->where('title', 'LIKE', "%{$searchQuery}%")
                ->orWhere('content', 'LIKE', "%{$searchQuery}%");
        }

        $user = auth()->user();
        $roles = $user->roles;
        
        if ($user->isAdmin()) {
            $blogs = $blogs->orderByDesc('created_at')->paginate(5);
        } else {
            $blogs = $blogs->where('author_id', $user->id)->orderByDesc('created_at')->paginate(5);
        }

        return view('blogs.index', compact('blogs'));
    }


    public function create(Blog $blog)
    {
        $this->authorize('create', $blog);


        $currentUser = auth()->user()->id;;
        $data = \App\Models\User::find($currentUser);
        $blogs = $data->Blog;
        $isPremium = $data->UserSubscription->isPremium ?? false;
        if (!$isPremium && (!is_null($blogs) && count($blogs) >= 3)) {
            abort(403, 'Unauthorized Action');
        }

        return view('blogs.create', ['content' => old('content')]);
    }

    public function store(StoreBlogRequest $request, Blog $blog)
    {
        $this->authorize('create', $blog);

        $input = $request->all();
        $input['author_id'] = auth()->user()->id;

        if ($image = $request->file('image')) {
            $destinationPath = 'storage/blog-photos/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }
     
        Blog::create($input);

        return redirect()->route('blogs.index')->with('success', "The blog post '{$request->title}' has been added successfully.");
    }

    public function show(Blog $blog)
    {
        $this->authorize('viewAny', $blog);

        return view('blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    { 
        $this->authorize('edit', $blog);

        return view('blogs.edit', compact('blog'));
    }

    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $this->authorize('update', $blog);

        $input = $request->all();
   
        if ($image = $request->file('image')) {
            $destinationPath = 'storage/blog-photos/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }else{
            unset($input['image']);
        }
           
        $blog->update($input);
    
        return redirect()->route('blogs.index')->with('success', "The blog post has been updated successfully.");
    }

    public function destroy(Blog $blog)
    {
        $this->authorize('delete', $blog);

        $blog->delete();

        return redirect()->route('blogs.index')->with('destroyed', "The blog post '{$blog->title}' has been deleted successfully.");
    }
    
}
