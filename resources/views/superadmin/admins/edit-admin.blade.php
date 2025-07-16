
<x-layout>
    <div class="max-w-3xl mx-auto mt-5 px-6 py-12">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-800">✏️ Edit Admin</h2>
            <a href="{{ route('superadmin.admins') }}"
               class="text-sm font-medium text-gray-700 hover:text-blue-600 transition flex items-center">
                ← Back to List
            </a>
        </div>

        <!-- Card -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-xl p-8 space-y-6">
         <div class="flex justify-end">
            <form action="{{ route('delete.admin', $admin->id) }}" method="POST" class="inline-block "
                onsubmit="return confirm('Are you sure you want to delete this admin?')" >
              @csrf
              @method('DELETE')
              <button type="submit"
                      class="px-3 py-2 text-xs text-white bg-red-600 rounded hover:bg-red-700">
                  🗑️ Delete
              </button>
          </form>
         </div>

         <form action="{{ route('superadmin.editadmin', $admin->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
        
            <!-- First Name -->
            <div>
                <label for="first_name" class="block text-sm font-semibold text-gray-600 mb-1">First Name</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $admin->first_name ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                       required>
                @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        
            <!-- Last Name -->
            <div>
                <label for="last_name" class="block text-sm font-semibold text-gray-600 mb-1">Last Name</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $admin->last_name ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                       required>
                @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        
            <!-- Mobile Number -->
            <div>
                <label for="mobile" class="block text-sm font-semibold text-gray-600 mb-1">Mobile Number</label>
                <input type="text" name="mobile" id="mobile" value="{{ old('mobile', $admin->mobile_number ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                       required>
                @error('mobile') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
    
        
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-600 mb-1">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                       required>
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        
            <!-- New Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-600 mb-1">New Password <span class="text-gray-400">(leave blank to keep current)</span></label>
                <input type="password" name="password" id="password"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                       placeholder="••••••••">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        
            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-semibold text-gray-600 mb-1">Role</label>
                <select name="role" id="role"
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        required>
                    <option value="admin" {{ old('role', $admin->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ old('role', $admin->role) == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                </select>
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        
            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit"
                        class="w-full inline-flex justify-center items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition duration-300 shadow-lg">
                    💾 Update Admin
                </button>
            </div>
        </form>
        
        </div>
    </div>
</x-layout>
