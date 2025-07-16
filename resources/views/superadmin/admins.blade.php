<x-layout>
    <div class="max-w-9/10 px-4 sm:px-6 md:px-8 py-10 mt-5 space-y-8">

        <!-- Header -->
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">👥 All Admin Users</h1>
            <a href="{{route('superadmin.addadmins')}}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                ➕ Add Admin
            </a>
        </div>

        <!-- Admin Table -->
        <div class="bg-white shadow-md rounded-lg overflow-x-auto border border-gray-200">

            @if(session('success'))
            <div class="max-w-3xl mx-auto px-6">
                <div class="relative flex items-center justify-between px-4 py-3 text-sm text-green-800 bg-green-100 border border-green-200 rounded-lg mb-6 shadow">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove();"
                            class="text-green-600 hover:text-green-800 ml-4 text-lg font-bold leading-none focus:outline-none">
                        &times;
                    </button>
                </div>
            </div>
        @endif
        
        
          

            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                    <tr>
                        <th class="px-6 py-3">S.no</th>
                        <th class="px-6 py-3">First Name</th>
                        <th class="px-6 py-3">Last Name</th>
                        <th class="px-6 py-3">Mobile</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Role</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admins as $index => $admin)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $admin->first_name }}</td>
                            <td class="px-6 py-4">{{ $admin->last_name }}</td>
                            <td class="px-6 py-4">{{ $admin->mobile_number }}</td>
                            <td class="px-6 py-4">{{ $admin->email }}</td>
                            <td class="px-6 py-4 capitalize">{{ $admin->role }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{route('superadmin.editadmin', $admin->id)}}" class="inline-block px-3 py-2 text-xs text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                    ✏️ Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No admins found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
