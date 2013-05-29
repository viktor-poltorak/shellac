$(document).ready(function(){
    $('#for_healh').bind('mouseenter', function(){       
        $('#mainBanner').css('background-image', 'url("../images/banner-one.png")');
    });

    $('#for_office').bind('mouseenter', function(){
        $('#mainBanner').css('background-image', 'url("../images/banner-two.png")');
    });

    $('#order_first').click(function(){
        $(this).hide();
        $('#order_second').show();
    })
});

image1 = new Image();
image1.src = '/images/banner-one.png';
image2 = new Image();
image2.src = '/images/banner-two.png';