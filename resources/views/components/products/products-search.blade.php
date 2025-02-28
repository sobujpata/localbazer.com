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
    display: inline; /* Ensure links are inline */
    text-decoration: none; /* Optional: Remove underline */
    margin: 0 5px; /* Adjust spacing */
    }

    .title {
        font-size: 1.5rem; /* Optional: Adjust title size */
    }

</style>

<div class="product-container">
    <hr>
    <div class="container" style="padding-top: 10px">
        @include('layouts.partials.sidebar2')

        <div class="product-box">
            <h2 class="title">
                <a href="{{ url('/') }}" class="text-dark">Home</a> /
                <a class="text-dark" href="{{ url('/products/search?search=' . $query) }}">{{ $query}}</a>
            </h2>
            

            <div class="header-search-container">
                <input type="search" name="search-category-product" id="category-search" class="search-field"
                    placeholder="Search products in category... ">
            </div>
            <div id="loading-indicator" style="display: none; text-align: center;">
                <p>Loading...</p>
            </div>
            <div class="product-main" style="padding-top: 10px">
                @if($products->count())
                <div class="product-grid" id="product-list">
                    <!-- Products will be dynamically loaded here -->
                    @foreach ($products as $product)
                    <div class="showcase pb-1">
                        <a href="{{ url('products/' . $product->id) }}" class="showcase-title">
                        <div class="showcase-banner">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->title }}" class="product-img p-1" style="border-radius:15px; width: 100%;">
                        </div>
                        <div class="showcase-content">
                            <h5>{{ $product->title }}</h5>
                            <div class="price-box">
                                <p class="price" style="font-size: 11px;"><del>{{ $product->price }}Tk</del> | {{ $product->discount_price }}Tk</p>
                            </div>
                        </div>
                        </a>
                    </div>
                    @endforeach
                    
                </div>
                <!-- Pagination Links -->
                {{ $products->appends(['search' => $query])->links() }}

                @else
                    <h3>No products found for "{{ $query }}"</h3>
                @endif

                
            </div>

        </div>
    </div>
</div>

<script>
    getCategoryData();
</script>
