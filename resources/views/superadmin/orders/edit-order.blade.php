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

        <form action="{{ route('update.order', $order->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label fw-semibold">Project Title *</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $order->project_title) }}" required>
            </div>

            <!-- Request Type -->
            <div class="mb-3">
                <label for="request_type" class="form-label fw-semibold">Type of Request *</label>
                <select class="form-select" id="request_type" name="request_type" required>
                    <option value="">Select Type</option>
                    @foreach(['Banner Creation', 'Image Editing', 'Background Removal', 'Flyer Design', 'Logo Design', 'Social Media Post', 'Infographics', 'Mockups', 'Brochure', 'Packaging Design', 'Business Card', 'Other'] as $type)
                        <option value="{{ $type }}" {{ $order->request_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                <input type="text" name="other_request_type" id="other_request_type" class="form-control collapse input-toggle" value="{{ old('other_request_type', $order->other_request_type) }}" placeholder="Enter your request" />
            </div>

            <!-- Instructions (Rich Text) -->
            <div class="mb-3">
                <label for="instructions" class="form-label"><strong>Instructions:</strong></label>
                <textarea name="instructions" id="instructions" class="form-control" rows="6">{{ old('instructions', $order->instructions) }}</textarea>
            </div>

            <!-- Color & Size -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="colors" class="form-label fw-semibold">Preferred Colors</label>
                    <input type="text" class="form-control" name="colors" id="colors" value="{{ old('colors', $order->colors) }}" placeholder="e.g., #ffffff, #000000">
                </div>
                <div class="col-md-6">
                    <label for="size" class="form-label fw-semibold">Size</label>
                    <select class="form-select" id="size" name="size">
                        <option value="">Select Size</option>
                        <option value="1080x1080" {{ $order->size == '1080x1080' ? 'selected' : '' }}>1080x1080 (Instagram)</option>
                        <option value="1920x1080" {{ $order->size == '1920x1080' ? 'selected' : '' }}>1920x1080 (HD)</option>
                        <option value="A4" {{ $order->size == 'A4' ? 'selected' : '' }}>A4</option>
                        <option value="Other" {{ $order->size == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <input type="text" name="other_size" id="other_size" class="form-control collapse input-toggle" value="{{ old('other_size', $order->other_size) }}" placeholder="Enter size" />
                </div>
            </div>

            <!-- Software to Use -->
            <div class="mb-3">
                <label for="software" class="form-label fw-semibold">Software to Use</label>
                <select class="form-select" id="software" name="software">
                    <option value="">Select Software</option>
                    <option value="Adobe Photoshop" {{ $order->software == 'Adobe Photoshop' ? 'selected' : '' }}>Adobe Photoshop</option>
                    <option value="Adobe Illustrator" {{ $order->software == 'Adobe Illustrator' ? 'selected' : '' }}>Adobe Illustrator</option>
                    <option value="Canva" {{ $order->software == 'Canva' ? 'selected' : '' }}>Canva</option>
                    <option value="Figma" {{ $order->software == 'Figma' ? 'selected' : '' }}>Figma</option>
                    <option value="Other" {{ $order->software == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                <input type="text" name="other_software" id="other_software" class="form-control collapse input-toggle" value="{{ old('other_software', $order->other_software) }}" placeholder="Enter software" />
            </div>

            <!-- Brand Profile -->
            <div class="mb-3">
                <label for="brand_profile_id" class="form-label fw-semibold">Select Brand Profile *</label>
                <select class="form-select" id="brand_profile_id" name="brand_profile_id">
                    <option value="">Choose Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $order->brands_profile_id == $brand->id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Format & Ratio -->
            @php
            $selectedFormats = json_decode($order->formats, true) ?? [];
            @endphp
            
            <div class="mb-3">
                <label class="form-label fw-semibold">Output Format</label><br>
                @foreach(['PDF', 'AI', 'EPS', 'PNG', 'JPG', 'PSD'] as $format)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="formats[]" value="{{ $format }}"
                            id="format_{{ $format }}" {{ in_array($format, $selectedFormats) ? 'checked' : '' }}>
                        <label class="form-check-label" for="format_{{ $format }}">{{ $format }}</label>
                    </div>
                @endforeach
            </div>
        

            <!-- Pre-approve budget -->
            <div class="mb-3">
                <label for="pre_approve" class="form-label fw-semibold">Pre-approve Up To (₹)</label>
                <input type="number" class="form-control" name="pre_approve" id="pre_approve" value="{{ old('pre_approve', $order->pre_approve) }}" min="0" step="1">
            </div>

            <!-- Reference Files Upload -->
            <div class="mb-3">
                <label for="reference_files" class="form-label fw-semibold">Upload Reference Files</label>
                <input class="form-control" type="file" name="reference_files[]" id="reference_files" multiple>
                @if($order->reference_files)
                    <ul class="list-unstyled mt-2">
                        @foreach(json_decode($order->reference_files) as $file)
                            <li><a href="{{ asset('storage/' . $file->path) }}" target="_blank" class="text-primary">{{ $file->original_name }}</a></li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Rush Request -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="rush" name="rush" {{ $order->rush ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold" for="rush">
                    Mark as Rush Request
                </label>
                <p></p>
            </div>


            <!-- Requested By -->
        <div class="mb-3">
            <label for="user_id" class="form-label fw-semibold">Requested By</label>
            <input type="text" class="form-control" value="{{$subscribers->where('id', $order->created_by)->first()->name ?? 'N/A' }}" disabled>
            <input type="hidden" name="user_id" value="{{ $order->created_by }}">
        </div>

        <!-- Assign To Admin -->
        <div class="mb-3">
            <label for="assigned_to" class="form-label fw-semibold">Assign To</label>
            <select name="assigned_to" id="assigned_to" class="form-select">
                <option value="">Select Admin</option>
                @foreach($admins as $admin)
                    <option value="{{ $admin->id }}" {{ $order->assigned_to == $admin->id ? 'selected' : '' }}>
                        {{ $admin->name }}
                    </option>
                @endforeach
            </select>
        </div>

            <!-- Submit -->
            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4 py-2">Update Request</button>
            </div>
        </form>
    </div>

    <!-- Include Rich Text Editor -->
    <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        window.onload = function() {
            CKEDITOR.replace('instructions');
        };

        $(document).ready(function(){
            $('#software, #request_type, #size').on('change', function(){
                let getDiv = $(this).closest('div');
                let value = $(this).val();
                let toggleInput = getDiv.find('.input-toggle');
                
                if(value === 'Other'){
                    toggleInput.removeClass('collapse');
                } else {
                    toggleInput.addClass('collapse').val(''); // also clears input when hidden
                }
            });
        });
    </script>
</x-layout>
