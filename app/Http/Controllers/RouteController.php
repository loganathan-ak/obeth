<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BrandsProfile;
use App\Models\Orders;
use App\Models\User;
use App\Models\Enquiry;
use Illuminate\Support\Facades\Auth;


class RouteController extends Controller
{
    public function home() {
        return view('subscribers.dashboard');
    }

    public function billing() {
        return view('subscribers.billing');
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

    public function requests() {
        $currentUser = Auth::user()->id;
        $orders = Orders::where('created_by', $currentUser)->get();
        return view('subscribers.requests', compact('orders'));
    }

    public function addOrder() {
        $currentUser = auth()->user()->id; 
        $brands = BrandsProfile::where('created_by', $currentUser)->get();  
        return view('subscribers.orders.add-order', compact('brands'));
    }

    public function viewOrder($id)
    {
        $user = auth()->user();
        $subscribers = User::where('role', 'subscriber')->get();
        $admins = User::where('role', 'admin')->get();
    
        // Superadmin can view all orders
        if ($user->role === 'superadmin') {
            $order = Orders::findOrFail($id);
            return view('subscribers.orders.view-order', compact('order', 'subscribers', 'admins'));
        }
    
        // Subscribers can only view their own orders
        $order = Orders::where('id', $id)
            ->where('created_by', $user->id)
            ->firstOrFail();
    
        return view('subscribers.orders.view-order', compact('order', 'subscribers', 'admins'));
    }


    public function editOrder($id)
    {
        $user = auth()->user();

        $brands = BrandsProfile::get();  
        $subscribers = User::where('role', 'subscriber')->get();

        $admins = User::where('role', 'admin')->get();
        // Superadmin can view all orders
        if ($user->role === 'superadmin') {
            $order = Orders::findOrFail($id);
            return view('superadmin.orders.edit-order', compact('order', 'brands', 'subscribers', 'admins'));
        }
    
        // Subscribers can only view their own orders
        $order = Orders::where('id', $id)->where('created_by', $user->id)->firstOrFail();
    
        return view('subscribers.orders.edit-order', compact('order', 'brands'));
    }
    
    

    public function usage() {
        return view('subscribers.usage');
    }

    public function users() {
        return view('subscribers.users');
    }


    public function login() {
        return view('auth.login');
    }

    public function register() {
        return view('auth.register');
    }



    public function superadminDashboard() {
        return view('superadmin.superadmin-dashboard');
    }


    public function superadminOrders() {
        $orders = Orders::get();
        return view('superadmin.orders', compact('orders'));
    }

    public function superadminSubscribers() {
        $subscribers = User::where('role', 'subscriber')->get();
        return view('superadmin.subscribers', compact('subscribers'));
    }

    public function adminsList(){
        $admins = User::where('role', 'admin')->orWhere('role', 'superadmin')->get();
        return view('superadmin.admins', compact('admins'));
    }


    public function addAdminForm(){
        return view('superadmin.admins.add-admin');
    }


    public function adminDashboard() {
        $totalOrders = Orders::get()->count();
        $completedOrders = Orders::where('status', 'Completed')->get()->count();
        $pendingOrders = Orders::where('status', 'Pending')->orWhere('status', 'In Progress')->get()->count();
        $rejectedOrders = Orders::where('status', 'Rejected')->get()->count();
        return view('designers&admin.admin-dashboard', compact('totalOrders', 'completedOrders', 'rejectedOrders'));
    }

    public function adminOrders(){
        $currentUser = Auth::user()->id;
        $orders = Orders::where('assigned_to', $currentUser)->get();
        return view('designers&admin.orders', compact('orders'));
    }

    public function superadminEnquires() {
        $enquiries = Enquiry::get();
        return view('superadmin.enquires', compact('enquiries'));
    }


}
