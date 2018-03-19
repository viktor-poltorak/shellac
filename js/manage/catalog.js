
var Catalog = Class({
    section: null,
    init: function (section) {
        this.section = $(section);

        this.initSortCategories();

        var that = this;
        this.section.find('.toggle-category').on('click', function () {
            that.toggleCategory($(this));
        });

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
    },
    toggleCategory: function (item) {
        var id = item.data('id');
        $.post('/manager/catalog/toggle', {id: id}, function (response) {
            var image = '/images/admin/star-off.png';
            if (response.visible == 1) {
                image = '/images/admin/star.png';
            }
            if (response.status) {
                item.find('img').attr('src', image);
            }
        });
    }
});