<x-layout>
<div class="mt-5 mb-5 p-5" >
         <!-- Template Dropdown -->
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h4 class="fw-bold">Design Request Form</h4>
        <div class="d-flex gap-2">
            <select id="template-selector" class="form-select">
                <option value="">-- Load Template --</option>
                @foreach ($templates as $template)
                    <option value="{{ $template->id }}">{{ $template->project_title }}</option>
                @endforeach
            </select>
        </div>
    </div>

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


    <form action="{{ route('create.order') }}" method="POST" enctype="multipart/form-data" id="request-form">
        @csrf
        <input type="hidden" name="mode" id="form-mode" value="create"> 
        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label fw-semibold">Project Title *</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <!-- Request Type -->
        <div class="flex gap-x-5">
            <div class="mb-3 w-full">
                <label for="request_type" class="form-label fw-semibold">Select Service*</label>
                <select class="form-select" id="request_type" name="request_type" required>
                    <option value="">Select Type</option>
                </select>
            </div>
            
            <div class="mb-3 w-full" id="sub_service_wrapper">
                <label for="sub_service" class="form-label fw-semibold">Select Sub-Service</label>
                <select class="form-select" id="sub_service" name="sub_service" required>
                    <option value="">Select Sub-Service</option>
                </select>
            </div>
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
                <div class="mb-3">
                    <select class="form-select" id="color" name="color" required>
                      <option value="">Select Color Format</option>
                      <option value="RGB">RGB</option>
                      <option value="CMYK">CMYK</option>
                      <option value="HEX">HEX</option>
                      <option value="Pantone">Pantone</option>
                      <option value="Grayscale">Grayscale</option>
                      <option value="Others">Others</option>
                    </select>
                    <input type="text" name="other_color_format" id="other_color_format" class="form-control collapse  input-toggle"  placeholder="Enter Color Format"/>
                </div>  
                
            </div>
            <div class="col-md-6">
                <label for="size" class="form-label fw-semibold">Size</label>
                <select class="form-select" id="size" name="size" required>
                    <option value="">Select Size</option>
                    <option value="Instagram Post (1080×1080 px)">Instagram Post (1080×1080 px)</option>
                    <option value="A4 Document (8.27″ × 11.69″ / 2480×3508 px @300dpi)">A4 Document (8.27″ × 11.69″ / 2480×3508 px @300dpi)</option>
                    <option value="Business Card (3.5″ × 2″ / 1050×600 px @300dpi)">Business Card (3.5″ × 2″ / 1050×600 px @300dpi)</option>
                    <option value="Website Banner (1920×1080 px)">Website Banner (1920×1080 px)</option>
                    <option value="Poster (24″ × 36″ / 7200×10800 px @300dpi)">Poster (24″ × 36″ / 7200×10800 px @300dpi)</option>
                    <option value="YouTube Thumbnail (1280×720 px)">YouTube Thumbnail (1280×720 px)</option>
                    <option value="Facebook Cover (820×312 px)">Facebook Cover (820×312 px)</option>
                    <option value="Instagram Story/Reel (1080×1920 px)">Instagram Story/Reel (1080×1920 px)</option>
                    <option value="Flyer - A4 (8.27″ × 11.69″ / 2480×3508 px @300dpi)">Flyer - A4 (8.27″ × 11.69″ / 2480×3508 px @300dpi)</option>
                    <option value="Letter Size (8.5″ × 11″ / 2550×3300 px @300dpi)">Letter Size (8.5″ × 11″ / 2550×3300 px @300dpi)</option>
                    <option value="Other">Other</option>
                </select>
                
                <input type="text" name="other_size" id="other_size" class="form-control collapse  input-toggle"  placeholder="Enter size"/>
            </div>
        </div>

        <!-- Software to Use -->
        <div class="mb-3">
            <label for="software" class="form-label fw-semibold">Software to Use</label>
            <select class="form-select" id="software" name="software" required>
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
            <label for="pre_approve" class="form-label fw-semibold">Pre-approve Up To (No.of credits)</label>
           <input type="number" class="form-control" name="pre_approve" id="pre_approve" min="0" step="1" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
        </div>

        <!-- Reference Files Upload -->
        <div class="mb-3">
            <label for="reference_files" class="form-label fw-semibold">Upload Reference Files</label>
            <input class="form-control" type="file" name="reference_files[]" id="reference_files" multiple required> 
        </div>
        <div id="preview-container" class="flex flex-wrap gap-4 mt-3"></div>

        <!-- Rush Request -->
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="rush" name="rush">
            <label class="form-check-label fw-semibold" for="rush">
                Mark as Rush Request
            </label>
            <p></p>
        </div>

        <!-- Submit -->
        <div class="text-end mt-4 flex gap-2 justify-end">
            <button type="button" class="btn btn-secondary" onclick="submitAsTemplate()">💾 Save as Template</button>
            <button type="submit" class="btn btn-primary">🚀 Submit Request</button>
        </div>
    </form>
</div>

<!-- Include Rich Text Editor -->
<script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<script>
     let filesArray = [];

function renderPreviews() {
    $('#preview-container').empty();

    filesArray.forEach((file, index) => {
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const previewHtml = `
                <div class="position-relative me-3 mb-3" style="width: 120px;">
                    <img src="${e.target.result}" class="img-thumbnail" style="height: 100px; object-fit: cover;">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-image" data-index="${index}">&times;</button>
                </div>
            `;
            $('#preview-container').append(previewHtml);
        };
        reader.readAsDataURL(file);
    });

    // Update the input element with current files
    const dataTransfer = new DataTransfer();
    filesArray.forEach(file => dataTransfer.items.add(file));
    $('#reference_files')[0].files = dataTransfer.files;
}

$('#reference_files').on('change', function(e) {
    filesArray = Array.from(e.target.files);
    renderPreviews();
});

$(document).on('click', '.remove-image', function() {
    const index = $(this).data('index');
    filesArray.splice(index, 1);
    renderPreviews();
});


///////////////////

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




    $('#color').on('change', function(){
        let getDiv = $(this).closest('div');
        let value = $(this).val();
        let toggleInput = getDiv.find('.input-toggle');
        
        if(value === 'Others'){
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

    // Populate main dropdown
    Object.keys(serviceMap).forEach(service => {
        const option = document.createElement('option');
        option.value = service;
        option.textContent = service;
        mainSelect.appendChild(option);
    });

    // Update sub-service on main selection
    mainSelect.addEventListener('change', function () {
        const selected = this.value;
        subSelect.innerHTML = '<option value="">Select Sub Type</option>'; // Reset

        if (serviceMap[selected]) {
            serviceMap[selected].forEach(sub => {
                const option = document.createElement('option');
                option.value = sub;
                option.textContent = sub;
                subSelect.appendChild(option);
            });
        }
    });



////////////////////////////////////////////////


    function submitAsTemplate() {
        document.getElementById('form-mode').value = 'template';
        document.getElementById('request-form').submit();
    }

    function populateSubServices(mainService, selectedSubService = '') {
    subSelect.innerHTML = '<option value="">Select Sub Type</option>';

    if (serviceMap[mainService]) {
        serviceMap[mainService].forEach(sub => {
            const option = document.createElement('option');
            option.value = sub;
            option.textContent = sub;
            subSelect.appendChild(option);
        });

        if (selectedSubService) {
            subSelect.value = selectedSubService;
        }
    }
}




    $('#template-selector').on('change', function () {
        const templateId = $(this).val();
        if (!templateId) return;

        $.ajax({
            url: `/order-templates/${templateId}`,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log(data);

                $('#title').val(data.project_title);
               $('#request_type').val(data.request_type);
                populateSubServices(data.request_type, data.sub_service ?? '');


                $('#instructions').val(data.instructions ?? '');
                $('#colors').val(data.colors ?? '');
                $('#size').val(data.size ?? '');
                $('#other_size').val(data.other_size ?? '');
                $('#software').val(data.software ?? '');
                $('#other_software').val(data.other_software ?? '');
                $('#brand_profile_id').val(data.brands_profile_id ?? '');
                $('#pre_approve').val(data.pre_approve ?? '');
                $('#rush').prop('checked', data.rush == 1);

                // Clear and check formats
                $('.format-checkbox').prop('checked', false);

                let formats = data.formats;

                // Parse if formats is a JSON string
                if (typeof formats === 'string') {
                    try {
                        formats = JSON.parse(formats);
                    } catch (e) {
                        formats = [];
                    }
                }

                if (Array.isArray(formats)) {
                    formats.forEach(f => {
                        const $el = $(`#format_${f}`);
                        if ($el.length) {
                            $el.prop('checked', true);
                        }
                    });
                }
            },
            error: function (xhr) {
                console.error("Error fetching template:", xhr.responseText);
                alert("Failed to load template.");
            }
        });
    });
</script>
</x-layout>
