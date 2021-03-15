@extends('layouts.master')

@section('content')
    
    {!! Breadcrumbs::render('cart') !!}

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            @if ($message = Session::get('success'))
               <div class="alert alert-success alert-block">
                    <button type="button" class="btn close" data-dismiss="alert">x</button>   
                    {{ $message }}
                </div> 
            @endif
            <div class="cart_inner">

                @if(Cart::count() > 0)

                <h2>{{ Cart::count() }} item(s) in shopping cart</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Cart::content() as $product)
                                
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="{{ Voyager::image($product->model->image) }}" alt="" class="w-50">
                                        </div>
                                        <div class="media-body">
                                            <h4>{{ $product->model->name }}</h4>
                                            <p>{{ $product->model->details}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5>{{ $product->model->price }}</h5>
                                </td>
                                <td>
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        <input type="hidden" name="name" value="{{ $product->name }}">
                                        <input type="hidden" name="price" value="{{ $product->price }}">
                                        <button type="submit" class="btn mb-3">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                    <div class="product_count">
                                        <input disabled type="number" name="qty" id="sst" maxlength="12" value="{{ $product->qty }}" title="Quantity:"
                                        class="input-text qty">
                                    </div>
                                    <form action="{{ route('cart.update', $product->rowId) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('PATCH') }}
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        <input type="hidden" name="name" value="{{ $product->name }}">
                                        <input type="hidden" name="price" value="{{ $product->price }}">
                                        <button type="submit" class="btn mt-3">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('cart.destroy', $product->rowId) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                    </form>
                                    <form action="{{ route('cart.save', $product->rowId) }}" method="POST">
                                        {{ csrf_field() }}
                                        <button type="submit" class="my-2 btn btn-warning">Save for later</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <h5>Subtotal</h5>
                                    <p>Taxe</p>
                                    <h4>Total</h4>
                                </td>
                                <td>
                                    <h5>{{ Cart::subtotal() }}</h5>
                                    <p>{{ Cart::tax() }}</p>
                                    <h4>{{ Cart::total() }}</h4>
                                </td>
                            </tr>
                            <tr class="out_button_area">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <div class="checkout_btn_inner d-flex align-items-center">
                                        <a class="gray_btn" href="{{ route('shop.index') }}">Continue Shopping</a>
                                        <a class="primary-btn" href="{{ route('checkout.index') }}">Proceed to checkout</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @else
                    <h3 class="my-3 text-center">No item in shopping cart</h3>
                    <div class="d-flex justify-content-around">
                        <a class="gray_btn" href="{{ route('shop.index') }}">Continue Shopping</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="single-product-slider">
            <div class="container">
                @if (Cart::instance('save')->count() > 0)
                    <h2 class="text-center my-5">{{ Cart::instance('save')->count() }} item(s) saved for later</h2>
                    <div class="row">
                        @foreach (Cart::instance('save')->content() as $product)
                            <div class="col-lg-3 col-md-6">
                                <div class="single-product">
                                    <img src="{{ Voyager::image($product->model->image) }}" alt="" class="img-fluid">
                                    <div class="product-details">
                                        <h6>{{ $product->model->name }}</h6>
                                        <div class="price">{{ $product->model->price }}€</div>
                                        <div class="prd-bottom">
                                            <form action="{{ route('save.store', $product->rowId) }}" method="POST">
                                                {{ csrf_field() }}
                                                <button class="btn btn-info">Add to cart</button>
                                            </form>
                                            <form action="{{ route('save.destroy', $product->rowId) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button class="my-2 btn btn-danger">Remove</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <h3 class="text-center mt-3">No item saved for later</h3>
                @endif
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->    
@endsection