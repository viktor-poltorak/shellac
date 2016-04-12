
var Catalog = Class({
    section: null,
    init: function (section) {
        this.section = $(section);

        this.initSortCategories();

        this.section.find('.remove-category').on('click', function () {
            var href = $(this).data('href');
            if (confirm("Вы действительно хотите удалить категорию?")) {
                document.location = href;
            }
        });
    },
    initSortCategories: function () {
        var that = this;
        this.section.find('.sort-categories').sortable({
            placeholder: "ui-state-highlight",
            axis: "y",
            tolerance: "pointer"
        }).on("sortstop", function (event, ui) {
            that.updateBg();
            that.saveOrder();
        });
    },
    updateBg: function () {
        var items = this.section.find('.sort-categories > div');
        for (var i = 0; i < items.length; i++) {
            $(items[i]).removeClass('gray-bg');
            if (i % 2) {
                $(items[i]).addClass('gray-bg');
            }
        }
    },
    saveOrder: function () {
        var items = this.section.find('.sort-categories > div');
        var orders = [];
        for (var i = 0; i < items.length; i++) {
            orders.push($(items[i]).data('id'));
        }
        $.post('/manager/catalog/update-order', {orders: orders});
    }
});