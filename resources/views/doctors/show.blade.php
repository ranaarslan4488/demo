<!-- resources/views/doctors/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-4">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <img  width="270" src="{{ asset('images/doctor-placeholder.png') }}" class="card-img-top" alt="Doctor Image">
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
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Make an Appointment</h2>
                    <form action="{{ route('appointments.store', $doctor) }}" method="post">
                        @csrf

                        <div class=" mb-3">
                            <label for="name" class="form-label">{{ __(' Your Name') }}</label>
                            <input id="name" value="{{ old('name') }}"  type="text" class="form-control @error('name') is-invalid @enderror" name="name">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __(' Your Email') }}</label>
                            <input id="email" value="{{ old('email') }}"  type="email" class="form-control @error('email') is-invalid @enderror" name="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                           
                        </div>

                        
                        
                        <div class="mb-3">
                            <label for="appointmentDate" class="form-label">Appointment Date</label>
                            <input id="appointment_date" value="{{ old('appointment_date') }}" type="date"  class="form-control @error('appointment_date') is-invalid @enderror"  name="appointment_date" required>
                        
                            @error('appointment_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="appointment_time" class="form-label">Appointment Time</label>
                            <input id="appointment_time" value="{{ old('appointment_time') }}" type="time" 
                                name="appointment_time" required
                                class="form-control @error('appointment_time') is-invalid @enderror"    
                                min="{{ $doctor->doctor_details->start_time ?? '00:00' }}" max="{{ $doctor->doctor_details->end_time ?? '23:59' }}">                        </div>

                        <button type="submit" class="btn btn-primary">Make Appointment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var dateInput = document.getElementById('appointmentDate');
        
        // Fetch the available days from the doctor_meta table
        var availableDays = @json($doctor->doctor_details->days ?? []);

        // Set the minimum date to today
        var today = new Date();
        dateInput.setAttribute('min', today.toISOString().split('T')[0]);

        // Disable unavailable days
        dateInput.addEventListener('input', function () {
            var selectedDate = new Date(this.value);
            var selectedDay = selectedDate.toLocaleDateString('en-US', { weekday: 'long' }).toLowerCase();
            
            if (!availableDays.includes(selectedDay)) {
                alert('Appointments are not available on ' + selectedDay + '. Please choose another date.');
                this.value = ''; // Clear the selected date
            }
        });
    });
</script>
@endsection
