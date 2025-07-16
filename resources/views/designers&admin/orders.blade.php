<x-layout>
    <div class="container-fluid mt-5 pt-4 mb-5 pb-5">
      <div class="page-inner">
        <div class="page-header">
          <h3 class="fw-bold mb-3">Requests</h3>
          <ul class="breadcrumbs mb-3">
            <li class="nav-home">
              <a href="/">
                <i class="fas fa-house"></i>
              </a>
            </li>
            <li class="separator">
              <i class="fa-solid fa-arrow-right"></i>
            </li>
            <li class="nav-item">
              <a href="/">Home</a>
            </li>
            <li class="separator">
              <i class="fa-solid fa-arrow-right"></i>
            </li>
            <li class="nav-item">
              <a href="/requests">Requests</a>
            </li>
          </ul>
        </div>


        <form method="GET" action="{{ route('admin.orders') }}" class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
          <!-- Status Filter -->
          <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
              <select name="status_filter" id="status_filter"
                      class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 bg-white">
                  <option value="">All Statuses</option>
                  <option value="Pending" {{ request('status_filter') == 'Pending' ? 'selected' : '' }}>Pending</option>
                  <option value="In Progress" {{ request('status_filter') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                  <option value="Completed" {{ request('status_filter') == 'Completed' ? 'selected' : '' }}>Completed</option>
                  <option value="Cancelled" {{ request('status_filter') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
              </select>
          </div>
      
          <!-- From Date -->
          <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
              <input type="date" name="from_date" value="{{ request('from_date') }}"
                     class="p-3 bg-white w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
          </div>
      
          <!-- To Date -->
          <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
              <input type="date" name="to_date" value="{{ request('to_date') }}"
                     class="p-3 bg-white w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
          </div>
      
          <!-- Filter Button -->
          <div class="flex flex-col gap-2">
              <label class="block text-sm font-medium text-gray-700 mb-1">Actions</label>
              <button type="submit"
                      class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                  Filter
              </button>
      
              <a href="{{ route('admin.orders') }}"
                 class="w-full inline-block text-center bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400 transition">
                  Reset
              </a>
          </div>
        </form>


    
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                {{-- <div class="search-sort-filter" style="display: flex; gap: 10px; align-items: center;">
                  <input type="text" class="form-control" id="admin_job_search" placeholder="Search...">
              
                  <select id="admin_status_filter" class="form-control px-3 py-2 border rounded-md">
                      <option value="">All Statuses</option>
                      <option value="Pending">Pending</option>
                      <option value="In Progress">In Progress</option>
                      <option value="Completed">Completed</option>
                      <option value="Rejected">Rejected</option>
                  </select>
              
                  <a href="{{ route('admin.orders') }}" class="px-4 py-[9px] rounded-md bg-blue-500 text-white hidden" id="filter_reset">Reset</a>
                </div> --}}
    

              </div>
    
              <div class="card-body">
                
                @if(session('success'))
                  <div class="alert alert-success">{{ session('success') }}</div>
              @endif
    
    
    
                <div class="overflow-x-auto mt-6">
                  <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg">
                      <thead class="bg-gray-100 text-xs font-semibold text-gray-700 uppercase">
                          <tr>
                              <th class="px-4 py-3 text-left">Job Id</th>
                              <th class="px-4 py-3 text-left">Project Title</th>
                              <th class="px-4 py-3 text-left">Request Type</th>
                              <th class="px-4 py-3 text-left">Software</th>
                              <th class="px-4 py-3 text-left">Created By</th>
                              <th class="px-4 py-3 text-left">Assigned To</th>
                              <th class="px-4 py-3 text-left">Rush</th>
                              <th class="px-4 py-3 text-left">Status</th>
                              <th class="px-4 py-3 text-left">Actions</th>
                              <th class="px-4 py-3 text-left"></th>
                          </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 text-sm text-gray-800" id="orders_table_body">
                          @foreach($orders as $order)
                              @php
                                    // Choose background color based on status
                                    $statusColor = match($order->status) {
                                        'Pending'     => 'bg-yellow-100',
                                        'In Progress' => 'bg-blue-100',
                                        'Completed'   => 'bg-green-100',
                                        'Cancelled'   => 'bg-red-100',
                                        default       => 'bg-gray-100',
                                    };

                                    // If unseen, override or append a light yellow shade
                                    $seenHighlight = $order->seen ? '' : 'bg-yellow-50';
                                @endphp

                                <tr class="{{ $seenHighlight ?: $statusColor }}">
                                  <td class="px-4 py-2">{{ $order->order_id }}</td>
                                  <td class="px-4 py-2">{{ $order->project_title }}</td>
                                  <td class="px-4 py-2">{{ $order->request_type }}</td>
                                  <td class="px-4 py-2">{{ $order->software ?? '-' }}</td>
                                  <td class="px-4 py-2">{{ \App\Models\User::find($order->created_by)->first_name ?? '-' }}</td>
                                  <td class="px-4 py-2">{{ \App\Models\User::find($order->assigned_to)->first_name ?? 'N/A' }}</td>
                                  <td class="px-4 py-2">
                                      @if($order->rush)
                                          <span class="text-red-600 font-semibold">Yes</span>
                                      @else
                                          <span class="text-gray-500">No</span>
                                      @endif
                                  </td>
                                  <td class="px-4 py-2">
                                      <span class="text-blue-600 capitalize">{{ $order->status ?? 'pending' }}</span>
                                  </td>
                                  <td class="px-4 py-2 flex gap-3">
                                      <a href="{{ route('admin.vieworders', $order->id) }}" class="text-indigo-600 hover:underline">View</a>
                                      <a href="{{ route('admin.editorders', $order->id) }}" class="text-indigo-600 hover:underline">Edit</a>
                                  </td>
                                  <td class="px-4 py-2">
                                      @if($order->seen)
                                          <span class="text-green-600 text-xs font-medium">Seen</span>
                                      @else
                                          <span class="text-yellow-600 text-xs font-medium">Unseen</span>
                                      @endif
                                  </td>

                              </tr>
                          @endforeach
                      </tbody>

                  </table>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    
    </x-layout>