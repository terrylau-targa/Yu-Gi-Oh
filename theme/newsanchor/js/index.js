;(function($) {

    var width = $( window ).width();

    var limit_word;

    if (width > 1199) {
        limit_word = 44;
    } else if (width < 1199 || width > 767) {
        limit_word = 35;
    } else {
        limit_word = 44;
    }

    // ARTICLE SLIDER
    $('.owl-carousel.article-slider_js').on('initialized.owl.carousel changed.owl.carousel', function(e) {
        if (!e.namespace)  {
            return;
        }
        var carousel = e.relatedTarget;
        $('.slider-counter').text(carousel.relative(carousel.current()) + 1 + ' of ' + carousel.items().length);
    }).owlCarousel({
        loop: true,
        items: 1,
        nav: true,
        dots: false,
        navContainer: '.custom-nav',
        navText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"]
    });

    var postsCarousel = function() {
        if ( $().owlCarousel ) {
            var container = $('.roll-posts-carousel');
            var imgLoad = imagesLoaded(container);
            imgLoad.on( 'always', function() {
                container.each(function(){
                    var $this = $(this);
                    $this.find('.owl-carousel').owlCarousel({
                        autoplay: $this.data('auto'),
                        //autoplay: false,
                        loop: true,
                        margin: 4,
                        dots: false,                        
                        nav: true,
                        autoplayTimeout: $this.data('speed'),
                        autoHeight: true,
                        navText: [ '<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>' ],
                        responsive:{
                            0:{
                                items: 1,
                                margin: 5,
                                stagePadding: 50,
                                singleItem: true,
                                dots: true
                            },
                            768:{
                                items: 1,
                                margin: 5,
                                stagePadding: 100,
                                singleItem: true,
                                dots: true
                            },
                            991:{
                                items: $this.data('items')
                            }
                        },
                        onInitialized: startProgressBar,
                        onTranslate: resetProgressBar,
                        onTranslated: startProgressBar
                    });
                });
            });
        } // end if
    };


    function carouselAutoplay() {
        if ($('#carousel')) {
            if (width > 767) {
                $('#carousel').attr('data-auto', 'false');
            } else {
                $('#carousel').attr('data-auto', 'true');
            }
        }
    }

    function startProgressBar() {
        // apply keyframe animation
        $(".owl-dots").css({
            width: "100%",
            transition: "width 4000ms"
        });
    }

    function resetProgressBar() {
        $(".owl-dots").css({
            width: 0,
            transition: "width 0s"
        });
    }


    function setThumbheight() {
        if (width > 767) {
            $('.page-content .tab-container .post-content .column.left').css('height', 0);
            var heightTotal = 0;
            $('.page-content .tab-container .post-tab .tab-item').each(function() {
                heightTotal += $(this).height();
            });

            var rightHeight = $('.page-content .tab-container .post-content .column.right').height();

            if (heightTotal > rightHeight) {
                $('.page-content .tab-container .post-content .column.left').css('height', heightTotal);
            } else {
                $('.page-content .tab-container .post-content .column.left').css('height', rightHeight);
            }
        }
    }

    function trimString(targetClass, limit) {
        var ObjNum = $(targetClass).length;

        $(targetClass).each(function(index, obj) {
            var trimmedString = $(this).text().substr(0, limit);
            var lastSpacing = trimmedString.lastIndexOf(" ");
            var outer = $(this).text().substr(limit, $(this).text().length);

            if ($(this).text().length > limit && lastSpacing > 0) {
                
                if (outer.indexOf(" ") != 0) {
                    trimmedString = trimmedString.substr(0, Math.min(trimmedString.length, lastSpacing));
                    outer = $(this).text().substr(lastSpacing , $(this).text().length);
                } else {
                    //outer = outer.substr(trimmedString.length, $(this).length);
                }

                $(this).html(trimmedString + ' ...<p class="hidden-text">' + outer + '</p>');
            }
        });
    }


    // DOM Ready
    $(function() {
        postsCarousel();
        setThumbheight();
        carouselAutoplay();
        trimString(".title-right-side", 35);
        trimString(".column.right>.title-category>h3>a", 60);
        trimString(".carousel-title>a", limit_word);
    });

})(jQuery);