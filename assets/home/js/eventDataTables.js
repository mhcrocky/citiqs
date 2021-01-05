$(document).ready(function() {
    var groupColumn = 2;
    var table = $('#tickets').DataTable({
        columnDefs: [{
            "visible": false,
            "targets": groupColumn
        }],
        ajax: {
            type: 'get',
            url: globalVariables.baseUrl +"events/test",
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
                        data.name + '">';
                }

            },
            {

                title: 'Group',
                data: 'group'

            },
            {

                title: 'Quantity',
                data: null,
                "render": function(data, type, row) {
                    return '<input type="text" id="quantity" class="form-control" name="quantity" value="' +
                        data.quantity + '">';
                }

            },

            {

                title: 'Price (Inc. VAT)',
                data: null,
                "render": function(data, type, row) {
                    return '<input type="text" id="price" class="form-control" name="price" value="' +
                        data.price + '">';
                }

            },
            {

                title: 'Visible',
                data: null,
                "render": function(data, type, row) {
                    return '<ul><li><div class="custom-control custom-checkbox"><input style="transform: scale(1.5);" class="custom-control-input" id="package-area-' +
                        data.id +
                        '"  type="checkbox" checked="checked" ><label class="custom-control-label" for="package-area-' +
                        data.id + '"> </label>  </div>    </li></ul>';
                }

            },
            {

                title: 'Options',
                data: null,
                "render": function(data, type, row) {
                    return "<div class='bg-success' style='width: 30px;height: 30px;'><i style='color: #fff;' class='fa fa-pencil p-2'><i></div>";
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


    var table2 = $('#additional-item').DataTable({
        columnDefs: [{
            "visible": false,
            "targets": groupColumn
        }],
        ajax: {
            type: 'get',
            url: globalVariables.baseUrl + "events/test",
            dataSrc: '',
        },
        columns: [{

                title: 'Design',
                data: null,
                "render": function(data, type, row) {
                    return '<i style="font-size: 37px;color: #E3A847;" class="fa fa-stop" aria-hidden="true"></i>';
                }

            },

            {

                title: 'Ticket Name',
                data: null,
                "render": function(data, type, row) {
                    return '<input type="text" id="event-name" class="form-control" name="event-name" value="' +
                        data.name + '">';
                }

            },
            {

                title: 'Quantity',
                data: null,
                "render": function(data, type, row) {
                    return '<input type="text" id="quantity" class="form-control" name="quantity" value="' +
                        data.quantity + '">';
                }

            },
            {

                title: 'Visible',
                data: null,
                "render": function(data, type, row) {
                    return '<ul><li><div class="custom-control custom-checkbox"><input style="transform: scale(1.5);" class="custom-control-input" id="package-area-' +
                        data.id +
                        '"  type="checkbox" checked="checked" ><label class="custom-control-label" for="package-area-' +
                        data.id + '"> </label>  </div>    </li></ul>';
                }

            },
            {

                title: 'Options',
                data: null,
                "render": function(data, type, row) {
                    return "<div class='bg-success' style='width: 30px;height: 30px;'><i style='color: #fff;' class='fa fa-pencil p-2'><i></div>";
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
            $("#additional-item_filter").remove();
            $("#additional-item_length").remove();
        }
    });
    $('#table2').on('draw.dt', function () {
        if ($('#table2').data()) {
            var rows = table.rows().data();
            var ord = new Array();
            for (var i = 0, ien = rows.length; i < ien; i++) {
                ord[i] = rows[i].DT_RowId;
            }
            //post_order(ord, $('#dattab').data('tabs'));
        }
    });
    table2.rowReordering();


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