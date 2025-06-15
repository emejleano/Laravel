@extends('layouts.customer')

@section('title')
PT.Gikoko
@endsection

@section('content')
@include('layouts.inc.IntroVideo')

@if (session('status'))
<div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

{{-- Section: Top Categories --}}
<div class="py-2">
    <div class="container d-flex align-items-center justify-content-around p-4">
        <div class="border border-dark" style="width:20rem; height:2px; background:black;"></div>
        <h3 style="font-size: 40px; font-weight:bolder; padding:5px; white-space: nowrap;">TOP CATEGORIES</h3>
        <div class="border border-dark" style="width:20rem; height:2px; background:black;"></div>
    </div>
</div>

<div class="py-5">
    <div class="container">
        <div class="owl-carousel owl-theme category-slider">
            @foreach ($category as $cate)
            <div class="item">
                <a href="{{ url('view-category/'.$cate->slug) }}" class="card category-card" style="border:none;">
                    <div class="card-body zoom position-relative">
                        <img src="{{ asset('upload/category/'.$cate->image) }}" 
                             class="w-100 rounded category-image" 
                             alt="{{ $cate->name }}"
                             onload="this.style.opacity='1'">
                        <div class="text-light position-absolute top-50 start-50 translate-middle text-center">
                            <h4 style="letter-spacing:3px; text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">{{ $cate->name }}</h4>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Section: New Arrivals --}}
<div class="py-2">
    <div class="container d-flex align-items-center justify-content-around p-4">
        <div class="border border-dark" style="width:20rem; height:2px; background:black;"></div>
        <h3 style="font-size: 40px; font-weight:bolder; padding:5px; white-space: nowrap;">NEW ARRIVALS</h3>
        <div class="border border-dark" style="width:20rem; height:2px; background:black;"></div>
    </div>
</div>

<div class="py-5" id="products">
    <div class="container">
        <div class="owl-carousel owl-theme product-slider">
            @foreach ($product as $item)
            <div class="item">
                <a class="link-dark text-decoration-none" href="{{ url('view-product/'.$item->slug) }}">
                    <div class="card product-card h-100">
                        <div class="card-img-container">
                            <img src="{{ asset('upload/product/'.$item->image) }}" 
                                 class="card-img-top product-image" 
                                 alt="{{ $item->name }}">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title product-title">{{ $item->name }}</h6>
                            <div class="price-section mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="original-price text-muted">
                                        <small><s>Rp {{ number_format($item->original_price, 0, ',', '.') }}</s></small>
                                    </span>
                                    <span class="selling-price fw-bold text-primary">
                                        Rp {{ number_format($item->selling_price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    // Initialize category images
    $('.category-image').each(function() {
        $(this).on('load', function() {
            $(this).addClass('loaded');
        });
        
        // If image is already loaded (cached)
        if (this.complete) {
            $(this).addClass('loaded');
        }
    });

    // Category Slider
    $(".category-slider").owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        dots: true,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        navText: [
            '<i class="fas fa-chevron-left"></i>',
            '<i class="fas fa-chevron-right"></i>'
        ],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });

    // Product Slider
    $(".product-slider").owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        dots: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        navText: [
            '<i class="fas fa-chevron-left"></i>',
            '<i class="fas fa-chevron-right"></i>'
        ],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            900: {
                items: 3
            },
            1200: {
                items: 4
            }
        }
    });
});

@if(session('status'))
swal("Done!", "{{ session('status') }}", "success");
@endif
</script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
/* Owl Carousel Navigation */
.owl-nav {
    display: block !important;
    margin-top: 20px;
}

.owl-nav button {
    background: #333 !important;
    color: white !important;
    border-radius: 50% !important;
    width: 50px !important;
    height: 50px !important;
    font-size: 18px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    transition: all 0.3s ease !important;
    border: none !important;
    outline: none !important;
}

.owl-nav button:hover {
    background: #007bff !important;
    transform: scale(1.1);
}

.owl-nav button.owl-prev {
    float: left;
}

.owl-nav button.owl-next {
    float: right;
}

/* Owl Carousel Dots */
.owl-dots {
    text-align: center;
    margin-top: 20px;
}

.owl-dot {
    display: inline-block;
    margin: 0 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #ccc;
    transition: all 0.3s ease;
}

.owl-dot.active {
    background: #007bff;
    transform: scale(1.2);
}

/* Category Cards */
.category-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.category-image {
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease, opacity 0.3s ease;
    opacity: 0;
}

.category-image.loaded {
    opacity: 1;
}

.category-card:hover .category-image {
    transform: scale(1.05);
}

/* Product Cards */
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #e0e0e0;
    border-radius: 15px;
    overflow: hidden;
    height: 100%;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    border-color: #007bff;
}

.card-img-container {
    height: 200px;
    overflow: hidden;
}

.product-image {
    height: 100%;
    width: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-title {
    font-weight: 600;
    color: #333;
    line-height: 1.4;
    height: 2.8em;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.price-section {
    padding-top: 10px;
    border-top: 1px solid #f0f0f0;
}

.selling-price {
    font-size: 1.1em;
}

.original-price {
    font-size: 0.9em;
}

/* Zoom Effect */
.zoom {
    transition: transform 0.3s ease;
}

.zoom:hover {
    transform: scale(1.02);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .container h3 {
        font-size: 28px !important;
    }
    
    .border {
        width: 10rem !important;
    }
    
    .owl-nav button {
        width: 40px !important;
        height: 40px !important;
        font-size: 14px !important;
    }
}

@media (max-width: 576px) {
    .container h3 {
        font-size: 24px !important;
    }
    
    .border {
        width: 5rem !important;
    }
    
    .category-image {
        height: 200px;
    }
    
    .card-img-container {
        height: 180px;
    }
}

/* Custom scrollbar for better UX */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
@endsection