{{-- @if (!isset($_COOKIE['debugger']))
    <div class="my-3">
        <swiper-container style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="mySwiper"
            thumbs-swiper=".mySwiper2" space-between="10" navigation="true">
            @foreach ($images as $img)
                <swiper-slide>
                    <img src="{{ wp_get_attachment_url($img) }}" attachment-id="{{ $img }}" />
                </swiper-slide>
            @endforeach
        </swiper-container>

        <swiper-container class="mySwiper2" space-between="10" slides-per-view="5" free-mode="true"
            watch-slides-progress="true">
            @foreach ($images as $img)
                <swiper-slide attachment-id="{{ $img }}">
                    <img src="{{ wp_get_attachment_url($img) }}" attachment-id="{{ $img }}" />
                </swiper-slide>
            @endforeach
        </swiper-container>
    </div>

    <style>
        swiper-container {
            width: 100%;
            height: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        swiper-slide {
            background-size: cover;
            background-position: center;
        }

        .mySwiper2 {
            height: 20%;
            box-sizing: border-box;
            padding: 10px 0;
        }

        .swiper-free-mode>.swiper-wrapper {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }

        swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            aspect-ratio: 16/9;
            object-fit: cover;
        }

        .mySwiper2 swiper-slide img {
            cursor: pointer;
        }
    </style>
@endif --}}

<div id="swiper-gallery" class="mt-3 mb-5">
    <div class="swiper-container gallery-top mb-2">
        <div class="swiper-wrapper">

            @foreach ($images as $img)
                <div class="swiper-slide">
                    <img src="{{ wp_get_attachment_url($img) }}" attachment-id="{{ $img }}" />
                </div>
            @endforeach

        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <div class="swiper-container gallery-thumbs">
        <div class="swiper-wrapper">

            @foreach ($images as $img)
                <div class="swiper-slide">
                    <img src="{{ wp_get_attachment_url($img) }}" attachment-id="{{ $img }}" />
                </div>
            @endforeach

        </div>
    </div>
</div>

<style>
    #swiper-gallery {
        width: 100%;
        overflow: hidden !important;
    }

    #swiper-gallery .swiper-container.gallery-top,
    #swiper-gallery .swiper-container.gallery-thumbs {
        position: relative;
        width: 100% !important;
    }

    #swiper-gallery .swiper-container img {
        width: 100% !important;
        object-position: center !important;
        object-fit: cover !important;

    }

    #swiper-gallery .swiper-container.gallery-top img {
        aspect-ratio: 16/9 !important;
    }

    #swiper-gallery .swiper-container.gallery-thumbs img {
        aspect-ratio: 1/1 !important;
        cursor: pointer;
    }

    #swiper-gallery .swiper-container .swiper-button-next,
    #swiper-gallery .swiper-container .swiper-button-prev {
        color: white !important;
    }
</style>

<script>
    var galleryTop;
    var galleryThumbs;

    jQuery(document).ready(function() {
        galleryTop = new Swiper('.gallery-top', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        galleryThumbs = new Swiper('.gallery-thumbs', {
            spaceBetween: 10,
            slidesPerView: 5,
            // freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
        });

        galleryThumbs.on('click', function() {
            var clickedIndex = galleryThumbs.clickedIndex;
            galleryTop.slideTo(clickedIndex);
        });

        galleryTop.controller.control = galleryThumbs;
        galleryThumbs.controller.control = galleryTop;
    });
</script>
