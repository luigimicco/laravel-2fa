@extends('layouts.app')

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">2FA Secret Key</div>

                <div class="panel-body">

                    @if(!Auth::user()->google2fa_secret)

                        Open up your 2FA mobile app and scan the following QR barcode:
                        <br />
                        If your 2FA mobile app does not support QR barcodes, 
                        enter in the following number: <code>{{ $secret }}</code>
                        <br /><br />

                        <div class="visible-print text-center">
                            {!! $image !!}
                        </div>
                        
                        <form class="form-horizontal" method="post" action="{{ route('2fa.store') }}">
                            @csrf
                            <div class="form-group{{ $errors->has('verify-code') ? ' has-error' : '' }}">
                                <input type="hidden" name="secretcode" value="{{ $secret }}">
                                <label for="secret" class="control-label">Authenticator Code</label>
                                <input id="secret" type="text" class="form-control col-md-4" name="secret" required>
                                @if ($errors->has('verify-code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('verify-code') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <br />
                            <button type="submit" class="btn btn-primary">Enable 2FA</button>
                        </form>
                    @else
                        <div class="alert alert-success">
                            2FA is currently <strong>enabled</strong> on your account.
                        </div>
                        <form class="form-horizontal" method="post" action="{{ route('2fa.disable') }}">
                            @csrf;
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