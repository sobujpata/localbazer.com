<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    function testimonialPage(){
        return view('admin-page.testimonials');
    }
    public function Testimonial(){
        $testimonial =Testimonial::all();

        return response()->json($testimonial);
    }

    function testimonialEdit(Request $request){
        $id = $request->query('id');

        $testimonial = Testimonial::find($id);


        return view('admin-page.testimonial-edit', compact('testimonial'));
    
    }

    function testimonialUpdate(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $position = $request->input('position');
        $testimonial = $request->input('testimonial');
        $image = $request->file('image');

        if($image){
            $t = time();
            $file_name = $image->getClientOriginalName();
            $image_name = "{$t}-{$file_name}";
            $image_url = "testimonial/{$image_name}";

            // Upload File to the 'testimonial' folder in public
            $image->move(public_path('testimonial'), $image_name);
            $testimonial=Testimonial::where('id', $id)->update([
                'name'=>$name,
                'position'=>$position,
                'testimonial'=>$testimonial,
                'image'=>$image_url
            ]);
            return response()->json([
                'status'=>'success',
            ],203);

        }else{
            $testimonial=Testimonial::where('id', $id)->update([
                'name'=>$name,
                'position'=>$position,
                'testimonial'=>$testimonial,
            ]);
            return response()->json([
                'status'=>'success',
            ],203);
        }
    }
}
