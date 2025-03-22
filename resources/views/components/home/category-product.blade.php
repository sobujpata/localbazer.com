<style>
    .buy-now {
        background-color: #ff5722;
        color: #fff;
        float: left;
        margin: 0px 0px 10px 8px;
        padding: 5px;
        border-radius: 5px;
    }

    .add-to-cart {
        background-color: #000;
        color: #fff;
        float: right;
        margin: 0px 8px 10px 0px;
        padding: 5px;
        border-radius: 5px;
    }

    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination li a,
    .pagination li span {
        padding: 10px 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-decoration: none;
        color: #007bff;
    }

    .pagination li.active span {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    .pagination li.disabled span {
        color: #999;
    }

    a {
        text-decoration: none !important;
    }

    .title a {
        display: inline;
        /* Ensure links are inline */
        text-decoration: none;
        /* Optional: Remove underline */
        margin: 0 5px;
        /* Adjust spacing */
    }

    .title {
        font-size: 1.5rem;
        /* Optional: Adjust title size */
    }
    
</style>

<div class="product-container">
    <hr>
    <div class="container" style="padding-top: 10px">
        @include('layouts.partials.sidebar2')

        <div class="product-box">
            <h2 class="title">
                <a href="{{ url('/') }}" class="text-dark">Home</a> /
                <a class="text-dark" href="{{ url('/product-category/' . $category->categoryName) }}">{{ $category->categoryName }}</a>
            </h2>


            {{-- <div class="header-search-container">
                <input type="search" name="search-category-product" id="category-search" class="search-field"
                    placeholder="Search products in category... ">
            </div> --}}
            <div id="loading-indicator" style="display: none; text-align: center;">
                <p>Loading...</p>
            </div>
            <div class="product-main" style="padding-top: 10px">
                <div class="product-grid" id="product-list">
                    <!-- Products will be dynamically loaded here -->
                    @foreach ($products as $product)
                    <div class="showcase pb-1">
                        <input type="hidden" value="{{ optional($product->product_details->first())->color }}" class="p_color_all">
                        <input type="hidden" min="0" value="1" name="quantity" step="1" aria-label="Quantity" class="p_qty_all">
                        <input type="hidden" value="{{ $product->id }}" class="p_id_all">
                        <div class="showcase-banner">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->title }}" class="product-img p-1" style="border-radius:15px; width: 100%;">
                            <img src="{{ asset(optional($product->product_details->first())->img2) }}" alt="{{ $product->title }}" class="product-img hover" width="300">
                            
                            <p class="showcase-badge angle pink">{{ $product->discount }}</p>
                                <div class="showcase-actions">
                                    
                            
                                    <button class="btn-action" title="View Details">
                                        <a href="{{ url('/products/'.$product->id) }}}">
                                            <ion-icon name="eye-outline"></ion-icon>
                                        </a>
                                    </button>

                                    <button class="btn-action" onclick="AddToCartFromAll(this)">
                                        <ion-icon name="cart-outline"></ion-icon>
                                    </button>
                                    
                            
                                    <button class="btn-action">
                                        <a href="{{ url('/order-form/'.$product->id) }}}">
                                            <ion-icon name="bag-add-outline"></ion-icon>
                                        </a>
                                        
                                    </button>
                                </div>
                        </div>
                        <div class="showcase-content">
                            <a href="{{ url('products/' . $product->id) }}" class="showcase-title">
                                <h5>{{ $product->title }}</h5>
                                <div class="price-box">
                                    <p class="price" style="font-size: 11px;"><del>{{ $product->price }}Tk</del> | {{ $product->discount_price }}Tk</p>
                                </div>
                            </a>

                        </div>
                    </div>
                    @endforeach
                </div>
                {{ $products->links() }}

                <div id="pagination" class="pagination-container"></div>
            </div>

        </div>
    </div>
</div>

<script>
    getCategoryData();
</script>
