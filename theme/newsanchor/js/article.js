;(function($) {
    var screen_sm = 767;
    var screen_xs = 425;

    var width = $( window ).width();

    var headerHeight = $("#header").height() + $("header.entry-header").height() + 45;
    var scrollPosition;

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

    var carousel = $(".image-carousel");
    carousel.owlCarousel(options);

    var currentPicks = 0;
    var totalPicks = $('.promote-product').find('.item').length;

    //Set start number of carousel
    $(".carousel-counter").each(function(){
        var totalItem = $(this).next(".image-carousel").find('.owl-item').length;
        console.log('1 of ' + totalItem);
        $(this).html('1 of ' + totalItem);
    });

    // Listen to owl events:
    carousel.on('changed.owl.carousel', function(event) {
        var totalItem = event.item.count;
        var currentItem = event.item.index + 1;

        console.log(currentItem + ' of ' + totalItem);
        $(this).prev('.carousel-counter').html(currentItem + ' of ' + totalItem);
    });

    $('#content-btn').click(function(){
        if ($(this).hasClass('close')) {
            $(this).removeClass('close');
            $(this).addClass('open');
        } else {
            $(this).removeClass('open');
            $(this).addClass('close');
        }

        $('#contents-block').toogle();
    });
    

    function CheckWidth() {
        if (width < 767) {
            console.log(currentPicks);
            $('.item').hide();
            $('.item').eq(currentPicks).show();
            productBtn();
            
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
            console.log();
            $('.item').show();
            $('#pre-picks').hide();
            $('#next-picks').hide();
        }
    }

    function productBtn() {
        $('#pre-picks').click(function(){
            $('#next-picks').show();
            if (currentPicks > 0) {
                currentPicks --;
                showPicks(currentPicks);
            }

            if (currentPicks == 0) {
                $(this).hide();
            }
        });

        $('#next-picks').click(function(){
            $('#pre-picks').show();
            console.log(totalPicks);
            if (currentPicks < totalPicks-1) {
                currentPicks ++;
                showPicks(currentPicks);
            }

            if (currentPicks == totalPicks-1) {
                $(this).hide();
            }
        });
    }

    function showPicks(index) {
        console.log(currentPicks);
        $('.item').hide();
        $('.item').eq(index).show();
    }

    $(function() {
        tocScrollTop();
        CheckWidth();
    });

    $(window).resize(function() {
        width = $( window ).width();
        CheckWidth();
    });


    $(window).scroll(function() {
        scrollPosition = $(document).scrollTop();
        if (scrollPosition > headerHeight) {
            
        } else {
            
        }
    });

    var tocScrollTop = function() {
        //Add title of share button
        var content_share = '<div class="share-title">Share this Fact: </div>' + $('.addtoany_content_bottom').html();
        $('.addtoany_content_bottom').html(content_share);

        $('a').click(function() {
            var href = $(this).attr('href');
            $([document.documentElement, document.body]).animate({
                scrollTop: $(href).offset().top -50
            }, 300);
        });
    }


})(jQuery);


