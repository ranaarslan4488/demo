<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Appointment;
use App\Models\TransactionHistory;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        $datam = [];
        if($user->role == 'admin'){
            $datam = TransactionHistory::latest()->get();
        }else if ($user->role == 'doctor'){
            $datam = Appointment::where('doctor_id',$user->id)->orderBy('appointment_date')->get();
        }else if ($user->role == 'client'){
            $datam = Appointment::where('client_id',$user->id)->orderBy('appointment_date')->get();

        }
        return view('home',['datam' => $datam]);
    }
}
