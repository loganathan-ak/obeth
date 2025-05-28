<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BrandsProfile;
use App\Models\Orders;

class AdminController extends Controller
{
    public function adminViewOrders($id){
        $user = auth()->user();

        $brands = BrandsProfile::get();  
        $subscribers = User::where('role', 'subscriber')->get();

        $admins = User::where('role', 'admin')->get();

            $order = Orders::findOrFail($id);
            return view('designers&admin.orders.view-order', compact('order', 'brands', 'subscribers', 'admins'));
        
    }

    public function adminEditOrders($id){

        $user = auth()->user();

        $brands = BrandsProfile::get();

        $subscribers = User::where('role', 'subscriber')->get();

        $admins = User::where('role', 'admin')->get();

        $order = Orders::findOrFail($id);

        return view('designers&admin.orders.edit-order', compact('order', 'brands', 'subscribers', 'admins'));
    
    }


    public function updateOrder(Request $request, $id)
{
    $request->validate([
        'status' => 'required|string|in:Pending,In Progress,Completed,Rejected',
    ]);

    $order = Orders::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    return back()->with('success', 'Status updated successfully!');
}

}
