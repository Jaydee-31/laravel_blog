<x-app-layout>


    @php
    $user = auth()->user();
    $currentUser = auth()->user()->id;
    $data = \App\Models\User::find($currentUser);
    $isPremium = $data->UserSubscription->isPremium ?? false;
    @endphp

    
    @section('title')
    Manage Blogs
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Blogs') }}
        </h2>
    </x-slot>
    {{-- <div class="flex justify-center">

        @if (!$isPremium && count($blogs) >= 3)
        <div class="ml-auto font-bold px-12 py-3 max-w-sm text-slate-400 bg-slate-50 rounded-xl shadow-lg flex">
            Debt
        </div>
        @else
        <a class="ml-auto" href="/editor">
            <x-button-link href="{{ route('blogs.create') }}" class="">
                {{ __('Create a Blog') }}
            </x-button-link>   
        </a>
        @endif
        @unless ($isPremium)
        <a class="ml-5" href="/subscribe">
            <div
                class="font-bold px-12 py-3 max-w-sm bg-amber-100 rounded-xl shadow-lg flex items-center hover:bg-amber-200">
                <h1>GO PREMIUM</h1>
            </div>
        </a>
        @else
        <div class="font-bold px-12 py-3 max-w-sm bg-emerald-200 rounded-xl shadow-lg ml-5 flex items-center">
            <h1>PREMIUM</h1>
        </div>
        @endunless
    </div> --}}


    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between mb-8 px-5 sm:px-0 ">
                <div>
                    @if (!$isPremium && (!is_null($blogs) && count($blogs) >= 3) && !$user->isAdmin() )
                
                      
                    @else
                        <x-button-link href="{{ route('blogs.create') }}" class="">
                            {{ __('Create a Blog') }}
                        </x-button-link>   
                    @endif

                    @if ($isPremium || $user->isAdmin())
                        <x-button-premium class="disabled ml-5">
                            {{ __('PREMIUM') }}
                        </x-button-premium> 
                       
                 
                    @else
                        <x-button-link  href="/subscribe" class="ml-5 bg-amber-600 dark:bg-amber-400 dark:hover:bg-green-400">
                            {{ __('GO PREMIUM') }}
                        </x-button-link>
                    @endif
                </div>
                
                <div class="max:w-md">
                    <form class="flex" action="{{ route('blogs.index') }}" method="GET">  
                        <label for="search-input" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input type="text" name="search" id="search-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-rose-500 focus:border-rose-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-rose-500 dark:focus:border-rose-500" placeholder="Search">
                        </div>
                        <button type="submit" class="p-2.5 ml-2 text-sm font-medium text-white bg-rose-700 rounded-lg border border-rose-700 hover:bg-rose-800 focus:ring-4 focus:outline-none focus:ring-rose-300 dark:bg-rose-600 dark:hover:bg-rose-700 dark:focus:ring-rose-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <span class="sr-only">Search</span>
                        </button>
                    </form>

                </div>
                
            </div>
            
            @if ($message = Session::get('success'))
                <x-alert-success>
                    {{ $message }}
                </x-alert-success>
            @endif

            @if ($message = Session::get('destroyed'))
                <x-alert-delete>
                    {{ $message }}
                </x-alert-delete>
            @endif

            @if($blogs->isEmpty())
                <x-alert-empty class="bg-gray-50 border dark:bg-gray-800 border-gray-400 dark:border-gray-500 text-gray-700  dark:text-gray-400">
                    No Blogs found.
                </x-alert-empty>
            @else  
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 dark:border-gray-900 sm:rounded-xl">
                            
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 w-full">
                                    <thead class="bg-gray-100 dark:bg-pink-900 text-gray-700 dark:text-gray-300 opacity">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                                ID
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                                Image
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                                Title
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                                Content
                                            </th>
                                            @can('admin_access')
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                                    Author
                                                </th>
                                            @endcan
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                
                                            </th>
                                        </tr>
                                    </thead>
                
                                    <tbody class="bg-white dark:bg-gray-800 dark:bg-opacity-50 divide-y divide-gray-200 dark:divide-gray-700">                           
                                        @foreach ($blogs as $blog)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {{ $blog->id }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                <img src="storage\blog-photos\{{$blog->image}}" class="max:w-8 max-h-7 rounded-lg">
                                            </td>
                
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white max-w-xs overflow-ellipsis truncate">
                                                {{ $blog->title }}
                                            </td>
                
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white max-w-xs overflow-ellipsis truncate">
                                                {{ $blog->content }}
                                            </td>

                                            @can('admin_access')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                    {{ $blog->author->name }}
                                                </td>
                                            @endcan
                                            
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('blogs.show', $blog->id) }}" class="text-rose-500 dark:text-rose-400 hover:text-rose-900 mb-2 mr-2">View</a>
                                                <a href="{{ route('blogs.edit', $blog->id) }}" class="text-amber-600 dark:text-amber-500 hover:text-amber-900 mb-2 mr-2">Edit</a>
                                                <form class="inline-block" action="{{ route('blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 cursor-pointer mb-2 mr-2" value="Delete">
                                                </form>
                                            </td>
                                        </tr>                                        
                                        @endforeach
                                    </tbody>
                                </table> 
                
                            </div>
                            @if ($blogs->total() > 5)
                                <div class="items-center px-4 py-3 bg-gray-50 dark:bg-gray-900 text-right mt-3 shadow sm:rounded-xl">
                                    {{ $blogs->onEachSide(5)->links() }}  
                                </div>
                            @endif
                        
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
