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
        gap: 5px;
        margin-top: 20px;
        justify-content: center;
    }
    .pagination-btn {
        margin: 0 5px;
        padding: 5px 10px;
        border: 1px solid #ddd;
        background-color: #fff;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }
    .pagination-btn.active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }
    .pagination-btn:hover {
        background-color: #f1f1f1;
    }
    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: 1fr;
        }
        .pagination {
            flex-wrap: wrap;
        }
        .pagination-btn {
            width: 40px;
            text-align: center;
        }
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
                       placeholder="Search products in category... " >
            </div>
            <div id="loading-indicator" style="display: none; text-align: center;">
                <p>Loading...</p>
            </div>
            <div class="product-main" style="padding-top: 10px">
                <div class="product-grid" id="product-list">
                    <!-- Products will be dynamically loaded here -->
                </div>
            </div>
            <div id="pagination" class="pagination-container"></div>
        </div>
    </div>
</div>

<script>
    
// Initialize products on page load
document.addEventListener('DOMContentLoaded', () => {
    const products = JSON.parse(localStorage.getItem('categoryProducts')) || [];
    displayProducts(products);
    // console.log(products);
    
    let currentPage = 1; // Track the current page

    // Fetch and display products based on search query and page
    function toggleLoading(show) {
        document.getElementById('loading-indicator').style.display = show ? 'block' : 'none';
    }

    async function fetchData(endpoint, params = {}) {
        try {
            const queryParams = new URLSearchParams(params).toString();
            const url = queryParams ? `${endpoint}?${queryParams}` : endpoint;

            const response = await fetch(url, {
                method: 'GET',
                headers: { 'Content-Type': 'application/json' },
            });
            const data = await response.json();
            return data;
        } catch (error) {
            // console.error('Error fetching data:', error);
            throw new Error('Unable to fetch products.');
        }
    }


    // Fetch and display products based on search query and page
    function fetchAndDisplayProducts({ query = '', page = 1, categoryName = products.category }) {
    toggleLoading(true);
    const endpoint = query ? '/product/category/search' : `/product-category/${categoryName}`;

    async function fetchData(endpoint, params = {}) {
        try {
            const response = await fetch(endpoint + `?page=${page}&query=${query}`);
            const data = await response.json();

            if (response.ok) {
                return data;
            } else {
                throw new Error(data.message || 'Unknown error');
            }
        } catch (error) {
            // console.error('Error fetching data:', error);
            throw new Error('Unable to fetch products: ' + error.message);
        }
    }

    fetchData(endpoint, { query, page })
        .then(data => {
            toggleLoading(false);
            displayProducts(data.data || [], data.pagination || {});
            setupPagination(data.pagination?.current_page || 1, data.pagination?.last_page || 1);
        })
        .catch(error => {
            toggleLoading(false);
            // console.error('Error:', error);
            document.getElementById('product-list').innerHTML = `<p>${error.message}</p>`;
        });
}


function displayProducts(products, meta = {}) {
    const productList = document.getElementById('product-list');
    productList.innerHTML = ''; // Clear existing products

    if (Array.isArray(products) && products.length > 0) {
        products.forEach(product => {
            const productImage = product.image || '/images/default-image.jpeg'; // Use a fallback image
            const productDiv = document.createElement('div');
            productDiv.classList.add('product-item');
            productDiv.innerHTML = `
                <div class="showcase">
                    <div class="showcase-banner">
                        <img src="${product.image}" alt="${product.title}" class="product-img" width="300">
                    </div>
                    <div class="showcase-content">
                        <h3>
                            <a href="#" class="showcase-title">${product.title}</a>
                        </h3>
                        <div class="price-box">
                            <p class="price">Tk ${product.discount_price || product.price || 'N/A'}</p>
                            ${product.discount_price ? `<del>Tk ${product.price}</del>` : ''}
                        </div>
                    </div>
                    <button class="buy-now" onclick="buyNow(${product.id})"> Buy Now</button>
                    <button class="add-to-cart" onclick="addToCart(${product.id})">Add to Cart</button>
                </div>
            `;
            productList.appendChild(productDiv);
        });
    } else {
        productList.innerHTML = '<p>No products found.</p>';
    }
}

    // Setup pagination buttons
    function setupPagination(currentPage, lastPage) {
    const paginationContainer = document.getElementById('pagination');
    paginationContainer.innerHTML = ''; // Clear existing pagination

    // Add Previous Button
    if (currentPage > 1) {
        const prevButton = document.createElement('button');
        prevButton.textContent = 'Previous';
        prevButton.classList.add('pagination-btn');
        prevButton.setAttribute('aria-label', 'Previous Page');
        prevButton.addEventListener('click', () => fetchAndDisplayProducts({ page: currentPage - 1 }));
        paginationContainer.appendChild(prevButton);
    }

    const range = 2; // Show 2 pages before and after the current page
    const startPage = Math.max(1, currentPage - range);
    const endPage = Math.min(lastPage, currentPage + range);

    // Show the start of the page range
    if (startPage > 1) {
        paginationContainer.appendChild(createPageButton(1));
        if (startPage > 2) paginationContainer.appendChild(createDotsButton());
    }

    // Show page buttons
    for (let page = startPage; page <= endPage; page++) {
        paginationContainer.appendChild(createPageButton(page));
    }

    // Show the end of the page range
    if (endPage < lastPage) {
        if (endPage < lastPage - 1) paginationContainer.appendChild(createDotsButton());
        paginationContainer.appendChild(createPageButton(lastPage));
    }

    // Add Next Button
    if (currentPage < lastPage) {
        const nextButton = document.createElement('button');
        nextButton.textContent = 'Next';
        nextButton.classList.add('pagination-btn');
        nextButton.setAttribute('aria-label', 'Next Page');
        nextButton.addEventListener('click', () => fetchAndDisplayProducts({ page: currentPage + 1 }));
        paginationContainer.appendChild(nextButton);
    }
}

function createPageButton(page) {
    const button = document.createElement('button');
    button.textContent = page;
    button.classList.add('pagination-btn');
    button.setAttribute('aria-label', `Page ${page}`);
    button.addEventListener('click', () => fetchAndDisplayProducts({ page }));
    return button;
}

function createDotsButton() {
    const button = document.createElement('button');
    button.textContent = '...';
    button.classList.add('pagination-btn');
    button.disabled = true;
    return button;
}



let debounceTimer;
document.getElementById('category-search').addEventListener('keyup', () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        const query = document.getElementById('category-search').value;
        fetchAndDisplayProducts({ query, page: 1 });
    }, 500); // Adjust debounce delay for smoother experience
});




});



</script>
