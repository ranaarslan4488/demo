<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Stripe\Exception\CardException;
use App\Models\Appointment;
use App\Models\TransactionHistory;

class PaymentController extends Controller
{
    public function paymentPage($appointment_id)
    {
        $appointment = Appointment::find($appointment_id);
        if(!empty($appointment->doctor->doctor_details)){
            return view('payment.index', ['appointment' => $appointment]);
        }else{
            return view('304');
        }
    }

    public function processPayment($appointmentId, Request $request)
    {
        // Retrieve the appointment details from the database
        $appointment = Appointment::find($appointmentId);
        if(!empty($appointment) && $appointment->doctor->doctor_details){

            $validator = Validator::make($request->all(), [
                'stripeToken' => 'required',
               
            ]);
    
    
            if ($validator->passes()) {
                Stripe::setApiKey(config('services.stripe.secret'));
    
                try {
                    $charge = \Stripe\Charge::create([
                        'amount' => $appointment->doctor->doctor_details->fees * 100,
                        'currency' => 'usd',
                        'source' => $request->get('stripeToken'), // Use the card token from the frontend
                            'description' => 'Appointment Payment',
                    ]);

                    // uncoment this code if you are using verify account

                    // $transfer = \Stripe\Transfer::create([
                    //     'amount' => $appointment->doctor->doctor_details->fees * 0.8 * 100, // Adjust the percentage as needed
                    //     'currency' => 'usd',
                    //     'destination' => $appointment->doctor->doctor_details->stripe_account_id,
                    // ]);

                    if ($charge->status === 'succeeded') {
                        TransactionHistory::create([
                            'doctor_id' => $appointment->doctor_id,
                            'client_id' => $appointment->client_id,
                            'appointment_id' => $appointment->id,
                            'amount' => $appointment->doctor->doctor_details->fees,
                            'status' => 'Paid',
                        ]);

                        $appointment->update(['status' => 'Paid']);
                        return redirect()->route('success');
                    } 
                } catch (CardException $e) {
                    return redirect()->back()->withErrors(['error' => $e->getMessage()]);
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors(['error' => $e->getMessage()]);
                }
            }
    
        }else{
            return redirect()->back()->withErrors(['error' => "Details are not found"]);
        }

    }

    public function success() {
        return view('payment.success');
    }
}
