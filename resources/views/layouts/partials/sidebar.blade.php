<!--- SIDEBAR-->

        <div class="sidebar  has-scrollbar" data-mobile-menu>

            <div class="sidebar-category">

                <div class="sidebar-top">
                    <h2 class="sidebar-title">Category</h2>

                    <button class="sidebar-close-btn" data-mobile-menu-close-btn>
                        <ion-icon name="close-outline"></ion-icon>
                    </button>
                </div>

                <ul class="sidebar-menu-category-list" id="category-list">

                </ul>

            </div>

            <div class="product-showcase">

                <h3 class="showcase-heading">best sellers</h3>

                <div class="showcase-wrapper">

                    <div class="showcase-container" id="BestSale">

                    </div>
                    <a href="#" style="text-align: right">See All</a>
                </div>

            </div>

        </div>
        @push('custom-scripts')
        <script>
            getCategoryData();

            async function getCategoryData() {
                try {
                    let res = await axios.get("Category-list");

                    // Clear existing categories if necessary
                    document.getElementById("category-list").innerHTML = '';

                    res.data.forEach(function(mainCategory) {
                        let li = `
                            <li class="sidebar-menu-category">
                                <button class="sidebar-accordion-menu" data-accordion-btn aria-expanded="false">
                                    <div class="menu-title-flex">
                                        <img src="${mainCategory["categoryImg"]}" alt="clothes" width="20" height="20" class="menu-title-img">
                                        <p class="menu-title">${mainCategory["categoryName"]}</p>
                                    </div>
                                    <div>
                                        <ion-icon name="add-outline" class="add-icon"></ion-icon>
                                        <ion-icon name="remove-outline" class="remove-icon" style="display:none;"></ion-icon>
                                    </div>
                                </button>
                                <ul class="sidebar-submenu-category-list" data-accordion style="display:none;">
                        `;

                        mainCategory.categories.forEach(function(category) {
                            li += `
                                <li class="sidebar-submenu-category">
                                <a href="/product-category/${category["categoryName"]}" class="sidebar-submenu-title">
                                        <p class="product-name">${category["categoryName"]}</p>
                                        <data value="300" class="stock" title="Available Stock">300</data>
                                    </a>
                                </li>
                            `;
                        });

                        li += `
                                </ul>
                            </li>
                        `;

                        // Append the constructed HTML to the sidebar
                        document.getElementById("category-list").innerHTML += li;
                    });

                    // After categories are loaded, add event listeners for the accordion behavior
                    addAccordionListeners();
                } catch (error) {
                    console.error('Error loading categories:', error);
                }

                //best sale

                try {
                    let resBestSale = await axios.get('best-sale');

                    // Clear existing categories if necessary
                    document.getElementById("BestSale").innerHTML = '';

                    resBestSale.data.forEach(function(item) {
                        let li = `
                            <div class="showcase">

                            <a href="/products/${item['id']}" class="showcase-img-box">
                                <img src="${item['image']}" alt="${item['title']}"
                                    width="75" height="75" class="showcase-img">
                            </a>

                            <div class="showcase-content">

                                <a href="/products/${item['id']}">
                                    <h4 class="showcase-title">${item['title']}</h4>
                                </a>

                                <div class="showcase-rating">
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                </div>

                                <div class="price-box">
                                    <del>Tk${item['price']}</del>
                                    <p class="price">Tk${item['discount_price']}</p>
                                </div>

                            </div>

                        </div>
                        `;

                        // Append the constructed HTML to the sidebar
                        document.getElementById("BestSale").innerHTML += li;
                    });

                } catch (error) {
                    console.error('Error loading BestSale:', error);
                }

            }

            function addAccordionListeners() {
                document.querySelectorAll('.sidebar-accordion-menu').forEach(button => {
                    button.addEventListener('click', function() {
                        let submenu = this.nextElementSibling;
                        let isVisible = submenu.style.display === "block";

                        // Toggle the visibility of the submenu
                        submenu.style.display = isVisible ? "none" : "block";

                        // Update the aria-expanded attribute
                        this.setAttribute('aria-expanded', !isVisible);

                        // Change icons based on the submenu state
                        this.querySelector('.add-icon').style.display = isVisible ? "block" : "none";
                        this.querySelector('.remove-icon').style.display = isVisible ? "none" : "block";
                    });
                });
            }
        </script>
        @endpush
        
