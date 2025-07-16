<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreatedMail;
use App\Models\User;
use App\Models\Notifications;
use App\Models\OrderTemplate;

class OrdersController extends Controller
{
    public function store(Request $request)
    {

        $mode = $request->input('mode', 'create'); // 'create' or 'template'


        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'request_type' => 'required|string',
            'sub_service' => 'required|string',
            'instructions' => 'nullable|string',
            'color' => 'nullable|string',
            'other_color_format' => 'nullable|string',
            'size' => 'nullable|string',
            'other_size' => 'nullable|string',
            'software' => 'nullable|string',
            'other_software' => 'nullable|string',
            'brand_profile_id' => 'nullable|exists:brands_profiles,id',
            'formats' => 'nullable|array',
            'pre_approve' => 'nullable|numeric|min:0',
            'reference_files.*' => 'nullable|file|mimes:jpg,jpeg,png,ai,psd,eps,svg,pdf,gif,indd,bmp,doc,docx,htm,html,txt,zip,rar,dst,emb,pxf,pof,raw,cdr,tiff|max:102400',
            'rush' => 'nullable',
        ]);
        
        $rush = $request->has('rush') ? 1 : 0;
    $formats = isset($validated['formats']) ? json_encode($validated['formats']) : null;
           
    if ($mode === 'template') {
        // 🔒 Limit template creation to 5 per user
        $templateCount = OrderTemplate::where('created_by', Auth::id())->count();
    
        if ($templateCount >= 5) {
            Alert::error('Limit Reached', 'You can only save up to 5 templates.');
            return back()->withInput();
        }
    
        OrderTemplate::create([
            'project_title' => $validated['title'],
            'request_type' => $validated['request_type'],
            'sub_service' => $validated['sub_service'],
            'instructions' => $validated['instructions'] ?? null,
            'colors' => $validated['color'] ?? null,
            'other_color_format' => $validated['other_color_format'] ?? null,
            'size' => $validated['size'] ?? null,
            'other_size' => $validated['other_size'] ?? null,
            'software' => $validated['software'] ?? null,
            'other_software' => $validated['other_software'] ?? null,
            'brands_profile_id' => $validated['brand_profile_id'] ?? null,
            'formats' => $formats,
            'pre_approve' => $validated['pre_approve'] ?? null,
            'rush' => $rush,
            'created_by' => Auth::id(),
        ]);
    
        Alert::success('Template Saved', 'Template saved successfully.');
        return back();
    }
    
        // Count current user's active and queued orders
        $activeCount = Orders::whereIn('status', ['Pending', 'In Progress'])
            ->where('created_by', Auth::id())
            ->count();
    
        $queueCount = Orders::where('status', 'Queued')
            ->where('created_by', Auth::id())
            ->count();
    
        // Decide status
        if ($activeCount < 5) {
            $status = 'Pending';
        } elseif ($queueCount < 5) {
            $status = 'Queued';
        } else {
            Alert::error('Error', 'You have reached the maximum limit of 5 active and 5 queued orders.');
            return back();
        }
    
        $uploadedFiles = [];
    
        if ($request->hasFile('reference_files')) {
            foreach ($request->file('reference_files') as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = pathinfo($originalName, PATHINFO_FILENAME);
                $storedPath = $file->storeAs('reference_files', $filename . '.' . $extension, 'public');
    
                $uploadedFiles[] = [
                    'path' => $storedPath,
                    'original_name' => $originalName,
                ];
            }
        }
    
        // Create the order
        $order = Orders::create([
            'project_title' => $validated['title'],
            'request_type' => $validated['request_type'],
            'sub_service' => $validated['sub_service'] ?? null,
            'instructions' => $validated['instructions'] ?? null,
            'colors' => $validated['color'] ?? null,
            'other_color_format' => $validated['other_color_format'] ?? null,
            'size' => $validated['size'] ?? null,
            'other_size' => $validated['other_size'] ?? null,
            'software' => $validated['software'] ?? null,
            'other_software' => $validated['other_software'] ?? null,
            'brands_profile_id' => $validated['brand_profile_id'],
            'formats' => $formats,
            'pre_approve' => $validated['pre_approve'] ?? null,
            'reference_files' => !empty($uploadedFiles) ? json_encode($uploadedFiles) : null,
            'rush' => $rush,
            'assigned_to' => Auth::user()->designer_id,
            'created_by' => Auth::id(),
            'obeth_id' => Auth::user()->obeth_id,
            'status' => $status,
        ]);
    
        // Generate unique order ID like JOB-101
        $lastOrder = Orders::whereNotNull('order_id')->orderByDesc('id')->first();
        $lastNumber = 100;
    
        if ($lastOrder && preg_match('/JOB-(\d+)/', $lastOrder->order_id, $matches)) {
            $lastNumber = (int)$matches[1];
        }
    
        $newOrderId = 'JOB-' . ($lastNumber + 1);
        $order->order_id = $newOrderId;
        $order->save();
           
        

            $getadmin = User::where('id', $order->created_by)->first()->designer_id;
            $clientEmail = User::where('id', $order->created_by)->value('email'); // cleaner than ->first()->email
            $adminEmail = User::where('id', $getadmin)->value('email');
            $superadminEmail = User::where('role', 'superadmin')->first()->email;
            $superadmin = User::where('role', 'superadmin')->first()->id;

            $recipients = [$clientEmail, $adminEmail, $superadminEmail];

            foreach ($recipients as $email) {
                Mail::to($email)->send(new OrderCreatedMail($order));
            }
            Notifications::create([
                'designer_id'    => $getadmin, // ID of the designer assigned to the order
                'client_id'      => Auth::id(), // The user who created the order
                'message'        => "A new Job \"{$order->project_title}\" has been created.",
                'purpose'        => 'order_created',
                'superadmin_id'  => $superadmin, // Ensure this is an ID if your DB expects ID, not email
            ]);
            

        Alert::success('Success', 'Job created successfully.');
        return redirect()->route('requests')->with('success', 'Job created successfully.');
    }
    



public function searchJob(Request $request)
{
    $user = auth()->user();

    // Determine base query based on role
    if ($user->role == 'superadmin') {
        $query = Orders::query(); // No filter for superadmin
    } elseif ($user->role == 'admin') {
        $query = Orders::where('assigned_to', $user->id);
    } else { // Assume subscriber or other roles
        $query = Orders::where('created_by', $user->id);
    }

    // Apply job name filter
    if ($request->filled('jobname')) {
        $query->where(function ($q) use ($request) {
            $q->where('project_title', 'like', '%' . $request->jobname . '%')
              ->orWhere('order_id', 'like', '%' . $request->jobname . '%');
        });
    }

    // Apply status filter
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Fetch results
    $orders = $query->latest()->get();

    return response()->json(['orders' => $orders]);
}


}
