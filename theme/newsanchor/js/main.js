
;(function($) {

    'use strict'
 
    var width = $( window ).width();
    var feature1 = document.querySelectorAll('.feature-1');
    Array.prototype.forEach.call( feature1, function (f1) {
        f1.classList.add('active');
    });
 
    var childCat = document.querySelectorAll('.child-category');
    if ( childCat ) {
        Array.prototype.forEach.call(childCat, function(cc) {
             var catAttr = cc.getAttribute('data-cat');
             var ccChilds =  document.querySelectorAll('.child-category li a')
             Array.prototype.forEach.call(ccChilds, function(ccs) {
                 var innerValue = ccs.innerHTML;
                 if ( ccs.innerHTML.indexOf(catAttr) != -1){
                     ccs.parentNode.classList.add('active');
                  }
            });
        });
    }    
   
     var responsiveMenu = function() {
         var	menuType = 'desktop';
 
         $(window).on('load resize', function() {
             var currMenuType = 'desktop';
 
             if ( matchMedia( 'only screen and (max-width: 991px)' ).matches ) {
                 currMenuType = 'mobile';
             }
 
             if ( currMenuType !== menuType ) {
                 menuType = currMenuType;
 
                 if ( currMenuType === 'mobile' ) {
                     $('.btn-menu').removeClass('active');
                 } else {
                     var $desktopMenu = $('#mainnav-mobi').attr('id', 'mainnav').removeAttr('style');
                     $desktopMenu.find('.sub-menu').removeAttr('style');
                 }
             }
         });
 
     }
 
     var responsiveVideo = function(){
         if ( $().fitVids ) {
             $('body').fitVids();
         }
     };
 
 
    function paginationHTML() {
        if ($('.page-numbers')) {
            $('.page-numbers').each(function() {
                var html = $(this).html();
                $(this).html('<div>' + html + '</div>');
            });
        }
    }

    function assignMoreCateIcon() {
        if ($('#mainnav') && width > 767) {
            $('#mainnav').children().children('.menu-item').each(function() {
                var cate = $(this).children().html();
                if (cate == 'More' || cate == 'MORE') {
                    cate = '<span>' + cate  + '</span>' + '<div class="more-toggle-icon"><span></span><span></span><span></span></div>';
                    $(this).children().html(cate);
                }
            });
        }
    }
 
     var goTop = function() {
         $(window).scroll(function() {
             if ( $(this).scrollTop() > 600 ) {
                 $('.go-top').addClass('show');
             } else {
                 $('.go-top').removeClass('show');
             }
         }); 
 
         $('.go-top, .go-top2').on('click', function() {
             $("html, body").animate({ scrollTop: 0 }, 1000);
             return false;
         });
 
         $(window).on('load scroll', function() {
             $('.go-top2').each(function(e) {
                 if ( this.getBoundingClientRect().top < $(window).height() ) {
                     $('.go-top').addClass('hide');
                     $('.go-top2').addClass('show');
                 } else {
                     $('.go-top').removeClass('hide');
                     $('.go-top2').removeClass('show');
                 }
             })
         }) 
     };
 
     var removePreloader = function() {
         $('.preloader').css('opacity', 0);
         setTimeout(function(){$('.preloader').hide();}, 600);	
     }
 
     //Header search
     $('.search-btn').on('click', function() {
         $('.search-panel').slideToggle(300);
         $(this).toggleClass('active');
     });
 
     //Nav toggle
     $('#nav-toggle').on('click', function() {
         $('#mobile-menu').slideToggle(300);
 
         if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $("body").css('overflow','scroll');
         } else {
            $(this).toggleClass('active');
            $("body").css('overflow','hidden');
         }
     });
     
 
     //Mobile menu
     $('#mobile-category #primary-menu >.menu-item-has-children').append('<div class="cate-toogle"></div>');
 
     $('.cate-toogle').on('click', function() {
         console.log('Layer1');
         if ($(this).parent().hasClass('active')) {
             $(this).removeClass('open');
             $(this).parent().removeClass('active');
         } else {
             $(this).addClass('open');
             $(this).parent().addClass('active');
         }
     });
 
     $('#mobile-category #primary-menu .sub-menu > .menu-item-has-children').append('<div class="subcate-toogle"><span></span><span></span></div>');
 
     $('.subcate-toogle').on('click', function() {
         console.log('Layer2');
         if ($(this).parent().hasClass('active')) {
             $(this).removeClass('open');
             $(this).parent().removeClass('active');
         } else {
             $(this).addClass('open');
             $(this).parent().addClass('active');
         }
     });
 

    function mailHTML() {
        var desktopHTML = $('#mailpoet_form_1 form.mailpoet_form').html();

        var title = '<div class="title"><div class="mail-icon"><img src="https://facts.net/wp-content/themes/newsanchor/images/subscribe-logo.png"></div><h4>SUBSCRIBE TO OUR NEWSLETTER</h4></div>';
        var mobileHTML = title + '<div class="one-tap-btn"><a href="mailto:webmaster@facts.net"><div>Subscribe Now</div></a></div>';

        if (width > 767) {
            $('#mailpoet_form_1 form.mailpoet_form').html(desktopHTML);
            console.log("desktop");
        } else {
            $('#mailpoet_form_1 form.mailpoet_form').html(mobileHTML);
            console.log("mobile");
        }
    }

     // DOM Ready
     $(function() {
        responsiveMenu();
        responsiveVideo();
        goTop();     
        removePreloader();
        paginationHTML();
        assignMoreCateIcon();
        mailHTML();
    });
 
})(jQuery);
