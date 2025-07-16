@extends('client.layout.master')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Checkout</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.html">Home</a>
                        <span>Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click here</a> to enter your code
                </h6>
            </div>
        </div>
        <div class="checkout__form">
            <h4>Billing Details</h4>
            <form action="{{ route('client.cart.place-order') }}" method="post">
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="checkout__input">
                                    <p>Full Name<span>*</span></p>
                                    <input type="text" name="name" value="{{ $user->name }}">
                                </div>
                            </div>
                        </div>
                    
                        <div class="checkout__input">
                            <p>Address<span>*</span></p>
                            <input type="text" name="address" placeholder="Street Address" class="checkout__input__add">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Phone<span>*</span></p>
                                    <input type="text" name="phone" value="{{ $user->phone }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input disabled type="text" name="email" value="{{ $user->email }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>Order notes</p>
                            <input type="text" name="note"
                                placeholder="Notes about your order, e.g. special notes for delivery.">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Your Order</h4>
                            <div class="checkout__order__products">Products <span>Total</span></div>
                            <ul>
                                @php $priceTotal = 0 @endphp
                                @foreach ($cart as $item)
                                    @php 
                                        $priceItem = $item['price'] * $item['qty'];
                                        $priceTotal += $priceItem;
                                    @endphp
                                    <li>{{ $item['name'] }} <span>${{ number_format($priceItem, 2) }}</span></li>    
                                @endforeach
                            </ul>
                            <div class="checkout__order__subtotal">Subtotal <span>${{ number_format($priceTotal, 2) }}</span></div>
                            <div class="checkout__order__total">Total <span>${{ number_format($priceTotal, 2) }}</span></div>
                            
                       
                            <div class="checkout__input__checkbox">
                                <label for="cod">
                                    COD
                                    <input type="radio" id="cod" name="payment_method" value="cod">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="vnpay">
                                    VNPay
                                    <input type="radio" id="vnpay" name="payment_method" value="vnpay">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            @csrf
                            <button type="submit" class="site-btn">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Checkout Section End -->
@endsection