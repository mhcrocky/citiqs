'use strict';
$(document).ready(function() {
    // ORDERS
    $('#reportesOrders tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );

    $('#reportesOrders').DataTable({
        order: [[2, 'desc' ]],
        pagingType: "first_last_numbers",
        pageLength: 25,
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    console.dir(this.value);
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                });
            });
        },
        drawCallback: function () {
            $('[data-toggle="popover"]').popover({
                html:true,
                animation: false,
                trigger: 'hover',
                delay: {
                    "hide": 100
                }
            });
            $('.popover-dismiss').popover({
                trigger: 'focus'
            });
        }
    });

    // CATEGORIES
    $('#reportesCategories tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search: '+title+'" />' );
    });

    $('#reportesCategories').DataTable({
        order: [[0, 'asc' ]],
        pagingType: "first_last_numbers",
        pageLength: 10,
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                });
            });
        }
    });

    // SPOTS
    $('#reportesSpots tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search: '+title+'" />' );
    });

    $('#reportesSpots').DataTable({
        order: [[0, 'asc' ]],
        pagingType: "first_last_numbers",
        pageLength: 10,
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                });
            });
        }
    });

    // BUYERS
    $('#reportesBuyers tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search: '+title+'" />' );
    });

    $('#reportesBuyers').DataTable({
        order: [[1, 'asc' ]],
        pagingType: "first_last_numbers",
        pageLength: 10,
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                });
            });
        }
    });

    // PRODUCTS
    $('#reportesProducts tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search: '+title+'" />' );
    });

    $('#reportesProducts').DataTable({
        order: [[0, 'asc' ]],
        pagingType: "first_last_numbers",
        pageLength: 10,
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                });
            });
        }
    });

    // paidDatatable('reportesOrders');
    visibleDatatableCol('reportesCategories','selectCategories', 2, 3);
    visibleDatatableCol('reportesBuyers','selectBuyers', 4, 5);
    visibleDatatableCol('reportesSpots','selectSpots', 2, 3);

    showDateTimePicker('timePeriod', warehouseGlobals.from, warehouseGlobals.to);
    // date time picker
    // $('.timePickers').datetimepicker({
    //     dayOfWeekStart : 1,
    // });
});

function paidDatatable(tableId){
    var value = $('#paid option:selected').val();
    if(value != 0){
        $('#'+tableId).DataTable()
        .columns( 3 )
        .search( '^'+value+'$', true, false )
        .draw();
        return ;
    }
    $('#'+tableId).DataTable()
    .columns( 3 )
    .search(value)
    .draw();
    return ;
}

function visibleDatatableCol(tableId, selectId, col1, col2){
    var col = $('#'+selectId+' option:selected').val();
    if(col == col1){
        $('#'+tableId).DataTable()
        .columns( col1 )
        .visible(true);

        $('#'+tableId).DataTable()
        .columns( col2 )
        .visible(false);
        
        return ;
    } else if(col == col2){
        $('#'+tableId).DataTable()
        .columns( col2 )
        .visible(true);

        $('#'+tableId).DataTable()
        .columns( col1 )
        .visible(false);
        return ;
    }
    $('#'+tableId).DataTable()
    .columns( col1 )
    .visible(true);
    $('#'+tableId).DataTable()
    .columns( col2 )
    .visible(true);
        
    return ;
}


function showDateTimePicker(elementId, fromDate, toDate) {
    $('#' + elementId).daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        startDate: fromDate,
        endDate: toDate,
        locale: {
            format: 'YYYY-MM-DD HH:mm:ss'
        },
        ranges: {
            'Today': [moment().startOf("day"), moment()],
            'Yesterday': [moment().startOf("day").subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().startOf("day").subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().startOf("day").subtract(29, 'days'), moment()],
            'This Month': [moment().startOf("day").startOf('month'), moment().endOf('month')],
            'Last Month': [moment().startOf("day").subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'This Quarter': [moment().startOf("day").subtract(1, 'quarter'), moment()],
            'Last Quarter': [moment().startOf("day").subtract(2, 'quarter'), moment().subtract(1, 'quarter')],
            'This Year': [moment().startOf("day").startOf('year'), moment().endOf('year')],
            'Last Year': [moment().startOf("day").subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
       }
    });
}