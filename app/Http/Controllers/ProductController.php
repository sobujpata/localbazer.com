<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\DealOfDay;
use App\Models\ProductCart;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\ProductSlider;
use App\Helper\ResponseHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
     //Deal of the day list
     public function DealOfTheDayPage(){
        return view("admin-page.deal-of-day");
    }

    //Product slider
    public function productSliderPage(){
        return view('admin-page.product-slider');
    }

    public function bestSale()
    {
        $bestSale = Product::where("remark", "popular")->take(4)->get();

        return response()->json($bestSale);
    }
    public function NewArrivals()
    {
        $newArrivals = Product::where("remark", "new")->take(4)->with(relations: 'categories')->get();
        $newArrivals1 = Product::where("remark", "new")->skip(4)->with(relations: 'categories')->take(4)->get();

        $data = [
            "first_batch" => $newArrivals,
            "second_batch" => $newArrivals1];

        return response()->json($data);

    }
    public function TrendingProduct()
    {
        $trending = Product::where("remark", "trending")->take(4)->with(relations: 'categories')->get();
        $trending1 = Product::where("remark", "trending")->skip(4)->take(4)->with(relations: 'categories')->get();

        $data = [
            "first_trending" => $trending,
            "second_trending" => $trending1];

        return response()->json($data);

    }
    public function TopRateProduct()
    {
        $top = Product::where("remark", "top")->take(4)->with(relations: 'categories')->get();
        $top1 = Product::where("remark", "top")->skip(4)->take(4)->with(relations: 'categories')->get();

        $data = [
            "first_top" => $top,
            "second_top" => $top1];

        return response()->json($data);

    }

    public function DealOfDay()
    {
        $deals = DealOfDay::take(2)->with('products')->get();
        
        return response()->json($deals);
    }

    public function NewProducts(Request $request)
    {
        $limit = $request->get('limit', 12); // Default to 6 products per page
        $products = Product::with('categories')->with('product_details')->paginate($limit);
        return response()->json($products);        
        // $products = Product::orderBy('updated_at', "desc")->with('categories')->paginate(12);

        // return response()->json($products);
    }

   
    public function searchCategoryProducts(Request $request)
    {
        $searchQuery = $request->query('query');
        // Check if the query parameter is empty
        if (empty($searchQuery)) {
            return response()->json(['message' => 'Search query is required'], 400);
        }

        // Validate the query
        $request->validate([
            'query' => 'required|string|min:1',
        ]);

        // Perform the search
        $products = Product::with('category')
            ->where('title', 'like', '%' . $searchQuery . '%')
            ->orWhere('price', 'like', '%' . $searchQuery . '%')
            ->orWhereHas('category', function ($query) use ($searchQuery) {
                $query->where('categoryName', 'like', '%' . $searchQuery . '%');
            })
            ->paginate(8);

        // If no products found, return a response
        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found'], 404);
        }
        // Return products and pagination
        return response()->json([
            'data' => $products->items(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);
    }

    public function CategoryWise(Request $request, $categoryName)
    {

        // Trim spaces and replace special characters
        $cleanCategoryName = trim($categoryName);
        $cleanCategoryName = str_replace(['+'], ' ', $cleanCategoryName); // Replace '+' and '&' with space
        // dd($cleanCategoryName);

        $category = Category::where('categoryName', $cleanCategoryName)->first();


        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $products = Product::where('category_id', $category->id)->with('product_details')->paginate(12);

        // Fetch all main categories with their related categories (subcategories)
        $mainCategories = MainCategory::with('categories')->get();

        $bestSale = Product::where("remark", "popular")->take(4)->get();

        return view('home.category-wise-product', compact('products', 'category', 'mainCategories','bestSale'));
    }

    public function ProductDetails(Request $request, $id)
    {
        $product = Product::where('id', $id)->with('categories')->first();
        $product_details= ProductDetail::where('product_id', $id)->first();
        $p_color = $product_details->color ?? '';
        $colors = array_filter(explode(',', $p_color)); // Remove empty values from the array
        $mainCategories = MainCategory::with('categories')->get();
        $bestSale = Product::where("remark", "popular")->take(4)->get();
        // dd($colors);
        return view('home.product-details', compact('product', 'product_details', 'colors', 'mainCategories', 'bestSale'));
    }

    public function ProductRemark(Request $request, $remark)
    {
        // dd( $remark);
        if($remark == 'all'){
            $products = Product::orderBy('created_at', 'desc')->with('product_details')->paginate(12);
            // foreach ($products as $product) {
            //     dd($product->product_details); // Debug first product's product_details
            // }
        }else{
            $products = Product::where('remark', $remark)->paginate(12);
        }
        $mainCategories = MainCategory::with('categories')->get();

        $bestSale = Product::where("remark", "popular")->take(4)->get();

        return view('home.products-remark', compact('products', 'remark', 'mainCategories', 'bestSale'));
    }

    public function CreateCartList(Request $request)
    {
        $user_id = $request->header('id');

        if (!$user_id) {
            return response()->json([
                'message' => "Please log in first.",
            ], 401);
        }

        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'color' => 'nullable|string',
            'qty' => 'required|integer|min:1',
        ]);

        $product_id = $validatedData['product_id'];
        $color = $validatedData['color'];
        $qty = $validatedData['qty'];

        $productDetails = Product::find($product_id);

        if (!$productDetails) {
            return response()->json([
                'message' => "Product not found."
            ], 404);
        }

        $unitPrice = $productDetails->discount ? $productDetails->discount_price : $productDetails->price;
        $totalPrice = $qty * $unitPrice;

        $data = ProductCart::updateOrCreate(
            ['user_id' => $user_id, 'product_id' => $product_id],
            [
                'user_id' => $user_id,
                'product_id' => $product_id,
                'color' => $color,
                'qty' => $qty,
                'price' => $totalPrice,
            ]
        );

        return response()->json([
            "message" => "Product added to cart. Please check your cart.",
            'status' => "success",
        ], 201);
    }


    public function CartListPage(){
        $mainCategories = MainCategory::with('categories')->get();
        $bestSale = Product::where("remark", "popular")->take(4)->get();
        return view('home.product-carts', compact('mainCategories', 'bestSale'));
    }

    public function CartList(Request $request)
    {
        try {
            // Validate user_id header
            $user_id = $request->header('id');
            if (!$user_id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User ID is required.',
                ], 400);
            }

            // Fetch cart items with product details
            $data = ProductCart::where('user_id', $user_id)
                ->with(['product:id,title,image,price']) // Optimize query with selected fields
                ->get();
                $totalPrice = ProductCart::where('user_id', $user_id)
                ->selectRaw('SUM(price) as total')
                ->value('total');
            
            // Check if the cart is empty
            if ($data->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'status' => 'success',
                    'message' => 'Your cart is empty. Start shopping now!',
                ], 200);
            }

            // Return cart items
            return response()->json([
                'data' => $data,
                'totalPrice' => $totalPrice,
                'status' => 'success',
            ], 200);
        } catch (\Exception $e) {
            // Log the error and return a generic message
            // \Log::error('CartList Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch cart items. Please try again later.',
            ], 500);
        }
    }

    public function CartCount(Request $request) {
        try {
            $user_id = $request->header('id');
            if (!$user_id) {
                return response()->json(['error' => 'User ID header is missing'], 400);
            }
            $data = ProductCart::where('user_id', $user_id)->count();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }





    public function DeleteCartList(Request $request){
        $user_id=$request->header('id');
        $product_id=$request->query('id');
        $data=ProductCart::where('user_id',$user_id)->where('product_id',$product_id)->delete();

        return redirect()->back()->with('message', 'Cart item deleted.');
    }

    //Product create
    public function CreateProduct(Request $request)
    {
            // Validate request data
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'short_des' => 'required|string|max:255',
                'price' => 'required|numeric',
                'discount_price' => 'required|numeric',
                'stock' => 'required|numeric',
                'star' => 'required|string|max:10',
                'remarks' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'main_category_id' => 'required|numeric',
                'category_id' => 'required|numeric',
                'brand_id' => 'required|numeric',
                'color' => 'required|string|max:255',
                'size' => 'required|string|max:100',
                'img1' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5000',
                'img2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5000',
                'img3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5000',
                'img4' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5000',
            ]);

            $imageUrls = [];

            // Handle multiple images
            foreach (['img1', 'img2', 'img3', 'img4'] as $imgField) {
                if ($request->hasFile($imgField)) {
                    $img = $request->file($imgField);
                    $imgName = time() . '-' . $img->getClientOriginalName();
                    $img->move(public_path('products'), $imgName);
                    $imageUrls[$imgField] = "products/{$imgName}";
                }
            }

            // Save the product to the database
            try {
                DB::beginTransaction();
            
                // Save the product to the database
                $product = Product::create([
                    'title' => $validatedData['title'],
                    'short_des' => $validatedData['short_des'],
                    'price' => $validatedData['price'],
                    'discount' => 0,
                    'discount_price' => $validatedData['discount_price'],
                    'stock' => $validatedData['stock'],
                    'remark' => $validatedData['remarks'],
                    'star' => $validatedData['star'],
                    'main_category_id' => $validatedData['main_category_id'],
                    'category_id' => $validatedData['category_id'],
                    'brand_id' => $validatedData['brand_id'],
                    'image' => $imageUrls['img1'] ?? null,
                ]);
                // Save product details, ensuring the `product_id` is set
                $productDetails = ProductDetail::create([
                    'product_id' => $product->id,
                    'img1' => $imageUrls['img1'] ?? null,
                    'img2' => $imageUrls['img2'] ?? null,
                    'img3' => $imageUrls['img3'] ?? null,
                    'img4' => $imageUrls['img4'] ?? null,
                    'color' => $validatedData['color'],
                    'size' => $validatedData['size'],
                    'des' => $validatedData['description'],
                ]);
                
            
                DB::commit();
            
                return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
            
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['message' => 'Product creation failed', 'error' => $e->getMessage()], 500);
            }
    }
    function ProductList(Request $request)
    {
        // $user_role=$request->header('role');
        $product = Product::with('category', 'main_category','brand')->get();
        return response()->json([
            'data' => $product,
            // 'role' => $user_role,
        ]);
    }

    function editProduct(Request $request){
        // Fetch product by ID from the query parameter
        $productId = $request->query('id');

        // dd($productId);
        $product = Product::where('id', $productId)->with('main_category','category', 'brand')->first();
        $product_detail = ProductDetail::where('product_id', $productId)->first();
        // Check if the product exists
        if (!$product) {
            return redirect()->route('product.list')->with('error', 'Product not found');
        }

        // Return edit view with product details
        return view('admin-page.product-edit', compact('product', 'product_detail'));

    }

    function UpdateProduct(Request $request) {
        
        $id = $request->input('id');
        $img1 = $request->input('img1');
        $img2 = $request->input('img2');
        $img3 = $request->input('img3');
        $img4 = $request->input('img4');
       
        // Validate request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'short_des' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discount_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'star' => 'required|numeric',
            'remarks' => 'nullable|string|max:100',
            'description' => 'required|string|max:3000',
            'main_category_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'color' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            
        ]);

    
        $imageUrls = [];
    
        // Handle multiple images
        foreach (['img1', 'img2', 'img3', 'img4'] as $imgField) {
            if ($request->hasFile($imgField)) {
                $img = $request->file($imgField);
                $imgName = time() . '-' . $img->getClientOriginalName();
                $img->move(public_path('products'), $imgName);
                $imageUrls[$imgField] = "products/{$imgName}";
            }
        }
    
        // Fetch existing product
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        // Fetch existing product
        $product_details = ProductDetail::where('product_id', $product->id)->first();
        
    
        // Save the product to the database
        try {
            DB::beginTransaction();
    
            // Update the product
            $product->update([
                'title' => $validatedData['title'],
                'short_des' => $validatedData['short_des'],
                'price' => $validatedData['price'],
                'discount' => 0,
                'discount_price' => $validatedData['discount_price'],
                'stock' => $validatedData['stock'],
                'remark' => $validatedData['remarks'],
                'star' => $validatedData['star'],
                'main_category_id' => $validatedData['main_category_id'],
                'category_id' => $validatedData['category_id'],
                'brand_id' => $validatedData['brand_id'],
                'image' => $imageUrls['img1'] ?? $product->image,
            ]);
    
            // Update product details
            $product_details->update([
                'img1' => $imageUrls['img1'] ?? $product_details->img1,
                'img2' => $imageUrls['img2'] ?? $product_details->img2,
                'img3' => $imageUrls['img3'] ?? $product_details->img3,
                'img4' => $imageUrls['img4'] ?? $product_details->img4,
                'color' => $validatedData['color'],
                'size' => $validatedData['size'],
                'des' => $validatedData['description'],
            ]);
    
            DB::commit();
    
            return response()->json(['message' => 'Product updated successfully', 'product' => $product, 'product_details'=>$product_details], 200);
    
        } catch (\Exception $e) {
            DB::rollBack();
            // Log error for debugging in production
            Log::error('Product update failed: ' . $e->getMessage());
            return response()->json(['message' => 'Product update failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function ProductDelete(Request $request)
    {
        $product_id = $request->query('id');
        $product_details = ProductDetail::where('product_id', $product_id)->first();
        // dd($product_details);
        $product_id=$product_details->product_id;
        
        if (!$product_details) {
            return redirect()->back()->with('error', 'Product not found');
        }

        try {
            DB::beginTransaction();

            // Deleting images if they exist
            $img_paths = [
                $product_details->img1 ?? '',
                $product_details->img2 ?? '',
                $product_details->img3 ?? '',
                $product_details->img4 ?? '',
            ];

            foreach ($img_paths as $path) {
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            // Deleting product records
            $product_details->delete(); // Deletes from `ProductDetail`
            Product::where('id', $product_id)->delete(); // Deletes from `Product`

            DB::commit();

            return redirect()->back()->with('message', 'Product Deleted');
        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error for debugging
            Log::error('Product delete failed: ' . $e->getMessage());

            // Return error response
            return redirect()->back()->with('error', 'Failed to delete product. Please try again later.');
        }
    }


   
    public function DealOfTheDayAddPage(){
        $products = Product::all();
        return view("admin-page.deal-of-day-add", compact('products'));
    }
    public function DealOfTheDayCreate(Request $request){
        $dealsProductId = $request->input('dealsProductId');
        $soldQty = $request->input('soldQty');
        $OfferUpTo = $request->input('OfferUpTo');
        // Prepare File Name & Path
        $img = $request->file('img1');
        $t = time();
        $file_name = $img->getClientOriginalName();
        $img_name = "{$t}-{$file_name}";
        $img_url = "deal-of-the-day/{$img_name}";

        // Upload File to the 'deal-of-the-day' folder in public
        $img->move(public_path('deal-of-the-day'), $img_name);
        DealOfDay::create([
            'product_id'=>$dealsProductId,
            'sold'=>$soldQty,
            'count_down'=>$OfferUpTo,
            'image_url'=>$img_url
        ]);
        return response()->json([
            'status'=>"success",
            'message'=>"Successfully Created",
        ]);
    }

    public function DealOfTheDayList(){
        $deals = DealOfDay::with('products')->get();

        return response()->json($deals);
    }
    public function DealOfTheDayEdit(Request $request){
        $id = $request->query('id');
        $deals = DealOfDay::with('products')->findOrFail($id);
        $products = Product::all();

        return view("admin-page.deal-of-day-edit", compact('deals','products'));
    }
    public function DealOfTheDayUpdate(Request $request){
        
        $id = $request->input('id');
        $dealsProductId = $request->input('dealsProductId');
        $soldQty = $request->input('soldQty');
        $OfferUpTo = $request->input('OfferUpTo');
        $img = $request->file('img1');

        if($img){
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$t}-{$file_name}";
            $img_url = "deal-of-the-day/{$img_name}";

            // Upload File to the 'deal-of-the-day' folder in public
            $img->move(public_path('deal-of-the-day'), $img_name);
            $dealOfDay=dealOfDay::where('id', $id)->update([
                'product_id'=>$dealsProductId,
                'sold'=>$soldQty,
                'count_down'=>$OfferUpTo,
                'image_url'=>$img_url
            ]);
            return response()->json($dealOfDay);

        }else{
            $dealOfDay=dealOfDay::where('id', $id)->update([
                'product_id'=>$dealsProductId,
                'sold'=>$soldQty,
                'count_down'=>$OfferUpTo,
            ]);
            return response()->json($dealOfDay);
        }
    }

    public function DealOfTheDayDelete(Request $request){
        $id = $request->query('id');
        $imagePath= $request->query('imgPath');

        File::delete($imagePath);
        DealOfDay::where('id',$id)->delete();

        return redirect()->back()->with('message', 'Deal Of the day Deleted');
    }

    public function productSliderList(){
        $data = ProductSlider::all();

        return response()->json($data);
    }

    public function productSliderCreate(Request $request){
        $title = $request->input('title');
        $short_des = $request->input('short_des');
        $price = $request->input('price');
        $product_id = $request->input('product_id');
        $image = $request->file('image');

        $t = time();
        $file_name = $image->getClientOriginalName();
        $image_name = "{$t}-{$file_name}";
        $image_url = "banners/{$image_name}";

        $image->move(public_path("banners"), $image_name);

        ProductSlider::create([
            'title'=>$title,
            'short_des'=>$short_des,
            'price'=>$price,
            'product_id'=>$product_id,
            'image'=>$image_url,
        ]);
        return response()->json([
            'status'=>'success',
            'message'=>'Create successfully.',
        ], 201);

    }

    public function productSliderEdit(Request $request){
        $id = $request->query('id');

        $slider = ProductSlider::find($id);

        $products = Product::all();

        return view('admin-page.product-slider-edit', compact('slider', 'products'));
    }

    function productSliderUpdate(Request $request){
        $id = $request->input('id');
        $title = $request->input('title');
        $short_des = $request->input('short_des');
        $price = $request->input('price');
        $product_id = $request->input('product_id');
        $image = $request->file('image');

        if($image){
            $t = time();
            $file_name = $image->getClientOriginalName();
            $image_name = "{$t}-{$file_name}";
            $image_url = "banners/{$image_name}";

            // Upload File to the 'banners' folder in public
            $image->move(public_path('banners'), $image_name);
            $slider=ProductSlider::where('id', $id)->update([
                'title'=>$title,
                'short_des'=>$short_des,
                'price'=>$price,
                'product_id'=>$product_id,
                'image'=>$image_url
            ]);
            return response()->json($slider);

        }else{
            $slider=ProductSlider::where('id', $id)->update([
                'title'=>$title,
                'short_des'=>$short_des,
                'price'=>$price,
                'product_id'=>$product_id,
            ]);
            return response()->json($slider);
        }
    }

    function productSliderDelete(Request $request){
        $id = $request->query('id');
        $image = $request->query('imgPath');

        File::delete($image);
        ProductSlider::where('id',$id)->delete();

        return redirect()->back()->with('message', 'Slider Deleted');
    }

    function UpdateCartQuantity(Request $request){
        $userId = $request->header('id');
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        // Get logged-in user ID
        $productId = $request->input('product_id');
        $newQuantity = $request->input('quantity');

        $product = Product::find($productId);

        $discount_price =$product->discount_price;

        $new_price = $discount_price * $newQuantity;

        
        // Find cart item for the user and product
        $cartItem = ProductCart::where('user_id', $userId)
                        ->where('product_id', $productId)
                        ->first();

        if (!$cartItem) {
            return response()->json(['error' => 'Product not found in cart'], 404);
        }

        ProductCart::where('product_id', $productId)->update([
            'price'=>$new_price,
            'qty'=>$newQuantity,
        ]);
        return response()->json([
            'status'=>'success',
            'message'=>'Card Update successfully.'
        ],200);
        
    }

    public function search(Request $request) {
        $query = $request->input('search'); // Get search input
    
        $products = Product::where('title', 'LIKE', "%{$query}%")
            ->orWhere('short_des', 'LIKE', "%{$query}%")
            ->paginate(10);
        $mainCategories = MainCategory::with('categories')->get();

        $bestSale = Product::where("remark", "popular")->take(4)->get();
    
        return view('home.products-search', compact('products','mainCategories','bestSale', 'query'));
    }



 }