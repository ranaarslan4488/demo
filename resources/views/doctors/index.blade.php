@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Top Doctors: Choose Your Specialist</h2>
    <p class="lead">
        Select a top doctor from the list below to make an appointment. Our experienced and highly qualified medical professionals are here to assist you.
    </p>
    <div class="row">
        @foreach ($doctors as $doctor)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('images/doctor-placeholder.png') }}" class="card-img-top" alt="Doctor Image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $doctor->name }}</h5>
                        <p class="card-text">{{ $doctor->email }}</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Fee:</strong> ${{ $doctor->doctor_details->fees ?? 'Not specified' }}
                            </li>
                            <li class="list-group-item">
                                <strong>Check Duration:</strong> {{ $doctor->doctor_details->check_time_duration ?? 'Not specified' }}
                            </li>
                        </ul>
                        <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-primary mt-3">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
