/**
 * Created by bundalla on 1/19/2017.
 */
Stripe.setPublishableKey('pk_test_sEbCTIr5YPDllnGdLYCt6Dqt');

// Grab the form:
var $form  = $('#checkout-form');
$form.submit(function (event) {
    $('#charge-error').addClass('hidden');
    $form.find('button').prop('disabled', true);
    Stripe.card.createToken({
        number: $('#card-number').val(),
        cvc: $('#card-cvc').val(),
        exp_month: $('#card-expiry-month').val(),
        exp_year: $('#card-expiry-year').val(),
        name:$('#card-name').val()
    }, stripeResponseHandler);   // Call back
    return false;
});

function  stripeResponseHandler(status, response) {
    if(response.error){ // Problem!
        // Show the errors on the form
        $('#charge-error').removeClass('hidden');
        $('#charge-error').text(response.error.message);
        $form.find('button').prop('disabled',false); // Re-enable submission
    }else {// Token was created!
        // Get the token ID:
        var token = response.id;
        // Insert the token into the form so it gets submitted to the server:
        $form.append($('<input type="hidden" name="stripeToken" />').val(token));

        // Submit the form->server:
        $form.get(0).submit();

    }
}