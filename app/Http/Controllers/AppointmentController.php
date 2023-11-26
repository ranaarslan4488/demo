<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Appointment;
use Auth;
class AppointmentController extends Controller
{
    public function store(User $doctor, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'appointment_date' => ['date_format:Y-m-d'],
            'appointment_time' => ['date_format:H:i'],
        ]);
    
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
      
        $isDoctorAvailable = $this->checkDoctorAvailability($doctor, $request->input('appointment_date'), $request->input('appointment_time'));

        if (!$isDoctorAvailable) {
            return redirect()
                ->back()
                ->withErrors(['appointment_time' => 'The doctor is not available at the specified date and time.'])
                ->withInput();
        }

        $user = Auth::user();

        if (!$user) {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt('password'), // You may want to generate a secure password
                'role' => 'client',
            ]);

            if (!$user) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'Failed to create a new user.'])
                    ->withInput();
            }
        }

        $appointment = new Appointment([
            'appointment_date' => $request->input('appointment_date'),
            'appointment_time' => $request->input('appointment_time'),
        ]);

        $appointment->doctor()->associate($doctor);
        $appointment->client()->associate($user);

        if (!$appointment->save()) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Failed to create the appointment.'])
                ->withInput();
        }

        return redirect()->route('payment.page', ['appointment_id' => $appointment->id]);

    }

    private function checkDoctorAvailability(User $doctor, $appointmentDate, $appointmentTime)
    {
        $doctorDetails = $doctor->doctor_details;

        if (!$doctorDetails) {
            return false; 
        }

        $checkTimeDuration = $doctorDetails->check_time_duration;
        $appointmentTimeBefore = date('H:i', strtotime("-$checkTimeDuration minutes", strtotime($appointmentTime)));
        $appointmentTimeAfter = date('H:i', strtotime("+$checkTimeDuration minutes", strtotime($appointmentTime)));

        $overlappingAppointments = Appointment::where('doctor_id', $doctor->id)
        ->where('appointment_date', $appointmentDate)
        ->where(function ($query) use ($appointmentTimeBefore, $appointmentTimeAfter) {
            $query->whereBetween('appointment_time', [$appointmentTimeBefore, $appointmentTimeAfter]);
        })
        ->exists();

        return !$overlappingAppointments;
    }
}