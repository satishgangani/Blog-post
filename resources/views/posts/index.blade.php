@extends('layouts.app', ['title' => $post->title])

@section('content')
<div class="relative flex items-top justify-center sm:items-center py-4 sm:pt-0">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex">
            <a href="{{route('home')}}" aria-label="Back" class="px-4 py-2 mr-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">Back</a>
            @auth
                @if(Auth::user()->id == $post->author_id)
                    <a href="{{route('post.edit',['post' => encrypt($post->id)])}}" class="px-4 py-2 mr-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Edit Post">Edit Post</a>
                    @if($post->comments->count() == 0)
                    <form action="{{route('post.destroy',['post' => encrypt($post->id)])}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this post?')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Delete Post">Delete Post</button>
                    </form>
                    @endif
                @endif
            @endauth
        </div>
        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="grid grid-cols-1">
                <div class="p-6 border-t border-gray-200 border-t-0 border-l">
                    <div class="grid grid-cols-1">
                        <div class="p-3 pb-0 text-lg leading-7 font-semibold underline text-gray-900">{{$post->title}}</div>
                        <div class="p-3 pt-0 text-sm font-thin text-black">By {{$post->user->name}}</div>
                    </div>

                    <div class="p-3 pt-0">
                        <div class="text-gray-600 text-sm post-desc">
                            {!!$post->description!!}
                        </div>
                    </div>
                    <div class="px-3 pt-1 pb-3 inline-block">
                        @forelse ($post->tags as $tag)
                            <span class="post-tags px-2" onclick=formSubmit(this)>{{getTagName($tag)}}</span>
                        @empty
                        
                        @endforelse
                        <form action="{{route('home.filter')}}" method="get" id="filter-form">
                            @csrf
                            <input type="hidden" name="filter" id="filter">
                        </form>
                    </div>
                </div>
                <div class="p-6 pt-0">
                    <span class="p-3 text-lg font-semibold text-gray-700">Comments</span>
                    <div class="row px-3 py-2 text-center">
                        <div class="col-9 col-md-9 col-sm-9">
                            <input type="text" name="comment" id="comment" class="form-control">
                        </div>
                        <div class="col-3 col-md-3 col-sm-3">
                            <button id="commentSubmit" onclick=postComment(this) data-post="{{encrypt($post->id)}}" class="px-4 py-2 mr-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">Post Comment</button>
                        </div>
                    </div>
                    <div class="comments-show px-3">
                        @forelse ($post->comments as $comment)
                            <div class="p-3 pb-0 text-lg leading-7 text-gray-900">{{$comment->user->name}}</div>
                            <div class="p-3 pt-0 text-sm font-thin text-black">{{$comment->comment}}</div>
                            <hr class="px-3">
                        @empty
                            
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $('#comment').keydown(function(ev){
            if(ev.which == 13 || ev.keycode == 13){
                postComment($('#commentSubmit'));
            }
        });
        function postComment(obj){
            let token = "{{csrf_token()}}";
            let url = "{{route('comment.store')}}";
            let data = {
                comment : $('#comment').val(),
                post : $(obj).data('post'),
            };
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': token,
                },
            })
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                dataType: 'json',
                success: function (data) {
                    let str = '<div class="p-3 pb-0 text-lg leading-7 text-gray-900">'+data.user+'</div>';
                    str += '<div class="p-3 pt-0 text-sm font-thin text-black">'+data.comment+'</div>';
                    str += '<hr class="px-3">';
                    $('.comments-show').prepend(str);
                    $('#comment').val('');
                },
                error: function (data){
                    if(data.status === 401){
                        window.location.href = "{{route('login')}}";
                    }
                }
            });
        }

        function formSubmit(obj){
            $('#filter').val($(obj).html());
            $('#filter-form').submit();
        }
    </script>
@endsection
