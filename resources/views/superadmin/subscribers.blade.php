<x-layout>
  <div class="w-full mx-auto py-10 px-6 mt-5">
      <h2 class="text-2xl font-semibold text-gray-700 mb-6 mt-5">📋 Subscriber List</h2>

      <!-- Filter Form -->
      <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
          <input type="text" name="search" value="{{ request('search') }}"
              placeholder="Search by name or email"
              class="border border-gray-300 px-4 py-2 rounded-lg w-full">

          <select name="plan" class="border border-gray-300 px-4 py-2 rounded-lg w-full">
              <option value="">All Plans</option>
              <option value="basic" {{ request('plan') == 'basic' ? 'selected' : '' }}>Basic</option>
              <option value="premium" {{ request('plan') == 'premium' ? 'selected' : '' }}>Premium</option>
          </select>

          <select name="status" class="border border-gray-300 px-4 py-2 rounded-lg w-full">
              <option value="">All Status</option>
              <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
              <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>

          <button type="submit"
              class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
              🔍 Filter
          </button>
      </form>

      <!-- Table -->
      <div class="bg-white shadow-md rounded-lg overflow-hidden">
          <table class="min-w-full table-auto">
              <thead class="bg-gray-100 text-gray-700">
                  <tr>
                      <th class="px-4 py-3 text-left">Name</th>
                      <th class="px-4 py-3 text-left">Email</th>
                      <th class="px-4 py-3 text-left">Plan</th>
                      <th class="px-4 py-3 text-left">Status</th>
                      <th class="px-4 py-3 text-left">Joined</th>
                  </tr>
              </thead>
              <tbody class="text-gray-700 divide-y">
                  @forelse($subscribers as $subscriber)
                      <tr>
                          <td class="px-4 py-2">{{ $subscriber->name }}</td>
                          <td class="px-4 py-2">{{ $subscriber->email }}</td>
                          <td class="px-4 py-2 capitalize">{{ $subscriber->plan }}</td>
                          <td class="px-4 py-2">
                              @if($subscriber->status == 'active')
                                  <span class="text-green-600 font-medium">Active</span>
                              @else
                                  <span class="text-red-500 font-medium">Inactive</span>
                              @endif
                          </td>
                          <td class="px-4 py-2">{{ $subscriber->created_at->format('d M, Y') }}</td>
                      </tr>
                  @empty
                      <tr>
                          <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                              No subscribers found.
                          </td>
                      </tr>
                  @endforelse
              </tbody>
          </table>

          <!-- Pagination -->
          <div class="p-4">
 
          </div>
      </div>
  </div>
</x-layout>
