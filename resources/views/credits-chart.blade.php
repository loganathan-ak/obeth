{{-- resources/views/credit_chart_page.blade.php --}}

<x-layout>
    {{-- Inline styles specific to this credit chart --}}
    <style>
        .category-title {
            border-bottom: 2px solid #e2e8f0; /* Light gray border */
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
            color: #2d3748; /* Darker text for titles */
        }
        .service-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px dashed #edf2f7; /* Dashed subtle border */
        }
        .service-item:last-child {
            border-bottom: none;
        }
        .credit-cost {
            font-weight: 600;
            color: #4a5568; /* Slightly darker than body text */
        }
        .credit-hour {
            font-style: italic;
            color: #718096; /* Muted color for hourly rates */
            font-size: 0.9em;
        }
    </style>

    {{-- Main content wrapper for visual appeal --}}
    <div class="container mx-auto p-20 mt-10 bg-white shadow-lg rounded-lg">

        <h1 class="text-4xl font-bold text-center mb-10 text-gray-800">Design Services Credit Chart</h1>

        {{-- Data definition --}}
        @php
            $categories = [
                'Logo and Branding' => [
                    'Logo Design (3 Options)' => '15 Credits',
                    'Logo & Brand Identity Pack (3 Logo Options & 1 Brand Identity on finalized logo)' => '50 Credits',
                    'Logo & Business Card (3 Logo Options & 1 Business Card Design)' => '20 Credits',
                    'Typography Design' => '2 Credit/Hour',
                    'Watermark' => '4 Credits',
                    'Label Design' => '2 Credit/Hour',
                    'Brand Guidelines' => '20 Credits',
                    'Business Card Design' => '6 Credits',
                    'Business Card Update' => '4 Credits',
                    'Stationery Design' => '2 Credit/Hour',
                    'Poster Design' => '2 Credit/Hour',
                    'Sticker Design' => '2 Credit/Hour',
                    'Coupon Design' => '2 Credit/Hour',
                    'Leaflet Design' => '20 Credits',
                    'Logo & Brand Guide (3 Logo Options & 1 Brand guide on finalized logo)' => '25 Credits',
                    'Logo & Product Packaging (3 Logo Options & 1 Product Packaging Design on finalized logo)' => '25 Credits',
                    'Corporate Logo Update (3 Logo Options)' => '25 Credits',
                    'Minimalist Logo Design (3 Logo Options)' => '20 Credits',
                    'Vintage Logo Design (3 Logo Options)' => '20 Credits',
                    '2D Logo Mockups' => '4 Credits',
                    'Email Template Design' => '15 Credits',
                    'PowerPoint Presentation (Upto 10 Pages)' => '40 Credits',
                ],
                'Embroidery Digitizing' => [
                    'Embroidered Patch Designs' => 'Varies by size',
                    'Left Chest Digitizing' => 'Varies by size',
                    'Right Chest Digitizing' => 'Varies by size',
                    'Sleeve Digitizing' => 'Varies by size',
                    'Full Front Digitizing' => 'Varies by size',
                    'Full Back Digitizing' => 'Varies by size',
                    'Hoodie Digitizing' => 'Varies by size',
                    'Shirt Digitizing' => 'Varies by size',
                    'Hat Digitizing' => 'Varies by size',
                    'Cap Digitizing' => 'Varies by size',
                    'Bag Digitizing' => 'Varies by size',
                    'Pant Digitizing' => 'Varies by size',
                    'Polo T-shirt Digitizing' => 'Varies by size',
                    'Apron Digitizing' => 'Varies by size',
                    'Custom Digitizing' => 'Varies by size',
                    '3D Puff Digitizing' => 'Varies by size',
                    'Cross Stitch Embroidery Digitizing' => 'Varies by size',
                    'Satin Stitch Embroidery Digitizing' => 'Varies by size',
                    'Up to 1 inch' => '2 Credits',
                    '1-2 inches' => '4 Credits',
                    '2-3 inches' => '6 Credits',
                    '3-4 inches' => '8 Credits',
                    '4-5 inches' => '10 Credits',
                    '5-6 inches' => '12 Credits',
                    '6-7 inches' => '14 Credits',
                    '7-8 inches' => '16 Credits',
                    '8-9 inches' => '18 Credits',
                    '9-10 inches' => '20 Credits',
                    'Above 10 Inches' => '30 Credits Flat',
                ],
                'Web & Digital Design' => [
                    'Blog Graphics' => '10 Credits',
                    'Slider Images' => '10 Credits',
                    'Digital Business Cards' => '8 Credits',
                    'Landing Page Design' => '10 Credits',
                    'Banner Ad Design' => '10 Credits',
                    'E-commerce Mockup' => '2 Credits',
                ],
                'Print & Promotional Designs' => [
                    'Flyer Design' => '10 Credits',
                    'Infographic Design' => '2 Credit/Hour',
                    'Brochure Design' => '20 Credits',
                    'Invoice Template Design' => '10 Credits',
                    'Gift Certificate Design' => '10 Credits',
                    'Thank You Cards' => '6 Credits',
                    'Invitations' => '10 Credits',
                    'Business Reports Layouts' => '2 Credit/Hour',
                    'Press Kit Design' => '20 Credits',
                    'Corporate Stationery Design' => '2 Credit/Hour',
                    'Resume Design' => '10 Credits',
                    'Presentation Design (Upto 10 Pages)' => '40 Credits',
                    'Catalogue Design (Upto 10 Pages)' => '40 Credits',
                    'Newspaper Ad Design' => '10 Credits',
                    'Roll-Up Banner Design' => '10 Credits',
                    'Postcard Design' => '8 Credits',
                    'Personalized Gift Design' => '2 Credit/Hour',
                    'Quote Graphic Design' => '2 Credit/Hour',
                    'Calendar Design' => '40 Credits',
                    'Booklet Design (Upto 10 Pages)' => '40 Credits',
                    'Large Format Print Design' => '2 Credit/Hour',
                    'Magazine Design (Upto 10 Pages)' => '40 Credits',
                    'Print-Ready Artwork' => '2 Credit/Hour',
                    'Car, Truck, & Van Wraps' => '2 Credit/Hour',
                    'Signage Design' => '2 Credit/Hour',
                    'Marketing Graphics' => '2 Credit/Hour',
                    'Menu Design (Double Side)' => '20 Credits',
                    'Slide Decks (Upto 10 Pages)' => '40 Credits',
                    'Album Cover Design' => '20 Credits',
                    'Podcast Cover Art' => '20 Credits',
                    'Presentation Decks (Upto 10 Pages)' => '40 Credits',
                    'Webinar Presentation Slides (Upto 10 Pages)' => '40 Credits',
                    'Annual Report Design (Upto 10 Pages)' => '40 Credits',
                    'Branded Letterhead Design' => '8 Credits',
                    'Corporate Email Signatures' => '8 Credits',
                    'Presentation Infographics' => '2 Credit/Hour',
                    'Seasonal Promotion Graphics' => '2 Credit/Hour',
                ],
                'Clothing & Merchandise Designs' => [
                    'T-Shirt Design (3 Options)' => '30 Credits',
                    'Clothing & Apparel Graphics' => '2 Credit/Hour',
                    'Merchandise Design' => '2 Credit/Hour',
                    'Mug & Cup Design' => '2 Credit/Hour',
                    'Popsocket Design' => '2 Credit/Hour',
                    'Bag & Tote Design' => '2 Credit/Hour',
                    'Hat & Cap Design' => '2 Credit/Hour',
                    'Pullover & Hoodie Design' => '2 Credit/Hour',
                    'Labels Design' => '2 Credit/Hour',
                    'Sweatshirt Graphics' => '2 Credit/Hour',
                    'Sportswear Graphics' => '2 Credit/Hour',
                    'Band Merch Design' => '2 Credit/Hour',
                    'Limited Edition Merch' => '2 Credit/Hour',
                    'Eco-friendly Merch Design' => '2 Credit/Hour',
                    'Socks & Footwear Graphics' => '2 Credit/Hour',
                    'Uniform Branding (3 Options)' => '30 Credits',
                    'Custom Print Design' => '2 Credit/Hour',
                    'Swimwear Graphics' => '2 Credit/Hour',
                    'Apron Designs' => '2 Credit/Hour',
                    'Workwear Branding (3 Options)' => '30 Credits',
                    'Seasonal Merch Design' => '2 Credit/Hour',
                    'Personalized Clothing Prints' => '2 Credit/Hour',
                    'Jersey Design (3 Options)' => '30 Credits',
                ],
                'Packaging & Label Designs' => [
                    'Product Packaging Design (3 Options)' => '30 Credits',
                    'Product Label Design (3 Options)' => '30 Credits',
                    'Food Packaging (3 Options)' => '30 Credits',
                    'Beverage Label Design (3 Options)' => '30 Credits',
                    'Cosmetic Packaging (3 Options)' => '30 Credits',
                    'Tech Product Packaging (3 Options)' => '30 Credits',
                    'Medicine & Pharmaceutical Labels (3 Options)' => '30 Credits',
                    'Minimalist Packaging (3 Options)' => '30 Credits',
                    'Name Badge Design' => '4 Credits',
                    'Subscription Box Packaging (3 Options)' => '30 Credits',
                    'Gift Box Design (3 Options)' => '30 Credits',
                    'Luxury Packaging Design (3 Options)' => '30 Credits',
                    'Branded Shopping Bags (3 Options)' => '30 Credits',
                    'Seasonal Packaging Themes (3 Options)' => '30 Credits',
                    'Box Packaging Design (3 Options)' => '30 Credits',
                    'Bag Printing Design (3 Options)' => '30 Credits',
                    'Die-Cut Packaging Design (3 Options)' => '30 Credits',
                    'Juice Label & Packaging Design (3 Options)' => '30 Credits',
                    'Hologram Sticker Design' => '2 Credit/Hour',
                    'Hang Tag Design' => '2 Credit/Hour',
                    'Branded Merchandise Packaging (3 Options)' => '30 Credits',
                ],
                'Art & Illustration' => [
                    'Custom Illustrations' => '2 Credit/Hour',
                    'Image to Vector Art' => '2 Credit/Hour',
                    'Color Separation' => '4 Credits',
                    'Template Placing' => '4 Credits',
                    'Form Typeset' => '2 Credit/Hour',
                    'Card & Invitation Design (3 Options)' => '30 Credits',
                    'Character & Mascot Design' => '30 Credits',
                    'Tattoo Design' => '2 Credit/Hour',
                    'Icon Design' => '2 Credit/Hour',
                    'Album Art' => '2 Credit/Hour',
                    'Custom Infographics' => '2 Credit/Hour',
                    'Digital Painting' => '2 Credit/Hour',
                    'Portraits & Caricatures' => '30 Credits',
                    'Watercolor Art' => '2 Credit/Hour',
                    'Vector Artwork' => '2 Credit/Hour',
                    'Pattern Design (3 Options)' => '30 Credits',
                    'Children\'s Book Illustrations' => '2 Credit/Hour',
                    'Pop Art & Retro Graphics' => '2 Credit/Hour',
                    'Architectural Graphics' => '2 Credit/Hour',
                    'Book Cover Design (3 Options)' => '30 Credits',
                    'E-Book Cover Design (3 Options)' => '30 Credits',
                    'DVD/CD Cover Design (3 Options)' => '30 Credits',
                    'Journal & Notebook Cover Design (3 Options)' => '30 Credits',
                    'Line Art Design' => '2 Credit/Hour',
                    'Mockup' => '2 Credits',
                    'Product Mockup' => '4 Credits',
                    'Neon Sign Mockup' => '4 Credits',
                    'NFT Artwork Creation' => '2 Credit/Hour',
                    'Photo Realistic Mockups' => '3 Credits',
                ],
                'Social Media Designs' => [
                    'Facebook Ads' => '8 Credits',
                    'Facebook Post Design' => '8 Credits',
                    'Facebook Cover Photo' => '8 Credits',
                    'Facebook Story Graphics' => '8 Credits',
                    'Facebook Event Cover Designs' => '8 Credits',
                    'Instagram Ads' => '8 Credits',
                    'Instagram Post Design' => '8 Credits',
                    'Instagram Story Design' => '8 Credits',
                    'LinkedIn Post Design' => '8 Credits',
                    'LinkedIn Banner Designs' => '8 Credits',
                    'YouTube Video Thumbnails' => '8 Credits',
                    'YouTube Channel Art' => '20 Credits',
                    'YouTube End Screens' => '8 Credits',
                    'Twitter Post Design' => '8 Credits',
                    'Twitter Header Graphics' => '8 Credits',
                    'Carousel Ad Design (Upto 10 Pages)' => '30 Credits',
                    'Advertisement Design (3 Options)' => '30 Credits',
                    'WhatsApp Story Designs' => '8 Credits',
                    'Pinterest Pin Design' => '8 Credits',
                    'Social Media Advertisements (3 Options)' => '30 Credits',
                ],
                'Digital Advertisement' => [
                    'Digital Display Ads (3 Options)' => '30 Credits',
                    'Influencer Media Kits (3 Options)' => '30 Credits',
                    'Web Banner Design (3 Options)' => '30 Credits',
                    'Tech Explainer Graphics' => '30 Credits',
                    'Online Banner Ads (3 Options)' => '30 Credits',
                    'Google Display Ads Design (3 Options)' => '30 Credits',
                    'Event Ticket Design (3 Options)' => '30 Credits',
                ],
                'Digital Enhancements & Image Editing' => [
                    'Image Retouching' => '2 Credit/Hour',
                    'Image Editing' => '2 Credit/Hour',
                    '2D Graphics for Mobile Apps' => '2 Credit/Hour',
                    'Overlays for Streaming' => '10 Credits',
                    'Photo Enhancement' => '2 Credit/Hour',
                    'Shadow and Reflection Creation' => '2 Credit/Hour',
                    'Image Background Removal' => '4 Credits',
                    'Product Background Removal' => '3 Credits',
                    'Clipping Path' => '2 Credit/Hour',
                    'Color Correction' => '2 Credit/Hour',
                    'Image Masking' => '2 Credit/Hour',
                    'Photo Manipulation' => '2 Credit/Hour',
                    'Virtual Staging' => '2 Credit/Hour',
                ],
                'Exhibition & Display Graphics' => [
                    'Exhibition Booth Graphics (3 Options)' => '30 Credits',
                    'Jumbotron Display Graphics (3 Options)' => '30 Credits',
                    'Hoarding/Billboard Design (3 Options)' => '30 Credits',
                    'Kiosk Display Design (3 Options)' => '30 Credits',
                    'Office Branding Graphics' => '2 Credit/Hour',
                    'Door Hanger Design' => '2 Credit/Hour',
                ],
                'Unique & Custom Designs' => [
                    'Concept Design' => '30 Credits',
                    'Concept Illustration' => '30 Credits',
                    'Promotional Product Design' => '2 Credit/Hour',
                    'Trend-Based Graphics' => '2 Credit/Hour',
                    'Unique Branding Icons' => '2 Credit/Hour',
                    'Minimalist Business Branding' => '2 Credit/Hour',
                    'Community Engagement Graphics' => '2 Credit/Hour',
                    'QR Code Design' => '2 Credit/Hour',
                    'Apparel Design' => '2 Credit/Hour',
                    'Keychain Design' => '2 Credit/Hour',
                    'Fabric Print Design' => '2 Credit/Hour',
                    'Heat Press Transfer Graphics' => '2 Credit/Hour',
                    'Helmet Wrap Design' => '2 Credit/Hour',
                ],
            ];
        @endphp

{{-- Loop through categories and services --}}
@foreach ($categories as $category => $services)
    <details class="mb-8 p-4 border border-gray-200 rounded-lg shadow-sm bg-white">
        <summary class="text-2xl font-semibold category-title cursor-pointer py-2 px-4 -mx-4 -mt-4 rounded-t-lg bg-gray-50 hover:bg-gray-100 flex justify-between items-center">
            {{ $category }}
            <span class="text-gray-500 text-sm">Click to {{ $loop->first ? 'collapse' : 'expand' }}</span>
        </summary>
        <div class="space-y-2 pt-4"> {{-- Added pt-4 for spacing below the summary --}}
            @foreach ($services as $serviceName => $creditCost)
                <div class="service-item text-gray-700">
                    <span>{{ $serviceName }}</span>
                    @if (str_contains($creditCost, 'Credit/Hour'))
                        <span class="credit-hour">{{ $creditCost }}</span>
                    @else
                        <span class="credit-cost">{{ $creditCost }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </details>
@endforeach


        <footer class="text-center mt-10 text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} All Rights Reserved.</p>
        </footer>
    </div>
</x-layout>