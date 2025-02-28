<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CustomerProfile;
use App\Models\Invoice;

class CustomerController extends Controller
{
    public function CustomerList()
{
    // Retrieve all users with their profiles
    $customers = User::with('profile')->get();

    // Get profiles associated with these users
    $customer_ids = $customers->pluck('id'); // Extract user IDs
    $customer_profiles = CustomerProfile::whereIn('user_id', $customer_ids)->get();

    // Get order statistics
    $orderCount = Invoice::whereIn('user_id', $customer_ids)->count();
    $totalPayable = Invoice::whereIn('user_id', $customer_ids)->sum('payable');

    return response()->json([
        'customers' => $customers,
        'profiles' => $customer_profiles,
        'orderCount' => $orderCount,
        'totalPayable' => $totalPayable
    ]);
}

}

