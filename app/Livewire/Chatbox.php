<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Conversation;

class Chatbox extends Component
{
    public $order;
    public $receiver;
    public $sender;
    public $message;
    public $receiverRole;

    public function mount($order)
    {
        $this->order = $order->id;

        if (auth()->id() === $order->assigned_to) {
            $this->receiver = $order->created_by;
            $this->sender = $order->assigned_to;
        } elseif (auth()->id() === $order->created_by) {
            $this->receiver = $order->assigned_to;
            $this->sender = $order->created_by;
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
