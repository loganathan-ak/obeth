


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


    <form method="GET" action="{{ route('requests') }}" class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
      <!-- Status Filter -->
      <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
          <select name="status_filter" id="status_filter"
                  class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 bg-white">
              <option value="">All Statuses</option>
              <option value="Pending" {{ request('status_filter') == 'Pending' ? 'selected' : '' }}>Pending</option>
              <option value="In Progress" {{ request('status_filter') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
              <option value="Completed" {{ request('status_filter') == 'Completed' ? 'selected' : '' }}>Completed</option>
              <option value="Queued" {{ request('status_filter') == 'Queued' ? 'selected' : '' }}>Queued</option>
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
  
          <a href="{{ route('requests') }}"
             class="w-full inline-block text-center bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400 transition">
              Reset
          </a>
      </div>
    </form>




    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-end align-items-center">
            {{-- <div class="search-sort-filter" style="display: flex; gap: 10px; align-items: center;">
              <input type="text" class="form-control" id="job_search" placeholder="Search...">
          
              <select id="status_filter" class="form-control px-3 py-2 border rounded-md">
                  <option value="">All Statuses</option>
                  <option value="Pending">Pending</option>
                  <option value="In Progress">In Progress</option>
                  <option value="Completed">Completed</option>
                  <option value="Rejected">Rejected</option>
              </select>
          
              <a href="{{ route('requests') }}" class="px-4 py-[9px] rounded-md bg-blue-500 text-white hidden" id="filter_reset">Reset</a>
            </div> --}}

            <div class="d-flex flex-wrap gap-3">
              <div class="info-box">
                <h6>Credits</h6>
                <div class="box-content">
                  <div class="">
                    <strong>{{$currentUserCredits}}</strong><br><small>Total</small>
                  </div>
                </div>
              </div>


              <div class="info-box text-center">
                <h6>Completed Requests</h6>
                <div class="single-value">
                  ({{ $completedOrders ?? 0 }})
                </div>
              </div>


              <div class="info-box text-center">
                <h6>Slots</h6>
                <div class="single-value">
                  ({{ $slots ?? 0 }} / 5 )
                </div>
              </div>


              <div class="info-box text-center">
                <h6>Queued</h6>
                <div class="single-value">
                  ({{ $queued ?? 0 }} / 5 )
                </div>
              </div>

            </div>
          </div>

          <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
       
              <a 
                  class="btn btn-success" 
                  href="{{ Auth::user()->credits == 0 ? '#' : route('create.order') }}" 
                  onclick="{{ Auth::user()->credits == 0 ? 'alertNoCredits(); return false;' : '' }}"
              >
                  Create New Job
              </a>
              </div>
            
            @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif




            <div class="overflow-x-auto mt-6">
              <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg">
                  <thead class="bg-gray-100 text-xs font-semibold text-gray-700 uppercase">
                    <tr>
                      <th class="px-4 py-3 text-left">S.No</th>
                      <th class="px-4 py-3 text-left">Date</th>
                      <th class="px-4 py-3 text-left">Created By</th>
                      <th class="px-4 py-3 text-left">Customer ID</th>
                      <th class="px-4 py-3 text-left">Order ID</th>
                      <th class="px-4 py-3 text-left">Project Title</th>
                      <th class="px-4 py-3 text-left">Request Type</th>
                      <th class="px-4 py-3 text-left">Software</th>
                      <th class="px-4 py-3 text-left">Assigned To</th>
                      <th class="px-4 py-3 text-left">Rush</th>
                      <th class="px-4 py-3 text-left">Status</th>
                      <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 text-sm text-gray-800" id="orders_table_body">
                      @foreach($orders as $order)
                          <tr class="
                                      @if($order->status === 'Pending') bg-yellow-100 
                                      @elseif($order->status === 'In Progress') bg-blue-100 
                                      @elseif($order->status === 'Completed') bg-green-100 
                                      @elseif($order->status === 'cancelled') bg-red-100 
                                      @else bg-gray-100 
                                      @endif
                                  ">
                              <td class="px-4 py-2">{{ $loop->iteration }}</td>
                              <td class="px-4 py-2">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                              <td class="px-4 py-2">{{ $users->where('id', $order->created_by)->first()->first_name ?? '-' }}</td>
                              <td class="px-4 py-2">{{ $users->where('id', $order->created_by)->first()->obeth_id ?? '-'}}</td>
                              <td class="px-4 py-2">{{ $order->order_id }}</td>
                              <td class="px-4 py-2">{{ $order->project_title }}</td>
                              <td class="px-4 py-2">{{ $order->request_type }}</td>
                              <td class="px-4 py-2">{{ $order->software ?? '-' }}</td>
                              <td class="px-4 py-2">{{ $users->where('id', $order->assigned_to)->first()->first_name ?? '-'}}</td>
                              <td class="px-4 py-2">
                                  @if($order->rush)
                                      <span class="text-red-600 font-semibold">Yes</span>
                                  @else
                                      <span class="text-gray-500">No</span>
                                  @endif
                              </td>
                              <td class="px-4 py-2"><span class="text-blue-600 capitalize">{{ $order->status ?? 'pending' }}</span></td>
                              <td class="px-4 py-2"><a href="{{ route('view.order', $order->id) }}" class="text-indigo-600 hover:underline">View</a></td>
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
<script>
  function alertNoCredits() {
    alert('You have no credits left. Please purchase more to create a new request.');
}
  </script>

</x-layout>