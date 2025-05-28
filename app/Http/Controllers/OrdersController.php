<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrdersController extends Controller
{
    public function store(Request $request)
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
    ]);


   $rush = $request->has('rush') ? 1 : 0;

   $uploadedFiles = [];
   if ($request->hasFile('reference_files')) {
       foreach ($request->file('reference_files') as $file) {
           $uploadedFiles[] = [
               'path' => $file->store('reference_files', 'public'),
               'original_name' => $file->getClientOriginalName(),
           ];
       }
   }
   

    // Create order
    $order = Orders::create([
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
        'reference_files' => !empty($uploadedFiles) ? json_encode($uploadedFiles) : null,
        'rush' => $rush,
        'created_by' => Auth::id(),
        'obeth_id' => Auth::user()->obeth_id, // Auto generate unique ID
        'status' => 'pending',
    ]);

    return redirect()->route('requests')->with('success', 'Order created successfully.');
}
}
