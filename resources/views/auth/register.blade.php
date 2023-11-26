@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-md-8">
            <div class="alert alert-success mt-4">
                <h4 class="alert-heading">Doctor Registration</h4>
            </div>
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

    

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Working Days</label>
                            <div class="col-md-6">
                                @php
                                    $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                @endphp

                                @foreach($daysOfWeek as $day)
                                    <div class="form-check">
                                        <input {{ in_array(strtolower($day), old('days', [])) ? 'checked' : '' }} class="form-check-input" type="checkbox" name="days[]" value="{{ strtolower($day) }}" id="{{ strtolower($day) }}">
                                        <label class="form-check-label" for="{{ strtolower($day) }}">{{ $day }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="start_time" class="col-md-4 col-form-label text-md-end">{{ __(' Start Time') }}</label>

                            <div class="col-md-6">
                                <input id="start_time" value="{{ old('start_time') }}"  type="time" class="form-control @error('start_time') is-invalid @enderror" name="start_time">

                                @error('start_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="end_time" class="col-md-4 col-form-label text-md-end">{{ __(' End Time') }}</label>

                            <div class="col-md-6">
                                <input id="end_time" value="{{ old('end_time') }}" type="time" class="form-control @error('end_time') is-invalid @enderror" name="end_time">

                                @error('end_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="check_time_duration" class="col-md-4 col-form-label text-md-end">{{ __('Check Time Duration') }} in minutes</label>

                            <div class="col-md-6">
                                <input id="check_time_duration" value="{{ old('check_time_duration') }}" type="numuber"  class="form-control @error('check_time_duration') is-invalid @enderror" name="check_time_duration">

                                @error('check_time_duration')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fees" class="col-md-4 col-form-label text-md-end">{{ __('Charges') }}</label>

                            <div class="col-md-6">
                                <input id="fees"  type="number" value="{{ old('fees') }}" step="any" class="form-control @error('fees') is-invalid @enderror" name="fees">

                                @error('fees')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection