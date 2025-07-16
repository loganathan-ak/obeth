<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BrandsProfile;
use App\Models\Orders;
use App\Models\User;
use App\Models\Plans;
use App\Models\Enquiry;
use App\Models\Transactions;
use App\Models\CreditsUsage;
use App\Models\OrderTemplate;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod; 


class RouteController extends Controller
{
    public function home() {
        $ordersCount = Orders::where('created_by', Auth::id())->get()->count();
        $brandsCount = BrandsProfile::where('created_by', Auth::id())->get()->count();
        $currentUserCredits = Auth::user()->credits;
        $completedProjects = Orders::where('created_by', Auth::id())->where('status', 'Completed')->get()->count();
        $transactions = Transactions::where('user_id', Auth::id())->latest()->limit(3)->get();
        $completed = Orders::where('created_by', Auth::id())->where('status', 'completed')->count();
        $inProgress = Orders::where('created_by', Auth::id())->where('status', 'in progress')->count();
        $qualityChecking = Orders::where('created_by', Auth::id())->where('status', 'quality checking')->count();
        $pending = Orders::where('created_by', Auth::id())->where('status', 'pending')->count();

        $currentUser = Auth::user()->id;
        $orders = Orders::where('created_by', $currentUser)->whereIn('status', ['Pending', 'In Progress'])->get();
        $users = User::get();
        return view('subscribers.dashboard', compact(  'users', 'orders', 'currentUserCredits', 'brandsCount', 'ordersCount', 'completedProjects', 'transactions', 'completed', 'inProgress', 'pending', 'qualityChecking'));
    }

    public function billing() {
        $transactions = Transactions::where('user_id', Auth::id())->get();
        $plans = Plans::get();
        return view('subscribers.billing', compact('transactions', 'plans'));
    }
    

    public function brandProfile(){
        $currentUser = auth()->user()->id; 
        $brands = BrandsProfile::where('created_by', $currentUser)->get();
        $count = BrandsProfile::where('created_by', $currentUser)->count();

        return view('subscribers.brandprofile', compact('brands', 'currentUser', 'count'));
    }

    public function viewBrand($id){
        $brand = BrandsProfile::findOrFail($id);
        return view('subscribers.branddetails.view-brand', compact('brand'));
    }

    public function editBrand($id){
        $brand = BrandsProfile::findOrFail($id);
        return view('subscribers.branddetails.edit-brand', compact('brand'));
    }

    public function brandForm() {
        return view('subscribers.branddetails.add-brand');
    }

    public function profile() {
        return view('subscribers.profile');
    }

    public function designBrief() {
        return view('subscribers.designbrief');
    }

    public function revisionTool() {
        return view('subscribers.revisiontool');
    }

    public function helpCenter() {
        return view('subscribers.helpcenter');
    }

    public function requests(Request $request)
    {
        $currentUser = Auth::user()->id;
        $currentUserCredits = Auth::user()->credits;
    
        $query = Orders::where('created_by', $currentUser);
    
        // Apply status filter
        if ($request->filled('status_filter')) {
            $query->where('status', $request->status_filter);
        }
    
        // Apply from date filter
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
    
        // Apply to date filter
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
    
        $orders = $query->latest()->get();
    
        $completedOrders = Orders::where('created_by', $currentUser)->where('status', 'completed')->count();
        $slots = Orders::where('created_by', $currentUser)->whereIn('status', ['Pending', 'In Progress'])->count();
        $queued = Orders::where('created_by', $currentUser)->where('status', 'Queued')->count();
        $users = User::get();
    
        return view('subscribers.requests', compact('orders', 'currentUserCredits', 'completedOrders', 'slots', 'queued', 'users'));
    }
    

    public function addOrder()
    {
        $currentUser = auth()->id();
    
        $brands = BrandsProfile::where('created_by', $currentUser)->get();
    
        $templates = OrderTemplate::where('created_by', $currentUser)->get();
    
        return view('subscribers.orders.add-order', compact('brands', 'templates'));
    }
    

public function viewOrder($id)
{
    $user = auth()->user();
    $subscribers = User::where('role', 'subscriber')->get();
    $admins = User::where('role', 'admin')->get();
    $creditsUsage = CreditsUsage::where('order_id', $id)->first();

    // If superadmin, fetch any order
    if ($user->role === 'superadmin') {
        $order = Orders::findOrFail($id);
    } else {
        // Subscribers can only see their own orders
        $order = Orders::where('id', $id)
                       ->where('created_by', $user->id)
                       ->firstOrFail();
    }

    // Load associated brand
    $brand = BrandsProfile::find($order->brands_profile_id);

    return view('subscribers.orders.view-order', compact(
        'order', 'subscribers', 'admins', 'creditsUsage', 'brand'
    ));
}



    public function editOrder($id)
    {
        $user = auth()->user();

        $brands = BrandsProfile::get();  
        $subscribers = User::where('role', 'subscriber')->get();

        $admins = User::where('role', 'admin')->orWhere('role', 'qualitychecker')->get();
        // Superadmin can view all orders
        if ($user->role === 'superadmin') {
            $order = Orders::findOrFail($id);
            return view('superadmin.orders.edit-order', compact('order', 'brands', 'subscribers', 'admins'));
        }
    
        // Subscribers can only view their own orders
        $order = Orders::where('id', $id)->where('created_by', $user->id)->firstOrFail();
    
        return view('subscribers.orders.edit-order', compact('order', 'brands'));
    }
    
    public function usage(Request $request) {
        $currentUser = (int) Auth::user()->id;
        $query = CreditsUsage::where('user_id', $currentUser);
    
        $from = $request->filled('from_date') ? Carbon::parse($request->from_date)->startOfDay() : null;
        $to = $request->filled('to_date') ? Carbon::parse($request->to_date)->endOfDay() : null;
    
        // Use OR logic for filtering
        if ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        } elseif ($from) {
            $query->where('created_at', '>=', $from);
        } elseif ($to) {
            $query->where('created_at', '<=', $to);
        }
        
    
        $usages = $query->get();
        $orders = Orders::where('created_by', $currentUser)->get();
    
        return view('subscribers.usage', compact('usages', 'orders'));
    }

    public function users() {
        return view('subscribers.users');
    }


    public function login() {
        return view('auth.login');
    }

    public function register() {
        $plans = Plans::get();
        return view('auth.register', compact('plans'));
    }



public function superadminDashboard() {
    // Unfiltered basic stats
    $ordersCount = Orders::count();
    $adminsCount = User::whereIn('role', ['admin', 'qualitychecker'])->count();
    $subscribersCount = User::where('role', 'subscriber')->count();
    $completedProjects = Orders::where('status', 'completed')->count();
    $transactions = Transactions::latest()->take(6)->get();
    $todayTotal = Transactions::whereDate('created_at', Carbon::today())->sum('amount_paid');
    $totalSales = Transactions::sum('amount_paid');

    // Filtered Orders Counts
    $weeklyOrders = Orders::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
    $monthlyOrders = Orders::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();
    $yearlyOrders = Orders::whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()])->count();

    // Weekly Sales Chart (7-day line chart)
    $startDate = now()->subDays(6);
    $weeklyData = Transactions::whereBetween('created_at', [$startDate, now()])
        ->selectRaw('DATE(created_at) as date, SUM(amount_paid) as total')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    $weeklySales = [];
    $weeklyLabels = [];
    $startDate = Carbon::now()->subDays(6);
    $dates = CarbonPeriod::create($startDate, Carbon::now());


    foreach ($dates as $date) {
        $label = $date->format('D'); // e.g., Mon, Tue...
        $daily = $weeklyData->firstWhere('date', $date->format('Y-m-d'));
        $weeklyLabels[] = $label;
        $weeklySales[] = $daily ? $daily->total : 0;
    }

    return view('superadmin.superadmin-dashboard', compact(
        'ordersCount', 'weeklyOrders', 'monthlyOrders', 'yearlyOrders',
        'completedProjects', 'adminsCount', 'subscribersCount',
        'transactions', 'todayTotal', 'totalSales',
        'weeklyLabels', 'weeklySales'
    ));
}


    public function superadminOrders(Request $request)
    {
        $query = Orders::query();
    
        // Filter by status
        if ($request->filled('status_filter')) {
            $query->where('status', $request->status_filter);
        }
        
    
        // Filter by from_date
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
    
        // Filter by to_date
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
    
        $orders = $query->latest()->get();
        $users = User::get();
    
        return view('superadmin.orders', compact('orders', 'users'));
    }
    

    public function superadminSubscribers(Request $request)
    {
        $query = User::with('latestTransaction')
            ->where('role', 'subscriber');
    
        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('id', $request->user_id);
        }
    
        // Filter by from_date
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
    
        // Filter by to_date
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
    
        // ✅ Filter by plan status
        if ($request->filled('status')) {
            if ($request->status === 'No Plan') {
                // Users with no transactions
                $query->whereDoesntHave('latestTransaction');
            } else {
                // Users with a matching transaction status
                $query->whereHas('latestTransaction', function ($q) use ($request) {
                    $q->where('status', $request->status);
                });
            }
        }
    
        $subscribers = $query->get();
        $plans = Plans::get();
        $users = User::where('role', 'subscriber')->get(); // for dropdown
    
        return view('superadmin.subscribers', compact('subscribers', 'plans', 'users'));
    }
    




    public function adminsList(){
        $admins = User::where('role', 'admin')->orWhere('role', 'superadmin')->orWhere('role', 'qualitychecker')->get();
        return view('superadmin.admins', compact('admins'));
    }


    public function addAdminForm(){
        return view('superadmin.admins.add-admin');
    }


    public function adminDashboard() {
        $totalOrders = Orders::where('assigned_to', Auth::user()->id)->get()->count();
        $completedOrders = Orders::where('status', 'Completed')->where('assigned_to', Auth::user()->id)->get()->count();
        $pendingOrders = Orders::where(function($query) {
            $query->where('status', 'Pending')
                  ->orWhere('status', 'In Progress');
        })
        ->where('assigned_to', Auth::user()->id)
        ->get();
    
        $rejectedOrders = Orders::where('status', 'Rejected')->where('assigned_to', Auth::user()->id)->get()->count();
        return view('designers&admin.admin-dashboard', compact('totalOrders', 'completedOrders', 'rejectedOrders', 'pendingOrders'));
    }

    public function adminOrders(Request $request)
    {
        $currentUser = Auth::id(); // or Auth::user()->id;
    
        $query = Orders::where('assigned_to', $currentUser);
    
        // Status Filter
        if ($request->filled('status_filter')) {
            $query->where('status', $request->status_filter);
        }
    
        // From Date Filter
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
    
        // To Date Filter
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
    
        $orders = $query->latest()->get();
    
        return view('designers&admin.orders', compact('orders'));
    }
    

public function superadminEnquires(Request $request)
{
    $query = Enquiry::query();

    // Filter by from_date
    if ($request->filled('from_date')) {
        $query->whereDate('created_at', '>=', $request->from_date);
    }

    // Filter by to_date
    if ($request->filled('to_date')) {
        $query->whereDate('created_at', '<=', $request->to_date);
    }

    // Filter by email or name (optional)
    if ($request->filled('keyword')) {
        $query->where(function ($q) use ($request) {
            $q->where('email', 'like', '%' . $request->keyword . '%')
              ->orWhere('name', 'like', '%' . $request->keyword . '%');
        });
    }

    $enquiries = $query->latest()->paginate(25);
    $users = User::get();

    return view('superadmin.enquires', compact('enquiries', 'users'));
}

public function creditChart(){
    return view('credits-chart');
}

}
