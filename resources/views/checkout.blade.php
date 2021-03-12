@extends('layouts.master')

@section('includes')
    <script src="https://js.stripe.com/v3/"></script>
@endsection 

@section('content')
    
    {!! Breadcrumbs::render('checkout') !!}

    <!--================Checkout Area =================-->
    <section class="checkout_area section_gap">
        <div class="container">
            <div class="billing_details">
                <div class="row">
                    <div class="col-lg-8">
                        <h3>Billing Details</h3>
                        <form class="row contact_form" action="{{ route('checkout.store') }}" method="POST" id="payment-form">
                            {{ csrf_field() }}
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="firstname" name="firstname">
                                <span class="placeholder" data-placeholder="First name"></span>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="lastname" name="name">
                                <span class="placeholder" data-placeholder="Last name"></span>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="number" name="phone">
                                <span class="placeholder" data-placeholder="Phone number"></span>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="email" name="email">
                                <span class="placeholder" data-placeholder="Email Address"></span>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control" id="add1" name="address">
                                <span class="placeholder" data-placeholder="Address line 01"></span>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control" id="city" name="city">
                                <span class="placeholder" data-placeholder="Town/City"></span>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="zip" name="postalcode" placeholder="Postcode/ZIP">
                            </div>
                            <div class="col-md-12 form-group">
                                <div class="creat_account">
                                    <div class="form-group">
                                        <label for="card-element">
                                            Credit or debit card
                                        </label>
                                        <div id="card-element">

                                        </div>
                                        <div id="card-errors" role="alert"></div>
                                    </div>
                                </div>
                            </div>
                            <button id="complete-order" type="submit" class="primary-btn my-3">Proceed to Paiement</button>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <div class="order_box">
                            <h2>Your Order</h2>
                            <ul class="list">
                                <li><a href="#">Product <span>Total</span></a></li>
                                @foreach (Cart::content() as $product)
                                    <li><a href="#">{{ $product->name }} <span class="middle">x {{ $product->qty }}</span> <span class="last">{{ $product->price }}€</span></a></li>
                                @endforeach
                            </ul>
                            <ul class="list list_2">
                                <li><a href="#">Subtotal <span>{{ Cart::subtotal() }}€</span></a></li>

                                @if(session()->has('coupon'))
                                    <li><a href="#">Discount ( {{ session()->get('coupon')['name'] }})<span> - {{ session()->get('coupon')['discount'] }}€</span></a></li>
                                    <form action="{{ route('coupon.destroy') }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn" type="submit">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif

                                <li><a href="#">Tax <span>{{ Cart::tax() }}€</span></a></li>
                                <li><a href="#">Total <span>{{ session()->has('coupon') ? Cart::total() - session()->get('coupon')['discount'] : Cart::total() }}€</span></a></li>
                            </ul>
                        </div>
                        <div class="coupon my-3">
                            <div class="code">
                                <p>Have a code ?</p>
                                <form action="{{ route('coupon.store') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="d-flex align-item-center contact_form">
                                        <input type="text" name="coupon" id="coupon" class="form-control" placeholder="Coupon code">
                                        <button class="primary-btn" type="submit">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Checkout Area =================-->
@endsection

@section('js')

    <script>
        // Create a Stripe client.
        var stripe = Stripe('pk_test_51ITYhLHVmsD8oKGHPKi1iYLbvkwGmsFrwqquGp86POZGYpGU9s19NoxiY0es30EynncNX8VD9TtdCE6jXR9stpKo003qis1wc2');
        // Create an instance of Elements.
        var elements = stripe.elements();
        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
            color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
        };
        // Create an instance of the card Element.
        var card = elements.create('card', {style: style});
        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');
        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
        });
        // Handle form submission.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
        event.preventDefault();
        document.getElementById('complete-order').disabled = true;
        var options = {
            firstname: document.getElementById('firstname').value,
            firstname: document.getElementById('firstname').value,
            firstname: document.getElementById('firstname').value,
            // name: document.getElementById('name_on_card').value,
            // address_line1: document.getElementById('address').value,
            // address_city: document.getElementById('city').value,
            // address_state: document.getElementById('province').value,
            // address_zip: document.getElementById('postalcode').value,
        }
        stripe.createToken(card, options).then(function(result) {
            if (result.error) {
            // Inform the user if there was an error.
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
            document.getElementById('complete-order').disabled = false;
            
            } else {
            // Send the token to your server.
            stripeTokenHandler(result.token);
            }
        });
        });
        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        // Submit the form
        form.submit();
        }
    </script>

@stop