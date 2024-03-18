

$(document).ready(function() {
    $('#about').click(function() {
        if($('#search-desktop').css('display') !== 'none') {
            $('#search-desktop').slideToggle();
        }
        $('.about-panel').slideToggle()
        $('#fix-about-nav').toggleClass('d-none')
    });

    $('#fix-about-nav').click(function() {
        $(this).addClass('d-none')
        $('.about-panel').slideToggle()
    });

    $('.blogs-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        dots: true,
        autoplay: true,
        autoplaySpeed: 10000,
        infinite: true,
    });

    $('.teachers').slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        arrows: false,
        dots: true,
        autoplay: true,
        autoplaySpeed: 12000,
        infinite: true,
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 2,
                    arrows: false,
                    dots: true,
                    infinite: true
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    arrows: false,
                    dots: true,
                    infinite: true
                }
            }
        ]
    });

    $('.blogs').slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        arrows: false,
        dots: true,
        autoplay: true,
        autoplaySpeed: 12000,
        infinite: true,
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    arrows: false,
                    dots: true,
                    infinite: true
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    dots: true,
                    infinite: true
                }
            }
        ]
    });

    
    $('.count-data').slick({
        slidesToShow: 4,
        slidesToScroll: 2,
        arrows: false,
        speed: 750,
        dots: true,
        autoplay: true,
        autoplaySpeed: 12000,
        infinite: true,
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    arrows: false,
                    dots: true,
                    infinite: true
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    dots: true,
                    infinite: true
                }
            }
        ]
    });

    $('#search-toggle').click(function() {
        $('#search-desktop').slideToggle();
        if($('.about-panel').css('display') !== 'none') {
            $('.about-panel').slideToggle()
            $('#fix-about-nav').toggleClass('d-none')    
        }
        // $('#search-toggle').toggleClass('text-warning');
    });

    $('#toggle-menu-profile').click(function() {
        $('.menu-profile').slideToggle()
    });

    var width = $(window).width()
    console.log('Width App : ' + width)
    if(width < 992) {
        $(window).scroll(function() {
            var top = window.pageYOffset || document.documentElement.scrollTop
            if(top > 741) {
                $('#toggle-menu-profile').addClass('menu-profile-fix')
            } else {
                $('#toggle-menu-profile').removeClass('menu-profile-fix')
            }
        });
    }

    $('.list-learning').click(function() {
        if($(this).find('.material-learning').css('display') == 'none') {
            $(this).find('.material-learning').slideDown();
            $(".list-learning").not(this).find('.material-learning').slideUp();
            $(this).parent().addClass('active-learning')
            $(".list-learning").not(this).parent().removeClass('active-learning');
        }
    });

    $('.data-learning').click(function() {
        $('.material-learning').slideUp();
    });
});