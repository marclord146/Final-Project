// Retrieve the form and card element references
var form = document.getElementById('payment-form');
var cardNumberElement = document.getElementById('card-number-element');
var cardExpiryElement = document.getElementById('card-expiry-element');
var cardCvcElement = document.getElementById('card-cvc-element');
var cardBrandLogo = document.getElementById('card-brand-logo');

// Set up Stripe using  publishable API key
var stripe = Stripe('pk_test_51N5HUTKEkL2KQIeIeKZRYdCV4M3PAZx8Yir73oFqwpE9PyXUWYUwPeeHfLRl6fZot3kYccDbmT1xfNCSM27zTMRM00ZlvKAmkZ');

// Create card elements
var elements = stripe.elements();
var cardNumber = elements.create('cardNumber');
cardNumber.mount(cardNumberElement);
var cardExpiry = elements.create('cardExpiry');
cardExpiry.mount(cardExpiryElement);
var cardCvc = elements.create('cardCvc');
cardCvc.mount(cardCvcElement);

// Handle card brand detection
cardNumber.on('change', function(event) {
  var brand = event.brand;
  if (brand) {
    cardBrandLogo.innerHTML = '<img src="https://js.stripe.com/v3/fingerprinted/img/checkout/brand/' + brand + '.svg" alt="' + brand + '">';
  } else {
    cardBrandLogo.innerHTML = '';
  }
});

// Handle form submission and payment processing// Handle form submission and payment processing
form.addEventListener('submit', function(event) {
  event.preventDefault();

  // Disable the submit button to prevent multiple submissions
  var submitButton = form.querySelector('button[type="submit"]');
  submitButton.disabled = true;

  // Create the payment method
  stripe.createPaymentMethod({
    type: 'card',
    card: cardNumber,
    billing_details: {
      // Include any relevant billing details
    }
  }).then(function(result) {
    if (result.error) {
      // Handle errors in payment method creation
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
      submitButton.disabled = false;
    } else {
      // Send the payment method ID to your server for further processing
      var paymentMethodId = result.paymentMethod.id;

      // Set the paymentMethodId value to the hidden input field
      var hiddenInput = document.getElementById('paymentMethodId');
      hiddenInput.value = paymentMethodId;

      // Submit the form
      form.submit();

      // Reset the form and enable the submit button
      form.reset();
      submitButton.disabled = false;
    }
  });
});



