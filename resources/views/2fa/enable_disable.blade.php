@extends('layouts.app')

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="card card-default">
                <div class="card-header">2FA with Google Authenticator</div>

                <div class="card-body">

                    <p>Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.</p>

                    @if(!Auth::user()->google2fa_secret)

                        <div class="row">
                            <div class="col-6">

                                1. Scan this QR code with your Google Authenticator App. Alternatively, you can use the code:: <strong><code>{{ $secret }}</code></strong>
                                <br /><br />
        
                                <div class="visible-print text-center">
                                    {!! $image !!}
                                </div>
                                
                                <form class="form-horizontal" method="post" action="{{ route('2fa.set2FA') }}">
                                    @csrf
                                    <div class="form-group{{ $errors->has('verify-code') ? ' has-error' : '' }}">
                                        <input type="hidden" name="secretcode" value="{{ $secret }}">
                                        <label for="secret" class="control-label">2. Enter the pin from Google Authenticator app:</label>
                                        <input id="secret" type="text" class="form-control col-md-4" name="secret" required>
                                        @if ($errors->has('verify-code'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('verify-code') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-primary">Enable 2FA</button>
                                </form>                                

                            </div>
                            <div class="col-6">
                                
                                <div class="text-center">
                                    <p>Get Google Authenticator</p>
                                    <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=it&gl=US"><img src="{{ asset("images/playstore.png")}}" alt=""></a>
                                    <a href="https://apps.apple.com/it/app/google-authenticator/id388497605"><img src="{{ asset("images/applestore.png")}}" width="153" height="46" alt=""></a>
                                </div>
                                
                            </div>

                        </div>

                    @else
                        <div class="alert alert-success">
                            2FA is currently <strong>enabled</strong> on your account.
                        </div>
                        <form class="form-horizontal" method="post" action="{{ route('2fa.unset2FA') }}">
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
                            <br />
                            <button type="submit" class="btn btn-primary ">Disable 2FA</button>
                        </form>
                    @endif

                    <br />
                    <a href="{{ url('/home') }}">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection