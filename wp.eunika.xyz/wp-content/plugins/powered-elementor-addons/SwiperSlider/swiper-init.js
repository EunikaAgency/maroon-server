debugger
jQuery(document).ready(function($){
    if(typeof Swiper==='undefined') return;

    if(window.SWIPER_INSTANCES && window.SWIPER_INSTANCES.length){
        window.SWIPER_INSTANCES.forEach(function(uid){
            debugger
            var wrapper = '#' + uid;
            new Swiper(wrapper, {
                loop: true,
                pagination: {el: wrapper + ' .swiper-pagination', clickable:true},
                navigation: {nextEl: wrapper + ' .swiper-button-next', prevEl: wrapper + ' .swiper-button-prev'},
            });
        });
    }
});
