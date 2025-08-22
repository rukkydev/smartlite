@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2>Two-Factor Authentication</h2>
        <p>Please enter the code from your authenticator app or a recovery code.</p>
        @if($errors->any())
            <div class="alert alert-danger">
                {!! implode('', $errors->all('<div>:message</div>')) !!}
            </div>
        @endif
        <form method="POST" action="{{ route('two-factor.login') }}">
            @csrf
            <div class="form-group">
                <label for="code">Code</label>
                <input type="text" name="code" id="code" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Verify</button>
            </div>
        </form>
    </div>
</div>
@endsection