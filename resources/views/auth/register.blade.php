<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - DesignerHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom styles for smoother transitions and modern look */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            transition: all 0.3s ease-in-out;
            border-color: #e2e8f0; /* default border color */
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: #a78bfa; /* purple-400 equivalent */
            box-shadow: 0 0 0 3px rgba(167, 139, 250, 0.4); /* focus ring */
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-500 to-pink-500 min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">

    <div class="bg-white shadow-2xl rounded-2xl w-full max-w-7xl flex flex-col md:flex-row overflow-hidden transform transition-all duration-300 scale-95 md:scale-100">
        {{-- LEFT SIDE: Registration Form --}}
        <div class="w-full md:w-2/3 p-6 sm:p-10 lg:p-12">
            {{-- Progress Steps --}}
            {{-- <div class="flex flex-wrap justify-between md:justify-start space-x-2 sm:space-x-4 mb-8 text-sm font-semibold">
                <div class="flex items-center text-blue-600">
                    <span class="w-6 h-6 flex items-center justify-center rounded-full bg-blue-600 text-white mr-2">1</span>
                    <span class="hidden sm:inline">CHOOSE PLAN</span>
                </div>
                <div class="flex items-center text-blue-600">
                    <span class="w-6 h-6 flex items-center justify-center rounded-full bg-blue-600 text-white mr-2">2</span>
                    <span class="hidden sm:inline">CREATE ACCOUNT</span>
                </div>
                <div class="flex items-center text-gray-400">
                    <span class="w-6 h-6 flex items-center justify-center rounded-full bg-gray-300 text-gray-600 mr-2">3</span>
                    <span class="hidden sm:inline">CHECKOUT</span>
                </div>
                <div class="flex items-center text-gray-400">
                    <span class="w-6 h-6 flex items-center justify-center rounded-full bg-gray-300 text-gray-600 mr-2">4</span>
                    <span class="hidden sm:inline">SUCCESS</span>
                </div>
            </div> --}}

            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-800 mb-6">Create your account</h2>

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                    <strong class="font-bold">Whoops!</strong>
                    <span class="block sm:inline">Please fix the following errors:</span>
                    <ul class="mt-2 list-disc pl-6">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
               <input type="hidden" name="plan_id" id="selected_plan_id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" name="first_name" id="first_name" required autofocus value="{{ old('first_name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                    </div>
            
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500" required>
                    </div>
                </div>
            
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label for="mobile_number" class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
                        <input type="text" name="mobile_number" id="mobile_number"
                            value="{{ old('mobile_number') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500"
                            required oninput="this.value = this.value.replace(/[^0-9]/g, '')">


                    </div>
            
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                        <select name="country" id="country" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                            <option value="" disabled selected>Select your country</option>
                            <option value="Argentina" {{ old('country') == 'Argentina' ? 'selected' : '' }}>Argentina</option>
                            <option value="Australia" {{ old('country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                            <option value="Austria" {{ old('country') == 'Austria' ? 'selected' : '' }}>Austria</option>
                            <option value="Brazil" {{ old('country') == 'Brazil' ? 'selected' : '' }}>Brazil</option>
                            <option value="Canada" {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                            <option value="Denmark" {{ old('country') == 'Denmark' ? 'selected' : '' }}>Denmark</option>
                            <option value="Finland" {{ old('country') == 'Finland' ? 'selected' : '' }}>Finland</option>
                            <option value="France" {{ old('country') == 'France' ? 'selected' : '' }}>France</option>
                            <option value="Germany" {{ old('country') == 'Germany' ? 'selected' : '' }}>Germany</option>
                            <option value="Iceland" {{ old('country') == 'Iceland' ? 'selected' : '' }}>Iceland</option>
                            <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
                            <option value="Indonesia" {{ old('country') == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                            <option value="Italy" {{ old('country') == 'Italy' ? 'selected' : '' }}>Italy</option>
                            <option value="Malaysia" {{ old('country') == 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
                            <option value="Mexico" {{ old('country') == 'Mexico' ? 'selected' : '' }}>Mexico</option>
                            <option value="Nepal" {{ old('country') == 'Nepal' ? 'selected' : '' }}>Nepal</option>
                            <option value="Qatar" {{ old('country') == 'Qatar' ? 'selected' : '' }}>Qatar</option>
                            <option value="Russia" {{ old('country') == 'Russia' ? 'selected' : '' }}>Russia</option>
                            <option value="Saudi Arabia" {{ old('country') == 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
                            <option value="Singapore" {{ old('country') == 'Singapore' ? 'selected' : '' }}>Singapore</option>
                            <option value="South Africa" {{ old('country') == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                            <option value="Spain" {{ old('country') == 'Spain' ? 'selected' : '' }}>Spain</option>
                            <option value="Sri Lanka" {{ old('country') == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                            <option value="Sweden" {{ old('country') == 'Sweden' ? 'selected' : '' }}>Sweden</option>
                            <option value="Switzerland" {{ old('country') == 'Switzerland' ? 'selected' : '' }}>Switzerland</option>
                            <option value="Thailand" {{ old('country') == 'Thailand' ? 'selected' : '' }}>Thailand</option>
                            <option value="Turkey" {{ old('country') == 'Turkey' ? 'selected' : '' }}>Turkey</option>
                            <option value="Uganda" {{ old('country') == 'Uganda' ? 'selected' : '' }}>Uganda</option>
                            <option value="Ukraine" {{ old('country') == 'Ukraine' ? 'selected' : '' }}>Ukraine</option>
                            <option value="United Kingdom" {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                            <option value="United States" {{ old('country') == 'United States' ? 'selected' : '' }}>United States</option>
                            <option value="Other" {{ old('country') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        <input type="text" name="other_country" id="other_country"
                        placeholder="Please specify your country" value="{{ old('other_country') }}"
                        class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 {{ old('country') == 'Other' ? '' : 'hidden' }}">
                    </div>
                </div>
              
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" required value="{{ old('email') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                        <input type="text" name="company_name" id="company_name" required value="{{ old('company_name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                    </div>
                </div>
            
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                </div>
            
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                </div>
            
                <button type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                    Register
                </button>
            </form>
            
            <p class="text-center text-sm text-gray-600 mt-6">
                Already have an account? <a href="{{ route('login') }}" class="text-purple-600 hover:underline font-medium">Sign in</a>
            </p>
        </div>

        {{-- RIGHT SIDE: Plan Summary --}}
        <div class="hidden md:block w-1/3 bg-gray-50 border-l border-gray-100 p-6 lg:p-10 flex flex-col justify-between">
            <div>
                <div class="text-lg font-bold text-gray-700 mb-3">Your Selected Plan</div>
                <div class="text-3xl font-extrabold text-pink-600 mb-6">Advanced</div>

           {{-- <ul class="text-base text-gray-700 space-y-3 mb-8">
                    <li><span class="text-green-500 mr-2">&#10003;</span> 1 Daily Output</li>
                    <li><span class="text-green-500 mr-2">&#10003;</span> Next Day Delivery</li>
                    <li><span class="text-green-500 mr-2">&#10003;</span> Dedicated Support</li>
                    <li><span class="text-green-500 mr-2">&#10003;</span> Unlimited Revisions</li>
                </ul> --}}

              <div class="space-y-4 text-base mb-8">
                    @php
                        $colors = ['Basic' => 'text-purple-600', 'Standard' => 'text-yellow-500', 'Premium' => 'text-pink-600'];
                    @endphp

                    @if($plans->count())
                        @foreach ($plans as $plan)
                            @php $color = $colors[$plan->name] ?? 'text-gray-600'; @endphp
                            <label class="flex items-center cursor-pointer">

                                <input
                                type="radio"
                                name="plan_id"
                                value="{{ $plan->id }}"
                                data-price="{{ $plan->price }}"
                                class="form-radio {{ $color }} h-4 w-4 plan-radio"
                                {{ $loop->first ? 'checked' : '' }}>

                                <span class="ml-2 text-gray-800">
                                    {{ $plan->name }} - 
                                    <span class="font-bold">${{ number_format($plan->price, 2) }}</span>
                                    <span class="text-sm text-gray-500 ml-2">({{ $plan->credits }} credits, valid {{ $plan->validity_days }} days)</span>
                                </span>
                            </label>
                        @endforeach
                    @else
                        <p class="text-red-600">No plans available.</p>
                    @endif
                </div>


            </div>

            <div class="border-t border-gray-200 pt-6">
                <div class="flex justify-between items-center text-xl font-bold text-gray-800">
                    <span>Billed today:</span>
                    <span id="billed-amount" class="text-blue-600">$0</span>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const countrySelect = document.getElementById('country');
            const otherCountryInput = document.getElementById('other_country');

            // Function to toggle 'Other' country input visibility
            function toggleOtherCountryInput() {
                if (countrySelect.value === 'Other') {
                    otherCountryInput.classList.remove('hidden');
                    otherCountryInput.setAttribute('required', 'required');
                } else {
                    otherCountryInput.classList.add('hidden');
                    otherCountryInput.removeAttribute('required');
                }
            }

            // Initial check on page load (useful if old('country') is 'Other')
            toggleOtherCountryInput();

            // Event listener for country select change
            countrySelect.addEventListener('change', toggleOtherCountryInput);
        });





         document.addEventListener('DOMContentLoaded', function () {
        const radios = document.querySelectorAll('.plan-radio');
        const billedAmount = document.getElementById('billed-amount');
        const hiddenPlanInput = document.getElementById('selected_plan_id');

        function updateAmountAndHiddenInput() {
            const selected = document.querySelector('.plan-radio:checked');
            if (selected) {
                const price = parseFloat(selected.dataset.price).toFixed(2);
                billedAmount.textContent = `$${price}`;
                hiddenPlanInput.value = selected.value;
            }
        }

        // Initial load
        updateAmountAndHiddenInput();

        // On change
        radios.forEach(radio => {
            radio.addEventListener('change', updateAmountAndHiddenInput);
        });
    });
    </script>
</body>
</html>