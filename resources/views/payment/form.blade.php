<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10">

<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="md:flex">

        <!-- Left Section: Course Information -->
        <div class="md:w-1/2 bg-gray-200 p-5 flex items-center justify-center">
            <div class=" text-center ">
                <img src="{{$course->thumbnail_url}}" alt="Course Image" class="mb-4 w-full rounded-md shadow-md">
                <h2 class="text-2xl font-semibold">{{$course->name}}</h2>
                <p class="text-gray-700 mt-2">Course description goes here. This could include details about the course content, duration, or any other relevant information.</p>
            </div>
        </div>

        <!-- Right Section: Payment Form -->
        <div class="md:w-1/2 p-6 text-center place-content-center">
            @if(Session::has('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                    {{ Session::get('success') }}
                    <p id="redirection">Redirecting to Course Page....</p>
                </div>
            @endif

            @if(Session::has('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                    {{ Session::get('error') }}
                </div>
            @endif

            <h2 class="text-xl font-bold mb-4">Complete Your Payment</h2>
            <form action="{{ route('payment.process') }}" method="post" id="payment-form" class="space-y-4">
                @csrf

                <!-- Card Element -->
                <div class="form-row">
                    <label for="card-element" class="block text-sm font-medium text-gray-700">
                        Credit or Debit Card
                    </label>
                    <div id="card-element" class="mt-2 p-3 border border-gray-300 rounded-md shadow-sm"></div>
                    <div id="card-errors" role="alert" class="text-red-600 mt-2"></div>
                </div>

                <input type="hidden" name="amount" value="{{$course->price}}"> <!-- Example amount in USD -->
                <input type="hidden" name="course_id" value="{{$course->id}}">

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Pay ${{$course->price}}
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    if (document.getElementById('redirection')){
        setTimeout(function() {
            var courseId = document.getElementById('course_id').value;
            window.location.href = "/course/" + courseId;
        }, 3000); // Change this value to your desired time in milliseconds. For example, 2000 milliseconds = 2 seconds.
    }

    var stripe = Stripe('{{ config('services.stripe.key') }}');
    var elements = stripe.elements();
    var card = elements.create('card');
    card.mount('#card-element');

    card.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(card).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Send the token to your server.
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', result.token.id);
                form.appendChild(hiddenInput);

                form.submit();
            }
        });
    });
</script>

</body>
</html>
