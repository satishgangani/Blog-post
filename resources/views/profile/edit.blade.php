@extends('layouts.app', ['title' => 'Profile Update'])

@section('content')
<div class="container">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <a href="{{route('home')}}" aria-label="Back" class="px-4 py-2 mr-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">Back</a>
        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="grid grid-cols-1">
                <div class="p-6 border-t border-gray-200 border-t-0 border-l">
                    <div class="grid grid-cols-1">
                        <form action="{{route('profile.update')}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name *</label>
                                <input class="form-control" type="text" name="name" id="name" required autofocus value="{{old('name', Auth::user()->name)}}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input class="form-control" type="email" name="email" id="email" required value="{{old('email', Auth::user()->email)}}">
                            </div>
                            <div class="row">
                                <div class="col-md-9 col-9 col-sm-9">
                                    <div class="form-group">
                                        <label for="password">Password *</label>
                                        <input class="form-control" type="hidden" readonly name="password_req" id="password_req" value="0">
                                        <input class="form-control" type="password" name="password" id="password" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3 col-3 col-sm-3 change_pass">
                                    <div class="form-group">
                                        <a href="javascript:void(0)" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" onclick=changePassword()>Change Password</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group confirmation row pt-0">
                                <div class="col-md-9 col-9 col-sm-9">
                                    <label for="password_confirmation">Comfirm Password *</label>
                                    <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" disabled>
                                </div>  
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
<script>
    function changePassword(){
        $('#password').prop('disabled', !$('#password').prop('disabled'));
        $('#password_confirmation').prop('disabled', !$('#password_confirmation').prop('disabled'));
        $('#password').prop('required', !$('#password').prop('required'));
        $('#password_confirmation').prop('required', !$('#password_confirmation').prop('required'));
        if($('#password').prop('required')){
            $('.confirmation').show();
            $('#password_req').val('1');
        }
        else{
            $('.confirmation').hide();
            $('#password_req').val('0');
        }
    }
</script>
@endsection
