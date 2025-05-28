<x-layout>
    <div class="mt-5 mb-5 p-5">
        <h2 class="fw-bold mb-4">Edit Design Request Form</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <h5 class="font-bold mb-2">Please fix the following errors:</h5>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.updateorders', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Project Title -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Project Title *</label>
                <input type="text" class="form-control" value="{{ old('title', $order->project_title) }}" readonly>
            </div>

            <!-- Type of Request -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Type of Request *</label>
                <select class="form-select" disabled>
                    @foreach(['Banner Creation', 'Image Editing', 'Background Removal', 'Flyer Design', 'Logo Design', 'Social Media Post', 'Infographics', 'Mockups', 'Brochure', 'Packaging Design', 'Business Card', 'Other'] as $type)
                        <option value="{{ $type }}" {{ $order->request_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                <input type="text" class="form-control collapse" value="{{ $order->other_request_type }}" readonly />
            </div>

            <!-- Instructions -->
            <div class="mb-3">
                <label class="form-label"><strong>Instructions:</strong></label>
                <textarea class="form-control" rows="6" readonly>{{ old('instructions', $order->instructions) }}</textarea>
            </div>

            <!-- Colors and Size -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Preferred Colors</label>
                    <input type="text" class="form-control" value="{{ old('colors', $order->colors) }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Size</label>
                    <select class="form-select" disabled>
                        <option value="1080x1080" {{ $order->size == '1080x1080' ? 'selected' : '' }}>1080x1080</option>
                        <option value="1920x1080" {{ $order->size == '1920x1080' ? 'selected' : '' }}>1920x1080</option>
                        <option value="A4" {{ $order->size == 'A4' ? 'selected' : '' }}>A4</option>
                        <option value="Other" {{ $order->size == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <input type="text" class="form-control collapse" value="{{ $order->other_size }}" readonly />
                </div>
            </div>

            <!-- Software -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Software to Use</label>
                <select class="form-select" disabled>
                    <option value="Adobe Photoshop" {{ $order->software == 'Adobe Photoshop' ? 'selected' : '' }}>Adobe Photoshop</option>
                    <option value="Adobe Illustrator" {{ $order->software == 'Adobe Illustrator' ? 'selected' : '' }}>Adobe Illustrator</option>
                    <option value="Canva" {{ $order->software == 'Canva' ? 'selected' : '' }}>Canva</option>
                    <option value="Figma" {{ $order->software == 'Figma' ? 'selected' : '' }}>Figma</option>
                    <option value="Other" {{ $order->software == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                <input type="text" class="form-control collapse" value="{{ $order->other_software }}" readonly />
            </div>

            <!-- Brand Profile -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Select Brand Profile *</label>
                <select class="form-select" disabled>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $order->brands_profile_id == $brand->id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Output Format -->
            @php $selectedFormats = json_decode($order->formats, true) ?? []; @endphp
            <div class="mb-3">
                <label class="form-label fw-semibold">Output Format</label><br>
                @foreach(['PDF', 'AI', 'EPS', 'PNG', 'JPG', 'PSD'] as $format)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="{{ $format }}" {{ in_array($format, $selectedFormats) ? 'checked' : '' }} disabled>
                        <label class="form-check-label">{{ $format }}</label>
                    </div>
                @endforeach
            </div>

            <!-- Pre-approve -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Pre-approve Up To (₹)</label>
                <input type="number" class="form-control" value="{{ $order->pre_approve }}" readonly>
            </div>

            <!-- Reference Files -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Uploaded Reference Files</label>
                @if($order->reference_files)
                    <ul class="list-unstyled mt-2">
                        @foreach(json_decode($order->reference_files) as $file)
                            <li><a href="{{ asset('storage/' . $file->path) }}" target="_blank" class="text-primary">{{ $file->original_name }}</a></li>
                        @endforeach
                    </ul>
                @else
                    <p>No files uploaded.</p>
                @endif
            </div>

            <!-- Rush Request -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" {{ $order->rush ? 'checked' : '' }} disabled>
                <label class="form-check-label fw-semibold">Mark as Rush Request</label>
            </div>

            <!-- Requested By -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Requested By</label>
                <input type="text" class="form-control" value="{{ $subscribers->where('id', $order->created_by)->first()->name ?? 'N/A' }}" disabled>
            </div>

            <!-- Assign To -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Assigned To</label>
                <select class="form-select" disabled>
                    @foreach($admins as $admin)
                        <option value="{{ $admin->id }}" {{ $order->assigned_to == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- ✅ Editable Status Field -->
            <div class="mb-3">
                <label for="status" class="form-label fw-semibold">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="">Select Status</option>
                    @foreach(['Pending', 'In Progress', 'Completed', 'Rejected'] as $status)
                        <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Submit -->
            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4 py-2">Update Status</button>
            </div>
        </form>
    </div>
</x-layout>
