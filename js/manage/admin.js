$(function () {

    $('#producer').bind('change', function(){
        var producerId = $(this).val();
        $.post('/manager/products/categories/id/' + producerId, function(data){
            $('#categories').html(data);
            $('#categories').attr('disabled', false);
        });

    })

    $('#contentPages').bind('change', function(){
        $('#link').val($(this).val());
    })

    $('#tabs').tabs();

    $('.manager-list-content > a').bind('click', function(){
        $('.feedbackMessage').hide();
        $(this).parent().find('.feedbackMessage').show('slow');
    });
})