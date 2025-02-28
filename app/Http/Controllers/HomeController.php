<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        // dd( $remark);
        $mainCategories = MainCategory::with('categories')->get();
        $bestSale = Product::where("remark", "popular")->take(4)->get();
        return view('home.home', compact('mainCategories', 'bestSale'));
    }
    public function navBar(){
        // dd( $remark);
        $mainCategories = MainCategory::with('categories')->get();
        $bestSale = Product::where("remark", "popular")->take(4)->get();
        return view('layouts.partials.nav', compact('mainCategories', 'bestSale'));
    }
}
