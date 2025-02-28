<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    function BlogCard(){
        $blogs = Blog::orderBy('created_at', 'desc')->take(4)->get();

        return response()->json($blogs);
    }
}
