@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2>Welcome, {{ auth()->user()->name }}!</h2>
        @if(auth()->user()->two_factor_secret)
            <p>Two-Factor Authentication is enabled.</p>
            <form method="POST" action="{{ route('two-factor.disable') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Disable 2FA</button>
            </form>
            <h3>Recovery Codes</h3>
            <ul class="list-group">
                @foreach(json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                    <li class="list-group-item">{{ $code }}</li>
                @endforeach
            </ul>
        @else
            <form method="POST" action="{{ route('two-factor.enable') }}">
                @csrf
                <button type="submit" class="btn btn-primary">Enable 2FA</button>
            </form>
        @endif
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link mt-3">Log Out</button>
        </form>
    </div>
</div>
@endsection