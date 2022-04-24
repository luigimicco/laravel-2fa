@extends('layouts.app')

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="card card-default">
                <div class="card-header">2FA with Google Authenticator</div>
                <p>Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.</p>

                <div class="card-body">
                    2FA has been removed
                    <br /><br />
                    <a href="{{ url('/home') }}">Back to Home</a>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection