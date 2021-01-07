$(document).ready(function() {
    //Options
    $('#guestTicketCheck').change(function() {
        if (this.checked) {
            $("#guestTicket").val(1);
            return $(this).prop("checked", true);
        }
        $("#guestTicket").val(0);
        return $(this).prop("checked", false);
    });
    
    $('#ticketSwapCheck').change(function() {
        if (this.checked) {
            $("#ticketSwap").val(1);
            return $(this).prop("checked", true);
        }
        $("#ticketSwap").val(0);
        return $(this).prop("checked", false);
    });
    
    $('#partialAccessCheck').change(function() {
        if (this.checked) {
            $("#partialAccess").val(1);
            return $(this).prop("checked", true);
        }
        $("#partialAccess").val(0);
        return $(this).prop("checked", false);
    });
    
    $('#soldout').change(function() {
        if (this.checked) {
            $("#soldoutExpired").val(1);
            return $(this).prop("checked", true);
        }
        $("#soldoutExpired").val(0);
        return $(this).prop("checked", false);
    });

    //Add Ticket
    $('#visible').change(function() {
        if (this.checked) {
            //var returnVal = confirm("Are you sure?");
            $("#ticketVisible").val(1);
            return $(this).prop("checked", true);
        }
        $("#ticketVisible").val(0);
        return $(this).prop("checked", false);
    });
    $("#group").on("change", function(){
        var group = $("#group option:selected").val();
        $("#ticketGroup").val(group);
    });
    $("#ticketType").on("change", function(){
        var type = $("#ticketType option:selected").val();
        $("#ticketTypeVal").val(type);
    });
    $("#ticketEvent").on("change", function(){
        var event = $("#ticketEvent option:selected").val();
        $("#eventId").val(event);
    });
    var groupColumn = 2;
    var table = $('#tickets').DataTable({
        columnDefs: [{
            "visible": false,
            "targets": groupColumn
        }],
        ajax: {
            type: 'get',
            url: globalVariables.baseUrl +"events/get_tickets",
            dataSrc: '',
        },
        columns: [{

                title: 'Design',
                data: null,
                "render": function(data, type, row) {
                    var html = '<div class="dropdown show">'
                    +'<a class="dropdown-toggle text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                    +'<i style="font-size: 37px;color: #377E7F;" class="fa fa-stop" aria-hidden="true"></i>&nbsp &nbsp &nbsp</a>'
                    +'<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">'
                    +'<a class="dropdown-item" href="#">Ticket</a>'
                    +'<a class="dropdown-item" href="#">Seating</a>'
                    +'<a class="dropdown-item" href="#">Seperator</a>'
                    +'<a class="dropdown-item" href="#">Group</a>'
                    +'<a class="dropdown-item" href="#">Item</a>'
                    +'</div></div>';
                    return html;
                }

            },

            {

                title: 'Ticket Name',
                data: null,
                "render": function(data, type, row) {
                    return '<input type="text" id="event-name" class="form-control" name="event-name" value="' +
                        data.ticketDescription + '">';
                }

            },
            {

                title: 'Group',
                data: 'ticketGroupId'

            },
            {

                title: 'Quantity',
                data: null,
                "render": function(data, type, row) {
                    return '<input type="text" id="quantity" class="form-control" name="quantity" value="' +
                        data.ticketQuantity + '">';
                }

            },

            {

                title: 'Price (Inc. VAT)',
                data: null,
                "render": function(data, type, row) {
                    return '<input type="text" id="price" class="form-control" name="price" value="' +
                        data.ticketPrice + '">';
                }

            },
            {

                title: 'Visible',
                data: null,
                "render": function(data, type, row) {
                    var checked = "";
                    if(data.ticketVisible == 1){
                        checked = "checked";
                    }
                    return '<ul><li><div class="custom-control custom-checkbox"><input style="transform: scale(1.5);" class="custom-control-input" id="package-area-' +
                        data.id +
                        '"  type="checkbox" '+checked+' ><label class="custom-control-label" for="package-area-' +
                        data.id + '"> </label>  </div>    </li></ul>';
                }

            },
            {

                title: 'Options',
                data: null,
                "render": function(data, type, row) {
                    return "<div class='bg-success btn-edit' style='width: 30px;height: 30px;'><a class='text-light' onclick='getTicketOptions("+data.ticketId+")' id='edit' href='javascript:' data-toggle='modal' data-target='#editModal'><i class='fa fa-pencil p-2'><i></a></div>";
                }

            },
            {

                title: '',
                data: null,
                "render": function(data, type, row) {
                    return "<div class='bg-dark' style='width: 30px;height: 30px;'><i style='color: #fff;' class='fa fa-trash p-2'><i></div>";
                }

            }
        ],
        order: [
            [groupColumn, 'asc']
        ],
        displayLength: 25,
        createdRow: function(row, data, dataIndex){
            $(row).attr('id', 'row-' + dataIndex);
        },
        drawCallback: function(settings) {
            $("#tickets_filter").remove();
            $("#tickets_length").remove();

            var api = this.api();
            var rows = api.rows({
                page: 'current'
            }).nodes();
            var last = null;

            api.column(groupColumn, {
                page: 'current'
            }).data().each(function(group, i) {
                if (last !== group) {
                    if (group == '') {

                    } else {
                        var html = '<div class="dropdown show">'
                    +'<a class="dropdown-toggle text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                    +'<i style="font-size: 37px;color: #39495C;" class="fa fa-stop" aria-hidden="true"></i>&nbsp &nbsp &nbsp</a>'
                    +'<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">'
                    +'<a class="dropdown-item" href="#">Ticket</a>'
                    +'<a class="dropdown-item" href="#">Seating</a>'
                    +'<a class="dropdown-item" href="#">Seperator</a>'
                    +'<a class="dropdown-item" href="#">Group</a>'
                    +'<a class="dropdown-item" href="#">Item</a>'
                    +'</div></div>';
                        $(rows).eq(i).before(
                            '<tr class="group">'+
                            '<td>'+html+'<td colspan="3">'
                            +'<input type="text" id="event-name" class="form-control" name="event-name" value="' + group + '">' +
                            '</td><td><ul><li><div class="custom-control custom-checkbox"><input style="transform: scale(1.5);" class="custom-control-input" id="package-area-0' + i +
                            '" type="checkbox" checked="checked" ><label class="custom-control-label" for="package-area-0' +i + '"> </label>  </div>    </li></ul></td><td></td>' +
                            '<td><div class="bg-dark" style="width: 30px;height: 30px;">'+
                            '<i style="color: #fff;" class="fa fa-trash p-2"><i></div></td></tr>'
                        );
                    }

                    last = group;
                }
            });
        }
    });

    table.rowReordering();



    /*Order by the grouping
    $('#tickets tbody').on('click', 'tr.group', function() {
        var currentOrder = table.order()[0];
        if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
            table.order([groupColumn, 'desc']).draw();
        } else {
            table.order([groupColumn, 'asc']).draw();
        }
    });
    */
});

$(function() {
    $('.input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        calendarWeeks: true,
        todayHighlight: true,
        autoclose: true
    });
});

function getTicketOptions(ticketId){
    defaultOptions();
    $("#ticketId").val(ticketId);
    $.get(globalVariables.baseUrl + "events/get_ticket_options/"+ticketId, function(data){
        if(data == ""){
            return defaultOptions();
        }
        data = JSON.parse(data);
        $.each(data, function(index,value){
            if(index == 'ticketExpired'){
                $("#"+value).prop( "checked", true );
            }
            $("#"+index).val(value);
            
        });
    });
    
}

function defaultOptions(){
    $("#ticketId").val('');
    $("#guestTicket").val(1);
    $("#ticketSwap").val(1);
    $("#partialAccess").val(1);
    $("#nonSharedTicketFee").val(1);
    $("#sharedTicketFee").val(1);
    $("#manually").prop( "checked", true );
    $("#startDate").val('');
    $("#startTime").val('');
    $("#endDate").val('');
    $("#endTime").val('');
    $("#soldoutExpired").val(0);
    $("#mailPerAmount").val(1);
    $("#emailAddress").val('');
    
}