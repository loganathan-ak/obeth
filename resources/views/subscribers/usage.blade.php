


<x-layout>
  <div class="container-fluid mt-5 pt-4 mb-5 pb-5">
    <div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Usage</h3>
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
            <a href="/usage">Usage</a>
          </li>
        </ul>
      </div>
  
  
  <div class="usage-card terms">
    <div class="date-filter">
      <form method="GET" action="{{ route('usage') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end mb-6">
        <!-- From Date -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="p-3 bg-white w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
    
        <!-- To Date -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="p-3 bg-white w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
    
        <!-- Filter Button -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Filter</label>
            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                Filter
            </button>
        </div>
    
        <!-- Reset Button -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Reset</label>
            <a href="{{ route('usage') }}" class="w-full inline-block text-center bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400 transition">
                Reset
            </a>
        </div>
    </form>
    
    
    </div>
  
    <div class="stats-buttons">
      <button class="stat-btn">Total Credits ({{ $usages->sum('credits_used') ?? 'N/A' }})</button>
      <button class="stat-btn">Total Orders ({{$usages->count()}})</button>
    </div>
  
    <div class="order-summary">
      <h3>Order Summary:</h3>
  
      @foreach($usages as $usage)
      @php
          $order = $orders->where('id', $usage->order_id)->first();
          $status = strtolower($order->status ?? '');
          $statusClass = match($status) {
              'completed' => 'bg-green-100 text-green-700',
              'in progress' => 'bg-yellow-100 text-yellow-800',
              'quality checking' => 'bg-blue-100 text-blue-800',
              'rejected' => 'bg-red-100 text-red-700',
              default => 'bg-gray-100 text-gray-800',
          };
      @endphp
  
  @if($order)
  <div class="order-card border rounded-xl p-4 shadow-sm bg-white mb-4">
      <p>
          <strong class="pe-3">Job ID #{{ $usage->job_id ?? $order->id }}:</strong>
          {{ $order->project_title }} –
          <span class="px-2 py-1 rounded text-sm font-medium {{ $statusClass }}">
              {{ ucfirst($order->status) }}
          </span>
      </p>

      <p class="mt-1">Credit Used: {{ $usage->credits_used }}</p>

      <p class="text-sm text-gray-600 mt-1">
          Created on: {{ $usage->created_at->format('d M Y, h:i A') }}
      </p>

      <a href="{{ route('view.order', $order->id) }}" class="inline-block mt-2 px-3 py-2 bg-indigo-600 text-white text-sm font-semibold rounded hover:bg-indigo-700">
          Project Overview
      </a>
  </div>
@endif

  @endforeach
  
    </div>
  </div>
  
  
  
  
  
  
    </div>
  </div>
  
  
  </x-layout>