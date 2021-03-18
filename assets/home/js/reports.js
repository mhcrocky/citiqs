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

    // date time picker
    $('.timePickers').datetimepicker({
        dayOfWeekStart : 1,
    });
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