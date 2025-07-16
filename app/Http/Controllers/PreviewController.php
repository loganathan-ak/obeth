<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Mail\PreviewSubmittedMail;
use App\Models\Preview;
use App\Models\Orders;
use App\Models\Notifications;
use App\Models\User;
use Mail;



class PreviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'job_id' => 'required|string|max:255',
            'image' => 'required|string', // Base64 image data
            'feedbacks' => 'required|json', // JSON string of annotations
        ]);
    
        try {
            // 1. Handle the image upload (base64 decode and save)
            $imageData = $request->input('image');
            $base64Image = Str::after($imageData, 'base64,');
            $decodedImage = base64_decode($base64Image);
    
            $filename = 'previews/' . Str::uuid() . '.jpeg';
            Storage::disk('public')->put($filename, $decodedImage);
    
            // 2. Save to database
            $preview = Preview::create([
                'order_id'   => $request->input('order_id'),
                'job_id'     => $request->input('job_id'),
                'image_path' => $filename,
                'feedback'   => $request->input('feedbacks'),
            ]);
    
            // 3. Get recipients
            $order = Orders::findOrFail($request->input('order_id'));
            $superadmin = User::where('role', 'superadmin')->first();
            $designer = User::find($order->assigned_to);
            $client = User::find($order->created_by);
    
            // 4. Create DB notification
            Notifications::create([
                'designer_id'   => $order->assigned_to,
                'client_id'     => $order->created_by,
                'message'       => "An image revision has been submitted for the \"{$order->project_title}\".",
                'purpose'       => 'image_revision_submitted',
                'superadmin_id' => $superadmin?->id,
            ]);
    
    
            // 6. Send mail to all 3
            foreach ([$designer, $client, $superadmin] as $recipient) {
                if ($recipient && $recipient->email) {
                    Mail::to($recipient->email)->send(
                        new PreviewSubmittedMail(
                            $order,
                            $recipient->first_name,
                            auth()->user()->first_name
                        )
                    );
                }
            }
    
            // 7. Return response
            return response()->json([
                'message'   => 'Preview saved successfully!',
                'preview'   => $preview,
                'image_url' => Storage::url($filename)
            ], 201);
    
        } catch (\Exception $e) {
            \Log::error('Error saving preview: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'message' => 'Failed to save preview.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function fetch(Request $request)
{
    $orderId = $request->query('order_id');
    $jobId = $request->query('job_id');

    $previews = Preview::where('order_id', $orderId)
        ->where('job_id', $jobId)
        ->get();

    return response()->json($previews);
}

}




