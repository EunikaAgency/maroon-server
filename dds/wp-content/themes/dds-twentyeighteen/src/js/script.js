$(document).ready(function(){
  // Add scrollspy to <body>
  $('body').scrollspy({target: ".site", offset: 50});   

  // Add smooth scrolling on all links inside the navbar
  $(".site-cta-btn").on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
      $('.cbp-spmenu-vertical').removeClass("cbp-spmenu-open");
      $('.nav-icon3').toggleClass("open");
    }  // End if
  });
});
  
(function($, window, undefined) {
    'use strict'
    var $body = $('body')
    
    $(document).ready(function() {
        
    var $mm = $body.find('#cbp-spmenu-s2')
    var $dm = $mm.find('ul > li')
    $dm.each(function(i) {
      $(this)
        .find('.sub-menu')
        .parent()
        .prepend(
          '<input type="checkbox" name="accordion" id="acc-' +
            i +
            '"/><label for="acc-' +
            i +
            '"></label>'
        )
    }) // Document Ready
        
    });
    
  var beloSidebar = {
    INIT: function() {
      $('.dds-sidebar .dds-sidebar__content').on('click', function(e) {
        $(this).siblings('.dds-sidebar__content-list').toggleClass('open');
      });
      $('.dds-sidebar .dds-sidebar__content-item').on('click', function (e) {
        $(this).siblings('.dds-sidebar__content-item__list').toggleClass('open');
      });

    }
  }

  beloSidebar.INIT();

  // Toggle keyboard navigation focus outline
  var toggleKeyboardNav = (function() {
    $(document).on('keydown', function(e) {
      var bodyClass = 'keyboard-in-use';
      if (e.key === 'Tab') {
        $('body').addClass(bodyClass);
      } else {
        $('body').removeClass(bodyClass);
      }
    });

    $(document).on('click', function(e) {
      var bodyClass = 'keyboard-in-use';
      $('body').removeClass(bodyClass);
    });
  })();

  // Superfish menu navigation using keyboard
  $('.primary-menu').superfish({
    animation: { opacity: 'show' },
    speed: 200,
    delay: 400,
    cssArrows: false
  });

  $('.collapse').on('shown.bs.collapse', function(){
    $(this).parent().find(".panel-title").addClass("panel-title-bold");
      }).on('hidden.bs.collapse', function(){
    $(this).parent().find(".panel-title").removeClass("panel-title-bold");
  });

  // $(".archive-month .archive-blogs").hide();
  // $(".archive-month").click(function() {
  //   $(this).siblings(".archive-blogs").toggle();
  // });

  // $( ".archive-month" ).toggle(
  //   function() {
  //     $(this).parent().find('.archive-blogs').addClass( "d-flex" );
  //   }, function() {
  //     $(this).parent().find('.archive-blogs').removeClass( "d-flex" );
  //   }
  // );


  // Menu navigation desktop
  var toggleShrink = (function() {

  })();
  highLightList()
})(jQuery, window, undefined);

function highLightList() {
  var list = document.getElementsByClassName('highlight_list_title')

      Object.keys(list).map(function(e) {

          list[e].addEventListener('click', function(event){

            if(list[e].classList.contains('collapsed')){
              list[e].childNodes[1].classList.add('font-weight-bold')
              list[e].children[1].children[0].src = '/wp-content/themes/dds-twentyeighteen/src/images/close.png';

            }else{
              list[e].children[0].classList.remove('font-weight-bold')
              list[e].children[1].children[0].src = '/wp-content/themes/dds-twentyeighteen/src/images/dropdown.png';

            }

          })
      })
}