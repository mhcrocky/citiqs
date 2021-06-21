<style>
.panel-heading {
    padding: 10px;
}
.breadcrumb {
    margin: 10px;
}
.drilldown-level {
    background: #fff;
    padding: 10px;
}
</style>
<div style="margin-top: 3%;" class="main-content-inner ui-sortable">
    
    <div class="row-sort ui-sortable" style="background:#ddd;margin-bottom: 3%;" data-row_position="2" data-row_sort="1">
        <?php echo $bookings_graphs; ?> 
    </div>


    <div class="row-sort ui-sortable" style="background:#ddd;margin-bottom: 3%;" data-row_position="3" data-row_sort="1">
        <?php echo $scan_graphs; ?> 
    </div>

         

<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/js/toastr.min.js"></script>
<script>
$('.col-md-4').css('visibility', 'hidden');
    $(document).ready(function(){
        var x = window.matchMedia("(max-width: 770px)");
        checkIfDisableSortable(x);

        //$('#saleDrillDown').addClass('ui-sortable');
        /*
        var sort = '';
        var sort_dashboard = '';
        $.ajax({
            url: "<?php echo base_url(); ?>dashboard/sortedWidgets",
            method: "GET",
            dataType: "JSON",
            success: function(data){
                sort = data['sort'];
                sort_dashboard = data['sort_dashboard'];
            },
            async:false
        });
        sort = (sort) ? sort.split(',').reverse() : '';
        sort_dashboard = (sort_dashboard) ? sort_dashboard.split(',').reverse() : '';
        
        $("div[data-position]").each(function(index,value){
            
            for(var i = 0; i < sort.length; i++){
                if ($(this).data('position') == sort[i]){
                    $(this).attr( "data-sort", (i+1) )
                }

            }
            
        });

        $("div[data-row_position]").each(function(index,value){
            
            for(var i = 0; i < sort_dashboard.length; i++){
                if ($(this).data('row_position') == sort_dashboard[i]){
                    $(this).attr( "data-row_sort", (i+1) )
                }

            }
            
        });

        setTimeout(function(){ 
            $('.main-content-inner .row-sort').sort(function(a, b) {
                return $(b).data('row_sort') - $(a).data('row_sort');
            }).appendTo('.main-content-inner');
            $('.main-content-inner').removeClass('fade');
        }, 0);

        setTimeout(function(){ 
            $('#sortable .col-md-4').sort(function(a, b) {
                return $(b).data('sort') - $(a).data('sort');
            }).appendTo('#sortable');
        }, 0);

        

        setTimeout(function(){ 
            $('.main-content-inner').removeClass('fade');
        }, 2);
        */
        
        

        
    }); 

    $(function () {
        $('.row').sortable({
            connectWith: ".row",
            items: ".col-md-4",
            update: function (event, ui) {
                var myTable = $(this).index();
                var positions = [];
                $("div[data-position]").each(function(index,value){
                    var data = $(this).data('position');
                    positions.push(data);
                });
                positions = positions.toString();
                //$.post('<?php echo base_url(); ?>dashboard/sortWidgets', {sort: positions});
                setTimeout(function(){
                    toastr.options = {
                        "showDuration": "100",
                        "hideDuration": "1000",
                        "timeOut": "1000"
                    }
                    toastr["success"]("Widget positions are updated successfully!");
                }, 0);
            }
        });

    });

    $(function () {
        $('.main-content-inner').sortable({
            connectWith: ".main-content-inner",
            items: ".row-sort",
            update: function (event, ui) {
                var myTable = $(this).index();
                var positions = [];
                $("div[data-row_position]").each(function(index,value){
                    var data = $(this).data('row_position');
                    positions.push(data);
                });
                positions = positions.toString();
                $.post('<?php echo base_url(); ?>dashboard/sortDashboardWidgets', {sort_dashboard: positions});

            }
        });

    });

function checkIfDisableSortable(x) {
  if (x.matches) { // If media query matches
    $('.main-content-inner').sortable("disable");
    $('.row').sortable("disable");
  }

  return ;
}

    
</script>
  
</div>

