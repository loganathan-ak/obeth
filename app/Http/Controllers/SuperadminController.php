<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class SuperadminController extends Controller
{

    public function createAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,superadmin',
        ]);
    
        $latestId = User::max('obeth_id');
        $nextNumber = $latestId ? intval(str_replace('OBE-', '', $latestId)) + 1 : 1000;
    
        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
            'obeth_id' => 'OBE-' . $nextNumber,
        ]);
    
        return redirect()->route('superadmin.admins')->with('success', 'Admin user created successfully.');
    }


    public function deleteAdmin($id)
    {
        $admin = User::where('id', $id)
                     ->whereIn('role', ['admin', 'superadmin'])
                     ->firstOrFail();
    
        $admin->delete();
    
        return redirect()->route('superadmin.admins')->with('success', 'Admin deleted successfully.');
    }
    
    public function updateOrder(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'request_type' => 'required|string',
            'other_request_type' => 'nullable|string',
            'instructions' => 'nullable|string',
            'colors' => 'nullable|string',
            'size' => 'nullable|string',
            'other_size' => 'nullable|string',
            'software' => 'nullable|string',
            'other_software' => 'nullable|string',
            'brand_profile_id' => 'nullable|exists:brands_profiles,id',
            'formats' => 'nullable|array',
            'pre_approve' => 'nullable|numeric|min:0',
            'reference_files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,ai,psd,eps|max:10240',
            'rush' => 'nullable',
            'assigned_to' => 'required',
        ]);
    
        $order = Orders::findOrFail($id);
    
        $rush = $request->has('rush') ? 1 : 0;
    
        // Handle file uploads (append to existing)
        $uploadedFiles = [];
        if ($request->hasFile('reference_files')) {
            foreach ($request->file('reference_files') as $file) {
                $uploadedFiles[] = [
                    'path' => $file->store('reference_files', 'public'),
                    'original_name' => $file->getClientOriginalName(),
                ];
            }
    
            // Merge with existing reference files (if needed)
            if ($order->reference_files) {
                $existingFiles = json_decode($order->reference_files, true);
                $uploadedFiles = array_merge($existingFiles, $uploadedFiles);
            }
        }
    
        // Update order
        $order->update([
            'project_title' => $validated['title'],
            'request_type' => $validated['request_type'],
            'other_request_type' => $validated['other_request_type'] ?? null,
            'instructions' => $validated['instructions'] ?? null,
            'colors' => $validated['colors'] ?? null,
            'size' => $validated['size'] ?? null,
            'other_size' => $validated['other_size'] ?? null,
            'software' => $validated['software'] ?? null,
            'other_software' => $validated['other_software'] ?? null,
            'brands_profile_id' => $validated['brand_profile_id'],
            'formats' => isset($validated['formats']) ? json_encode($validated['formats']) : null,
            'pre_approve' => $validated['pre_approve'] ?? null,
            'reference_files' => !empty($uploadedFiles) ? json_encode($uploadedFiles) : $order->reference_files,
            'rush' => $rush,
            'assigned_to' => $validated['assigned_to'],
        ]);
    
        return redirect()->route('superadmin.orders')->with('success', 'Order updated successfully.');
    }
    

    public function updateAdminform($id){
        $admin = User::findOrFail($id);
        return view('superadmin.admins.edit-admin', compact('admin'));
    }

    public function updateAdmin(Request $request, $id)
{
    $admin = User::findOrFail($id); // Assuming you're using the User model

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $admin->id,
        'password' => 'nullable|string|min:6',
        'role' => 'required|in:admin,superadmin',
    ]);

    $admin->name = $validated['name'];
    $admin->email = $validated['email'];
    $admin->role = $validated['role'];

    // Update password only if filled
    if (!empty($validated['password'])) {
        $admin->password = bcrypt($validated['password']);
    }

    $admin->save();

    return redirect()->route('superadmin.admins')->with('success', 'Admin updated successfully.');
}

    

}
