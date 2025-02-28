   <!--- HEADER-->
   <style>
       .menu-container {
           display: flex;
           /* Aligns menu items horizontally */
           list-style: none;
           /* Removes default list bullets */
           padding: 0;
           margin: 0;
           gap: 20px;
           /* Space between menu items */
       }

       .menu-category {
           position: relative !important;
       }
   </style>
   <header>
       <div class="header-top">

           <div class="container">

               <ul class="header-social-container">

                   <li>
                       <a href="https://www.facebook.com/share/15Qmbw5FyW/" class="social-link" target="_blank">
                           <ion-icon name="logo-facebook"></ion-icon>
                       </a>
                   </li>

                   <li>
                       <a href="#" class="social-link">
                           <ion-icon name="logo-twitter"></ion-icon>
                       </a>
                   </li>

                   <li>
                       <a href="#" class="social-link">
                           <ion-icon name="logo-instagram"></ion-icon>
                       </a>
                   </li>

                   <li>
                       <a href="#" class="social-link">
                           <ion-icon name="logo-linkedin"></ion-icon>
                       </a>
                   </li>

               </ul>

               <div class="header-alert-news">
                   <p>
                       <b>Free Shipping</b>
                       This Week Order Over - 5,000.00৳
                   </p>
               </div>

               <div class="header-top-actions">

                   <select name="currency">

                       {{-- <option value="usd">USD &dollar;</option> --}}
                       <option value="eur">Taka ৳</option>

                   </select>

                   <select name="language">

                       <option value="en-US">English</option>
                       {{-- <option value="es-ES">Bangla</option> --}}

                   </select>

               </div>

           </div>
           <div class="header-main">

               <div class="container">

                   <a class='header-logo' href='/'>
                       <img src="{{ asset('images/logo.png') }}" alt="It Solution logo"
                           style="width: 200px; height:90px;">
                   </a>

                   <div class="header-search-container dropdown">
                       <form action="{{ url('/products/search/') }}" method="get">
                           <input type="search" name="search" class="search-field"
                               placeholder="Enter your product name..." id="search">

                           <button class="search-btn">
                               <ion-icon name="search-outline"></ion-icon>
                           </button>
                       </form>

                       <ul id="searchResults" class="dropdown-menu w-100"></ul>

                   </div>



                   <script>
                       document.getElementById('search').addEventListener('keyup', function() {
                           let query = this.value;
                           let dropdown = document.getElementById('searchResults');

                           if (query.length > 2) {
                               axios.get('/search-products', {
                                       params: {
                                           q: query
                                       }
                                   })
                                   .then(response => {
                                       let results = response.data;
                                       if (results.length > 0) {
                                           let suggestions = results.map(product =>
                                               `<li>
                                <a class="dropdown-item" href="/products/${product.id}">
                                    <div class="row">
                                        <div class="col-2">
                                            <img src="/${product.image}?t=${new Date().getTime()}" class="me-2 w-md-80 w-100 rounded-2">
                                        </div>    
                                        <div class="col-10">
                                            ${product.title} <br> 
                                            <del class="text-decoration-line-through">$${product.price}</del> - $${product.discount_price}
                                        </div>    
                                    </div>
                                     
                                </a>
                            </li>`
                                           ).join('');
                                           dropdown.innerHTML = suggestions;
                                           dropdown.classList.add('show'); // Show dropdown
                                       } else {
                                           dropdown.classList.remove('show');
                                       }
                                   });
                           } else {
                               dropdown.classList.remove('show'); // Hide dropdown when no input
                           }
                       });

                       // Hide dropdown when clicking outside
                       document.addEventListener('click', function(e) {
                           if (!document.getElementById('search').contains(e.target)) {
                               document.getElementById('searchResults').classList.remove('show');
                           }
                       });
                   </script>

                   <div class="header-user-actions">
                       <a href="{{ url('/profile') }}">
                           <button class="action-btn">

                               <ion-icon name="person-outline"></ion-icon>
                           </button>
                       </a>

                       <button class="action-btn">
                           <ion-icon name="heart-outline"></ion-icon>
                           {{-- <span class="count" id="countCartDesktop">0</span> --}}
                       </button>
                       <a href="/cart">
                           <button class="action-btn">
                               <ion-icon name="bag-handle-outline"></ion-icon>
                               {{-- <span class="count"></span> --}}
                           </button>
                       </a>
                   </div>

               </div>

           </div>

           <nav class="desktop-navigation-menu">

               <div class="container">

                   <ul class="desktop-menu-category-list">

                       <li class="menu-category">
                           <a href="{{ '/' }}" class="menu-title">Home</a>
                       </li>

                       <li class="menu-category">
                           <a href="#" class="menu-title">Categories</a>

                           <div id="category-dropdown" class="dropdown-panel"></div>
                       </li>
                       {{-- main nav push --}}
                       <span id="menuList" class="menu-container"></span>


                       <li class="menu-category menu-category-nav">
                           <a href="{{ url('/products-remark/Special') }}" class="menu-title">Hot Offers</a>
                       </li>

                       @if (Cookie::get('token') !== null)
                           <li class="menu-category"><a href="{{ url('/invoices') }}" class="menu-title">Orders</a>
                           </li>
                           {{-- <li class="menu-category"><a href="{{ url('/profile') }}" class="menu-title">Account</a>
                           </li> --}}
                           <li class="menu-category"><a href="{{ url('/logout') }}" class="menu-title">Logout</a>
                           </li>
                       @else
                           <li class="menu-category"><a href="{{ url('/login') }}" class="menu-title">Login</a></li>
                       @endif

                   </ul>

               </div>

           </nav>
           <style>
               body {
                   font-family: "Lato", sans-serif;
               }

               .sidenav {
                   height: 100%;
                   width: 0;
                   position: fixed;
                   z-index: 1;
                   top: 0;
                   left: 0;
                   background-color: #fcfcfc;
                   overflow-x: hidden;
                   transition: 0.5s;
                   padding-top: 15px;
               }

               .sidenav a {
                   padding: 2px 8px 2px 32px;
                   text-decoration: none;
                   font-size: 25px;
                   color: #0e0d0d;
                   display: block;
                   transition: 0.3s;
               }

               .sidenav a:hover {
                   color: #b7f0b0;
               }

               .sidenav .closebtn {
                   position: absolute;
                   top: 0;
                   right: 0;
                   font-size: 36px;
                   margin-left: 50px;
               }

               .mobile-hover-menu {
                   padding: 6px;
               }

               .mobile-hover-menu:hover {
                   background-color: #f7d9d9;
                   border-radius: 8px;
                   padding: 6px;
               }

               @media screen and (max-height: 450px) {
                   .sidenav {
                       padding-top: 15px;
                   }

                   .sidenav a {
                       font-size: 18px;
                   }
               }
           </style>
           {{-- mobile side main menu bar --}}
           <div id="mySidenav" class="sidenav">
               <div class="row mb-3">
                   <div class="col-10">
                       <img src="{{ asset('images/logo/it-logo2.jpg') }}" alt="It Solution logo"
                           style="width: 150px; height:40px;">
                   </div>
                   <div class="col-2">
                       <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                   </div>
               </div>
               <p class="mb-2 mobile-hover-menu ">
                   <a href="/" class="text-dark ">Home</a>
               </p>
               <p class="mb-2 mobile-hover-menu">
                   <a data-bs-toggle="collapse" href="#collapse-category" role="button" aria-expanded="false"
                       aria-controls="collapse-category" class="text-dark">
                       Categories <span style="float:right;" class="text-bold">+</span>
                   </a>
               </p>

               <div class="collapse" id="collapse-category">
                   @foreach ($mainCategories as $item)
                       <ul>
                           <li>
                               <a data-bs-toggle="collapse" href="#sub-category-{{ $item->id }}" role="button"
                                   aria-expanded="false" aria-controls="sub-category-{{ $item->id }}"
                                   class="text-dark">
                                   {{ $item->categoryName }} <span style="float:right;" class="text-bold">+</span>
                               </a>
                               <div class="collapse" id="sub-category-{{ $item->id }}">
                                   @if ($item->categories->isNotEmpty())
                                       <ul>
                                           @foreach ($item->categories as $subcategory)
                                               <li>
                                                   <a class="text-dark"
                                                       href="{{ url('/product-category/' . urlencode($subcategory->categoryName)) }}">{{ $subcategory->categoryName }}
                                                       <span style="float:right">300</span>
                                                   </a>
                                               </li>
                                           @endforeach
                                       </ul>
                                   @else
                                       <p>No subcategories available.</p>
                                   @endif
                               </div>
                           </li>
                       </ul>
                   @endforeach
               </div>
               <span id="menuListMobile" style="width:330px !important">



               </span>
               <p class="mb-2 mobile-hover-menu ">
                   <a href="{{ url('/products-remark/Special') }}" class="text-dark">Hot Offers</a>
               </p>

               @if (Cookie::get('token') !== null)
                   <p class="mb-2 mobile-hover-menu ">
                       <a href="{{ url('profile') }}" class="text-dark">Account</a>

                   </p>
                   <p class="mb-2 mobile-hover-menu ">
                       <a href="{{ url('/logout') }}" class="text-dark">Logout</a>

                   </p>
               @else
                   <p class="mb-2 mobile-hover-menu ">
                       <a href="{{ url('/login') }}" class="text-dark">Login</a>

                   </p>
               @endif
           </div>
           {{-- mobile side category menu bar --}}
           <div id="categoryManu" class="sidenav">
               <div class="row">
                   <div class="col-10">
                       <img src="{{ asset('images/logo/it-logo2.jpg') }}" alt="It Solution logo"
                           style="width: 150px; height:40px;">
                   </div>
                   <div class="col-2">
                       <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                   </div>
               </div>
               <!--- SIDEBAR-->

               <div class="sidebar-category">

                   <div class="sidebar-top">
                       <h2 class="mt-4 mx-4">Product Categories</h2>
                   </div>

                   <ul class="sidebar-menu-category-list" id="category-list">
                       @foreach ($mainCategories as $item)
                           <p>
                               <a data-bs-toggle="collapse" href="#collapse-{{ $item->id }}" role="button"
                                   aria-expanded="false" aria-controls="collapse-{{ $item->id }}"
                                   class="text-dark">
                                   <span><img src="{{ asset($item->categoryImg) }}" alt="clothes" width="20"
                                           height="20" class="menu-title-img"></span> {{ $item->categoryName }}
                                   <span style="float:right;" class="text-bold">+</span>
                               </a>
                           </p>
                           <div class="collapse" id="collapse-{{ $item->id }}">
                               @if ($item->categories->isNotEmpty())
                                   <ul>
                                       @foreach ($item->categories as $subcategory)
                                           <li>
                                               <a class="text-dark"
                                                   href="{{ url('/product-category/' . urlencode($subcategory->categoryName)) }}">{{ $subcategory->categoryName }}
                                                   <span style="float:right">>></span>
                                               </a>
                                           </li>
                                       @endforeach
                                   </ul>
                               @else
                                   <p>No subcategories available.</p>
                               @endif
                           </div>
                       @endforeach


                   </ul>

               </div>

               <div class="product-showcase">

                   <h3 class="showcase-heading">best sellers</h3>

                   <div class="showcase-wrapper">

                       <div class="showcase-container" id="BestSale">
                           {{-- @dd($bestSale) --}}
                           @foreach ($bestSale as $item)
                               <div class="row">
                                   <div class="col-12">
                                       <div class="row">
                                           <div class="col-4">
                                               <a href="#" class="">
                                                   <img src="{{ asset($item->image) }}" alt="baby fabric shoes"
                                                       width="75" height="75" class="showcase-img">
                                               </a>
                                           </div>
                                           <div class="col-8">
                                               <div class="row">
                                                   <div class="col-12 text-left">
                                                       <a href="#" class="p-0">
                                                           {{ $item->title }}
                                                       </a>
                                                   </div>
                                                   <div class="col-12">
                                                       <div class="price-box">
                                                           <del>{{ $item->price }}</del>
                                                           <p class="price">{{ $item->discount_price }}</p>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           @endforeach

                       </div>
                       <a href="#" style="text-align: right">See All</a>
                   </div>

               </div>



           </div>

           <div class="mobile-bottom-navigation">

               <button class="action-btn" onclick="openNav()">
                   <ion-icon name="menu-outline"></ion-icon>
               </button>
               <a href="{{ url('/cart') }}">
                   <button class="action-btn">
                       <ion-icon name="bag-handle-outline"></ion-icon>

                       {{-- <span class="count" id="countCartMobile"></span> --}}
                   </button>
               </a>
               <a href='/'>
                   <button class="action-btn">
                       <ion-icon name="home-outline">
                       </ion-icon>
                   </button>
               </a>

               <button class="action-btn">
                   <ion-icon name="heart-outline"></ion-icon>

                   {{-- <span class="count">0</span> --}}
               </button>

               <button class="action-btn" onclick="categorynNavOpen()">
                   <ion-icon name="grid-outline"></ion-icon>
               </button>

           </div>



   </header>

   <script>
       function openNav() {
           document.getElementById("mySidenav").style.width = "330px";
       }

       function categorynNavOpen() {
           document.getElementById("categoryManu").style.width = "330px";
       }

       function closeNav() {
           document.getElementById("mySidenav").style.width = "0";
           document.getElementById("categoryManu").style.width = "0";
       }
   </script>
   <script>
       document.addEventListener("DOMContentLoaded", function() {
           axios.get("{{ url('/category-main-nav') }}")
               .then(response => {
                   const data = response.data;
                   const categoryContainer = document.getElementById("category-dropdown");
                   categoryContainer.innerHTML = ""; // Clear previous data

                   data.mainCategories.forEach(mainCategory => {
                       let subCategoriesHtml = "";

                       if (data.subCategories[mainCategory.id]) {
                           data.subCategories[mainCategory.id].forEach(subCategory => {
                               subCategoriesHtml += `<li class="panel-list-item">
                                <a href="/product-category/${subCategory.categoryName}">${subCategory.categoryName}</a>
                            </li>`;
                           });
                       }

                       categoryContainer.innerHTML += `
                        <ul class="dropdown-panel-list">
                            <li class="menu-title">
                                <a href="#">${mainCategory.categoryName}</a>
                            </li>
                            ${subCategoriesHtml}
                            <li class="panel-list-item">
                                <a href="#">
                                    <img src="{{ asset('${mainCategory.categoryImg}') }}" alt="${mainCategory.categoryName}" width="250" height="119">
                                </a>
                            </li>
                        </ul>
                    `;
                   });
               })
               .catch(error => console.error("Error fetching categories:", error));
       });


       async function getNav() {
           try {
               let res = await axios.get('/nav-menu');

               let menuList = $("#menuList");
               menuList.html(''); // Clear previous menu items
               let menuListMobile = $("#menuListMobile");
               menuListMobile.html(''); // Clear previous menu items

               let menuMap = {}; // To group submenus under their respective main menu

               res.data.forEach(item => {
                   let mainMenuId = item['main_menu']['id'];
                   let mainMenuName = item['main_menu']['name'];
                   let subMenuName = item['name'];
                   let subMenuUrl = item['url'] || "#"; // Ensure a valid URL

                   // If main menu doesn't exist, create it
                   if (!menuMap[mainMenuId]) {
                       menuMap[mainMenuId] = {
                           name: mainMenuName,
                           subMenus: []
                       };
                   }
                   menuMap[mainMenuId].subMenus.push({
                       name: subMenuName,
                       url: subMenuUrl
                   });
               });

               // Render the desktop menu
               Object.values(menuMap).forEach(menu => {
                   let mainMenuLi = $(`
                <li class="menu-category">
                    <a href="#" class="menu-title px-2">${menu.name}</a>
                    <ul class="dropdown-list"></ul>
                </li>
            `);

                   let dropdownList = mainMenuLi.find(".dropdown-list");

                   menu.subMenus.forEach(subMenu => {
                       dropdownList.append(
                           `<li class="dropdown-item"><a href="${subMenu.url}">${subMenu.name}</a></li>`
                       );
                   });

                   menuList.append(mainMenuLi);
               });

               // Render the mobile menu
               Object.values(menuMap).forEach(menu => {
                   let menuSlug = menu.name.replace(/\s+/g, '-').toLowerCase(); // Sanitize name for IDs
                   let mainMenuLiMobile = $(`
                <li class="menu-category">
                    <p class="mb-2 mobile-hover-menu">
                        <a data-bs-toggle="collapse" href="#collapse-${menuSlug}" role="button" aria-expanded="false"
                            aria-controls="collapse-${menuSlug}" class="text-dark">
                            ${menu.name} <span style="float:right;" class="text-bold">+</span>
                        </a>
                    </p>
                    <div class="collapse" id="collapse-${menuSlug}">
                        <ul class="dropdown-list"></ul>
                    </div>
                </li>
            `);

                   let dropdownList = mainMenuLiMobile.find(".dropdown-list");

                   menu.subMenus.forEach(subMenu => {
                       dropdownList.append(
                           `<li class="dropdown-item"><a href="${subMenu.url}" class="text-dark">${subMenu.name}</a></li>`
                       );
                   });

                   menuListMobile.append(mainMenuLiMobile);
               });

           } catch (error) {
               console.error("Failed to fetch navigation menu:", error);
               alert("Error loading menu. Please try again.");
           }
       }

       getNav();
   </script>
