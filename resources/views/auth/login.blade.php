@extends('auth.auth-master')

@section('content-box')

    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>Admin-</b>Login</a>
        </div><!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>
            {!! Form::open(['route'=>'postLogin', 'method'=>'post']) !!}
                <div class="form-group has-feedback">
                    <input required value="{{ old('email') }}"
                           type="email" name="email"
                           class="form-control" placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input required
                           type="password" name="password"
                           class="form-control" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    {{--<div class="col-xs-8">--}}
                        {{--<div class="checkbox icheck">--}}
                            {{--<label>--}}
                                {{--<input type="checkbox" name="remember_me"> Remember Me--}}
                            {{--</label>--}}
                        {{--</div>--}}
                    {{--</div><!-- /.col -->--}}
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div><!-- /.col -->
                </div>
            {!! Form::close() !!}

            @if(session()->has('error'))
                <div class="social-auth-links text-center">
                    <p class="text-danger">- Error -</p>
                    <div class="alert alert-danger">
                        <p>{{ session()->get('error') }}</p>
                    </div>
                </div>
            @endif
        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

@endsection