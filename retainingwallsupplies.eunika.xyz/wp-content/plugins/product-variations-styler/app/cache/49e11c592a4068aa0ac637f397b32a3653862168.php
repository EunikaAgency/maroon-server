

<div id="swiper-gallery" class="mt-3 mb-5">
    <div class="swiper-container gallery-top mb-2">
        <div class="swiper-wrapper">

            <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="swiper-slide">
                    <img src="<?php echo e(wp_get_attachment_url($img)); ?>" attachment-id="<?php echo e($img); ?>" />
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <div class="swiper-container gallery-thumbs">
        <div class="swiper-wrapper">

            <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="swiper-slide">
                    <img src="<?php echo e(wp_get_attachment_url($img)); ?>" attachment-id="<?php echo e($img); ?>" />
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
