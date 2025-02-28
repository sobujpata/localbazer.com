<?php

namespace App\Http\Controllers;

use App\Models\OfferCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OfferCardController extends Controller
{
    function index(){
        return view('admin-page.offer-cards');
    }
    function OfferCardHome(){
        $data = OfferCard::get();

        return response()->json($data);
    }

    function OfferList(){
        $data = OfferCard::all();

        return response()->json($data);
    }
    function OfferCardCreate(Request $request){
        $title = $request->input('title');
        $short_des = $request->input('short_des');
        $discount = $request->input('discount');
        $image = $request->file('image');

        $t = time();
        $file_name = $image->getClientOriginalName();
        $image_name = "{$t}-{$file_name}";
        $image_url = "banners/{$image_name}";

        $image->move(public_path("banners"), $image_name);

        OfferCard::create([
            'title'=>$title,
            'short_des'=>$short_des,
            'discount'=>$discount,
            'image'=>$image_url,
        ]);
        return response()->json([
            'status'=>'success',
            'message'=>'Create successfully.',
        ], 201);
    }

    function OfferCardEdit(Request $request){
        $id = $request->query('id');

        $card = OfferCard::find($id);

        return view('admin-page.offer-card-edit', compact('card'));
    }
    function OfferCardUpdate(Request $request){
        $id = $request->input('id');
        $title = $request->input('title');
        $short_des = $request->input('short_des');
        $discount = $request->input('discount');
        $image = $request->file('image');

        if($image){
            $t = time();
            $file_name = $image->getClientOriginalName();
            $image_name = "{$t}-{$file_name}";
            $image_url = "banners/{$image_name}";

            // Upload File to the 'banners' folder in public
            $image->move(public_path('banners'), $image_name);
            $slider=OfferCard::where('id', $id)->update([
                'title'=>$title,
                'short_des'=>$short_des,
                'discount'=>$discount,
                'image'=>$image_url
            ]);
            return response()->json($slider);

        }else{
            $slider=OfferCard::where('id', $id)->update([
                'title'=>$title,
                'short_des'=>$short_des,
                'discount'=>$discount,
            ]);
            return response()->json($slider);
        }
    }

    function OfferCardDelete(Request $request){
        $id = $request->query('id');
        $image = $request->query('imgPath');

        File::delete($image);
        OfferCard::where('id',$id)->delete();

        return redirect()->back()->with('message', 'Card Deleted');
    }

    function Notification(){
        $data = OfferCard::first();

        return response()->json($data);
    }
}
