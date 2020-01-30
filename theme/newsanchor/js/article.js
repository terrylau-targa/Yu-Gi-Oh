;(function($) {
    var screen_sm = 767;
    var screen_xs = 425;

    var width = $( window ).width();

    var currentPicks = 0;
    var totalPicks = $('.promote-product').find('.item').length;

    var options = {
        items: 1,
        center: true,
        loop: false,
        lazyLoad: true,
        autoHeight: false,
        autoplay: false,
        autoplayTimeout: 1000,
        autoplayHoverPause: true,
        nav: true,
        dots: false,
        dotsData: true,
        info: true,
    }

    var carousel = $(".owl-carousel");
    carousel.owlCarousel(options);

    var currentPicks = 1;
    var totalPicks = $('.promote-product').find('.item').length;

    //Set start number of carousel
    $(".carousel-counter").each(function(){
        var target = $(this).data("productid");
        var totalItem = $('#product-' + target).find('.owl-item').length;
        $(this).html('1 of ' + totalItem);
    });

    // Listen to owl events:
    carousel.on('changed.owl.carousel', function(event) {
        var totalItem = event.item.count;
        var currentItem = event.item.index + 1;
        var target = $(this).attr('id').split("-");

        console.log('.carousel-counter[data-productid="' + target[1] + '"] :' + currentItem + ' of ' + totalItem);
        $('.carousel-counter[data-productid="' + target[1] + '"]').html(currentItem + ' of ' + totalItem);
    });
    

    function CheckWidth() {
        if ($('.promote-product>.item').length) {
            $('.code-block-7').remove();
            
            if (width < 767) {
                $('.item').hide();
                $('.item').eq(currentPicks).show();

                if (currentPicks == 0) {
                    $('#pre-picks').hide();
                    $('#next-picks').show();
                } else if (currentPicks == totalPicks-1) {
                    $('#pre-picks').show();
                    $('#next-picks').hide();
                } else {
                    $('#pre-picks').show();
                    $('#next-picks').show();
                }
            } else {
                $('.item').show();
                $('#pre-picks').hide();
                $('#next-picks').hide();
            }
        } else {
            $('.promote-wrapper').remove();
        }
    }

    function productBtn() {
        $('#pre-picks').click(function(){
            $('#next-picks').show();
            if (currentPicks > 0) {
                currentPicks -= 1;
                showPicks(currentPicks);
            }

            if (currentPicks == 0) {
                $(this).hide();
            }
            console.log("currentPicks = " + currentPicks);
        });

        $('#next-picks').click(function(){
            $('#pre-picks').show();
            if (currentPicks < totalPicks) {
                currentPicks += 1;
                showPicks(currentPicks);
            }

            if (currentPicks == totalPicks-1) {
                $(this).hide();
            }
            console.log("currentPicks = " + currentPicks);
        });
    }

    function showPicks(index) {
        $('.item').hide();
        $('.item').eq(index).show();
    }

    function imageLabel() {
        var imageHTML;
        var imageLink;
        var imageCaption;

        $('.product-paragraph img').each(function() {
            if ($(this).hasClass('product-gallery-image')) {
                imageLink = $(this).parents('.product-paragraph').attr('data-link');
                imageHTML = $(this).prop("outerHTML");
                imageCaption = $(this).parent().find('figcaption').prop("outerHTML");

                $(this).parent().html('<div class="image-wrapper">' + imageHTML + '<a href="' + imageLink +'"><div class="image-labels">Read More Reviews <i class="fas fa-arrow-right"></i></div></a></div>' + imageCaption);
            }
        });
    }

    $(function() {
        CheckWidth();
        productBtn();
        imageLabel();
    });

    $(window).resize(function() {
        width = $( window ).width();
        CheckWidth();
    });



})(jQuery);