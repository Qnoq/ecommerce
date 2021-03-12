<?php

namespace App\Http\Controllers;

use App\OrderProduct;
use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $limit = 8;
        $array = [];

        // News
        $news = Product::take(2)->get();

        // Latest products
        $latestProducts = Product::orderBy('id', 'DESC')->take(8)->get();

        // Bestsellers
        $orders = OrderProduct::all()->groupBy('product_id');
        foreach($orders as $order) {
            array_push($array, $order[0]->product_id);
        }
        $bestSellers = Product::whereIn('id', $array)->take($limit)->get();

        return view('home', [
            'latestProducts' => $latestProducts,
            'news' => $news,
            'bestSellers' => $bestSellers
        ]);
    }

    public function orders()
    {
        $user = auth()->user();
        return view('orders', [
            'orders' => $user->orders
        ]);
    }

    public function contact()
    {
        return view('contact');
    }

}
