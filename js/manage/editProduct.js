
var EditProduct = Class({
    section: null,
    init: function (section) {
        this.section = $(section);

        var that = this;
        this.section.find('.remove-image').on('click', function (e) {
            e.preventDefault();
            that.removeImage($(this));
        });
    },
    removeImage: function (button) {
        var row = button.closest('div');
        var url = row.data('url');
        var key = row.data('key');
        $.post(url, {key: key}, function (response) {
            if (response.status) {
                row.remove();
            } else {
                alert('Что-то не удаляется ;(');
            }
        });
    }
});