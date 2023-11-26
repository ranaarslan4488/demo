@extends('layouts.app')

@section('content')
    <div class="container mt-4">
   

    <div class="row justify-content-center">

        <div class="col-md-6">
            <div class="card">


                <div class="card-header" >

                        <h3 class="panel-title" >Payment Details</h3>
                        <p>Appointment Date: {{ $appointment->appointment_date }}</p>
                        <p>Appointment Time: {{ $appointment->appointment_time }}</p>
                </div>

                <div class="card-body">                

                    <form 

                            role="form" 

                            action="{{ route('process.payment', $appointment->id) }}"

                            method="post" 

                            class="require-validation"

                            data-cc-on-file="false"

                            data-stripe-publishable-key="{{ env('STRIPE_PUBLIC_KEY') }}"

                            id="payment-form">

                        @csrf



                        <div class='mb-4 row'>

                            <div class='col-xs-12 form-group required'>

                                <label class='control-label'>Name on Card</label> <input

                                    class='form-control' size='4' type='text'>

                            </div>

                        </div>



                        <div class='mb-4'>

                            <div class='form-group required'>

                                <label class='control-label'>Card Number</label> <input

                                    autocomplete='off' class='form-control card-number' size='20'

                                    type='text'>

                            </div>

                        </div>



                        <div class='form-row row mb-4'>

                            <div class='col-xs-12 col-md-4 form-group cvc required'>

                                <label class='control-label'>CVC</label> 
                                <input autocomplete='off'

                                    class='form-control card-cvc' placeholder='ex. 311' size='4'

                                    type='text'>

                            </div>

                            <div class='col-xs-12 col-md-4 form-group expiration required'>

                                <label class='control-label'>Expiration Month</label> <input

                                    class='form-control card-expiry-month' placeholder='MM' size='2'

                                    type='text'>

                            </div>

                            <div class='col-xs-12 col-md-4 form-group expiration required'>

                                <label class='control-label'>Expiration Year</label> <input

                                    class='form-control card-expiry-year' placeholder='YYYY' size='4'

                                    type='text'>

                            </div>

                        </div>



                        <div class='form-row row'>

                            <div class='col-md-12 error form-group hide'>

                                <div class='alert-danger alert'>Please correct the errors and try

                                    again.</div>

                            </div>

                        </div>



                        <div class="row">

                            <div class="col-xs-12">

                                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now (${{$appointment->doctor->doctor_details->fees}})</button>

                            </div>

                        </div>

                            

                    </form>

                </div>

            </div>        

        </div>
    </div>
@endsection

@section('scripts')
<script src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">

  

$(function() {
    var $form = $(".require-validation");    

    $('form.require-validation').bind('submit', function(e) {
        var $form = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),

        $inputs = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid = true;
        $errorMessage.addClass('hide');  

        $('.has-error').removeClass('has-error');

        $inputs.each(function(i, el) {

          var $input = $(el);

          if ($input.val() === '') {

            $input.parent().addClass('has-error');

            $errorMessage.removeClass('hide');

            e.preventDefault();

          }

        });

     

        if (!$form.data('cc-on-file')) {

          e.preventDefault();

          Stripe.setPublishableKey($form.data('stripe-publishable-key'));

          Stripe.createToken({

            number: $('.card-number').val(),

            cvc: $('.card-cvc').val(),

            exp_month: $('.card-expiry-month').val(),

            exp_year: $('.card-expiry-year').val()

          }, stripeResponseHandler);

        }

    

    });

      

    /*------------------------------------------

    --------------------------------------------

    Stripe Response Handler

    --------------------------------------------

    --------------------------------------------*/

    function stripeResponseHandler(status, response) {

        if (response.error) {

            $('.error')

                .removeClass('hide')

                .find('.alert')

                .text(response.error.message);

        } else {

            /* token contains id, last4, and card type */

            var token = response['id'];

                 

            $form.find('input[type=text]').empty();

            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");

            $form.get(0).submit();

        }

    }

     

});

</script>
@endsection
