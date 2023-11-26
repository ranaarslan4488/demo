@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if(auth()->user()->role == 'admin')
                        <p>Welcome, Admin!</p>
                        <h2>Revenue Dashboard</h2>
                        <table class="table table-responisve">
                            <thead>
                                <tr>
                                    <th>Id </td>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Fee</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                                $totalAmount = 0;
                                $totalFee = 0;
                            @endphp
                                @foreach ($datam as $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $row->amount }}</td>
                                        <td>{{  ( 20 / 100) * $row->amount  }}</td>
                                        <td>Appointment schedule {{ $row->appointment->appointment_date }} on {{ $row->appointment->appointment_time }} </td>
                                    </tr>
                                    @php
                                        $totalAmount += $row->amount;
                                        $totalFee += (20 / 100) * $row->amount;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2">Total:</th>
                                    <th>{{ $totalAmount }}</th>
                                    <th>{{ $totalFee }}</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="note">
                        <p>1. A default test connected account has been created for testing purposes. Payments will be sent to this account unless you specify a verified Stripe account for payment transfers.</p>

                            <p>2. If you wish to transfer payments, please ensure that your Stripe account is verified. Visit the <a href="https://dashboard.stripe.com" target="_blank">Stripe Dashboard</a> to complete the verification process.</p>

                            <p>3. To enable payment transfers, uncomment lines <code>49</code> to <code>53</code> in the PaymentController. These lines may include the necessary logic for transferring payments to the specified Stripe account.</p>
                        </div>
                    @elseif(auth()->user()->role == 'doctor')
                        <p>Welcome, Doctor!</p>
                        <note> </note>
                        <h2>Appointment List</h2>
                        <table class="table table-responisve">
                            <thead>
                                <tr>
                                    <th>Id </td>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Patient Name</th>
                                    <th>Payment Received</th>
                                    <th>Amount</th>
                                    <th>Fee</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                                $totalAmount = 0;
                                $totalFee = 0;
                            @endphp
                                @foreach ($datam as $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->appointment_date }}</td>
                                        <td>{{ $row->appointment_time }}</td>
                                        <td>{{ $row->client->name }}</td>
                                        <td>{{ $row->status }}</td>
                                        <td>{{ $row->payment->amount??0 }}</td>
                                        <td>{{  ( 20 / 100) * $row->payment->amount  }}</td>
                                    </tr>
                                    @php
                                        $totalAmount += $row->payment->amount;
                                        $totalFee += (20 / 100) * $row->payment->amount;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5">Total:</th>
                                    <th>{{ $totalAmount }}</th>
                                    <th>{{ $totalFee }}</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    @elseif(auth()->user()->role == 'client')
                        <p>Welcome, Client!</p>
                        <h2>Appointment List</h2>
                        <table class="table table-responisve">
                            <thead>
                                <tr>
                                    <th>Id </td>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Doctor Name</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Fee</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                                $totalAmount = 0;
                                $totalFee = 0;
                            @endphp
                                @foreach ($datam as $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->appointment_date }}</td>
                                        <td>{{ $row->appointment_time }}</td>
                                        <td>{{ $row->doctor->name }}</td>
                                        <td>{{ $row->status == 'paid' ? 'Confirm' : 'Pending' }}</td>
                                        <td>{{ $row->payment->amount??0 }}</td>
                                        <td>{{  ( 20 / 100) * $row->payment->amount  }}</td>
                                    </tr>
                                    @php
                                        $totalAmount += $row->payment->amount;
                                        $totalFee += (20 / 100) * $row->payment->amount;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5">Total:</th>
                                    <th>{{ $totalAmount }}</th>
                                    <th>{{ $totalFee }}</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    @else
                        <p>Welcome, User!</p>
                        {{-- Additional content for other roles --}}
                    @endif 
                </div>            
            </div>
        </div>
    </div>
</div>
@endsection
