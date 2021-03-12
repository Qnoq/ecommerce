<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderProduct;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Stripe\Exception\CardException;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // Gérer le paiement
    public function checkout()
    {
        //
        return view('checkout');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request->all);
        // Stripe::setApiKey('STRIPE_SECRET');
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $charge = \Stripe\Charge::create([
                'amount' => session()->has('coupon') ? round(Cart::total() - session()->get('coupon')['discount'], 2) * 100 : Cart::total() * 100,
                'currency' => 'eur',
                'description' => 'Mon paiement',
                'source' => $request->stripeToken,
                'receipt_email' => $request->email,
                'metadata' => [
                    'owner' => $request->name,
                    'products' => Cart::content()->toJson()
                ]
            ]);

            $order = Order::create( [
                'user_id' => auth()->user()->id,
                'paiement_firstname' => $request->firstname,
                'paiement_name' => $request->name,
                'paiement_phone' => $request->phone,
                'paiement_email' => $request->email,
                'paiement_address' => $request->address,
                'paiement_city' => $request->city,
                'paiement_postalcode' => $request->postalcode,
                'discount' => session()->get('coupon')['name'] ?? null,
                'paiement_total' => session()->has('coupon') ? round(Cart::total() - session()->get('coupon')['discount'], 2) : Cart::total(),
            ]);

            foreach(Cart::content() as $product) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $product->qty,
                ]);
            }

            return redirect()->route('checkout.success')->with('success', 'Payment has been accepted !');
        }
        catch(CardException $e) {
            throw $e;
        }
    }

    // En cas de paiement réussi
    public function success()
    {
        //
        if(!session()->has('success')) {
            return redirect()->route('home');
        }
        
        $order = Order::latest()->first();

        Cart::destroy();
        session()->forget('coupon');
        return view('success', [
            'order' => $order,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
