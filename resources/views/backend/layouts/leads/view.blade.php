@extends('backend.master')

@section('title','Lead Details')

@section('content')
<div class="container-fluid">

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h3 class="fw-bold">Lead Details</h3>
            <a href="{{ route('lead.manage.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">

        <!-- Left Gallery Slider -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    @if($lead->galleryImages->count())

                    <!-- Main Slider -->
                    <div class="swiper gallery-main mb-3">
                        <div class="swiper-wrapper">
                            @foreach($lead->galleryImages as $image)
                                <div class="swiper-slide">
                                    <img src="{{ asset($image->image) }}"
                                         class="img-fluid rounded w-100"
                                         style="height:400px; object-fit:cover;">
                                </div>
                            @endforeach
                        </div>
                        <!-- Navigation -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                    <!-- Thumbnails -->
                    <div class="swiper gallery-thumbs">
                        <div class="swiper-wrapper">
                            @foreach($lead->galleryImages as $image)
                                <div class="swiper-slide">
                                    <img src="{{ asset($image->image) }}"
                                         class="img-fluid rounded w-100"
                                         style="height:80px; object-fit:cover;">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @else
                        <p class="text-muted">No gallery images available.</p>
                    @endif

                </div>
            </div>
        </div>

        <!-- Right Lead Info -->
        <div class="col-lg-7">

            <!-- Lead Info Card -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="fw-bold">{{ $lead->fullName }}</h4>
                        <div class="text-muted">
                            <i class="bi bi-telephone"></i> {{ $lead->phone }} &nbsp; | &nbsp;
                            <i class="bi bi-envelope"></i> {{ $lead->email }}
                        </div>
                    </div>
                    @php
                        $color = match($lead->status){
                            'pending'=>'warning',
                            'contacted_by_mail'=>'primary',
                            'contacted_by_message'=>'info',
                            'not_interested'=>'danger',
                            default=>'secondary'
                        };
                    @endphp
                    <span class="badge bg-{{ $color }} fs-6 px-3 py-2">
                        {{ ucfirst(str_replace('_',' ',$lead->status)) }}
                    </span>
                </div>
            </div>

            <!-- Vehicle Info -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted mb-2">Vehicle Information</h6>
                    <div class="row g-2">
                        <div class="col-6"><small>Asset</small><div>{{ $lead->asset->assetType ?? 'N/A' }}</div></div>
                        <div class="col-6"><small>Condition</small><div>{{ $lead->condition->condition ?? 'N/A' }}</div></div>
                        <div class="col-6"><small>Year</small><div>{{ $lead->year }}</div></div>
                        <div class="col-6"><small>Make</small><div>{{ $lead->make }}</div></div>
                        <div class="col-6"><small>Model</small><div>{{ $lead->model }}</div></div>
                        <div class="col-6"><small>Mileage</small><div>{{ $lead->mileage }}</div></div>
                        <div class="col-12"><small>VIN</small><div>{{ $lead->vin }}</div></div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted mb-2">Notes</h6>
                    <p>{{ $lead->notes ?? 'No notes available.' }}</p>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<style>
    .swiper-thumb {
        height: 80px;
    }
    .swiper-thumb .swiper-slide {
        cursor: pointer;
        opacity: 0.6;
    }
    .swiper-thumb .swiper-slide-thumb-active {
        opacity: 1;
        border: 2px solid #0d6efd;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
var galleryThumbs = new Swiper(".gallery-thumbs", {
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
});
var galleryMain = new Swiper(".gallery-main", {
    spaceBetween: 10,
    loop:true,
    autoplay:{
        delay:3000,
        disableOnInteraction:false,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    thumbs: {
        swiper: galleryThumbs,
    },
});
</script>
@endpush
