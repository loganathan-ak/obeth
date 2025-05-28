<div class="bg-white shadow rounded-2xl p-6 border border-gray-200 flex flex-col max-h-[500px]">
    <h2 class="text-xl font-bold text-gray-800 mb-4">💬 Chat</h2>

    <div class="flex-1 overflow-y-auto space-y-4 mb-4" wire:poll.3s>
        @foreach ($conversations as $chat)
            @php
                $isSender = $chat->sender_id == auth()->id();
                $receiverId = $isSender ? $chat->receiver_id : $chat->sender_id;
                $receiver = \App\Models\User::find($receiverId);
                $receiverRole = ucfirst($receiver->role); // Capitalize: 'admin' => 'Admin'
            @endphp
    
            <div class="@if($isSender) bg-blue-100 self-end @else bg-gray-100 @endif p-3 rounded-lg text-sm text-gray-800 ">
                <strong>{{ $isSender ? 'You' : $receiverRole }}:</strong> {{ $chat->message }}
            </div>
        @endforeach
    </div>
    
 
    @if ($sender && $receiver)
    <form wire:submit.prevent="store" class="flex items-center gap-2">
        <input type="text" wire:model="message" placeholder="Type a message..."
            class="flex-1 border rounded-lg px-3 py-2 text-sm">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">Send</button>
    </form>
@else
    <div class="text-sm text-gray-500 text-center mt-2">
        🔒 You are not authorized to participate in this chat.
    </div>
@endif

</div>
