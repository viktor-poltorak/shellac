
var Products = Class({
    section: null,
    init: function (section) {
        this.section = $(section);
        this.initSortCategories();

        var that = this;
        this.section.find('.toggle-product').on('click', function () {
            that.toggleProduct($(this));
        });

        this.section.find('.manager-list-save-price').on('click', function () {
            var button = $(this);
            that.savePrice(button);
        });

        this.section.find('.manager-list-product-price').on('keyup', function () {
            $(this).parent().find('.manager-list-save-price').prop('disabled', false);
        });
    },
    initSortCategories: function () {
        var that = this;
        this.section.find('.sort-products').sortable({
            placeholder: "ui-state-highlight",
            axis: "y",
            tolerance: "pointer"
        }).on("sortstop", function (event, ui) {
            that.updateBg();
            that.saveOrder();
        });
    },
    updateBg: function () {
        var items = this.section.find('.sort-products > div');
        for (var i = 0; i < items.length; i++) {
            $(items[i]).removeClass('gray-bg');
            if (i % 2) {
                $(items[i]).addClass('gray-bg');
            }
        }
    },
    saveOrder: function () {
        var items = this.section.find('.sort-products > div');
        var orders = [];
        for (var i = 0; i < items.length; i++) {
            orders.push($(items[i]).data('id'));
        }
        $.post('/manager/products/update-order', {orders: orders});
    },
    toggleProduct: function (item) {
        var id = item.data('id');
        $.post('/manager/products/toggle-product', {id: id}, function (response) {
            var image = '/images/admin/star-off.png';
            if (response.visible == 1) {
                image = '/images/admin/star.png';
            }
            if (response.status) {
                item.find('img').attr('src', image);
            }
        });
    },
    savePrice: function (button) {
        button.prop('disabled', true);
        var row = $(button).closest('.manager-list');
        var id = row.data('id');
        var price = row.find('.manager-list-product-price').val();

        $.post('/manager/products/save-price', {id: id, price: price}, function (response) {
            button.prop('disabled', true);
        }).error(function () {
            alert('Ошибка при сохранении');
        });

    }
});