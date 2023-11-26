<!-- resources/views/success.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="alert alert-success mt-4">
            <h4 class="alert-heading">Payment Successful!</h4>
            <p>Your payment has been processed successfully.</p>
        </div>
        <div class="alert alert-info mt-4">
            <h5 class="alert-heading">Login Information</h5>
            <p>You can now log in with the following credentials:</p>
            <ul>
                <li>Email: Your Email</li>
                <li>Password: password</li>
            </ul>
            <p class="mt-4">
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            </p>
            <p><strong>Note:</strong> It is recommended to change your password after the first login.</p>
        </div>
    </div>
@endsection
