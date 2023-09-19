@extends('layouts.login_app')

@section('content')

<div class="content">

    <div class="logo">
        <img src="{{ $logo }}" width="120" alt="logo" />
    </div>

    <form class="form-vertical login-form" action="{{ route('login') }}" method="post">
        @csrf

        <h3 class="form-title">
            <small>Academe Access - Back Office</small>
        </h3>

        @if($errors->any())
            <div class="alert alert-sm alert-danger fade in">
                <i class="icon-remove close" data-dismiss="alert"></i>
                @foreach($errors->all() as $error)
                    <li style="display: inline;">{{ $error }}</li><br>
                @endforeach
            </div>
        @endif

        @if( Session::has("error") )
            <div class="alert alert-danger fade in">
                <i class="icon-remove close" data-dismiss="alert"></i>
                <li style="display: inline;">{!! Session::get("error") !!}</li>
            </div>
        @endif

        <div class="alert fade in alert-danger" style="display: none;">
            <i class="icon-remove close" data-dismiss="alert"></i>
            Enter any username and password.
        </div>

        <div class="form-group">
            <div class="input-icon">
                <i class="icon-user"></i>
                <input
                    type="text"
                    name="loginDual"
                    value="{{ old('loginDual') }}"
                    class="form-control"
                    placeholder="Email / Username"
                    autofocus="autofocus"
                    data-rule-required="true"
                    data-msg-required="Please enter your username or email."
                />
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon">
                <i class="icon-lock"></i>
                <input type="password" name="password" id="passwordField" class="form-control" placeholder="Password" data-rule-required="true" data-msg-required="Please enter your password." />
                <a href="#" class="pull-right" onclick="handlePasswordToggle()" id="hidePassToggle">show password</a>
            </div>
        </div>

        <div style="margin-bottom: 30px;"></div>
        <hr/>

        <div class="form-actions">
            <button type="submit" id="loginBtn" class="submit btn btn-block btn-info pull-right">
                Log In
            </button>
        </div>
    </form>
</div>

<script type="text/javascript" src="{{ asset('template/assets/js/libs/jquery-1.10.2.min.js') }}"></script>
<script type="text/javascript">

function handlePasswordToggle() {
    var x = document.getElementById("passwordField");
    var hidePassLink = $('a#hidePassToggle');
    x.type === "password" ? x.type = "text" : x.type = "password";
    x.type === "password" ? hidePassLink.text('show password') : hidePassLink.text('hide password');
}

</script>

@stop

@section('other-links')
<div class="single-sign-on">
    <a href="{{ url('/') }}" class="btn btn-default btn-block">
       Attendance Page
    </a>
</div>
@stop