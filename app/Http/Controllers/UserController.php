<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\OTPMail;
use App\Models\Product;
use App\Helper\JWTToken;
use Illuminate\View\View;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use App\Models\CustomerProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Validator;

class UserController extends Controller
{
    public function LoginPage()
    {
        $mainCategories = MainCategory::with('categories')->get();
        $bestSale = Product::where("remark", "popular")->take(4)->get();
        return view('home.auth.login-page', compact('mainCategories', 'bestSale'));
    }
    public function RegistrationPage()
    {
        $mainCategories = MainCategory::with('categories')->get();
        $bestSale = Product::where("remark", "popular")->take(4)->get();
        return view('home.auth.reg-page', compact('mainCategories', 'bestSale'));
    }

    function SendOtpPage():View{
        $mainCategories = MainCategory::with('categories')->get();
        $bestSale = Product::where("remark", "popular")->take(4)->get();
        return view('home.auth.send-otp-page', compact('mainCategories', 'bestSale'));
    }
    function VerifyOTPPage():View{
        $mainCategories = MainCategory::with('categories')->get();
        $bestSale = Product::where("remark", "popular")->take(4)->get();
        return view('home.auth.verify-otp-page', compact('mainCategories', 'bestSale'));
    }
    function ResetPasswordPage():View{
        $mainCategories = MainCategory::with('categories')->get();
        $bestSale = Product::where("remark", "popular")->take(4)->get();
        return view('home.auth.reset-pass-page', compact('mainCategories', 'bestSale'));
    }
    function ProfilePage():View{
        $mainCategories = MainCategory::with('categories')->get();
        $bestSale = Product::where("remark", "popular")->take(4)->get();
        return view('home.dashboard.profile-page', compact('mainCategories', 'bestSale'));
    }

    function UserProfilePage(){
        $mainCategories = MainCategory::with('categories')->get();
        $bestSale = Product::where("remark", "popular")->take(4)->get();
        return view('home.profile', compact('mainCategories', 'bestSale'));
    }

    function UserRegistration(Request $request){
        try {
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => $request->input('password'),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfully'
            ],200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ],200);

        }
    }
    
    function UserLogin(Request $request)
        {
            // dd($request);
            $user = User::where('email', $request->input('email'))->first();

            if ($user && Hash::check($request->input('password'), $user->password)) {
                // Generate JWT token for authenticated user
                $token = JWTToken::CreateToken($user->email, $user->id, $user->role);
            
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login successfully',
                    'data' => $user->role,
                ], 200)->cookie('token', $token, time() + 60 * 60 * 30); // Set token in cookie
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Unauthorized',
                ], 401);
            }
    
        }

    function UserLogout(){
        return redirect('/')->cookie('token','',-1);
    }




    function SendOTPCode(Request $request){

        $email=$request->input('email');
        $otp=rand(1000,9999);
        $count=User::where('email','=',$email)->count();

        if($count==1){
            // OTP Email Address
            Mail::to($email)->send(new OTPMail($otp));
            // OTO Code Table Update
            User::where('email','=',$email)->update(['otp'=>$otp]);

            return response()->json([
                'status' => 'success',
                'message' => '4 Digit OTP Code has been send to your email !'
            ],200);
        }
        else{
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ]);
        }
    }




    function VerifyOTP(Request $request){
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', '=', $email)
                ->where('otp', '=', $otp)
                ->count();

            if($count==1){
                //Database update otp
                User::where('email', '=', $email)->update(['otp'=>'0']);

                //Pass reset token issue
                $token = JWTToken::CreateTokenForPassword($request->input('email'));

                return response()->json([
                    'status'=>'success',
                    'message'=>'OTP Verified',
                    'token'=>$token
                ], 200)->cookie('token',$token,60*24*30);
            }else{
                return response()->json([
                    'status'=>'fsiled',
                    'message'=>'unauthorized'
                ], 401);
            }
    }



    function ResetPassword(Request $request){
        try{
            $email=$request->header('email');
            $password=$request->input('password');
            User::where('email','=',$email)->update(['password'=>$password]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ],200);

        }catch (Exception $exception){
            return response()->json([
                'status' => 'fail',
                'message' => 'Something Went Wrong',
            ],200);
        }
    }




    function UserProfile(Request $request){

        $email=$request->header('email');
        $user=User::where('email','=',$email)->first();
        return response()->json([
            'status' => 'success',
            'message' => 'Request Successful',
            'data' => $user
        ],200);
    }

    function UpdateProfile(Request $request){
        try{
            $email=$request->header('email');
            $firstName=$request->input('firstName');
            $lastName=$request->input('lastName');
            $mobile=$request->input('mobile');
            $password=$request->input('password');
            User::where('email','=',$email)->update([
                'firstName'=>$firstName,
                'lastName'=>$lastName,
                'mobile'=>$mobile,
                'password'=>$password
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ],200);

        }catch (Exception $exception){
            return response()->json([
                'status' => 'fail',
                'message' => 'Something Went Wrong',
            ],200);
        }
    }

    function GetUserProfile(Request $request){
        $user_id = $request->header('id');

        $data = User::with('profile')->find($user_id);

        return response()->json($data);
    }

    public function ProfileUpdate(Request $request) {
        $user_id = $request->header('id');
        $validatedData = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'cus_add' => 'required|string|max:255',
            'cus_city' => 'required|string|max:255',
            'cus_country' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:255',
            'cus_fax' => 'nullable|string|max:255',
            'cus_postcode' => 'required|numeric',
            'profileImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5000',
        ]);
    
        $imageUrls = [];
    
        if ($request->hasFile('profileImage')) {
            $img = $request->file('profileImage');
            $imgName = $user_id . '-' . time() . '-' . $img->getClientOriginalName();
            $imgPath = $img->storeAs('profile', $imgName, 'public');
            $imageUrls['profileImage'] = "storage/{$imgPath}";
        }

        // Fetch existing user
        $user = User::find($user_id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Save the user to the database
        try {
            DB::beginTransaction();
    
            // Update user data
            $user->update([
                'firstName' => $validatedData['firstName'],
                'lastName' => $validatedData['lastName'],
                'email' => $validatedData['email'],
                'mobile' => $validatedData['mobile'],
            ]);
    
            // Update or create user details
            CustomerProfile::updateOrCreate(
                ['user_id' => $user_id], // Find existing record by user_id
                [
                    'user_id' => $user_id,
                    'cus_add' => $validatedData['cus_add'],
                    'cus_city' => $validatedData['cus_city'],
                    'cus_postcode' => $validatedData['cus_postcode'],
                    'cus_country' => $validatedData['cus_country'],
                    'cus_fax' => $validatedData['cus_fax'],

                    'ship_name' => $validatedData['firstName'] . " " . $validatedData['lastName'],
                    'ship_add' => $validatedData['cus_add'],
                    'ship_postcode' => $validatedData['cus_postcode'],

                    'ship_city' => $validatedData['cus_city'],
                    
                    'ship_country' => $validatedData['cus_country'],
                    'ship_phone' => $validatedData['mobile'],
                    'image_url' => $imageUrls['profileImage'] ?? $user->customerProfile->image_url ?? null,
                ]
            );
            DB::commit();
    
            return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("User update failed for ID {$user_id}: " . $e->getMessage());
            return response()->json(['message' => 'User update failed', 'error' => $e->getMessage()], 500);
        }
    }
    

    
}
