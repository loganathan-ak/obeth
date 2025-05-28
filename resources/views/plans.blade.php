<x-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">
        <h2 class="text-4xl font-bold text-center mb-10 text-gray-800">Choose Your Plan</h2>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach ($plans as $index => $plan)
                <div class="relative bg-white rounded-2xl shadow-lg p-8 border hover:scale-105 transition-transform duration-300 {{ $index === 1 ? 'border-blue-600 shadow-xl' : 'border-gray-200' }}">
                    
                    @if ($index === 1)
                        <span class="absolute top-4 right-4 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                            Most Popular
                        </span>
                    @endif

                    <h3 class="text-2xl font-semibold text-gray-800 mb-2">{{ $plan->name }}</h3>
                    <p class="text-5xl font-bold text-blue-600 mb-4">${{ number_format($plan->price, 2) }}</p>
                    <p class="text-gray-700 text-lg mb-2">{{ $plan->credits }} Credits</p>
                    <p class="text-sm text-gray-500 mb-6">{{ $plan->description }}</p>

                    <form method="POST" action="{{route('paypal.create')}}">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        <button type="submit"  class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-xl transition-colors duration-300">
                            Buy Now
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>