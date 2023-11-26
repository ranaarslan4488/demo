<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Appointment;
use App\Http\Controllers\AppointmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ClientTest extends TestCase
{
    public function testItCanStoreAClientAndCreateAnAppointment()
    {
        // Set up a doctor user for testing
        $doctor = User::where('role','doctor')->first();

        // Set up a request with the required data
        $request = new Request([
            'name' => 'John Doe',
            'email' => 'john@google.com',
            'appointment_date' => date('Y-m-d'),
            'appointment_time' => date('H:i'),
        ]);

       // Mock Validator
        Validator::shouldReceive('make')->once()->andReturn(
            \Mockery::mock('Illuminate\Validation\Validator')->shouldReceive('fails')->andReturn(false)->getMock()
        );

        $appointmentController = new AppointmentController();

        $response = $appointmentController->store($doctor, $request);

        // Assertions
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertEquals(302, $response->getStatusCode());

        $this->assertDatabaseHas('users', ['email' => 'john@google.com', 'role' => 'client']);
        $this->assertDatabaseHas('appointments', ['appointment_date' => date('Y-m-d'), 'appointment_time' => date('H:i')]);
    }
    
}
