<x-layout>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow rounded-lg mt-25">
        <h2 class="text-2xl font-bold mb-6">Profile Settings</h2>

        @if(session('success'))
            <div class="mb-4 text-green-600 font-medium">{{ session('success') }}</div>
        @endif

        {{-- Profile Info --}}
        <div class="flex items-center space-x-6 mb-6">
            <img src="{{ Auth::user()->profile_photo_url ?? asset('user.png') }}"
                 alt="Profile Photo"
                 class="w-20 h-20 rounded-full object-cover border">
            <div>
                <h3 class="text-xl font-semibold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h3>
                <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                <span class="inline-block mt-1 px-3 py-1 text-xs font-bold rounded-full
                    @switch(Auth::user()->role)
                        @case('superadmin') bg-purple-100 text-purple-800 @break
                        @case('admin') bg-blue-100 text-blue-800 @break
                        @case('subscriber') bg-green-100 text-green-800 @break
                        @case('qualitychecker') bg-yellow-100 text-yellow-800 @break
                        @default bg-gray-100 text-gray-800
                    @endswitch">
                    {{ ucfirst(Auth::user()->role) }}
                </span>
            </div>
        </div>


        @php
    $transaction = \App\Models\Transactions::where('user_id', Auth::id())
        ->orderByDesc('created_at')
        ->first();

    $status = 'Unknown';

    if ($transaction && $transaction->transaction_id) {
        // Try to get status from cached DB field or external API/webhook
        $status = $transaction->status ?? 'Active'; // fallback if you track status in DB
    }
@endphp

@if($transaction)
    <div class="bg-white border rounded-lg p-4 shadow-sm mb-5">
        <h4 class="text-md font-bold mb-2">Current Subscription</h4>
        <p class="text-sm text-gray-700"><strong>Plan:</strong> {{ \App\Models\Plans::where('id', $transaction->plan_id)->first()->name ?? 'N/A' }}</p>
        <p class="text-sm text-gray-700"><strong>Purchased:</strong> {{ $transaction->credits_purchased }} credits</p>
        <p class="text-sm text-gray-700"><strong>Amount:</strong> ₹{{ $transaction->amount_paid }}</p>
        <p class="text-sm text-gray-700"><strong>Subscription ID:</strong> {{ $transaction->transaction_id }}</p>
        <p class="text-sm text-gray-700"><strong>Status:</strong> 
            <span class="font-semibold text-sm 
                @if($status == 'Cancelled') text-red-600 
                @elseif($status == 'Active') text-green-600 
                @else text-gray-600 @endif">
                {{ ucfirst($status) }}
            </span>
        </p>
@if($transaction->expire_date)
    @php
        $utcTime = \Carbon\Carbon::parse($transaction->expire_date)->timezone('UTC');
        $istTime = $utcTime->copy()->timezone('Asia/Kolkata');
    @endphp

    <p class="text-sm text-gray-700">
        <strong>Expires on (PayPal Time - UTC):</strong> {{ $utcTime->format('d M Y h:i A') }} UTC
    </p>
    <p class="text-sm text-gray-700">
        <strong>Expires on (Your Time - IST):</strong> {{ $istTime->format('d M Y h:i A') }} IST
    </p>
@endif


        @if($transaction->status === 'Active')
            <form action="{{ route('paypal.cancel.subscription') }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this subscription?')">
                    @csrf
                    <input type="hidden" name="subscription_id" value="{{ $transaction->transaction_id }}">
                    <button type="submit" class="mt-4 inline-block px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                        Cancel Subscription
                    </button>
            </form>
        @endif

    </div>


@endif


        {{-- Profile Update --}}
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', Auth::user()->first_name) }}"
                           class="w-full border rounded px-3 py-2 focus:ring focus:outline-none">
                </div>

                <div>
                    <label class="block font-medium mb-1">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', Auth::user()->last_name) }}"
                           class="w-full border rounded px-3 py-2 focus:ring focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Mobile Number</label>
                    <input type="text" name="mobile_number" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10);"
                    value="{{ old('mobile_number', Auth::user()->mobile_number) }}"
                           class="w-full border rounded px-3 py-2 focus:ring focus:outline-none">
                </div>

                <div>
                    <label class="block font-medium mb-1">Country</label>
                    <select name="country" id="country"
                        class="w-full border rounded px-3 py-2 focus:ring focus:outline-none">
                        <option value="">Select your country</option>
                        @php
                            $countries = ['India', 'United States', 'United Kingdom', 'Canada', 'Australia', 'Germany', 'France', 'Singapore', 'United Arab Emirates', 'Other'];
                        @endphp
                        @foreach($countries as $country)
                            <option value="{{ $country }}" @selected(Auth::user()->country == $country)>
                                {{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="other_country_div" class="{{ Auth::user()->country === 'Other' ? '' : 'hidden' }}">
                <label class="block font-medium mb-1">Other Country</label>
                <input type="text" name="other_country" id="other_country"
                       value="{{ old('other_country', Auth::user()->other_country) }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:outline-none">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Company Name</label>
                    <input type="text" name="company_name"
                           value="{{ old('company_name', Auth::user()->company_name) }}"
                           class="w-full border rounded px-3 py-2 focus:ring focus:outline-none">
                </div>
                
                <div>
                    <label class="block font-medium mb-1">Office Number</label>
                    <input type="text" name="office_number" inputmode="numeric"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10);"
                           value="{{ old('office_number', Auth::user()->office_number) }}"
                           class="w-full border rounded px-3 py-2 focus:ring focus:outline-none">
                </div>
            </div>
            
            <div>
                <label class="block font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:outline-none">
            </div>

            <div>
                <label class="block font-medium mb-1">Address</label>
                <textarea type="address" name="address"
                       class="w-full border rounded px-3 py-2 focus:ring focus:outline-none">{{ old('address', Auth::user()->address) }}</textarea>
            </div>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                Save Changes
            </button>
        </form>

        {{-- Divider --}}
        <hr class="my-8">

        {{-- Password Change --}}
        <h3 class="text-xl font-semibold mb-4">Change Password</h3>
        <form action="{{ route('profile.password') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium mb-1">Current Password</label>
                <input type="password" name="current_password" required
                       class="w-full border rounded px-3 py-2 focus:ring">
            </div>

            <div class="relative">
                <label class="block font-medium mb-1">New Password</label>
                <input type="password" name="new_password" id="new_password" required
                       class="w-full border rounded px-3 py-2 focus:ring">
                <button type="button" onclick="togglePassword('new_password')"
                        class="absolute right-3 top-9 text-sm text-gray-600 hover:text-black">
                    👁️
                </button>
            </div>

            <div class="relative">
                <label class="block font-medium mb-1">Confirm Password</label>
                <input type="password" name="new_password_confirmation" id="confirm_password" required
                       class="w-full border rounded px-3 py-2 focus:ring">
                <button type="button" onclick="togglePassword('confirm_password')"
                        class="absolute right-3 top-9 text-sm text-gray-600 hover:text-black">
                    👁️
                </button>
            </div>

            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                Update Password
            </button>
        </form>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const countrySelect = document.getElementById('country');
            const otherDiv = document.getElementById('other_country_div');
            const otherInput = document.getElementById('other_country');

            countrySelect.addEventListener('change', function () {
                if (this.value === 'Other') {
                    otherDiv.classList.remove('hidden');
                    otherInput.required = true;
                } else {
                    otherDiv.classList.add('hidden');
                    otherInput.required = false;
                    otherInput.value = '';
                }
            });
        });
    </script>
</x-layout>
