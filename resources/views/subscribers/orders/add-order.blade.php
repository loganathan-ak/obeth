<x-layout>
<div class="mt-5 mb-5 p-5" >
    <h2 class="fw-bold mb-4">Design Request Form</h2>

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


    <form action="" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label fw-semibold">Project Title *</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <!-- Request Type -->
        <div class="mb-3">
            <label for="request_type" class="form-label fw-semibold">Type of Request *</label>
            <select class="form-select" id="request_type" name="request_type" required>
                <option value="">Select Type</option>
                @foreach(['Banner Creation', 'Image Editing', 'Background Removal', 'Flyer Design', 'Logo Design', 'Social Media Post', 'Infographics', 'Mockups', 'Brochure', 'Packaging Design', 'Business Card', 'Other'] as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
            <input type="text" name="other_request_type" id="other_request_type" class="form-control collapse  input-toggle"  placeholder="Enter your request"/>
        </div>

        <!-- Instructions (Rich Text) -->
         <div class="mb-3">
            <label for="instructions" class="form-label"><strong>Instructions:</strong></label>
            <textarea name="instructions" id="instructions" class="form-control" rows="6"></textarea>
        </div>

        <!-- Color & Size -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="colors" class="form-label fw-semibold">Preferred Colors</label>
                <input type="text" class="form-control" name="colors" id="colors" placeholder="e.g., #ffffff, #000000">
            </div>
            <div class="col-md-6">
                <label for="size" class="form-label fw-semibold">Size</label>
                <select class="form-select" id="size" name="size">
                    <option value="">Select Size</option>
                    <option value="1080x1080">1080x1080 (Instagram)</option>
                    <option value="1920x1080">1920x1080 (HD)</option>
                    <option value="A4">A4</option>
                    <option value="Other">Other</option>
                </select>
                <input type="text" name="other_size" id="other_size" class="form-control collapse  input-toggle"  placeholder="Enter size"/>
            </div>
        </div>

        <!-- Software to Use -->
        <div class="mb-3">
            <label for="software" class="form-label fw-semibold">Software to Use</label>
            <select class="form-select" id="software" name="software">
                <option value="">Select Software</option>
                <option>Adobe Photoshop</option>
                <option>Adobe Illustrator</option>
                <option>Canva</option>
                <option>Figma</option>
                <option>Other</option>
            </select>
            <input type="text" name="other_software" id="other_software" class="form-control collapse  input-toggle"   placeholder="Enter software"/>
        </div>

        <!-- Brand Profile -->
        <div class="mb-3">
            <label for="brand_profile_id" class="form-label fw-semibold">Select Brand Profile *</label>
            <select class="form-select" id="brand_profile_id" name="brand_profile_id" >
                <option value="">Choose Brand</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Format & Ratio -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Output Format</label><br>
            @foreach(['PDF', 'AI', 'EPS', 'PNG', 'JPG', 'PSD'] as $format)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="formats[]" value="{{ $format }}" id="format_{{ $format }}">
                    <label class="form-check-label" for="format_{{ $format }}">{{ $format }}</label>
                </div>
            @endforeach
        </div>

        <!-- Pre-approve budget -->
        <div class="mb-3">
            <label for="pre_approve" class="form-label fw-semibold">Pre-approve Up To (₹)</label>
            <input type="number" class="form-control" name="pre_approve" id="pre_approve" min="0" step="1">
        </div>

        <!-- Reference Files Upload -->
        <div class="mb-3">
            <label for="reference_files" class="form-label fw-semibold">Upload Reference Files</label>
            <input class="form-control" type="file" name="reference_files[]" id="reference_files" multiple>
        </div>

        <!-- Rush Request -->
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="rush" name="rush">
            <label class="form-check-label fw-semibold" for="rush">
                Mark as Rush Request
            </label>
            <p></p>
        </div>

        <!-- Submit -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4 py-2">Submit Request</button>
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
            toggleInput.removeClass('collapse ');
        } else {
            toggleInput.addClass('collapse ').val(''); // also clears input when hidden
        }
    });
});



</script>
</x-layout>
