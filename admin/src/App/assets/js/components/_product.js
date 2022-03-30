$( document ).ready(function(){
    // $("#productEditButton").prop('disabled', true);
    // $("#productDeleteButton").prop('disabled', true);

    $("#productAddButton").click(function () {
    $.get('/product/add')
        .done(function (data) {
            $("#formModalTitle").html('Add Product');
            $("#formPlaceholder").html(data);

            $('#formMessages').empty();
            $("#formModal").modal('show');
        })
        .fail(function (data) {
            showFailDialog(data);
        });
});

$("#productEditButton").click(function () {
    var selections = $("#bsTable").bootstrapTable('getSelections');
    if (selections.length != 1) {
        showAlertDialog('Selection error',
            'Multiple or no product selected. Only one product can be edited a time',
            'error');
    } else {
        $.get('/product/edit/' + selections[0].uuid)
            .done(function (data) {
                $("#formModalTitle").html('Edit product');
                $("#formPlaceholder").html(data);

                $('#formMessages').empty();
                $("#formModal").modal('show');
            })
            .fail(function (data) {
                showFailDialog(data);
            });
    }
 });

    $("#productDeleteButton").click(function () {
        var selections = $("#bsTable").bootstrapTable('getSelections');
        if (selections.length === 0) {
            return;
        }
        $("#deleteFormPlaceholder").text('Are you sure you want to delete ' + selections[0].title + '?');
        $("#deleteFormMessages").empty();
        $("#deleteFormModal").modal('show');
    });

    $("#deleteProductFormModalSubmit").click(function () {
        var selections = $("#bsTable").bootstrapTable('getSelections');
        $('#deleteFormModal').modal('handleUpdate');

        $.post('/product/delete', selections[0])
            .done(function (data) {
                if (data.success == 'success') {
                    $("#deleteFormMessages").html('<div class="alert alert-success alert-dismissible" ' +
                        'role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">×</span></button> <div>'+data.message+'</div>' +
                        '</div>');
                    $("#bsTable").bootstrapTable('refresh');
                    setTimeout(function () {
                        $('#deleteFormModal').modal('hide');
                    },1500);
                } else {
                    $("#deleteFormMessages").html('<div class="alert alert-danger alert-dismissible" ' +
                        'role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">×</span></button> <div>'+data.message+'</div>' +
                        '<div>');
                    setTimeout(function () {
                        $('#deleteFormModal').modal('hide');
                    },2000);
                }
            })
            .fail(function (data) {
                $('#formModal').modal('hide');
            });
    });

    $("#stockAddButton").click(function () {
        var selections = $("#bsTable").bootstrapTable('getSelections');
        if (selections.length != 1) {
            showAlertDialog('Selection error',
                'Multiple or no product selected. Only one product can be edited a time',
                'error');
        } else {
            $.get('/product/stock/' + selections[0].uuid)
                .done(function (data) {
                    $("#formModalTitle").html('Add stock for ' +selections[0].title);
                    $("#formPlaceholder").html(data);

                    $('#formMessages').empty();
                    $("#formModal").modal('show');
                })
                .fail(function (data) {
                    showFailDialog(data);
                });
        }
    });
});