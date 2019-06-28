$(document).ready(function() {

    $('.delete-product').on('click', function(){
        let product_id = $(this).data('id');
        $.ajax({
            type: "DELETE",
            data: product_id,
            dataType: 'json',
            async: false,
            url: "/product/delete/" + product_id,
            success: function (response) {
                console.log(response);
                window.location.reload();
            },
            error: function (response) {
                console.log(response);
                window.location.reload();
            }
        });
    });

});