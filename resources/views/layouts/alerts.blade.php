@if (Session::get('success'))
<div class="alert alert-success alert-block" id="alert">
    @foreach(Session::get('success') as $success)
        <strong>{{ $success }}</strong>
    @endforeach
</div>
@endif

@if (Session::get('error'))
<div class="alert alert-danger alert-block" id="alert">
    @foreach(Session::get('success') as $success)
        <strong>{{ $success }}</strong>
    @endforeach
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-block" id="alert">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif

@if (Session::get('warning'))
<div class="alert alert-warning alert-block" id="alert">
    {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}

    <strong>{{ $message }}</strong>
</div>
@endif

@if (Session::get('info'))
<div class="alert alert-info alert-block" id="alert">

    {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}

    <strong>{{ $message }}</strong>
</div>
@endif

