
var Products = Class({
    section: null,
    init: function (section) {
        this.section = $(section);

        this.initSortCategories();
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
    }
});