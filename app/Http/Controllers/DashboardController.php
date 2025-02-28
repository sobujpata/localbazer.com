<?php

namespace App\Http\Controllers;

use App\Models\CustomerProfile;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Visitor;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function DashboardPage(){
        return view('admin-page.dashboard');
    }
    public function DashboardOrdersPage(){
        return view('admin-page.orders');
    }
    public function DashboardCustomersPage(){
        return view('admin-page.customers');
    }
    public function DashboardProductsPage(){
        return view('admin-page.products');
    }
    public function DashboardProductsAddPage(){
        return view('admin-page.product-add');
    }
    public function SettingPage(){
        return view('admin-page.setting');
    }


    public function ProductCount(){
        $countProduct = Product::count();

        return response()->json([
            'productCount'=>$countProduct
        ]);
    }



    function Summary(Request $request):array{

        $user_id=$request->header('id');
        $user_role = $request->header('role');

        $product= Product::count();
        // $customer= CustomerProfile::count();
        $Category= Category::count();
        $Customer=User::count();
        $Invoice= Invoice::count();
        $total=  Invoice::sum('total');
        $vat= Invoice::sum('vat');


        $currentDate = Carbon::today();

        // Get the start and end dates for the previous month
        $startOfLastMonth = Carbon::now()->startOfMonth()->subMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        // dd($endOfLastMonth);
        // Sum the total for rentals from last month
        $total_last_month_earn = Invoice::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
                               ->sum('total');
        

        // Get the start and end dates for the current month
        $startOfCurrentMonth = Carbon::now()->startOfMonth();
        $endOfCurrentMonth = Carbon::now()->endOfMonth();

        // Sum the total for rentals in the current month
        $total_current_month_earn = Invoice::whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])
                                        ->sum('total');
        
                                        // dd($total_current_month_buy_product);
        // Get the start and end dates for the last week
        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek(Carbon::SUNDAY);  // Start of last week (Sunday)
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek(Carbon::SATURDAY);    // End of last week (Saturday)

        // Sum the total for rentals from last week
        $total_last_week_earn = Invoice::whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
                              ->sum('total');
        


        // Get the start and end dates for the current week
        $startOfCurrentWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY);  // Start of this week (Sunday)
        $endOfCurrentWeek = Carbon::now()->endOfWeek(Carbon::SATURDAY);    // End of this week (Saturday)

        // Sum the total for rentals from the current week
        $total_current_week_earn = Invoice::whereBetween('created_at', [$startOfCurrentWeek, $endOfCurrentWeek])
                                 ->sum('total');
        


                                 // Get the start and end of the previous day
        $startOfPreviousDay = Carbon::yesterday()->startOfDay();  // Start of yesterday
        $endOfPreviousDay = Carbon::yesterday()->endOfDay();      // End of yesterday

        // Sum the total for rentals from the previous day
        $total_previous_day_earn = Invoice::whereBetween('created_at', [$startOfPreviousDay, $endOfPreviousDay])
                                 ->sum('total');
        $total_previos_invoice = Invoice::whereBetween('created_at', [$startOfPreviousDay, $endOfPreviousDay])
                                 ->count();
        
        // Get the start of today and the current time
        $startOfToday = Carbon::today()->startOfDay();  // Start of today (00:00:00)
        $endOfToday = Carbon::now();                    // Current time (now)

        // Sum the total for rentals created today
        $total_today_earn = Invoice::whereBetween('created_at', [$startOfToday, $endOfToday])
                           ->sum('total');
        $total_today_invoice = Invoice::whereBetween('created_at', [$startOfToday, $endOfToday])
                           ->count();
        

        // Get the current month start and end dates
        $startOfMonth = Carbon::now()->startOfMonth();  // Start of the current month (1st day)
        $endOfMonth = Carbon::now()->endOfMonth();      // End of the current month (last day)

        // Retrieve and group invoices by day, summing the total for each day
        $daily_totals = Invoice::select(
                            DB::raw('DATE(created_at) as date'), // Group by date
                            DB::raw('SUM(total) as total')       // Sum totals for each day
                        )
                        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                        ->groupBy(DB::raw('DATE(created_at)'))  // Group by date
                        ->get();


        $chartData = [
            'labels' => $daily_totals->pluck('date'),  // Extract dates
            'data' => $daily_totals->pluck('total'),   // Extract total sums
        ];

        // Retrieve and group Collection by day, summing the total for each day
        

        
        return[
            'role'=>$user_role,
            'product'=> $product,
            'category'=> $Category,
            'customer'=> $Customer,
            'invoice'=> $Invoice,
            
            'total'=> round($total,2),
            'total_last_month_earn'=> round($total_last_month_earn,2),
            'total_current_month_earn'=> round($total_current_month_earn,2),
            'total_last_week_earn'=> round($total_last_week_earn,2),
            'total_current_week_earn'=> round($total_current_week_earn,2),
            'total_previous_day_earn'=> round($total_previous_day_earn,2),
            'total_today_earn'=> round($total_today_earn,2),
            'total_today_invoice' => $total_today_invoice,
            'total_previos_invoice' => $total_previos_invoice,
            
            

            //Order details chart
            'chartData' =>$chartData,
            'labels' => $daily_totals->pluck('date'),  // Extract dates
            'data' => $daily_totals->pluck('total'),   // Extract total sums
            
        ];
    }

    public function VisitorCount()
    {
        $visitorCount = Visitor::count();
        return response()->json($visitorCount);
    }
}
