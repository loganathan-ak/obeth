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
            <div class="flex gap-x-5">
                <div class="mb-3 w-full">
                    <label for="request_type" class="form-label fw-semibold">Select Service*</label>
                    <select class="form-select" id="request_type" name="request_type" required>
                        <option value="">Select Type</option>
                        {{-- JS will populate options --}}
                    </select>
                </div>
                
                <div class="mb-3 w-full">
                    <label for="sub_service" class="form-label fw-semibold">Select Sub Service*</label>
                    <select class="form-select" id="sub_service" name="sub_service">
                        <option value="">Select Sub Type</option>
                        {{-- JS will populate options --}}
                    </select>
                </div>
            </div>
            {{-- For JS to access old values --}}
            <input type="hidden" id="old_request_type" value="{{ old('request_type', $order->request_type) }}">
            <input type="hidden" id="old_sub_service" value="{{ old('sub_service', $order->sub_service) }}">

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
                    <div class="mt-3 d-flex flex-wrap gap-3">
                        @foreach(json_decode($order->reference_files) as $file)
                            @php
                                $extension = pathinfo($file->original_name, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']);
                            @endphp
            
                            @if($isImage)
                                <div style="width: 150px; position: relative;">
                                    <img src="{{ asset('storage/' . $file->path) }}" 
                                         alt="{{ $file->original_name }}" 
                                         class="img-thumbnail" 
                                         style="max-width: 100%; max-height: 150px;">
                                    <small class="d-block text-truncate mt-1">{{ $file->original_name }}</small>
                                </div>
                            @else
                                <div style="width: 150px;">
                                    <a href="{{ asset('storage/' . $file->path) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-primary w-100">
                                        View {{ strtoupper($extension) }}
                                    </a>
                                    <small class="d-block text-truncate mt-1">{{ $file->original_name }}</small>
                                </div>
                            @endif
                        @endforeach
                    </div>
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
            @php
            $subscriber = $subscribers->where('id', $order->created_by)->first();
            $fullName = $subscriber->first_name . ' ' . $subscriber->last_name;
            @endphp
            <input type="text" class="form-control" value="{{$fullName ?? 'N/A' }}" disabled>
            <input type="hidden" name="user_id" value="{{ $order->created_by }}">
        </div>

        <!-- Assign To Admin -->
        {{-- <div class="mb-3">
            <label for="assigned_to" class="form-label fw-semibold">Assign To</label>
            <select name="assigned_to" id="assigned_to" class="form-select">
                <option value="">Select Admin</option>
                @foreach($admins as $admin)
                    <option value="{{ $admin->id }}" {{ $order->assigned_to == $admin->id ? 'selected' : '' }}>
                        {{ $admin->name }}
                    </option>
                @endforeach
            </select>
        </div> --}}

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





////////////////////////////////////////////



const serviceMap = {
  "Logo and Branding": [
    "Logo Design",
    "Logo & Brand Identity Pack",
    "Logo & Business",
    "Typography Design",
    "Watermark",
    "Label Design",
    "Brand Guidelines",
    "Business Card Design",
    "Business Card Update",
    "Stationery Design",
    "Poster Design",
    "Sticker Design",
    "Coupon Design",
    "Leaflet Design",
    "Logo & Brand Guide",
    "Logo & Product Packaging",
    "Corporate Logo Update",
    "Minimalist Logo Design",
    "Vintage Logo Design",
    "2D Logo Mockups",
    "Email Template Design",
    "PowerPoint Presentation"
  ],
  "Embroidery Digitizing": [
    "Underlay for Embroidery Digitizing",
    "Embroidered Patch Designs",
    "Left Chest Digitizing",
    "Right Chest Digitizing",
    "Sleeve Digitizing",
    "Full Front Digitizing",
    "Full Back Digitizing",
    "Hoodie Digitizing",
    "Shirt Digitizing",
    "Hat Digitizing",
    "Cap Digitizing",
    "Bag Digitizing",
    "Pant Digitizing",
    "Polo T-shirt Digitizing",
    "Apron Digitizing",
    "Custom Embroidery Digitizing",
    "3D Puff Digitizing",
    "Cross Stitch Embroidery Digitizing",
    "Satin Stitch Embroidery Digitizing"
  ],
  "Web & Digital Design": [
    "Blog Graphics",
    "Slider Images",
    "Digital Business Cards",
    "Landing Page Design",
    "Banner Ad Design",
    "E-commerce Mockup"
  ],
  "Print & Promotional Materials": [
    "Flyer Design",
    "Infographic Design",
    "Brochure Design",
    "Invoice Template Design",
    "Gift Certificate Design",
    "Thank You Cards",
    "Invitations",
    "Business Reports Layouts",
    "Press Kit Design",
    "Corporate Stationery Design",
    "Resume Design",
    "Presentation Design",
    "Catalogue Design",
    "Newspaper Ad Design",
    "Roll-Up Banner Design",
    "Postcard Design",
    "Personalized Gift Design",
    "Quote Graphic Design",
    "Calendar Design",
    "Booklet Design",
    "Large Format Print Design",
    "Magazine Design",
    "Print-Ready Artwork",
    "Car, Truck, & Van Wraps",
    "Signage Design",
    "Marketing Graphics",
    "Menu Design",
    "Slide Decks",
    "Album Cover Design",
    "Podcast Cover Art",
    "Presentation Decks",
    "Webinar Presentation Slides",
    "Annual Report Design",
    "Branded Letterhead Design",
    "Corporate Email Signatures",
    "Presentation Infographics"
  ],
  "Clothing & Merchandise": [
    "T-Shirt Design",
    "Clothing & Apparel Graphics",
    "Merchandise Design",
    "Mug & Cup Design",
    "Popsocket Design",
    "Bag & Tote Design",
    "Hat & Cap Design",
    "Pullover & Hoodie Design",
    "Labels Design",
    "Sweatshirt Graphics",
    "Sportswear Graphics",
    "Band Merch Design",
    "Limited Edition Merch",
    "Eco-friendly Merch Design",
    "Socks & Footwear Graphics",
    "Uniform Branding",
    "Custom Print Design",
    "Swimwear Graphics",
    "Apron Designs",
    "Workwear Branding",
    "Seasonal Merch Design",
    "Personalized Clothing Prints",
    "Jersey Design"
  ],
  "Packaging & Label Design": [
    "Product Packaging Design",
    "Product Label Design",
    "Food Packaging",
    "Beverage Label Design",
    "Cosmetic Packaging",
    "Tech Product Packaging",
    "Medicine & Pharmaceutical Labels",
    "Minimalist Packaging",
    "Name Badge Design",
    "Subscription Box Packaging",
    "Gift Box Design",
    "Luxury Packaging Design",
    "Branded Shopping Bags",
    "Seasonal Packaging Themes",
    "Box Packaging Design",
    "Bag Printing Design",
    "Die-Cut Packaging Design",
    "Juice Label & Packaging Design",
    "Hologram Sticker Design",
    "Hang Tag Design"
  ],
  "Art & Illustration": [
    "Custom Illustrations",
    "Image to Vector Art",
    "Color Separation",
    "Template Placing",
    "Form Typeset",
    "Card & Invitation Design",
    "Character & Mascot Design",
    "Tattoo Design",
    "Icon Design",
    "Album Art",
    "Custom Infographics",
    "Digital Painting",
    "Portraits & Caricatures",
    "Watercolor Art",
    "Vector Artwork",
    "Pattern Design",
    "Children's Book Illustrations",
    "Pop Art & Retro Graphics",
    "Architectural Graphics",
    "Book Cover Design",
    "E-Book Cover Design",
    "DVD/CD Cover Design",
    "Journal & Notebook Cover Design",
    "Line Art Design",
    "Mockups",
    "Product Mockups",
    "Neon Sign Mockup",
    "NFT Artwork Creation"
  ],
  "Social Media Content": [
    "Facebook Ads",
    "Facebook Post Design",
    "Facebook Cover Photo",
    "Facebook Story Graphics",
    "Facebook Event Cover Designs",
    "InstagramAds",
    "Instagram Post Design",
    "Instagram Story Design",
    "LinkedIn Post Design",
    "LinkedIn Banner Designs",
    "YouTube Video Thumbnails",
    "YouTube Channel Art",
    "YouTube End Screens",
    "Twitter Post Design",
    "Twitter Header Graphics",
    "Carousel Ad Design",
    "Advertisement Design",
    "WhatsApp Story Designs",
    "Pinterest Pin Design",
    "Social Media Advertisements"
  ],
  "Digital Advertisement": [
    "Digital Display Ads",
    "Influencer Media Kits",
    "Web Banner Design",
    "Tech Explainer Graphics",
    "Online Banner",
    "Google Display Ads Design",
    "Event Ticket Design"
  ],
  "Digital Enhancements & Image Editing": [
    "Image Retouching",
    "Image Editing",
    "2D Graphics for Mobile Apps",
    "Overlays for Streaming",
    "Photo Enhancement",
    "Shadow and Reflection Creation",
    "Image Background Removal",
    "Product Background Removal",
    "Clipping Path",
    "Color Correction",
    "Image Masking",
    "Photo Manipulation",
    "Virtual Staging"
  ],
  "Exhibition & Display Graphics": [
    "Exhibition Booth Graphics",
    "Jumbotron Display Graphics",
    "Hoarding/Billboard Design",
    "Kiosk Display Design",
    "Office Branding Graphics",
    "Door Hanger Design"
  ],
  "Unique & Custom Creations": [
    "Concept Art",
    "Concept Illustration",
    "Promotional Product Design",
    "Trend-Based Graphics",
    "Unique Branding Icons",
    "Minimalist Business Branding",
    "Community Engagement Graphics",
    "QR Code Design",
    "Apparel Design",
    "Keychain Design",
    "Fabric Print Design",
    "Heat Press Transfer Graphics",
    "Helmet Wrap Design"
  ],
  "Additional Services": [
    "Photo Realistic Mockups",
    "Branded Merchandise Packaging",
    "Seasonal Promotion Graphics"
  ]
};

const mainSelect = document.getElementById('request_type');
    const subSelect = document.getElementById('sub_service');

    const oldMain = document.getElementById('old_request_type').value;
    const oldSub = document.getElementById('old_sub_service').value;

    function populateMainDropdown() {
        Object.keys(serviceMap).forEach(service => {
            const option = document.createElement('option');
            option.value = service;
            option.textContent = service;
            if (service === oldMain) option.selected = true;
            mainSelect.appendChild(option);
        });
    }

    function populateSubDropdown(mainValue) {
        subSelect.innerHTML = '<option value="">Select Sub Type</option>';
        if (serviceMap[mainValue]) {
            serviceMap[mainValue].forEach(sub => {
                const option = document.createElement('option');
                option.value = sub;
                option.textContent = sub;
                if (sub === oldSub) option.selected = true;
                subSelect.appendChild(option);
            });
        }
    }

    // On change of main select
    mainSelect.addEventListener('change', function () {
        populateSubDropdown(this.value);
    });

    // On page load
    populateMainDropdown();
    populateSubDropdown(oldMain);
    </script>
</x-layout>
