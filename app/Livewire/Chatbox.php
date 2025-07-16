<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\User;

class Chatbox extends Component
{
    public $order;
    public $receiver;
    public $sender;
    public $message;
    public $receiverRole = 'superadmin';

    public function mount($order)
    {
        $this->order = $order->id;
        $designer = User::find($order->assigned_to);
        $clientId = $order->created_by;
        $currentUser = auth()->user();
    
        if (!$designer) {
            abort(404, 'Assigned designer not found.');
        }
    
        // If client is logged in
        if ($currentUser->id === $clientId) {
            $this->sender = $clientId;
            $this->receiver = $designer->id;
    
        // If designer is logged in
        } elseif ($currentUser->id === $designer->id) {
            $this->sender = $designer->id;
            $this->receiver = $clientId;
    
        // If superadmin is logged in — just view mode by default (optional: pick either side to talk as)
        } elseif ($currentUser->role === 'superadmin') {
            // Default: superadmin views as third-party (could also allow to message either)
            $this->sender = null; // or $currentUser->id if you want superadmin to send messages
            $this->receiver = null;
    
        } else {
            abort(403, 'Unauthorized.');
        }
    }
    
    

    public function store()
    {
        $this->validate([
            'message' => 'required',
        ]);

        Conversation::create([
            'order_id' => $this->order,
            'sender_id' => $this->sender,
            'receiver_id' => $this->receiver,
            'message' => $this->message,
        ]);

        $this->message = '';
    }

    public function render()
    {
        return view('livewire.chatbox', [
            'conversations' => Conversation::where('order_id', $this->order)
                ->orderBy('created_at')
                ->get(),
        ]);
    }
}


