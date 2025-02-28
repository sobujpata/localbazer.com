<?php

namespace App\Http\Controllers;

use App\Models\MainMenu;
use App\Models\SubMenu;
use Illuminate\Http\Request;

class MainMenuController extends Controller
{
    public function MainMenuPage(){
        return view("admin-page.main-menu");
    }
    public function SubMenuPage(){
        return view("admin-page.sub-menu");
    }

    public function StoreMenu(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:main_menus,name',
            ]);

            $data = MainMenu::create([
                'name' => $request->input('name'),
            ]);

            return response()->json([
                'data' => $data,
                'status' => "success",
                'message' => "Created Successfully",
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => "error",
                'message' => "Something went wrong: " . $e->getMessage(),
            ], 500);
        }
    }

    function MenuEdit(Request $request){
        $id = $request->query('id');

        $mainMenu = MainMenu::find($id);

        return view("admin-page.main-menu-edit", compact('mainMenu'));
    }

    function MenuUpdate(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');

        MainMenu::where('id', $id)->update(['name'=>$name]);

        return response()->json([
            'status'=>'success'
        ], 203);
    }
    function MenuDelete(Request $request){
        $id = $request->input('id');

        $sub_menu = Submenu::where('main_menu_id', $id)->first();
        if($sub_menu){
            return redirect()->back()->with('error', 'Not Deleted ! Because Sub menu available.');
        }
        MainMenu::where('id', $id)->delete();

        return redirect()->back()->with('message', 'Delete Successfully.');
    }


    public function SubMenuCreate(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:main_menus,name',
                'url' => 'required|string|max:255',
                'main_menu_id' => 'required|string|max:255',
            ]);

            $data = SubMenu::create([
                'name' => $request->input('name'),
                'url' => $request->input('url'),
                'main_menu_id' => $request->input('main_menu_id'),
            ]);

            return response()->json([
                'data' => $data,
                'status' => "success",
                'message' => "Created Successfully",
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => "error",
                'message' => "Something went wrong: " . $e->getMessage(),
            ], 500);
        }
    }

    function SubEdit(Request $request){
        $id = $request->query('id');

        $subMenu = SubMenu::find($id);

        $mainMenu = MainMenu::all();

        return view('admin-page.sub-menu-edit', compact('subMenu', 'mainMenu'));
    }
    function SubUpdate(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $url = $request->input('url');
        $main_menu_id = $request->input('main_menu_id');

        $subMenu = SubMenu::find($id);

        $subMenu->update([
            'name'=>$name,
            'url'=>$url,
            'main_menu_id'=>$main_menu_id,
        ]);

        return response()->json([
            'status'=>'success',
        ], 203);
    }
    function SubDelete(Request $request){
        $id = $request->query('id');
        

        $subMenu = SubMenu::find($id);

        $subMenu->delete();

        return redirect()->back()->with('message', "Sub menu deleted.");
    }

    public function ListMenu(){
        $data = MainMenu::get();

        return response()->json($data);
    }
    public function ListSubMenu(){
        $data = SubMenu::with("main_menu")->get();

        return response()->json($data);
    }
    
}
