<link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-1.10.16/sl-1.2.5/datatables.min.css">
<link type="text/css" href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />

<hr><br>
<div class="container">


<table id="buyers" class="display" cellspacing="0" width="100%">

</table>

<hr>

<p class="text-left"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#messageModal" data-whatever="@mdo">Choose</button>
</p>
<hr>

<div class="modal" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="messageModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="closeModal" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="sendMessage" type="button" class="btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="userMessageModal" tabindex="-1" role="dialog" aria-labelledby="userMessageModalLabel" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userMessageModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="usermessage-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <input id="buyerId" type="hidden" value="">
        <button id="closeUserModal" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="sendUserMessage" type="button" class="btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div>

</div>
<script src="https://cdn.datatables.net/v/dt/dt-1.10.16/sl-1.2.5/datatables.min.js"></script>

<script type="text/javascript" src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
<script>
   function getBuyerId(buyerId){
     $("#buyerId").val(buyerId);   
   }

    $(document).ready(function() {
   var table = $('#buyers').DataTable({
    processing: true,
    responsive: true,
    ajax: {
            type: 'get',
            url: '<?php echo base_url("marketing/selection/allbuyers"); ?>',
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
                    return data.buyerMobile + '<input id="mobile-'+data.buyerId+'" type="hidden" value="'+data.buyerMobile+'">'
                }
            },
            {
                title: 'OneSignal ID',
                data: null,
                "render": function(data, type, row) {
                    if (data.buyerOneSignalId) {
                        return data.buyerOneSignalId + '<input id="onesignal-'+data.buyerId+'" type="hidden" value="'+data.buyerOneSignalId+'">'
                    } else {
                        return '-' + '<input id="onesignal-'+data.buyerId+'" type="hidden" value="'+data.buyerOneSignalId+'">';
                    }

                }
            },
            {
                title: 'Actions',
                data: null,
                "render": function(data, type, row) {
                  return '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userMessageModal" onClick="getBuyerId('+data.buyerId+')">Choose</button>';

                }
            }
        ],
      columnDefs: [
         {
            targets: 0,
            checkboxes: {
               selectRow: true
            }
         }
      ],
      select: {
         style: 'multi'
      },
      order: [[1, 'asc']]
   });
   
   // Handle form submission event 
   $('#sendMessage').on('click', function(){
      var rows_selected = table.column(0).checkboxes.selected();
      // Iterate over all selected checkboxes
      $.each(rows_selected, function(index, rowId){
         // Create a hidden element ;
         var buyerId = rowId;
         var buyerMobile = $('#mobile-'+rowId).val();
         var buyerOneSignalId = $('#onesignal-'+rowId).val();
         var message = $('textarea#message-text').val();
         alert('HERE 1');
         $.ajax({
           type: "get",
           url: "<?php echo base_url('Marketing/Selection/sendMessage/'); ?>",
           data: {buyerId:buyerId,buyerMobile:buyerMobile,buyerOneSignalId:buyerOneSignalId,message:message},
           success: function(data){
            $("#closeModal").click();
             console.log(data);
           }
         });
      });
   });

   $('#sendUserMessage').on('click', function(){
     var buyerId = $('#buyerId').val();
     var buyerMobile = $('#mobile-'+buyerId).val();
     var buyerOneSignalId = $('#onesignal-'+buyerId).val();
     var message = $('textarea#usermessage-text').val();
	   // alert('HERE 1');
     $.ajax({
       type: "get",
       url: "<?php echo base_url('Marketing/Selection/sendMessage/'); ?>",
       data: {buyerId:buyerId,buyerMobile:buyerMobile,buyerOneSignalId:buyerOneSignalId,message:message},
       success: function(data){
         $("#closeModal").click();
         console.log(data);
       }
     });
   });

});
</script>
