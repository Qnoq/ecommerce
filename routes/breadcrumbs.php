<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('home'));
});

// Contact
Breadcrumbs::register('contact', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Contact', route('contact'));
});

// Orders
Breadcrumbs::register('orders', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Orders', route('orders'));
});

// Shop
Breadcrumbs::register('shop', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Shop', route('shop.index'));
});

// Cart
Breadcrumbs::register('cart', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cart', route('cart.index'));
});

// Checkout
Breadcrumbs::register('checkout', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Checkout', route('checkout.index'));
});

// Confirmation
Breadcrumbs::register('confirmation', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Confirmation', route('checkout.success'));
});

// Shop > Product
Breadcrumbs::register('product', function($breadcrumbs, $product)
{
    $breadcrumbs->parent('shop');
    $breadcrumbs->push($product->name, route('shop.show', $product->slug));
});

// forgotPassword
Breadcrumbs::register('forgotPassword', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Forgot Password', route('password.email'));
});

// login
Breadcrumbs::register('login', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Login', route('login'));
});

// Register
Breadcrumbs::register('register', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Register', route('register'));
});