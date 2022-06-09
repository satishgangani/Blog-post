@extends('layouts.app')

@section('content')
<div class="relative flex items-top justify-center sm:items-center pt-0 py-4 sm:pt-0">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between">
            <form action="{{route('home.filter')}}" method="get" id="filter-form">
                @csrf
                <select onchange=formSubmit() name="filter" id="filter" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                    @forelse ($tags as $tag)
                        @if($loop->first)
                            <option selected disabled hidden>Filter Posts by Tags</option>
                            @if(isset($currentFilter))
                                <option value="all">Select All</option>
                            @endif
                        @endif
                        <option value="{{$tag->title}}" @if(isset($currentFilter) && $tag->title == $currentFilter) selected @endif>{{$tag->title}}</option>
                    @empty
                        <option selected disabled hidden>No Tags Found.</option>
                    @endforelse
                </select>
            </form>
            @auth
                <a href="{{route('post.create')}}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Create Post">Create Post</a>
            @endauth
        </div>
        @forelse ($posts as $post)
            <div class="card mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg" onclick="redirect(this)" data-post="{{route('post.index',['post' => encrypt($post->id)])}}">
                <div class="grid grid-cols-1">
                    <div class="p-6 border-t border-gray-200 border-t-0 border-l">
                        <div class="grid grid-cols-1">
                            <div class="row p-3 pb-0 leading-7 text-gray-900">
                                <div class="col-md-9 col-9 col-sm-9 text-lg underline font-semibold">
                                    <div>{{$post->title}}</div>
                                </div>
                                <div class="col-sm-3 col-3 col-md-3" style="direction:rtl">
                                    <span class="px-2"><a href="mailto:?subject=I wanted you to see this site&amp;body=Check out this post: {{route('post.index',['post' => encrypt($post->id)])}}"><i class="fa-solid fa-share-nodes"></i></a></span>
                                    @auth
                                        @if(Auth::user()->id == $post->author_id)
                                            @if($post->comments->count() == 0)
                                                <form style="all:unset" action="{{route('post.destroy',['post' => encrypt($post->id)])}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this post?')">
                                                        <span class="px-2"><i class="fa-regular fa-trash-can"></i></span>
                                                    </button>
                                                </form>
                                            @endif
                                            <span class="px-2"><a href="{{route('post.edit',['post' => encrypt($post->id)])}}"><i class="fa-regular fa-pen-to-square"></i></a></span>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                            <div class="p-3 pt-0 text-sm font-thin text-black">By {{$post->user->name}}</div>
                        </div>

                        <div class="p-3 pt-0">
                            <div class="text-gray-600 text-sm post-desc">
                                {!!short_string($post->description, 300, 'read more')!!}
                            </div>
                        </div>
                        <div class="p-3 pt-0">
                            <div class="text-gray-600 text-sm comments-counter">
                                {{$post->comments->count()}} Comment(s)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
        <div class="card mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="grid grid-cols-1">
                <div class="p-6 border-t border-gray-200 border-t-0 border-l">
                    <div class="grid grid-cols-1">
                        No Post Found.
                    </div>
                </div>
            </div>
        </div>
        @endforelse
        <div class="mt-8">
            {{ $posts->links('pagination::simple-tailwind') }}
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function redirect(obj){
        window.location.href = obj.getAttribute('data-post');
    }
    function formSubmit(){
        document.getElementById('filter-form').submit();
    }
</script>
@endsection