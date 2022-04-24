@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Two-Factor Authentication</div>

                @if (session('message'))
                <div class="alert alert-{{ $alert_type}}">
                    {{ $alert_message }}
                </div>
                @endif

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                        
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <br>
                            @if (Auth::user()->google2fa_secret)
                                <div class="alert alert-success">
                                    2FA is currently <strong>enabled</strong> on your account.
                                </div>
                                <p>If you are looking to disable Two Factor Authentication. Please confirm your password and Click Disable 2FA Button.</p>
                                <form class="form-horizontal" method="POST" action="{{ route('2fa.disable') }}">
                                    @csrf
                                    <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                        <label for="change-password" class="control-label">Current Password</label>
                                            <input id="current-password" type="password" class="form-control col-md-4" name="current-password" required>
                                            @if ($errors->has('current-password'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('current-password') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                    <button type="submit" class="btn btn-primary ">Disable 2FA</button>
                                </form>

                            @else
                            <a href="{{ url('2fa/enable') }}" class="btn btn-primary">Enable 2FA</a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
