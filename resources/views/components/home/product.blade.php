<div class="product-container">

    <div class="container">


        @include('layouts.partials.sidebar2')

        <div class="product-box">

            <!--- PRODUCT MINIMAL-->

            <div class="product-minimal">

                <div class="product-showcase">

                    <h2 class="title">New Arrivals</h2>

                    <div class="showcase-wrapper has-scrollbar" >

                        <div class="showcase-container" id="newArrivals">

                        </div>

                        <div class="showcase-container" id="newArrivals2">

                        </div>

                    </div>
                    <a href="{{ url('/products-remark/New') }}" style="text-align: right">See All</a>

                </div>

                <div class="product-showcase">

                    <h2 class="title">Trending</h2>

                    <div class="showcase-wrapper  has-scrollbar">

                        <div class="showcase-container" id="trending">

                        </div>

                        <div class="showcase-container" id="trending2">

                        </div>

                    </div>
                    <a href="{{ url('/products-remark/Trending') }}" style="text-align: right">See All</a>
                </div>

                <div class="product-showcase">

                    <h2 class="title">Top Rated</h2>

                    <div class="showcase-wrapper  has-scrollbar">

                        <div class="showcase-container" id="topRate">

                        </div>

                        <div class="showcase-container" id="topRate2">

                        </div>

                    </div>
                    <a href="{{ url('/products-remark/Top') }}" style="text-align: right">See All</a>
                </div>

            </div>



            <!--- PRODUCT FEATURED-->

            <div class="product-featured">

                <h2 class="title">Deal of the day</h2>

                <div class="showcase-wrapper has-scrollbar" id="dealOfDay">

                </div>

            </div>



            <!--- PRODUCT GRID-->

            <div class="product-main">

                <h2 class="title">New Products</h2>

                <div class="product-grid" id="newProductsList">

                </div>
                <button id="loadMoreBtn" class="mt-3">Load More</button>
                
                <a href="{{ url('/products-remark/all') }}" style="text-align: right">See All Products</a>
            </div>

        </div>

    </div>

</div>

@push('custom-scripts')
    <script>
    getProductList()

    async function getProductList(){
        //new arraivals
        try {
            let res = await axios.get("new-arrivals");
                    // Clear existing items for both newArrivals and newArrivals2
                    document.getElementById("newArrivals").innerHTML = '';
                    document.getElementById("newArrivals2").innerHTML = '';

                    // Loop through the first batch of new arrivals and append to /products/${item['id']}newArrivals
                    res.data.first_batch.forEach(function(item) {
                        let div = `
                            <div class="showcase">

                                <a href="/products/${item['id']}" class="showcase-img-box">
                                    <img src="${item['image']}"
                                        alt="${item['title']}" width="70"
                                        class="showcase-img">
                                </a>

                                <div class="showcase-content">

                                    <a href="/products/${item['id']}">
                                        <h4 class="showcase-title">${item['title']}</h4>
                                    </a>

                                    <a href="/products/${item['id']}" class="showcase-category">${item.categories['categoryName']}</a>

                                    <div class="price-box">
                                      <p><strong><del>${item['price']}</del></strong></p>  
                                      <p class="price"><strong>${item['discount_price']}</strong></p>
                                        
                                    </div>

                                </div>

                            </div>
                        `;

                        // Append the constructed HTML to the /products/${item['id']}newArrivals element
                        document.getElementById("newArrivals").innerHTML += div;
                    });

                    // Loop through the second batch of new arrivals and append to /products/${item['id']}newArrivals2
                    res.data.second_batch.forEach(function(item) {
                        let div = `
                            <div class="showcase">

                                <a href="/products/${item['id']}" class="showcase-img-box">
                                    <img src="${item['image']}"
                                        alt="${item['title']}" width="70"
                                        class="showcase-img">
                                </a>

                                <div class="showcase-content">

                                    <a href="/products/${item['id']}">
                                        <h4 class="showcase-title">${item['title']}</h4>
                                    </a>

                                    <a href="/products/${item['id']}" class="showcase-category">${item.categories['categoryName']}</a>

                                    <div class="price-box">
                                        <p><strong><del>${item['price']}</del></strong></p>  
                                      <p class="price"><strong>${item['discount_price']}</strong></p>
                                    </div>

                                </div>

                            </div>
                        `;

                        // Append the constructed HTML to the /products/${item['id']}newArrivals2 element
                        document.getElementById("newArrivals2").innerHTML += div;
                    });

                    // After categories are loaded, add event listeners for the accordion behavior
        } catch (error) {
            console.error('Error loading newArrivals:', error);
        }

        //trending
        try {
            let restrending = await axios.get("trending");
                // console.log(restrending)
                    // Clear existing items for both trending and trending2
                    document.getElementById("trending").innerHTML = '';
                    document.getElementById("trending2").innerHTML = '';

                    // Loop through the first trending of new arrivals and append to /products/${item['id']}trending
                    restrending.data.first_trending.forEach(function(item) {
                        let div = `
                            <div class="showcase">

                                <a href="/products/${item['id']}" class="showcase-img-box">
                                    <img src="${item['image']}"
                                        alt="${item['title']}" width="70"
                                        class="showcase-img">
                                </a>

                                <div class="showcase-content">

                                    <a href="/products/${item['id']}">
                                        <h4 class="showcase-title">${item['title']}</h4>
                                    </a>

                                    <a href="/products/${item['id']}" class="showcase-category">${item.categories['categoryName']}</a>

                                    <div class="price-box">
                                        <p><strong><del>${item['price']}</del></strong></p>  
                                      <p class="price"><strong>${item['discount_price']}</strong></p>
                                    </div>

                                </div>

                            </div>
                        `;

                        // Append the constructed HTML to the /products/${item['id']}trending element
                        document.getElementById("trending").innerHTML += div;
                    });

                    // Loop through the second trending of new arrivals and append to /products/${item['id']}trending2
                    restrending.data.second_trending.forEach(function(item) {
                        let div = `
                            <div class="showcase">

                                <a href="/products/${item['id']}" class="showcase-img-box">
                                    <img src="${item['image']}"
                                        alt="${item['title']}" width="70"
                                        class="showcase-img">
                                </a>

                                <div class="showcase-content">

                                    <a href="/products/${item['id']}">
                                        <h4 class="showcase-title">${item['title']}</h4>
                                    </a>

                                    <a href="/products/${item['id']}" class="showcase-category">${item.categories['categoryName']}</a>

                                    <div class="price-box">
                                        <p><strong><del>${item['price']}</del></strong></p>  
                                      <p class="price"><strong>${item['discount_price']}</strong></p>
                                    </div>

                                </div>

                            </div>
                        `;

                        // Append the constructed HTML to the /products/${item['id']}trending2 element
                        document.getElementById("trending2").innerHTML += div;
                    });

                    // After categories are loaded, add event listeners for the accordion behavior
        } catch (error) {
            console.error('Error loading trending:', error);
        }

        //Top Rateded
        try {
            let restopRate = await axios.get("top-rate");
                // console.log(restopRate)
                    // Clear existing items for both topRate and topRate2
                    document.getElementById("topRate").innerHTML = '';
                    document.getElementById("topRate2").innerHTML = '';

                    // Loop through the first topRate of new arrivals and append to /products/${item['id']}topRate
                    restopRate.data.first_top.forEach(function(item) {
                        let div = `
                            <div class="showcase">

                                <a href="/products/${item['id']}" class="showcase-img-box">
                                    <img src="${item['image']}"
                                        alt="${item['title']}" width="70"
                                        class="showcase-img">
                                </a>

                                <div class="showcase-content">

                                    <a href="/products/${item['id']}">
                                        <h4 class="showcase-title">${item['title']}</h4>
                                    </a>

                                    <a href="/products/${item['id']}" class="showcase-category">${item.categories['categoryName']}</a>

                                    <div class="price-box">
                                        <p><strong><del>${item['price']}</del></strong></p>  
                                      <p class="price"><strong>${item['discount_price']}</strong></p>
                                    </div>

                                </div>

                            </div>
                        `;

                        // Append the constructed HTML to the /products/${item['id']}top element
                        document.getElementById("topRate").innerHTML += div;
                    });

                    // Loop through the second topRate2 of new arrivals and append to /products/${item['id']}topRate2
                    restopRate.data.second_top.forEach(function(item) {
                        let div = `
                            <div class="showcase">

                                <a href="/products/${item['id']}" class="showcase-img-box">
                                    <img src="${item['image']}"
                                        alt="${item['title']}" width="70"
                                        class="showcase-img">
                                </a>

                                <div class="showcase-content">

                                    <a href="/products/${item['id']}">
                                        <h4 class="showcase-title">${item['title']}</h4>
                                    </a>

                                    <a href="/products/${item['id']}" class="showcase-category">${item.categories['categoryName']}</a>

                                    <div class="price-box">
                                        <p><strong><del>${item['price']}</del></strong></p>  
                                      <p class="price"><strong>${item['discount_price']}</strong></p>
                                    </div>

                                </div>

                            </div>
                        `;

                        // Append the constructed HTML to the /products/${item['id']}topRate2 element
                        document.getElementById("topRate2").innerHTML += div;
                    });

                    // After categories are loaded, add event listeners for the accordion behavior
        } catch (error) {
            console.error('Error loading top Rate:', error);
        }

        //Deal Of The Day
        try {
            let restDeal = await axios.get("deal-of-day");
            // console.log(restDeal);

            // Clear existing items
            document.getElementById("dealOfDay").innerHTML = '';

            let dealHTML = '';
            restDeal.data.forEach(function(item) {
            let countdownEnd = new Date(item['count_down']);  // Assuming 'deal_end_time' is in your data
            let star = item.products['star'];  // Make sure the key is correct, 'star' should be part of 'item.products'
            let productId = item.products['id'];  // Unique product ID

            dealHTML += `
                        <div class="showcase-container">
                            <div class="showcase">
                                <div class="showcase-banner">
                                    <img src="${item['image_url']}" alt="product image" class="showcase-img">
                                </div>
                                <div class="showcase-content">
                                    <div class="showcase-rating" id="rating-container-${productId}"></div> <!-- Unique ID here -->

                                    <a href="/products/${item['id']}">
                                        <h3 class="showcase-title">${item.products?.['title'] || 'No Title'}</h3>
                                    </a>
                                    <p class="showcase-desc">
                                        ${item.products?.['short_des'] || 'No Description'}
                                    </p>
                                    <div class="price-box">
                                        <p class="price">Tk ${item.products?.['descount_price'] || 0}</p>
                                        <del>Tk ${item.products?.['price'] || 0}</del>
                                    </div>
                                    <form action="" method="POST">
                                        @csrf
                                        <div class="row my-2">
                                            <input type="text" value="Black, Golden, White" id="p_color" class="form-control mx-2" style="width:50%;">
                                            <input type="number" min="0" value="1" name="quantity" step="1" class="form-control mx-2" style="width:40%; float:right;" aria-label="Quantity" id="p_qty">
                                        </div>
                                        <input type="text" value="${item['id']}" class="d-none" id="p_id">

                                    </form>
                                    <button onclick="AddToCart()" class="add-cart-btn">add to cart</button>
                                    <div class="showcase-status">
                                        <div class="wrapper">
                                            <p>Already sold: <b>${item['sold']}</b></p>
                                            <p>Available: <b>${item.products?.['stock'] || 0}</b></p>
                                        </div>
                                        <div class="showcase-status-bar">
                                            <div class="showcase-progress" style="width: ${calculateProgress(item['sold'], item.products?.['stock'])};"></div>
                                        </div>
                                    </div>

                                    <div class="countdown-box">
                                        <p class="countdown-desc">Hurry Up! Offer ends in:</p>
                                        <div class="countdown" data-end-time="${countdownEnd}">
                                            <div class="countdown-content">
                                                <p class="display-number days">--</p>
                                                <p class="display-text">Days</p>
                                            </div>
                                            <div class="countdown-content">
                                                <p class="display-number hours">--</p>
                                                <p class="display-text">Hours</p>
                                            </div>
                                            <div class="countdown-content">
                                                <p class="display-number minutes">--</p>
                                                <p class="display-text">Min</p>
                                            </div>
                                            <div class="countdown-content">
                                                <p class="display-number seconds">--</p>
                                                <p class="display-text">Sec</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    // Render the stars dynamically for each product after appending the dealHTML
                    setTimeout(() => {
                        renderStars(star, `rating-container-${productId}`);
                    }, 0);
                });

            // Insert into DOM
            document.getElementById("dealOfDay").innerHTML = dealHTML;

            // Countdown logic
            let countdownElements = document.querySelectorAll('.countdown');
            countdownElements.forEach(function(countdownElement) {
                let endTime = new Date(countdownElement.getAttribute('data-end-time')).getTime();

                let countdownInterval = setInterval(function() {
                    let now = new Date().getTime();
                    let distance = endTime - now;

                    if (distance < 0) {
                        clearInterval(countdownInterval);
                        countdownElement.innerHTML = "EXPIRED";
                    } else {
                        let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        countdownElement.querySelector('.days').innerText = days;
                        countdownElement.querySelector('.hours').innerText = hours;
                        countdownElement.querySelector('.minutes').innerText = minutes;
                        countdownElement.querySelector('.seconds').innerText = seconds;
                    }
                }, 1000);
            });
        } catch (error) {
            console.error('Error loading Deal Of the day:', error);
        }

        //New products
        let currentPage = 1;  // Track the current page
        const perPage = 12; // Products per page
        let nextPageUrl = null; // Store next page URL

        // Function to fetch and append products without changing the URL
        async function fetchProducts(page = 1, append = false) {
            try {
                let res = await axios.get(`/new-products?page=${page}&limit=${perPage}`);

                // console.log(res);
                let NewProductHtml = '';

                res.data.data.forEach((item) => {
                    let productId = item['id'];
                    let color = Array.isArray(item.product_details) && item.product_details.length > 0 
                        ? item.product_details[0].color 
                        : item?.product_details?.color; // Handle both array and single object cases
                    let img2 = Array.isArray(item.product_details) && item.product_details.length > 0 
                        ? item.product_details[0].img2 
                        : item?.product_details?.img2; // Handle both array and single object cases

                    // console.log(color);
                    NewProductHtml += `
                        <div class="showcase">
                            <div class="showcase-banner">
                                <img src="${item.image}" alt="${item.title}" class="product-img default" width="300">
                                <img src="${img2}" alt="${item.title}" class="product-img hover" width="300">
                                <p class="showcase-badge angle pink">${item.discount}</p>
                                <div class="showcase-actions">
                                    
                            
                                    <button class="btn-action" title="View Details">
                                        <a href="/products/${productId}">
                                            <ion-icon name="eye-outline"></ion-icon>
                                        </a>
                                    </button>

                                    <button class="btn-action" onclick="AddToCartFromAll(this)">
                                        <ion-icon name="cart-outline"></ion-icon>
                                    </button>
                                    
                            
                                    <button class="btn-action">
                                        <a href="/order-form/${productId}">
                                            <ion-icon name="bag-add-outline"></ion-icon>
                                        </a>
                                        
                                    </button>
                                </div>
                            </div>
                
                            <div class="showcase-content">
                                <a href="/product-category/${item.categories?.categoryName}" class="showcase-category">${item.categories?.categoryName || 'Uncategorized'}</a>

                                <h3>
                                    <a href="/products/${productId}" class="showcase-title">${item.title}</a>
                                </h3>

                                <div class="showcase-rating" id="rating-container-${productId}"></div>

                                <div class="price-box">
                                    <p><strong><del>${item.price}</del></strong></p>  
                                    <p class="price"><strong>${item.discount_price}</strong></p>
                                </div>
                            </div>
                            
                                <div class="row my-2">
                                    <input type="hidden" value="${color || 'null'} " class="p_color_all">
                                    <input type="hidden" min="0" value="1" name="quantity" step="1" aria-label="Quantity" class="p_qty_all">
                                </div>
                                <input type="hidden" value="${productId}" class="p_id_all">

                            
                        </div>
                    `;
                });

                if (append) {
                    // Append new products without removing old ones
                    document.getElementById("newProductsList").innerHTML += NewProductHtml;
                } else {
                    // Load fresh products (first-time load)
                    document.getElementById("newProductsList").innerHTML = NewProductHtml;
                }

                // Render stars after updating the DOM
                res.data.data.forEach((item) => {
                    renderStars(item.star, `rating-container-${item.id}`);
                });

                // Update next page URL
                nextPageUrl = res.data.next_page_url;

                // Hide "Load More" button if no more pages
                if (!nextPageUrl) {
                    document.getElementById("loadMoreBtn").style.display = "none";
                }
            } catch (error) {
                console.error('Error loading products:', error);
            }
        }

        // Function to load next page without changing URL
        function loadNextProducts() {
            if (nextPageUrl) {
                currentPage++; // Increase page count
                fetchProducts(currentPage, true); // Append new products
            }
        }

        // Load first page on page load
        fetchProducts();

        // Event Listener for "Load More" button
        document.getElementById("loadMoreBtn").addEventListener("click", loadNextProducts);


        




    }

  // Calculate the percentage of items sold out of total stock
  function calculateProgress(sold, stock) {
    if (!stock || stock == 0) return '0%';
    const progress = (sold / stock) * 100;
    return `${progress}%`;
  }






    // Function to render stars dynamically
    function renderStars(rating, containerId) {
        const maxStars = 5;
        const ratingContainer = document.getElementById(containerId);
        if (!ratingContainer) return; // Exit if container is not found
        ratingContainer.innerHTML = ''; // Clear any existing stars

        for (let i = 1; i <= maxStars; i++) {
            const starIcon = document.createElement('ion-icon');

            // Full star for ratings greater than or equal to the current index
            if (i <= Math.floor(rating)) {
                starIcon.setAttribute('name', 'star'); // Full star
            }
            // Half star logic for fractional ratings
            else if (i === Math.ceil(rating) && rating % 1 !== 0) {
                starIcon.setAttribute('name', 'star-half'); // Half star
            }
            // Outlined star for remaining stars
            else {
                starIcon.setAttribute('name', 'star-outline'); // Empty star
            }

            ratingContainer.appendChild(starIcon); // Append to the container
        }
    }
    </script>

@endpush
