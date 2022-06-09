@extends('layouts.app', ['title' => 'New Post'])

@section('content')
<div class="container">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <a href="{{route('home')}}" aria-label="Back" class="px-4 py-2 mr-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">Back</a>
        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="grid grid-cols-1">
                <div class="p-6 border-t border-gray-200 border-t-0 border-l">
                    <div class="grid grid-cols-1">
                        <form action="{{route('post.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="title">Title *</label>
                                <input class="form-control" type="text" name="title" id="title" required autofocus value="{{old('title')}}">
                            </div>
                            <div class="form-group">
                                <label for="description">Description *</label>
                                <textarea class="form-control" name="description" required id="description">{{old('description')}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="tags">Tags *</label>
                                <select name="tags[]" id="tags" class="form-control" multiple>
                                    @foreach ($tags as $tag)
                                        <option value="{{encrypt($tag->id)}}">{{$tag->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="post_date">Date *</label>
                                <input class="form-control" type="date" name="post_date" required id="post_date" value={{today()}} max="{{today()}}">
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="//cdn.ckeditor.com/4.18.0/basic/ckeditor.js"></script>
    <script>
        $(document).ready(function(){
            CKEDITOR.replace('description');
        })
    </script>
@endsection
