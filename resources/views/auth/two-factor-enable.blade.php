@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2>Enable Two-Factor Authentication</h2>
        <p>Scan the QR code with your authenticator app.</p>
        <div>{!! auth()->user()->twoFactorQrCodeSvg() !!}</div>
        <form method="POST" action="{{ route('two-factor.confirm') }}">
            @csrf
            <div class="form-group">
                <label for="code">Verification Code</label>
                <input type="text" name="code" id="code" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Confirm 2FA</button>
            </div>
        </form>
    </div>
</div>
@endsection