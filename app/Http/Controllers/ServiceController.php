<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    function ServicesPage(){
        return view('admin-page.services');
    }
    public function index(){
        $service = Service::all();

        return response()->json($service);
    }

    function ServicesCreate(Request $request){
        $title = $request->input('title');
        $short_des = $request->input('short_des');
        $icon = $request->input('icon');

        Service::create([
            'title'=>$title,
            'short_des'=>$short_des,
            'icon'=>$icon,
        ]);

        return response()->json([
            'status'=>'success',
            'message'=>'Service Created successfully.'
        ],201);
    }

    function ServicesEdit(Request $request){
        $id = $request->query('id');

        $service = Service::find($id);

        return view('admin-page.service-edit', compact('service'));
    }
    function ServicesUpdate(Request $request){
        $id = $request->input('id');
        $title = $request->input('title');
        $short_des = $request->input('short_des');
        $icon = $request->input('icon');

        $service = Service::where('id', $id)->create([
            'title'=>$title,
            'short_des'=>$short_des,
            'icon'=>$icon,
        ]);

        return response()->json($service);
    }

    function ServicesDelete(Request $request){
        $id = $request->query('id');
        
        Service::where('id',$id)->delete();

        return redirect()->back()->with('message', 'Slider Deleted');
    }

}
