<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4>Shipping & Billing</h4>
                    <hr>
                    {{-- @dd($customer_details) --}}
                    <form action="{{ route('create.invoice') }}" method="post">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <input type="text" name="firstName" placeholder="First Name" value="{{ $user->firstName }}" class="form-control">
                                    @error('firstName')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <input type="text" name="lastName" placeholder="Last Name" class="form-control" value="{{ $user->lastName }}">
                                    @error('lastName')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <input type="email" name="email" placeholder="Email Address" class="form-control" value="{{ $user->email }}">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <input type="text" name="mobile" placeholder="Mobile No" class="form-control" value="{{ $user->mobile }}">
                                    @error('mobile')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <input type="text" name="apartment" placeholder="Apartment, Flat No, Road No" class="form-control" value="">
                                    @error('apartment')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <textarea type="text" name="address" placeholder="Address" class="form-control" rows="1">{{ $customer_details->ship_add ?? null }}</textarea>
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <input type="text" name="city" placeholder="City" class="form-control" value="{{ $customer_details->ship_city ?? null }}">
                                    @error('city')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                            </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <input type="text" name="postal_code" placeholder="Postal code" class="form-control" value="{{ $customer_details->ship_postcode ?? null }}">
                                    @error('postal_code')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <input type="text" name="country" value="{{ $customer_details->ship_country ?? "Bangladesh" }}" readonly class="form-control">
                                    @error('country')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            
                        </div>
                        
                        
                    
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4>Products</h4>
                    <hr>
                        <div class="row">
                            <div class="col-3">
                                <img src="{{ asset($products['image']) }}" alt="" class="rounded" style="width: 70px">
                            </div>
                            <div class="col-9">
                                <p>{{ $products['title'] }}<br>
                                <strong>৳{{ $products->discount_price }}</strong></p>
                            </div>
                        </div>
                    
                    <hr>
                    <div class="row">
                        <div class="col-7">Subtotal</div>
                        <div class="col-5" style="text-align:right;">৳{{ $total_product_price }}</div>
                        <input type="text" class="d-none" value="{{ $total_product_price }}" name="subtotal">
                        <div class="col-7">Shipping</div>
                        <div class="col-5" style="text-align:right;">৳{{ $shipping_charge }}</div>
                        <input type="text" class="d-none" value="{{ $shipping_charge }}" name="shipping_charge">
                        <div class="col-7"><strong>Total</strong> </div>
                        <div class="col-5 mb-3" style="text-align:right;">BDT ৳{{ $total_pay }}</div>
                        <input type="text" class="d-none" value="{{ $total_pay }}" name="payable">
                        <input type="text" class="d-none" value="1" name="buy_now">
                        <input type="text" class="d-none" value="{{ $products->id }}" name="product_id">
                        <input type="text" class="d-none" value="{{ $product_details->color }}" name="product_color">
                        <input type="text" class="d-none" value="{{ $product_details->size }}" name="product_size">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">Order Confirm</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        
        
        
    </div>
</div>