$( document ).ready(function(){
    $('.addToCart').click(function() {
        var id = $(this).attr("data-id");
        $.post( "/product/add-to-cart", { prodID: id }, function( data ) {
                //alert( "Data Loaded: " + data['result'] );
            });
    });

    $('.removeFromCart').click(function() {
        var id = $(this).val();
        //console.log(id);
        $.post( "/product/remove-from-cart", { prodID: id }, function( data ) {
            location.reload();
        });
    });

    $('.emptyCart').click(function() {
        $.post( "/product/empty-cart", function( data ) {
            location.reload();
        });
    });

    $('.order').click(function() {
        window.location.href = "/product/send-order"
    });

    return false;
});