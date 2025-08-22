@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2>Email Verification</h2>
        @if(session('status') == 'verification-link-sent')
            <div class="alert alert-success">A new verification link has been sent to your email address.</div>
        @endif
        <p>Before proceeding, please check your email for a verification link.</p>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Resend Verification Email</button>
            </div>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link">Log Out</button>
        </form>
    </div>
</div>
@endsection