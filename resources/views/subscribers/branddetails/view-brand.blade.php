    <x-layout>

<div class="max-w-7xl mx-auto mt-32 px-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 bg-white rounded-2xl shadow-xl p-10 border border-gray-200">

        <!-- Left: Logo + Downloads -->
        <div class="flex flex-col items-center justify-start gap-6">
            <div class="w-44 h-44 border rounded-xl shadow-sm overflow-hidden bg-gray-50 flex items-center justify-center">
                @if($brand->logo)
                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="Logo" class="w-full h-full object-contain">
                @else
                    <span class="text-gray-400 italic text-base">No logo</span>
                @endif
            </div>

            <div class="w-full space-y-4">
                <div>
                    <p class="text-base font-semibold text-gray-600">Brand Guide</p>
                    @if($brand->brand_guide)
                        <a href="{{ asset('storage/' . $brand->brand_guide) }}" target="_blank" class="inline-block w-full text-center px-4 py-2 bg-indigo-600 text-white text-base rounded-lg hover:bg-indigo-700 transition">
                            Download Guide
                        </a>
                    @else
                        <p class="text-gray-400 italic text-base">No guide uploaded.</p>
                    @endif
                </div>

                <div>
                    <p class="text-base font-semibold text-gray-600">Additional Assets</p>
                    @if($brand->additional_assets)
                        <a href="{{ asset('storage/' . $brand->additional_assets) }}" target="_blank" class="inline-block w-full text-center px-4 py-2 bg-blue-600 text-white text-base rounded-lg hover:bg-blue-700 transition">
                            Download Assets
                        </a>
                    @else
                        <p class="text-gray-400 italic text-base">No assets uploaded.</p>
                    @endif
                </div>
            </div>

            <a href="{{ route('brandprofile') }}" class="mt-6 inline-block px-4 py-2 text-base text-gray-600 hover:text-gray-800 underline">
                ← Back to Brand List
            </a>
        </div>

        <!-- Right: Brand Info -->
        <div class="md:col-span-2">
            <h2 class="text-4xl font-bold text-gray-800 mb-6">{{ $brand->brand_name }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-base text-gray-800">

                <div>
                    <p class="text-gray-500 font-semibold">📅 Date</p>
                    <p class="mt-1">{{ \Carbon\Carbon::parse($brand->brand_date)->format('d M Y') }}</p>
                </div>

                <div>
                    <p class="text-gray-500 font-semibold">🏢 Industry</p>
                    <p class="mt-1">{{ $brand->industry ?? $brand->other_industry }}</p>
                </div>

                <div>
                    <p class="text-gray-500 font-semibold">🌐 Website</p>
                    <a href="{{ $brand->web_address }}" target="_blank" class="mt-1 text-blue-600 hover:underline">
                        {{ $brand->web_address }}
                    </a>
                </div>

                <div>
                    <p class="text-gray-500 font-semibold">🎯 Audience</p>
                    <p class="mt-1">{{ $brand->brand_audience }}</p>
                </div>

                <div class="md:col-span-2">
                    <p class="text-gray-500 font-semibold">📝 Description</p>
                    <p class="mt-1 text-justify leading-relaxed">{{ $brand->brand_description }}</p>
                </div>

                <div>
                    <p class="text-gray-500 font-semibold">🎨 Color Codes</p>
                    <p class="mt-1">{{ $brand->color_codes }}</p>
                </div>

                <div>
                    <p class="text-gray-500 font-semibold">🔤 Fonts</p>
                    <p class="mt-1">{{ $brand->fonts }}</p>
                </div>
            </div>
        </div>
    </div>
</div>





    </x-layout>
