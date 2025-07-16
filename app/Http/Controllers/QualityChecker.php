<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\BrandsProfile;
use App\Models\user;
use App\Models\CreditsUsage;
use Illuminate\Support\Facades\Auth;

class QualityChecker extends Controller
{
    public function dashboard(){
        $totalOrders = Orders::where('assigned_to', Auth::user()->id)->get()->count();
        $completedOrders = Orders::where('assigned_to', Auth::user()->id)->where('status', 'Completed')->get()->count();
        $pendingOrders = Orders::where('assigned_to', Auth::user()->id)->where('status', 'Pending')->get()->count();
        $inProgress = Orders::where('assigned_to', Auth::user()->id)->where('status', 'In Progress')->get()->count();
        return view('qualitychecker.qc-dashboard', compact('totalOrders', 'completedOrders', 'pendingOrders'));
    }

    public function orders(){
        $orders = Orders::where('assigned_to', Auth::user()->id)->whereNotIn('status', ['Quality Checking'])->get();
        return view('qualitychecker.qc-orders', compact('orders'));
    }

    public function ordersEdit($id){
        $order = Orders::find($id);
        $brands = BrandsProfile::get();
        $subscribers = User::where('role', 'subscriber')->get();
        $admins = User::where('role', 'admin')->orWhere('role', 'qualitychecker')->get();
        return view('qualitychecker.orders.edit-order', compact('order', 'brands', 'subscribers', 'admins'));
    }

    public function qclist(){
        $orders = Orders::where('status', ['Quality Checking'])->get();
        return view('qualitychecker.quality-checkinglist', compact('orders'));
    }


    public function updateOrder(Request $request, $id){
        $request->validate([
            'status' => 'required|string|in:Pending,In Progress,Completed,Rejected,Quality Checking',
        ]);
    
        $order = Orders::findOrFail($id);
        $order->status = $request->status;
        $order->save();
    
        return back()->with('success', 'Status updated successfully!');
    }

    public function viewOrder($id){
        $user = auth()->user();
        $subscribers = User::where('role', 'subscriber')->get();
        $admins = User::where('role', 'admin')->orWhere('role', 'qualitychecker')->get();
        $creditsUsage = CreditsUsage::where('order_id', $id)->first();
        // Subscribers can only view their own orders
        $order = Orders::where('id', $id)->where('assigned_to', $user->id)->firstOrFail();
        return view('qualitychecker.orders.view-order', compact('order', 'subscribers', 'admins', 'creditsUsage'));
    }

    public function viewQcorders($id){
        $subscribers = User::where('role', 'subscriber')->get();
        $admins = User::where('role', 'admin')->orWhere('role', 'qualitychecker')->get();
        $creditsUsage = CreditsUsage::where('order_id', $id)->first();
        // Subscribers can only view their own orders
        $order = Orders::where('id', $id)->firstOrFail();
        return view('qualitychecker.view-qcorders.view_qcorders', compact('order', 'subscribers', 'admins', 'creditsUsage'));
    }
    
}
