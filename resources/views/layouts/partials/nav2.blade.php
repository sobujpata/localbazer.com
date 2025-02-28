
<div class="navigation">
    <ul>
        <!-- <li style="position: fixed; border-color: black;"> -->
        <li>
            <a href="{{url('/dashboard')}}">
                <span class="icon">
                    <img src="{{asset('/images/logo/it-logo.jpg')}}" alt="" style="width:40px; border-radius: 8px;;">
                </span>
                <span class="title">The it Solution Bd</span>
            </a>
        </li>

        <li>
            <a class="{{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}" href="{{url('/dashboard')}}">
                <span class="icon">
                    <ion-icon name="home-outline"></ion-icon>
                </span>
                <span class="title">Dashboard</span>
            </a>
        </li>

        <li>
            <a href="{{ url('/orders') }}" class="{{ Route::currentRouteName() == 'orders' ? 'active' : '' }}">
                <span class="icon">
                    <ion-icon name="gift-outline"></ion-icon>
                </span>
                <span class="title">Orders</span>
            </a>
        </li>

        <li>
            <a href="{{ url('/customers') }}" class="{{ Route::currentRouteName() == 'customers' ? 'active' : '' }}">
                <span class="icon">
                    <ion-icon name="people-outline"></ion-icon>
                </span>
                <span class="title">Customers</span>
            </a>
        </li>

        <li>
            <a href="{{ url('/products-list') }}" class="{{ Route::currentRouteName() == 'products-list' ? 'active' : '' }}">
                <span class="icon">
                    <ion-icon name="cube-outline"></ion-icon>
                </span>
                <span class="title">Products</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/product-slider-admin') }}" class="{{ Route::currentRouteName() == 'product-slider-admin' ? 'active' : '' }}">
                <span class="icon">
                    <ion-icon name="cube-outline"></ion-icon>
                </span>
                <span class="title">Product Slider</span>
            </a>
        </li>

        <li>
            <a href="{{url('/main-category')}}" class="{{ Route::currentRouteName() == 'main-category' ? 'active' : '' }}">
                <span class="icon">
                    <ion-icon name="add-circle-outline"></ion-icon>
                </span>
                <span class="title">Main Category</span>
            </a>
        </li> 
        <li>
            <a href="{{url('/sub-category')}}" class="{{ Route::currentRouteName() == 'sub-category' ? 'active' : '' }}">
                <span class="icon">
                    <ion-icon name="add-circle-outline"></ion-icon>
                </span>
                <span class="title">Sub Category</span>
            </a>
        </li> 
        <li>
            <a href="{{url('/brand-list')}}" class="{{ Route::currentRouteName() == 'brand-list' ? 'active' : '' }}">
                <span class="icon">
                    <ion-icon name="add-circle-outline"></ion-icon>
                </span>
                <span class="title">Brand</span>
            </a>
        </li> 
        <li>
            <a href="{{url('/deal-of-the-day-admin')}}" class="{{ Route::currentRouteName() == 'deal-of-the-day' ? 'active' : '' }}">
                <span class="icon">
                    <ion-icon name="add-circle-outline"></ion-icon>
                </span>
                <span class="title">Deal Of The Day</span>
            </a>
        </li> 

        <li>
            <a href="{{ url('/setting') }}" class="{{ Route::currentRouteName() == 'setting' ? 'active' : '' }}">
                <span class="icon">
                    <ion-icon name="settings-outline"></ion-icon>
                </span>
                <span class="title">Settings</span>
            </a>
        </li>

        <!-- <li>
            <a href="./profile.html">
                <span class="icon">
                    <ion-icon name="person-circle-outline"></ion-icon>
                </span>
                <span class="title">Profile</span>
            </a>
        </li> -->

        <li>
            <a href="{{ url('/logout') }}">
                <span class="icon">
                    <ion-icon name="log-out-outline"></ion-icon>
                </span>
                <span class="title">Sign Out</span>
            </a>
        </li>
    </ul>
</div>