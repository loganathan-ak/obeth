<x-layout>
<div class="container-fluid mt-5 pt-4 mb-5 pb-5">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Design Brief</h3>
      <ul class="breadcrumbs mb-3 list-unstyled d-flex align-items-center">
        <li class="nav-home">
          <a href="/">
            <i class="fas fa-house"></i>
          </a>
        </li>
        <li class="separator mx-2">
          <i class="fa-solid fa-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="/">Home</a>
        </li>
        <li class="separator mx-2">
          <i class="fa-solid fa-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="/brandform">Design Brief</a>
        </li>
      </ul>
    </div>

    <div class="card p-4">
      <form id="designBriefForm">
        <!-- Title and Request Type -->
        <div class="row mb-4">
          <div class="col-md-6">
            <label class="form-label fw-bold">1. Title:</label>
            <input type="text" class="form-control" placeholder="Give a name for your request" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">2. Request Type:</label>
            <select class="form-control" required>
              <option value="">Select Request Type</option>
              <!-- Add dynamic options later -->
            </select>
          </div>
        </div>

        <!-- Instructions -->
        <div class="row mb-4">
          <div class="col-md-12">
            <label class="form-label fw-bold">3. Instructions:</label>
            <textarea class="form-control" placeholder="Write notes..." rows="4" required></textarea>
            <div class="mt-2">
              <button type="button" class="btn btn-sm btn-light border">B</button>
              <button type="button" class="btn btn-sm btn-light border">T</button>
              <button type="button" class="btn btn-sm btn-light border">F</button>
            </div>
          </div>
        </div>

        <!-- Color, Size, Software -->
        <div class="row mb-5">
          <div class="col-md-4">
            <label class="form-label fw-bold">4. Color:</label>
            <select class="form-control" required>
              <option value="">Select Color</option>
              <!-- Add dynamic options later -->
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label fw-bold">5. Size:</label>
            <select class="form-control" required>
              <option value="">Select Size</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label fw-bold">6. Software to use:</label>
            <select class="form-control" required>
              <option value="">Select Software</option>
            </select>
          </div>
        </div>

        <!-- Brand Profile, Formats, Pre-Approve -->
        <div class="row mb-5">
          <div class="col-md-4">
            <label class="form-label fw-bold">7. Select Brand Profile:</label>
            <select class="form-control" required>
              <option value="">Select Brand Profile</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label fw-bold">8. Formats:</label><br>
            <div class="d-flex flex-wrap gap-2 mt-2">
              @foreach (['PDF', 'AI', 'EPS', 'PNG', 'JPG', 'PSD'] as $format)
                <button type="button" class="btn btn-outline-primary btn-sm">{{ $format }}</button>
              @endforeach
            </div>
          </div>
          <div class="col-md-4">
            <label class="form-label fw-bold">9. Pre-Approve upto:</label>
            <select class="form-control" required>
              <option value="">Select Approver</option>
            </select>
          </div>
        </div>

        <!-- Upload, Rush Request -->
        <div class="row mb-4">
          <div class="col-md-6">
            <label class="form-label fw-bold">10. Upload Reference Files:</label><br>
            <input type="file" class="form-control mt-2" multiple>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">11. Make Rush Request:</label><br>
            <div class="form-check form-switch mt-2">
              <input class="form-check-input" type="checkbox" id="rushRequest">
              <label class="form-check-label" for="rushRequest">Credits will be charged 2X for Rush Requests</label>
            </div>
          </div>
        </div>

        <!-- Form Buttons -->
        <div class="d-flex justify-content-end gap-3 mt-4">
          <button type="button" class="btn btn-secondary">Save Template</button>
          <button type="button" class="btn btn-info">Use Template</button>
          <button type="submit" class="btn btn-danger">Submit Request</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
document.querySelectorAll('.btn-outline-primary').forEach(button => {
  button.addEventListener('click', function() {
    this.classList.toggle('active');
  });
});
</script>


</x-layout>
