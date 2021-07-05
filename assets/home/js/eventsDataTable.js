$(document).ready(function() {
 
    var eventTable = $('#events').DataTable({
        columnDefs: [{
            "visible": false,
        }],
        ajax: {
            type: 'get',
            url: globalVariables.baseUrl +"events/get_events",
            dataSrc: '',
        },
        columns: [

            {

                title: 'ID',
                data: 'id'

            },

            {

                title: 'Name',
                data: 'eventname'

            },
            {

                title: 'Buyers',
                data: null,
                "render": function(data, type, row) {
                    return '<a href="' + globalVariables.baseUrl + 'events/report/' + data.id + '" class="btn btn-primary mr-2" style="background: #10b981;">Go to Buyers</a>';
                }

            },
            /*
            {

                title: 'Venue',
                data: 'eventVenue'

            },
            {

                title: 'Address',
                data: 'eventAddress'

            },
            {

                title: 'City',
                data: 'eventCity'

            },
            {

                title: 'Country',
                data: 'eventCountry'

            },
            {

                title: 'Postal Code',
                data: 'eventZipcode'

            },
            */
            {

                title: 'Start Date',
                data: 'StartDate'

            },
            {

                title: 'Start Time',
                data: 'StartTime'

            },
            {

                title: 'End Date',
                data: 'EndDate'

            },
            {

                title: 'End Time',
                data: 'EndTime'

            },
            {

                title: 'Archived',
                data: null,
                "render": function(data, type, row) {
                    if(data.archived == 1){
                        return 'Yes';
                    }
                    return 'No';
                }

            },
            {

                title: 'Archive',
                data: null,
                "render": function(data, type, row) {
                    if(data.archived == 1){
                        return '<button onclick="update_archived('+data.id+', 0)" class="btn btn-primary">Unarchive</button>';
                    }
                    return '<button onclick="update_archived('+data.id+', 1)" class="btn btn-primary">Archive</button>';
                }

            },
            {

                title: 'Actions',
                data: null,
                "render": function(data, type, row) {
                    
                    let html = '<div style="display: inline-flex; width: 240px;justify-content: center;"><a title="Copy Event" class="event-icons mr-1" href="javascript:;" style="padding-top: 10px;padding-left: 12px;" onclick="openShopUrlWithTagModal('+data.id+')" target="_blank" data-toggle="modal" data-target="#copyUrlToClipboard"><i class="gg-copy"></i></a>';
                    html += '<a class="event-icons ml-3" title="Edit Event" href="'+globalVariables.baseUrl+'events/edit/'+data.id+'"><i class="fa fa-pencil mx-auto"></i></a>';
                    html += '<a class="event-icons ml-3" title="Guestlist" style="font-size: 19px;" href="'+globalVariables.baseUrl+'events/guestlist/'+data.id+'"><i class="gg-user-list"></i></a>'
                    html += '<a class="event-icons ml-3" title="Tickets" href="'+globalVariables.baseUrl+'events/event/'+data.id+'"><i class="ti-ticket ticket-icon"></i></a></div>';
                    return html;
                }

            },
            {

                title: 'Shop',
                data: null,
                "render": function(data, type, row) {
                    return '<a id="shop_url_'+data.id+'" href="'+globalVariables.baseUrl+'events/shop/'+data.id+'" data-href="'+fullBaseUrl+'events/shop/'+data.id+'" style="background: #10b981;" class="btn btn-primary" onclick="openShopUrlWithoutTagModal('+data.id+')" data-toggle="modal" data-target="#copyUrlToClipboard">Meta link</a>';
                },
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).closest('tr').addClass('eventRow'+ rowData.id);
                 }

            },
            /*
            {

                title: 'Url',
                data: null,
                "render": function(data, type, row) {
                    return '<a href="javascript:;" onclick="openShopUrlModal('+data.id+')" class="d-flex ml-2" target="_blank" data-toggle="modal" data-target="#copyUrlToClipboard"><i class="gg-copy"></i></a>';
                }

            },
            */
            {

                title: 'Shop Design',
                data: null,
                "render": function(data, type, row) {
                    return '<a href="'+globalVariables.baseUrl+'events/viewdesign/'+data.id+'" style="background: #10a9b9;" class="btn btn-primary">Go To Design</a>'
                }

            },
            {

                title: 'Copy',
                data: null,
                "render": function(data, type, row) {
                    return '<a href="javascript:;" onclick="copy_event(' + data.id + ')" class="btn btn-primary">Copy Event</a>'
                }

            }
        ],
        columnDefs: [
            { visible: false, "targets": [4, 5] }
          ],

        displayLength: 25,
        createdRow: function(row, data, dataIndex){
            $(row).attr('id', 'row-' + dataIndex);
        }
    });
    
    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            if(settings.nTable.id == 'events'){
                let val = $('#selectTime option:selected').val();
                let current_timestamp = dayjs();
                let today = dayjs().format('YYYY-MM-DD');
                let start_date = data[3];
                //let end_str_timestamp = data[8] + ' ' + data[10];
                //let end_timestamp = dayjs(end_str_timestamp);
                let start_str_timestamp = data[5] + ' ' + data[6];
                let start_timestamp = dayjs(start_str_timestamp);
                
                if (val == 'past' && current_timestamp >= start_timestamp) { return true;}
                if(val == 'archived' && data[8] == 'Yes') { return true; }
                if(val == 'today' && today == start_date && data[6] != 'Yes') {return true;}
                if(val == 'future' && current_timestamp <= start_timestamp && data[8] != 'Yes') {return true;}
                
                if(val == 'all') { return true; }
                return false;
            }
            return true;
            
    });

    $('#selectTime').change(function () {
        setTimeout(() => {
            eventTable.draw();
        }, 2);
            
    });

        
}); 

function openShopUrlWithTagModal(id){
    $('#tag_url').removeClass('d-none');
    openShopUrlModal(id);
}

function openShopUrlWithoutTagModal(id){
    $('#tag_url').removeClass('d-none').addClass('d-none');
    openShopUrlModal(id);
}

function openShopUrlModal(id) {
    let url = $('#shop_url_'+id).attr('data-href');
    $('.shopUrlText').text(url);
    $('#shopUrl').val(url);
    $('#copyShopUrlModal').modal('show');
}

function copyShopUrl(){
    let copyText = $('#shopUrl').val();
    textToClipboard(copyText);
}

function copyShopUrlWithTag(){
    let tag = $('#tagUrl option:selected').val();
    let copyText = $('#shopUrl').val();
    copyText += '?tag=' + tag;
    textToClipboard(copyText);
}

function textToClipboard (copyText) {

    var textarea = document.createElement('textarea');
    textarea.textContent = copyText;
    document.body.appendChild(textarea);
    var selection = document.getSelection();
    var range = document.createRange();
    range.selectNode(textarea);
    selection.removeAllRanges();
    selection.addRange(range);
    console.log('copy success', document.execCommand('copy'));
    selection.removeAllRanges();
    document.body.removeChild(textarea);
  
}

function saveShopSettings() {

    var formData = new FormData($("#shopsettings")[0]);
        formData.append('userfile', $("#userfile")[0].files[0]);
        formData.append('showAddress', $('#showAddress option:selected').val());
        formData.append('showCountry', $('#showCountry option:selected').val());
        formData.append('showZipcode', $('#showZipcode option:selected').val());
        formData.append('showMobileNumber', $('#showMobileNumber option:selected').val());
        formData.append('googleAnalyticsCode', $('#googleAnalyticsCode').val());
        formData.append('googleAdwordsConversionId', $('#googleAdwordsConversionId').val());
        formData.append('googleAdwordsConversionLabel', $('#googleAdwordsConversionLabel').val());
        formData.append('googleTagManagerCode', $('#googleTagManagerCode').val());
        formData.append('facebookPixelId', $('#facebookPixelId').val());
        formData.append('closedShopMessage', $('#closedShopMessage').val());

        $.ajax({
            url: globalVariables.baseUrl + "events/save_shopsettings",
            data:formData,
            type:'POST',
            contentType: false,
            processData: false,
            success: function(data){
                alertify.success("Settings are saved successfully!");
                $('#closeShopSettingsModal').click();
            },
            error: function(data){
                let error = data.responseJSON;
                alertify['error']("Something went wrong");
            }
        });
}

function update_archived(eventId, value){
    $.post(globalVariables.baseUrl + 'events/update_event_archived', {id: eventId, value: value});
    $('#events').DataTable().ajax.reload();
    return ;
}

function copy_event(eventId){
    $.post(globalVariables.baseUrl + 'events/copy_event', {eventId: eventId}, function(data){
        data = JSON.parse(data);
        alertify[data.status](data.message);
        $('#events').DataTable().ajax.reload();
    });
    
    return ;
}
