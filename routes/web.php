<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MainMenuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfferCardController;
use App\Http\Controllers\TestimonialController;
use App\Http\Middleware\TokenVerificationMiddleware;
use App\Http\Controllers\Admin\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', [HomeController::class, 'index']);

 //products search
 Route::get('/search-products', function (Request $request) {
    $query = $request->query('q');
    
    if (!$query) {
        return response()->json([]);
    }

    // Fetch products from the database
    $products = Product::where('title', 'LIKE', "%{$query}%")
        ->limit(20)
        ->get(['id', 'title', 'price','discount_price', 'image']); // Adjust fields as needed

    return response()->json($products);
});

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

//Category Api
Route::get('/notification', [OfferCardController::class, "Notification"]);
Route::get('/Category-header-list', [CategoryController::class, "CategoryHeader"]);

Route::get('/Category-list', [CategoryController::class, "CategoryList"]);

Route::get('/product-banner', [BannerController::class, 'GetBanner']);

Route::get('/best-sale', [ProductController::class, 'bestSale']);

Route::get('/new-arrivals', [ProductController::class, 'NewArrivals']);

Route::get('/trending', [ProductController::class, 'TrendingProduct']);

Route::get('/top-rate', [ProductController::class, 'TopRateProduct']);

Route::get('/deal-of-day', [ProductController::class, 'DealOfDay']);

Route::get('/new-products', [ProductController::class, "NewProducts"]);

// Search products within a category
// Route::get('/product/category/search', [ProductController::class, 'searchCategoryProducts']);
Route::get('/product-category/{categoryName}', [ProductController::class, 'CategoryWise']);

// Route::get('/category-products', [ProductController::class, 'CategoryProducts']);
Route::get('/category-footer', [CategoryController::class, 'CategoryFooter']);
Route::get('/category-main-nav', [CategoryController::class, 'CategoryMainNav']);
Route::get('/nav-menu', [CategoryController::class, 'MainNav']);

//product details
Route::get('/products/{id}', [ProductController::class, 'ProductDetails']);

Route::get('/products-remark/{remark}', [ProductController::class, 'ProductRemark'])->name('product.remark');

Route::get('/offer-card-home', [OfferCardController::class, 'OfferCardHome']);
Route::get('/testimonial', [TestimonialController::class, 'Testimonial']);

Route::get('/services', [ServiceController::class, 'index']);
//demo
Route::get('/blogs-card', [BlogController::class, 'BlogCard']);
//brand category
Route::get('/brand-category', [BrandController::class, 'BrandWithCategory']);

//Auth Route
Route::get('/login', [UserController::class, 'LoginPage']);
Route::get('/registration', [UserController::class, 'RegistrationPage']);
Route::get('/sendOtp', [UserController::class, 'SendOtpPage']);
Route::get('/verifyOtp', [UserController::class, 'VerifyOTPPage']);
// Route::get('/resetPassword',[UserController::class,'ResetPasswordPage'])->middleware([TokenVerificationMiddleware::class]);

// Web API Routes
Route::post('/user-registration', [UserController::class, 'UserRegistration']);
Route::post('/user-login', [UserController::class, 'UserLogin']);
Route::post('/send-otp', [UserController::class, 'SendOTPCode']);
Route::post('/verify-otp', [UserController::class, 'VerifyOTP']);
Route::post('/reset-password', [UserController::class, 'ResetPassword'])->middleware([TokenVerificationMiddleware::class]);

Route::get('/user-profile', [UserController::class, 'UserProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/user-update', [UserController::class, 'UpdateProfile'])->middleware([TokenVerificationMiddleware::class]);

// User Logout
Route::get('/logout', [UserController::class, 'UserLogout']);




//Customer dashboard route
Route::middleware(['user'])->group(function () {
    //profile
    Route::get('/profile', [UserController::class, 'UserProfilePage'])->middleware([TokenVerificationMiddleware::class]);
    Route::get('/customer-profile', [UserController::class, 'GetUserProfile'])->middleware([TokenVerificationMiddleware::class]);
    Route::post('/update-profile', [UserController::class, 'ProfileUpdate'])->middleware([TokenVerificationMiddleware::class]);
    //cart page
    Route::get('/cart', [ProductController::class, 'CartListPage'])->middleware([TokenVerificationMiddleware::class]);
    // Product Cart
    Route::post('/CreateCartList', [ProductController::class, 'CreateCartList'])->middleware([TokenVerificationMiddleware::class]);
    Route::get('/CartList', [ProductController::class, 'CartList'])->middleware([TokenVerificationMiddleware::class]);
    Route::get('/DeleteCartList', [ProductController::class, 'DeleteCartList'])->middleware([TokenVerificationMiddleware::class]);
    Route::get('/cart-count', [ProductController::class, 'CartCount'])->middleware([TokenVerificationMiddleware::class]);
    Route::post('/UpdateCartQuantity', [ProductController::class, 'UpdateCartQuantity'])->middleware([TokenVerificationMiddleware::class]);
    
    

    //Wish API Route
    Route::post('/CreateWishList', [ProductController::class, 'WishlistCreate']);
    
    //invoice Route
    Route::get('/payment-form', [InvoiceController::class, 'InvoicePage'])->middleware([TokenVerificationMiddleware::class]);
    Route::get('/order-form/{id}', [InvoiceController::class, 'OrderPage'])->middleware([TokenVerificationMiddleware::class]);
    Route::get('/invoices', [InvoiceController::class, 'InvoicesCustomer'])->name('invoices.index')->middleware([TokenVerificationMiddleware::class]);
    //invoice API
    Route::post("/create-invoice", [InvoiceController::class, 'InvoiceCreate'])->name('create.invoice')->middleware([TokenVerificationMiddleware::class]);
    Route::post("/delete-invoice", [InvoiceController::class, 'InvoiceDelete'])->middleware([TokenVerificationMiddleware::class]);
    Route::post("/update-invoice", [InvoiceController::class, 'InvoiceUpdate'])->middleware([TokenVerificationMiddleware::class]);
    Route::post("/invoice-by-id", [InvoiceController::class, 'InvoiceByID'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/invoice-customer-list", [InvoiceController::class, 'InvoiceByCustomer'])->middleware([TokenVerificationMiddleware::class]);

});

//admin dashboard
Route::middleware(['admin'])->group(function () {
    //Admin API
    Route::get('/admin-list', [AdminDashboardController::class, 'adminList'])->middleware([TokenVerificationMiddleware::class]);
    Route::post('/admin-by-id', [AdminDashboardController::class, 'adminEdit'])->middleware([TokenVerificationMiddleware::class]);
    Route::get('/user-list', [AdminDashboardController::class, 'userList'])->middleware([TokenVerificationMiddleware::class]);
    Route::get('/dashboard', [AdminDashboardController::class, 'DashboardPage'])->middleware([TokenVerificationMiddleware::class]);

    //Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'DashboardPage'])->name('dashboard')->middleware([TokenVerificationMiddleware::class]);

    Route::get('/products-list', [DashboardController::class, 'DashboardProductsPage'])->name('products-list')->middleware([TokenVerificationMiddleware::class]);
    Route::get('/dashboard/product-add', [DashboardController::class, 'DashboardProductsAddPage'])->middleware([TokenVerificationMiddleware::class]);
    Route::get('/setting', [DashboardController::class, 'SettingPage'])->name('setting')->middleware([TokenVerificationMiddleware::class]);

    //customer Route
    Route::get('customers', [DashboardController::class, 'DashboardCustomersPage'])->name('customers')->middleware([TokenVerificationMiddleware::class]);

    // Customer API
    Route::get("/list-customer", [CustomerController::class, 'CustomerList'])->name('product.list')->middleware([TokenVerificationMiddleware::class]);
    Route::post("/create-customer", [CustomerController::class, 'CustomerCreate'])->middleware([TokenVerificationMiddleware::class]);
    Route::post("/delete-customer", [CustomerController::class, 'CustomerDelete'])->middleware([TokenVerificationMiddleware::class]);
    Route::post("/update-customer", [CustomerController::class, 'CustomerUpdate'])->middleware([TokenVerificationMiddleware::class]);
    Route::post("/customer-by-id", [CustomerController::class, 'CustomerByID'])->middleware([TokenVerificationMiddleware::class]);

    //Invoice Route
    Route::get('/orders', [DashboardController::class, 'DashboardOrdersPage'])->name('orders')->middleware([TokenVerificationMiddleware::class]);
    // Invoice API
    Route::post('/update-delivery-status', [InvoiceController::class, 'updateDeliveryStatus'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/list-invoice", [InvoiceController::class, 'InvoiceList'])->name('product.list')->middleware([TokenVerificationMiddleware::class]);
    
    Route::get("/order-details", [InvoiceController::class, 'InvoiceProductDetails'])->name('invoice.product.list')->middleware([TokenVerificationMiddleware::class]);
    
    // Product API
    Route::post("/create-product", [ProductController::class, 'CreateProduct'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/delete-product", [ProductController::class, 'ProductDelete'])->middleware([TokenVerificationMiddleware::class]);

    Route::post('/update-product', [ProductController::class, 'UpdateProduct'])->name('update-product')->middleware([TokenVerificationMiddleware::class]);
    Route::get("/list-product", [ProductController::class, 'ProductList'])->middleware([TokenVerificationMiddleware::class]);
    Route::get('/dashboard/product-edit', [ProductController::class, 'editProduct'])->name('product.edit')->middleware([TokenVerificationMiddleware::class]);

    Route::get("/count-product", [DashboardController::class, 'ProductCount'])->middleware([TokenVerificationMiddleware::class]);

    // Category API
    Route::get("/list-main-category", [CategoryController::class, 'MainCategoryList'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/list-sub-category", [CategoryController::class, 'SubCategoryList'])->middleware([TokenVerificationMiddleware::class]);

    //Brand API
    Route::get("/list-brand", [BrandController::class, 'BrandList'])->middleware([TokenVerificationMiddleware::class]);
    //brand Route
    Route::get("/brand-list", [BrandController::class, 'BrandPage'])->name('brand-list')->middleware([TokenVerificationMiddleware::class]);
    //brand API
    Route::get("/brand-add", [BrandController::class, 'BrandAddPage'])->middleware([TokenVerificationMiddleware::class]);
    Route::POST("/create-brand", [BrandController::class, 'BrandCreate'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/brand-edit", [BrandController::class, 'BrandEdit'])->middleware([TokenVerificationMiddleware::class]);
    Route::post("/update-brand", [BrandController::class, 'BrandUpdate'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/brand-delete", [BrandController::class, 'BrandDelete'])->middleware([TokenVerificationMiddleware::class]);

    //main Category
    Route::get("/main-category", [CategoryController::class, 'MainCategoryPage'])->name('main-category')->middleware([TokenVerificationMiddleware::class]);
    Route::get("/main-category-add", [CategoryController::class, 'MainCategoryAddPage'])->middleware([TokenVerificationMiddleware::class]);
    Route::POST("/create-main-category", [CategoryController::class, 'MainCategoryCreate'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/main-category-edit", [CategoryController::class, 'MainCategoryEdit'])->middleware([TokenVerificationMiddleware::class]);
    Route::post("/update-main-category", [CategoryController::class, 'MainCategoryUpdate'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/main-category-delete", [CategoryController::class, 'MainCategoryDelete'])->middleware([TokenVerificationMiddleware::class]);

    //Sub Category
    Route::get("/sub-category", [CategoryController::class, 'SubCategoryPage'])->name('sub-category')->middleware([TokenVerificationMiddleware::class]);
    Route::get("/sub-category-add", [CategoryController::class, 'SubCategoryAddPage'])->middleware([TokenVerificationMiddleware::class]);
    Route::POST("/create-sub-category", [CategoryController::class, 'SubCategoryCreate'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/sub-category-edit", [CategoryController::class, 'SubCategoryEdit'])->middleware([TokenVerificationMiddleware::class]);
    Route::post("/update-sub-category", [CategoryController::class, 'SubCategoryUpdate'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/sub-category-delete", [CategoryController::class, 'SubCategoryDelete'])->middleware([TokenVerificationMiddleware::class]);
    
    //Deal of the day Route
    Route::get("/deal-of-the-day-admin", [ProductController::class, 'DealOfTheDayPage'])->name('deal-of-the-day')->middleware([TokenVerificationMiddleware::class]);
    //Deal of the day API
    Route::get("/deal-of-the-day-list", [ProductController::class, 'DealOfTheDayList'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/deal-of-the-day-add", [ProductController::class, 'DealOfTheDayAddPage'])->middleware([TokenVerificationMiddleware::class]);
    Route::POST("/create-deal-of-the-day", [ProductController::class, 'DealOfTheDayCreate'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/deal-of-the-day-edit", [ProductController::class, 'DealOfTheDayEdit'])->middleware([TokenVerificationMiddleware::class]);
    Route::post("/update-deal-of-the-day", [ProductController::class, 'DealOfTheDayUpdate'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/deal-of-the-day-delete", [ProductController::class, 'DealOfTheDayDelete'])->middleware([TokenVerificationMiddleware::class]);
    
    //Product slide Route
    Route::get("/product-slider-admin", [ProductController::class, 'productSliderPage'])->name('product-slider')->middleware([TokenVerificationMiddleware::class]);
    //Product slide API
    Route::get("/product-slider-list", [ProductController::class, 'productSliderList'])->middleware([TokenVerificationMiddleware::class]);
    Route::POST("/create-product-slider", [ProductController::class, 'productSliderCreate'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/product-slider-edit", [ProductController::class, 'productSliderEdit'])->middleware([TokenVerificationMiddleware::class]);
    Route::post("/update-product-slider", [ProductController::class, 'productSliderUpdate'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/product-slider-delete", [ProductController::class, 'productSliderDelete'])->middleware([TokenVerificationMiddleware::class]);
    
    //Product slide Route
    Route::get("/services-setting", [ServiceController::class, 'ServicesPage'])->name('services-setting')->middleware([TokenVerificationMiddleware::class]);
    //Product slide API
    Route::get("/services-setting-list", [ServiceController::class, 'index'])->middleware([TokenVerificationMiddleware::class]);
    Route::POST("/create-services-setting", [ServiceController::class, 'ServicesCreate'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/services-setting-edit", [ServiceController::class, 'ServicesEdit'])->middleware([TokenVerificationMiddleware::class]);
    Route::post("/update-services-setting", [ServiceController::class, 'ServicesUpdate'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/services-setting-delete", [ServiceController::class, 'ServicesDelete'])->middleware([TokenVerificationMiddleware::class]);
    
    //offer card Route
    Route::get("/offer-card", [OfferCardController::class, 'index'])->name('offer-card')->middleware([TokenVerificationMiddleware::class]);
    //offer card API
    Route::get("/offer-card-list", [OfferCardController::class, 'OfferList'])->middleware([TokenVerificationMiddleware::class]);
    Route::POST("/create-offer-card", [OfferCardController::class, 'OfferCardCreate'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/offer-card-edit", [OfferCardController::class, 'OfferCardEdit'])->middleware([TokenVerificationMiddleware::class]);
    Route::post("/update-offer-card", [OfferCardController::class, 'OfferCardUpdate'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/offer-card-delete", [OfferCardController::class, 'OfferCardDelete'])->middleware([TokenVerificationMiddleware::class]);
    
    //Testimonial Route
    Route::get("/testimonial-setting", [TestimonialController::class, 'testimonialPage'])->name('testimonial-setting')->middleware([TokenVerificationMiddleware::class]);
    //Testimonial API
    Route::get("/testimonial-setting-list", [TestimonialController::class, 'Testimonial'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/testimonial-setting-edit", [TestimonialController::class, 'testimonialEdit'])->middleware([TokenVerificationMiddleware::class]);
    Route::post("/update-testimonial-setting", [TestimonialController::class, 'testimonialUpdate'])->middleware([TokenVerificationMiddleware::class]);
    
    //Main menu Route
    Route::get("/add-main-menu", [MainMenuController::class, 'MainMenuPage'])->middleware([TokenVerificationMiddleware::class]);
    //main menu API
    Route::post('/menu-create', [MainMenuController::class, "StoreMenu"])->middleware([TokenVerificationMiddleware::class]);
    Route::get('/menu-list', [MainMenuController::class, "ListMenu"])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/menu-edit", [MainMenuController::class, 'MenuEdit'])->middleware([TokenVerificationMiddleware::class]);
    Route::post("/update-menu", [MainMenuController::class, 'MenuUpdate'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/menu-delete", [MainMenuController::class, 'MenuDelete'])->middleware([TokenVerificationMiddleware::class]);
    
    //Sub menu
    Route::get('/add-dropdown-menu', [MainMenuController::class, "SubMenuPage"])->middleware([TokenVerificationMiddleware::class]);
    //Sub menu API
    Route::post('/sub-menu-create', [MainMenuController::class, "SubMenuCreate"])->middleware([TokenVerificationMiddleware::class]);
    Route::get('/sub-menu-list', [MainMenuController::class, "ListSubMenu"])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/sub-edit", [MainMenuController::class, 'SubEdit'])->middleware([TokenVerificationMiddleware::class]);
    Route::post("/update-sub", [MainMenuController::class, 'SubUpdate'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/sub-delete", [MainMenuController::class, 'SubDelete'])->middleware([TokenVerificationMiddleware::class]);
    

    Route::get("/summary", [DashboardController::class, 'Summary'])->middleware([TokenVerificationMiddleware::class]);
    Route::get("/visitors", [DashboardController::class, 'VisitorCount'])->middleware([TokenVerificationMiddleware::class]);
});
