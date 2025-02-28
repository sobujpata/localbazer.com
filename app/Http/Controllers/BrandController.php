<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    function BrandShow(){
        $brand = Brand::all();

        return response()->json($brand);
    }
    function BrandPage(){
        return view('admin-page.brand-list');
    }

    function BrandWithCategory() {
        $ids = Brand::pluck('id');
        $brandWithCat = Product::select('brand_id', 'title', 'category_id')->with('categories')
            ->whereIn('brand_id', $ids)
            ->distinct('brand_id')
            ->get();
        return $brandWithCat;
    }

    public function BrandList(){
        $brands = Brand::get();

        return response()->json($brands);
    }

    public function BrandAddPage(){
        return view('admin-page.brand-add');
    }

    public function BrandCreate(Request $request){
        // $user_id=$request->header('id');

        $brandName = $request->input('brandName');
        // Prepare File Name & Path
        $img = $request->file('img1');
        $t = time();
        $file_name = $img->getClientOriginalName();
        $img_name = "{$t}-{$file_name}";
        $img_url = "brand/{$img_name}";

        // Upload File to the 'brand' folder in public
        $img->move(public_path('brand'), $img_name);
        $brand=Brand::create([
            'brandName'=>$brandName,
            'brandImg'=>$img_url
        ]);
        return response()->json($brand);
    }

    public function BrandEdit(Request $request){
        $id = $request->query('id');
        $brand = Brand::where('id', $id)->first();

        return view('admin-page.brand-edit', compact('brand'));
    }

    public function BrandUpdate(Request $request){
        $id = $request->input('id');
        $brandName=$request->input('brandName');
        $img = $request->file('img1');

        if($img){
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$t}-{$file_name}";
            $img_url = "brand/{$img_name}";

            // Upload File to the 'brand' folder in public
            $img->move(public_path('brand'), $img_name);
            $brand=Brand::where('id', $id)->update([
                'brandName'=>$brandName,
                'brandImg'=>$img_url
            ]);
            return response()->json($brand);

        }else{
            $brand=Brand::where('id', $id)->update([
                'brandName'=>$brandName,
            ]);
            return response()->json($brand);
        }
    }

    public function BrandDelete(Request $request){
        $id = $request->query('id');
        $imagePath= $request->query('imgPath');

        File::delete($imagePath);
        Brand::where('id',$id)->delete();

        return redirect()->back()->with('message', 'Brand Deleted');
    }
}
