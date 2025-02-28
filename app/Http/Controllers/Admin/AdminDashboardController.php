<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    function DashboardPage():View{
        return view('pages.dashboard.dashboard-page');
    }
    public function adminUser(Request $request):View{
        return view('pages.dashboard.admins');
    }
    public function
    GenUser(Request $request):View{
        return view('pages.dashboard.users');
    }
    public function adminList(Request $request){
        $admins = Admin::get();
        return response()->json([
            'data'=> $admins,
            'status'=>'success'
        ], 200);
    }

    public function adminUpdate(Request $request)
    {
        // Validate input fields
        $validatedData = $request->validate([
            'id' => 'required|exists:admins,id', // Ensure 'id' exists to update the correct admin
            'fname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'mobile' => 'required|digits:11', // Validates mobile number with exactly 11 digits
            'password' => 'required|string|min:4', // Ensures password is at least 4 characters
            'role' => 'required|numeric|min:0',
        ]);

        try {
            // Find the existing admin entry by ID
            $admin = Admin::findOrFail($validatedData['id']);

            // Update the admin fields
            $admin->update([
                "fname" => $validatedData['fname'],
                "email" => $validatedData['email'],
                "mobile" => $validatedData['mobile'],
                "password" => $validatedData['password'], // Encrypt the password
                "role" => $validatedData['role'],
            ]);

            // Return a successful response
            return response()->json([
                'message' => 'Admin updated successfully',
                'data' => $admin
            ], 200);

        } catch (\Exception $e) {
            // Return error message with detailed information
            return response()->json([
                'message' => 'Failed to update admin',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function adminCreate(Request $request){
        // Validate input fields
        $validatedData = $request->validate([
            'fname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'mobile' => 'required|digits:11', // Validates mobile number with exactly 11 digits
            'password' => 'required|string|min:4', // Ensures password is at least 4 characters
            'role' => 'required|numeric|min:0',
        ]);

        try {
            // Create the admin fields
            $admin = Admin::create([
                "fname" => $validatedData['fname'],
                "email" => $validatedData['email'],
                "mobile" => $validatedData['mobile'],
                "password" => $validatedData['password'],
                "role" => $validatedData['role'],
            ]);

            // Return a successful response
            return response()->json([
                'message' => 'Admin Created successfully',
                'data' => $admin
            ], 200);

        } catch (\Exception $e) {
            // Return error message with detailed information
            return response()->json([
                'message' => 'Failed to Create admin',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function adminDelete(Request $request){
        $id = $request->input('id');
        return Admin::where('id',$id)->delete();
    }

    public function adminEdit(Request $request){
        // dd($request->id);
        $id = $request->input('id');
        $admin = Admin::find($id);
        return response()->json([
            'data'=> $admin,
            'status'=> 'success'
            ],200);
    }
    public function userList(Request $request){
        $users = User::get();
        return response()->json([
            'data'=> $users,
            'status'=>'success'
        ], 200);
    }

    public function UserById(Request $request){
         // dd($request->id);
         $id = $request->input('id');
         $user = User::find($id);
         return response()->json([
             'data'=> $user,
             'status'=> 'success'
             ],200);

    }

    public function UserUpdate(Request $request){
        // Validate input fields
        $validatedData = $request->validate([
            'id' => 'required|exists:users,id', // Ensure 'id' exists to update the correct user
            'fname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'mobile' => 'required|digits:11', // Validates mobile number with exactly 11 digits
            'password' => 'required|string|min:4', // Ensures password is at least 4 characters
            'status' => 'required|numeric|min:0',
        ]);

        try {
            // Find the existing user entry by ID
            $user = User::findOrFail($validatedData['id']);

            // Update the user fields
            $user->update([
                "fname" => $validatedData['fname'],
                "email" => $validatedData['email'],
                "mobile" => $validatedData['mobile'],
                "password" => $validatedData['password'],
                "status" => $validatedData['status'],
            ]);

            // Return a successful response
            return response()->json([
                'message' => 'user updated successfully',
                'data' => $user
            ], 200);

        } catch (\Exception $e) {
            // Return error message with detailed information
            return response()->json([
                'message' => 'Failed to update user',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
