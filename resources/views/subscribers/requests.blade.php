


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

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <div class="search-sort-filter" style="display: flex;">
              <input type="text" class="form-control" placeholder="Search...">
              {{-- <div class="btn-group ms-2">
                <button class="btn btn-outline-secondary">Sort</button>
                <button class="btn btn-outline-secondary">Filter</button>
              </div> --}}
            </div>

            <div class="d-flex flex-wrap gap-3">
              <div class="info-box">
                <h6>Credits</h6>
                <div class="box-content">
                  <div class="half">
                    <strong>10</strong><br><small>Used</small>
                  </div>
                  <div class="half">
                    <strong>50</strong><br><small>Total</small>
                  </div>
                </div>
              </div>

              <div class="info-box">
                <h6>Slots</h6>
                <div class="box-content">
                  <div class="half">
                    <strong>2</strong><br><small>Used</small>
                  </div>
                  <div class="half">
                    <strong>5</strong><br><small>Total</small>
                  </div>
                </div>
              </div>

              <div class="info-box text-center">
                <h6>Queued Requests</h6>
                <div class="single-value">
                  (2)
                </div>
              </div>

              <div class="info-box text-center">
                <h6>Completed Requests</h6>
                <div class="single-value">
                  (3)
                </div>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
              <div class="status-filter">
                <button class="btn btn-sm btn-primary">Drafts</button>
                <button class="btn btn-sm btn-primary">Queued</button>
                <button class="btn btn-sm btn-primary">Active</button>
                <button class="btn btn-sm btn-primary">Completed</button>
                <button class="btn btn-sm btn-primary">All</button>
              </div>
       
              <a class="btn btn-success" href="{{route('create.order')}}">New Request</a>
              </div>
            
            @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
          @endif




            <div class="overflow-x-auto mt-6">
              <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg">
                  <thead class="bg-gray-100 text-xs font-semibold text-gray-700 uppercase">
                      <tr>
                          <th class="px-4 py-3 text-left">Project Title</th>
                          <th class="px-4 py-3 text-left">Request Type</th>
                          <th class="px-4 py-3 text-left">Size</th>
                          <th class="px-4 py-3 text-left">Software</th>
                          <th class="px-4 py-3 text-left">Brand</th>
                          <th class="px-4 py-3 text-left">Rush</th>
                          <th class="px-4 py-3 text-left">Status</th>
                          <th class="px-4 py-3 text-left">Actions</th>
                      </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 text-sm text-gray-800">
                      @foreach($orders as $order)
                          <tr>
                              <td class="px-4 py-2">{{ $order->project_title }}</td>
                              <td class="px-4 py-2">{{ $order->request_type }}</td>
                              <td class="px-4 py-2">{{ $order->size ?? '-' }}</td>
                              <td class="px-4 py-2">{{ $order->software ?? '-' }}</td>
                              <td class="px-4 py-2">
                                  {{ $order->brandProfile->brand_name ?? 'N/A' }}
                              </td>
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
                              <td class="px-4 py-2">
                                  <a href="{{ route('view.order', $order->id) }}" class="text-indigo-600 hover:underline">View</a>
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