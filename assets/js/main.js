/**
  * isMobile
  * flatRetinaLogo
  * flatCounter
  * goTop
  * removePreloader
  * flatPrice
  * flatFilterBox
  * flatShopSearch
  * flexProduct
  * quantityNumber
  * flatTabs
  * flatImagePopup
  * flatVideoPopup
  * flatEffectDir
  * searchIcon
  * headerFixed
  * responsiveMenu
  * flatContentBox
  * swClick
*/

;(function($) {

   'use strict'

    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    var flatRetinaLogo = function() {
        var retina = window.devicePixelRatio > 1 ? true : false;
        var $logo = $('#logo img');
        var $logo_retina = $logo.data('retina');

        if ( retina && $logo_retina ) {
            $logo.attr({
                src: $logo.data('retina'),
                width: $logo.data('width'),
                height: $logo.data('height')
            });
        }
    };


    var flatCounter = function() {       
        $('.flat-counter').on('on-appear', function() {             
            $(this).find('.numb-count').each(function() { 
                var to = parseInt( ($(this).attr('data-to')),10 ), speed = parseInt( ($(this).attr('data-speed')),10 );
                if ( $().countTo ) {
                    $(this).countTo({
                        to: to,
                        speed: speed
                    });
                }
            });
       });
    }; 

  

    var goTop = function() {
      $(window).scroll(function() {
          if ( $(this).scrollTop() > 800 ) {
              $('.go-top').addClass('show');
          } else {
              $('.go-top').removeClass('show');
          }
      }); 

      $('.go-top').on('click', function() {            
          $("html, body").animate({ scrollTop: 0 }, 1000 , 'easeInOutExpo');
          return false;
      });
    };


    var removePreloader = function() {        
        $(window).on("load", function () {
            $(".loader").fadeOut();
            $("#loading-overlay").delay(500).fadeOut('slow',function(){
            $(this).remove();
            }); 
      });
    };

    var flatPrice = function() {
        if( $().slider ) {
            $( function() {
                $( "#slide-range" ).slider({
                  range: true,
                  min: 0,
                  max: 2900,
                  values: [ 0, 2900 ],
                  slide: function( event, ui ) {
                    $( "#amount" ).val( "$" + ui.values[ 0 ] + ".00" + " - " + "$" + ui.values[ 1 ] + ".00" );
                  }
                });
                $( "#amount" ).val( $( "#slide-range" ).slider( "values", 0 ) + "$" + " - " + $( "#slide-range" ).slider( "values", 1 ) + "$" );
            });
        }
    };

    var flatFilterBox = function(){
        $('.box-filter').hide();
        $('.show-filter').on('click',function(){
            $('.box-filter').slideToggle(1000);
            $('.filter-shop li.filter-list').toggleClass('active');
            $(this).toggleClass('active');
        });
        $('.box-filter .btn-close').on('click',function(){
            $('.box-filter').slideToggle(1000);
            $('.show-filter').removeClass('active');
            $('.filter-shop li.filter-list').removeClass('active');
        });
    };

    var flatShopSearch = function(){
        $('.shop-search').hide();
        $('.search-product').on('click',function(){
            $('.shop-search').slideToggle(1000);
            $(this).toggleClass('active');
        });
    };

    var flexProduct = function() {
        $('.flexslider').flexslider({
            animation: "slide",
            controlNav: "thumbnails"
        });
    }; 

    var quantityNumber = function(){
        $('.quantity-button').on('click', function(){
            var numberValue= $(this).parent().find('.quantity-number').val();

            if($(this).text()=="+") {
                var newVal=parseFloat(numberValue) + 1;
            }else{
                if(numberValue > 0){
                    var newVal = parseFloat(numberValue) -1;
                }else{
                    newVal = 0;
                }
            }

            $(this).parent().find('.quantity-number').val(newVal);
        });
    };

    var flatTabs=function(){
        $('.flat-tabs').each(function(){
            $(this).find('.content-tab').children().hide();
            $(this).find('.content-tab').children().first().show();
            $(this).find('.menu-tab').children('li').on('click',function(){
                var liActive = $(this).index();
                var contentActive=$(this).siblings().removeClass('active').parents('.flat-tabs').find('.content-tab').children().eq(liActive);
                contentActive.addClass('active').fadeIn("slow");
                contentActive.siblings().removeClass('active');
                $(this).addClass('active').parents('.flat-tabs').find('.content-tab').children().eq(liActive).siblings().hide();
            });
        });
    };

    var flatImagePopup = function(){
        if($().magnificPopup) {
            $('.flat-icon').each(function(){
                $(this).find('.zoom-popup').magnificPopup({
                    disableOn: 700,
                    type: 'image',
                    gallery:{
                        enabled: true
                    },
                    mainClass: 'mfp-fade',
                    removalDelay: 160,
                    preloader: false,
                    fixedContentPos: true
                });
            });
        };
    };

    var flatVideoPopup = function() {
        if ( $().magnificPopup ) {
            $('.popup-video').magnificPopup({
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: true
            });
        };
    };

    var flatEffectDir = function(){
        if($().hoverdir){
            $('.data-effect').each(function(){
                $(this).find('.data-effect-item').hoverdir({
                    hoverDelay: 15,
                    hoverElem: '.overlay-effect'
                })
            })
        };
    };

  
    var searchIcon = function () {
        $(document).on('click', function(e) {   
            var clickID = e.target.id;   
            if ( ( clickID !== 'input-search' ) ) {
                $('.header-search-form').removeClass('show');                
            } 
        });

        $('.header-search-icon').on('click', function(event){
            event.stopPropagation();
        });

        $('.header-search-form').on('click', function(event){
            event.stopPropagation();
        });        

        $('.header-search-icon').on('click', function (event) {
            if(!$('.header-search-form').hasClass( "show" )) {
                $('.header-search-form').addClass('show'); 
                event.preventDefault();                
            }
            else {
                $('.header-search-form').removeClass('show');
                event.preventDefault();
            }
        });

        // Accessibility: open search form on Enter or Space key
        $('.header-search-icon').on('keydown', function(event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                if (!$('.header-search-form').hasClass('show')) {
                    $('.header-search-form').addClass('show');
                } else {
                    $('.header-search-form').removeClass('show');
                }
            }
        });

        $('.header-search-icon').on('focus', function() {
            $('.header-search-form').addClass('show');
        });
        $('.header-search-icon').on('blur', function() {
            $('.header-search-form').removeClass('show');
        });
    };  

    var headerFixed = function(){
        if($('body').hasClass('header_sticky')){
            var nav = $('#header');

            if( nav.length ){
                var offsetTop = nav.offset().top,
                headerHeight = nav.height(),
                injectSpace = $('<div/>', {
                    height: headerHeight
                }).insertAfter(nav);

                $(window).on('load scroll', function(){
                    if($(window).scrollTop() > offsetTop){
                        nav.addClass('is-fixed');
                        injectSpace.show();
                    }else {
                        nav.removeClass('is-fixed');
                        injectSpace.hide();
                    }

                    if($(window).scrollTop() > 300 ) {
                        nav.addClass('is-small');
                    }else {
                        nav.removeClass('is-small');
                    }
                });
            }
        };
    };

    var responsiveMenu = function() {

        var menuType = 'desktop';



        $(window).on('load resize', function() {

            var currMenuType = 'desktop';



            if ( matchMedia( 'only screen and (max-width: 991px)' ).matches ) {

                currMenuType = 'mobile';

            }



            if ( currMenuType !== menuType ) {

                menuType = currMenuType;



                if ( currMenuType === 'mobile' ) {

                    var $mobileMenu = $('#mainnav').attr('id', 'mainnav-mobi').hide();

                    var hasChildMenu = $('#mainnav-mobi').find('li:has(ul)');



                    $('#header #site-header-inner').after($mobileMenu);

                    hasChildMenu.children('ul').hide();

                    hasChildMenu.children('a').after('<span class="btn-submenu"></span>');

                    $('.btn-menu').removeClass('active');

                } else {

                    var $desktopMenu = $('#mainnav-mobi').attr('id', 'mainnav').removeAttr('style');



                    $desktopMenu.find('.submenu').removeAttr('style');

                    $('#header').find('.nav-wrap').append($desktopMenu);

                    $('.btn-submenu').remove();

                }

            }

        });



        $('.mobile-button').on('click', function() {         

            $('#mainnav-mobi').slideToggle(300);

            $(this).toggleClass('active');

        });



        $(document).on('click', '#mainnav-mobi li .btn-submenu', function(e) {

            $(this).toggleClass('active').next('ul').slideToggle(300);

            e.stopImmediatePropagation()

        });

    };

 
    var flatContentBox = function(){
        $(window).on('load resize', function(){
            var mode = 'desktop';

            if(matchMedia(' only screen and (max-width: 991px').matches){
                mode = 'mobile';
            }

            $('.flat-content-box').each(function(){
                var margin = $(this).data('margin');

                if( margin ){
                    if(mode == 'desktop') {
                        $(this).attr('style','margin:'+ $(this).data('margin'))
                    }else if( mode == 'mobile') {
                        $(this).attr('style','margin' + $(this).data('mobilemargin'))
                    }
                }
            });
        });
    };

    var swClick = function () {
        function activeLayout () {
            $(".switcher-container" ).on( "click", "a.sw-light", function() {
                $(this).toggleClass( "active" );
                $('body').addClass('home-boxed');  
                $('body').css({'background': '#f6f6f6' });                
                $('.sw-pattern.pattern').css ({ "top": "100%", "opacity": 1, "z-index": "10"});
            }).on( "click", "a.sw-dark", function() {
                $('.sw-pattern.pattern').css ({ "top": "98%", "opacity": 0, "z-index": "-1"});
                $(this).removeClass('active').addClass('active');
                $('body').removeClass('home-boxed');
                $('body').css({'background': '#fff' });
                return false;
            })       
        }        

        function activePattern () {
            $('.sw-pattern').on('click', function () {
                $('.sw-pattern.pattern a').removeClass('current');
                $(this).addClass('current');
                $('body').css({'background': 'url("' + $(this).data('image') + '")', 'background-size' : '30px 30px', 'background-repeat': 'repeat' });
                return false
            })
        }

        activeLayout(); 
        activePattern();
    }; 
    
   	// Dom Ready
	$(function() {
      removePreloader();
      goTop();
      flatRetinaLogo();
      searchIcon();
      headerFixed();
      responsiveMenu();
      swClick();
      flatCounter();
      flatPrice();  
      flatFilterBox(); 
      flatShopSearch();
      flexProduct(); 
      quantityNumber(); 
      flatTabs();
      flatImagePopup();
      flatVideoPopup(); 
      flatEffectDir();
      flatContentBox();
   	});
})(jQuery);