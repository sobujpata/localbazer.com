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
</style>
<div class="product-container">
    <hr>
    <div class="container" style="padding-top: 10px">
        @include('layouts.partials.sidebar')

        <div class="product-box">
            <h2 class="title">Category Products</h2>

            <div class="header-search-container">
                <input type="search" name="search-category-product" id="category-search"
                       class="search-field"
                       placeholder="Search products in category..."
                       onkeyup="searchCategoryProducts()">
            </div>

            <!--- PRODUCT GRID -->
            <div class="product-main" style="padding-top: 10px">
                <div class="product-grid" id="product-list">
                    <!-- Products will be dynamically loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function searchCategoryProducts() {
    const searchQuery = document.getElementById('category-search').value;

    if (searchQuery.length > 0) {  // Trigger search after 3 characters
        axios.get('/product-category/search', { params: { query: searchQuery } })
            .then(response => {
                // Ensure the response is valid and contains the 'data' array
                if (response.data && Array.isArray(response.data.data)) {
                    displayProducts(response.data.data);  // Access the 'data' array from the response
                } else {
                    console.error('Unexpected response format:', response.data);
                    document.getElementById('product-list').innerHTML = '<p>Unexpected error occurred.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching search results:', error);
                document.getElementById('product-list').innerHTML = '<p>Error fetching search results. Please try again.</p>';
            });

    } else {
        // Clear the product list if query is too short
        // document.getElementById('product-list').innerHTML = '';
        location.reload();
    }

}

function displayProducts(products) {
    const productList = document.getElementById('product-list');
    productList.innerHTML = ''; // Clear the current list

    // Check if the products is an array and display accordingly
    if (Array.isArray(products)) {
        if (products.length === 0) {
            productList.innerHTML = '<p>No products found.</p>';
        } else {
            products.forEach(product => {
                const productDiv = document.createElement('div');
                productDiv.innerHTML = `
                    <div class="showcase">
                        <div class="showcase-banner">
                            <img src="${product.image || 'default-image.png'}"
                                 alt="${product.title || 'Product'}"
                                 class="product-img default" width="300">
                            <img src="${product.image || 'default-image.png'}"
                                 alt="${product.title || 'Product'}"
                                 class="product-img hover" width="300">
                        </div>
                        <div class="showcase-content">
                            <h3>
                                <a href="#" class="showcase-title">${product.title || 'Untitled'}</a>
                            </h3>
                            <div class="showcase-rating" id="rating-container-${product.id}"></div>
                            <div class="price-box">
                                <p class="price">Tk ${product.discount_price || product.price || 'N/A'}</p>
                                ${product.discount_price ? `<del>Tk ${product.price}</del>` : ''}
                            </div>
                        </div>

                        <button class="buy-now" onclick="buyNow(${product.id})">Buy Now</button>
                        <button class="add-to-cart" onclick="addToCart(${product.id})">Add to Cart</button>
                    </div>
                `;
                productList.appendChild(productDiv);
            });
        }
    } else {
        productList.innerHTML = '<p>Invalid product data format.</p>';
    }
}

// Initial product load (when the page loads)
document.addEventListener('DOMContentLoaded', () => {
    const products = JSON.parse(localStorage.getItem('categoryProducts')) || [];
    displayProducts(products);
});



</script>
