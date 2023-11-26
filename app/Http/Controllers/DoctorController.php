<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = User::where('role', 'doctor')->get();

        return view('doctors.index', compact('doctors'));
    }

    public function show(User $doctor)
    {
        return view('doctors.show', compact('doctor'));
    }
}