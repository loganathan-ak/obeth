<x-layout>
<div class="container-fluid mt-5 pt-4 mb-5 pb-5">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Brand Profile Form</h3>
      <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="/"><i class="fas fa-house"></i></a></li>
        <li class="separator"><i class="fa-solid fa-arrow-right"></i></li>
        <li class="nav-item"><a href="/">Home</a></li>
        <li class="separator"><i class="fa-solid fa-arrow-right"></i></li>
        <li class="nav-item"><a href="/brandform">Brand Profile Form</a></li>
      </ul>
    </div>



@if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
        <strong class="font-semibold">Whoops! Something went wrong:</strong>
        <ul class="mt-2 list-disc pl-6">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="/add-brand" method="POST" enctype="multipart/form-data">
      @csrf
  
      <div class="card form-section bottoms">
          <!-- Auto Date Display -->
          <div class="mb-4 text-end">
            <label for="brand_date" class="form-label"><strong>Date:</strong></label>
            <input type="date" name="brand_date" id="brand_date" class="form-control d-inline-block w-auto" required 
            readonly value="{{ old('brand_date', \Carbon\Carbon::now()->toDateString()) }}">
        </div>
        
  
          <!-- Brand Info -->
          <div class="row mb-3">
              <div class="col-md-4">
                  <label for="brand_name"><strong>* 1. Brand Name:</strong></label>
                  <input type="text" name="brand_name" id="brand_name" class="form-control" placeholder="Set a unique name for your Brand"
                  value="{{ old('brand_name') }}" required>
              </div>
              <div class="col-md-4">
                <label for="industry"><strong>* 2. Industry:</strong></label>
                <select name="industry" id="industry" class="form-control" required onchange="toggleOtherIndustry(this.value)">
                    <option value="">Select Industry</option>
                    @foreach(['Fashion','Technology','Food','Healthcare','Automotive','Education','Entertainment','Finance','Retail','Real Estate','Travel & Tourism','Sports','Media','Construction','E-commerce','Agriculture','Logistics','Legal','Non-Profit','Other'] as $option)
                        <option value="{{ $option }}" {{ old('industry') == $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
            
                <!-- Optional text input for "Other" -->
                <div id="otherIndustryContainer" class="mt-2" style="display: none;">
                    <input type="text" name="other_industry" id="other_industry" class="form-control" value="{{ old('other_industry') }}" placeholder="Please specify your industry">
                </div>
            </div>
            
              <div class="col-md-4">
                  <label for="web_address"><strong>* 3. Web Address:</strong></label>
                  <input type="url" name="web_address" id="web_address" class="form-control" value="{{ old('web_address') }}" placeholder="https://www.example.com" required>
              </div>
          </div>
  
          <!-- Description and Logo -->
          <div class="row mt-4 mb-3">
              <div class="col-md-4">
                  <label for="brand_audience"><strong>* 4. Brand Audience:</strong></label>
                  <input type="text" name="brand_audience" id="brand_audience" class="form-control" value="{{ old('brand_audience') }}" placeholder="Who is your target audience?" required>
              </div>
              <div class="col-md-4">
                  <label for="brand_description"><strong>* 5. Brand Description:</strong></label>
                  <input type="text" name="brand_description" id="brand_description" class="form-control" value="{{ old('brand_description') }}" placeholder="Brief description of your brand" required>
              </div>
              <div class="col-md-4 d-flex align-items-end">
                <div class="w-100">
                    <label for="logo"><strong>* 6. Logo:</strong></label><br>
                    <input type="file" name="logo" id="logo" class="ml-4 p-1 w-full text-slate-500 text-sm rounded-full leading-6 file:bg-violet-200 file:text-violet-700 file:font-semibold
                file:border-none file:px-4 file:py-1 file:mr-6 file:rounded-full hover:file:bg-violet-100 border border-gray-300">
                </div>
            </div>
            
            
          </div>
  
          <!-- Color, Font, Brand Guide -->
          <div class="row mt-4 mb-4">
              <div class="col-md-4">
                  <label for="color_codes">
                      <strong>* 7. Color Codes:</strong>
                      <button type="button" class="upload-btn btn btn-info">Color Guide</button>
                  </label>
                  <input type="text" name="color_codes" id="color_codes" class="form-control"  value="{{ old('color_codes') }}" placeholder="Hex or RGB values" required>
              </div>
              <div class="col-md-4">
                  <label for="fonts">
                      <strong>* 8. Fonts:</strong>
                      <button type="button" class="upload-btn btn btn-info">Font Guide</button>
                  </label>
                  <input type="text" name="fonts" id="fonts" class="form-control" value="{{ old('fonts') }}" placeholder="Enter font names" required>
              </div>
              <div class="col-md-4 d-flex align-items-end">
                  <div class="w-100">
                      <label for="brand_guide"><strong>* 9. Brand Guide:</strong></label><br>
                      <input type="file" name="brand_guide" id="brand_guide" class="ml-4 p-1 w-full text-slate-500 text-sm rounded-full leading-6 file:bg-violet-200 file:text-violet-700 file:font-semibold
                      file:border-none file:px-4 file:py-1 file:mr-6 file:rounded-full hover:file:bg-violet-100 border border-gray-300">
                      
                  </div>
              </div>
          </div>
  
          <!-- Additional Assets -->
          <div class="row mt-4">
              <div class="col-md-12 text-center">
                  <label for="additional_assets"><strong>10. Additional Assets:</strong></label><br>
                  <input type="file" name="additional_assets" id="additional_assets" class="ml-4 p-1 w-full max-w-[450px] text-slate-500 text-sm rounded-full leading-6 file:bg-violet-200 file:text-violet-700 file:font-semibold
                      file:border-none file:px-4 file:py-1 file:mr-6 file:rounded-full hover:file:bg-violet-100 border border-gray-300">
                  <p>Upload images, fonts, style guides, etc. to help our designers understand your brand better.</p>
              </div>
          </div>
  
          <!-- Submit -->
          <div class="text-end mt-4">
              <button type="submit" class="submit-btn btn btn-danger">Submit</button>
          </div>
      </div>
  </form>
  
  </div>
</div>

<!-- Scripts -->
<script>
  function toggleOtherIndustry(value) {
      const otherInput = document.getElementById('otherIndustryContainer');
      if (value === 'Other') {
          otherInput.style.display = 'block';
      } else {
          otherInput.style.display = 'none';
      }
  }


  </script>
  

</x-layout>
