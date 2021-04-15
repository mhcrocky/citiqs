$(document).ready(function() {
    var table = $('#buyers').DataTable({
        processing: true,
      
        
        ajax: {
            type: 'get',
            url: globalVariables.baseUrl + "marketing/selection/allbuyers",
            dataSrc: '',
        },
        columns: [{
                title: 'ID',
                data: 'buyerId'
            },
            {
                title: 'ID',
                data: 'buyerId'
            },
            {
                title: 'UserName',
                data: 'buyerUserName'
            },
            {
                title: 'Email',
                data: 'buyerEmail'
            },
            {
                title: 'Mobile',
                data: null,
                "render": function(data, type, row) {
                    return data.buyerMobile + '<input id="mobile-' + data.buyerId +
                        '" type="hidden" value="' + data.buyerMobile + '">'
                }
            },
            {
                title: 'OneSignal ID',
                data: null,
                "render": function(data, type, row) {
                    if (data.buyerOneSignalId) {
                        return data.buyerOneSignalId + '<input id="onesignal-' + data.buyerId +
                            '" type="hidden" value="' + data.buyerOneSignalId + '">'
                    } else {
                        return '-' + '<input id="onesignal-' + data.buyerId +
                            '" type="hidden" value="' + data.buyerOneSignalId + '">';
                    }

                }
            },
            {
                title: 'Notification',
                data: null,
                "render": function(data, type, row) {
                    return '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userMessageModal" onclick="getBuyerId(' +
                        data.buyerId + ')">Choose</button>';

                }
            },
            {
                title: 'Action',
                data: null,
                "render": function(data, type, row) {
                    return '<button type="button" style="background: #10b981;" class="btn btn-primary" data-toggle="modal" data-target="#editOneSignalIdModal" onclick="editOneSignalId(' +
                        data.buyerId + ', \''+ data.buyerOneSignalId + '\')">Edit OneSignal</button>';

                }
            }
        ],
        columnDefs: [{
            targets: 0,
            checkboxes: {
                selectRow: true
            }
        }],
        select: {
            style: 'multi'
        },
        order: [
            [1, 'asc']
        ]
    });

    // Handle form submission event
    $('#sendMessage').on('click', function() {
        var rows_selected = table.column(0).checkboxes.selected();
        // Iterate over all selected checkboxes
        $.each(rows_selected, function(index, rowId) {
            // Create a hidden element ;
            var buyerId = rowId;
            var buyerMobile = $('#mobile-' + rowId).val();
            var buyerOneSignalId = $('#onesignal-' + rowId).val();
            var message = $('textarea#message-text').val();
            //alert('HERE 1');
            $.ajax({
                type: "get",
                url: globalVariables.baseUrl + 'Marketing/Selection/sendMessage/',
                data: {
                    buyerId: buyerId,
                    buyerMobile: buyerMobile,
                    buyerOneSignalId: buyerOneSignalId,
                    message: message
                },
                success: function(data) {
                    $("#closeModal").click();
                    alertify['success']('Sent Successfully!');
                    $('textarea#message-text').val('');
                }
            });
        });
    });

    $('#sendUserMessage').on('click', function() {
        var buyerId = $('#buyerId').val();
        var buyerMobile = $('#mobile-' + buyerId).val();
        var buyerOneSignalId = $('#onesignal-' + buyerId).val();
        var message = $('textarea#usermessage-text').val();
        // alert('HERE 1');
        $.ajax({
            type: "get",
            url: globalVariables.baseUrl + 'Marketing/Selection/sendMessage/',
            data: {
                buyerId: buyerId,
                buyerMobile: buyerMobile,
                buyerOneSignalId: buyerOneSignalId,
                message: message
            },
            success: function(data) {
                $("#closeUserModal").click();
                alertify['success']('Sent Successfully!');
                $('textarea#usermessage-text').val('');
            }
        });
    });

});

function getBuyerId(buyerId) {
    $("#buyerId").val(buyerId);
}

function editOneSignalId(buyerId, buyerOneSignalId) {
    $("#editBuyerId").val(buyerId);
    if (buyerOneSignalId != 'null') {
        $("#buyerOneSignalId").val(buyerOneSignalId);
    } else {
        $("#buyerOneSignalId").val('');
    }
}

function updateOneSignalId(){
    let data = {
        'buyerId': $("#editBuyerId").val(),
        'buyerOneSignalId': $("#buyerOneSignalId").val()
    }

    $.post(globalVariables.baseUrl + 'Marketing/Selection/update_onesignal/', data, function(data){
        $('#buyers').DataTable().ajax.reload();
        $('#closeOneSignalModal').click();
        alertify['success']('Updated Successfully!');
    });
}