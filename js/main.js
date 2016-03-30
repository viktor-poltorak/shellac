var Class = function (methods) {
    var baseClass = function () {
        this.init.apply(this, arguments);
    };

    for (var property in methods) {
        baseClass.prototype[property] = methods[property];
    }

    if (!baseClass.prototype.init)
        baseClass.prototype.init = function () {};

    return baseClass;
};

$(document).ready(function () {
    $('#order_first').click(function () {
        $(this).hide();
        $('#order_second').show();
    })

    if (typeof slides == 'undefined') {
        return;
    }

    $('#for_healh').bind('mouseenter', function () {
        $('#mainBanner').css('background-image', 'url("' + slides.bannerOne + '")');
    });

    $('#for_office').bind('mouseenter', function () {
        $('#mainBanner').css('background-image', 'url("' + slides.bannerTwo + '")');
    });
});
if (typeof slides !== 'undefined') {
    image1 = new Image();
    image1.src = slides.bannerOne;
    image2 = new Image();
    image2.src = slides.bannerTwo;
}