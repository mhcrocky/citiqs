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

                title: 'Name',
                data: 'eventname'

            },
            /*
            {

                title: 'Description',
                data: null,
                "render": function(data, type, row) {
                    let eventdescript = data.eventdescript;
                    eventdescript = eventdescript.replace(/(<([^>]+)>)/gi, "");
                    eventdescript = eventdescript.substring(0,25) + '...';
                    return eventdescript;
                }

            },
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
            /*
            {

                title: 'End Date',
                data: 'EndDate'

            },
            */
            {

                title: 'Start Time',
                data: 'StartTime'

            },
            /*
            {

                title: 'End Time',
                data: 'EndTime'

            },
            */
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

                title: 'Actions',
                data: null,
                "render": function(data, type, row) {
                    
                    let html = '<div style="display: inline-flex; width: 180px;justify-content: center;"><a class="event-icons mr-1" href="'+globalVariables.baseUrl+'events/edit/'+data.id+'"><i class="fa fa-pencil mx-auto"></i></a>';
                    html += '<a class="event-icons ml-3" style="font-size: 19px;" href="'+globalVariables.baseUrl+'events/guestlist/'+data.id+'"><i class="gg-user-list"></i></a>'
                    html += '<a class="event-icons ml-3" href="'+globalVariables.baseUrl+'events/event/'+data.id+'"><i class="ti-ticket ticket-icon"></i></a></div>';
                    return html;
                }

            },
            {

                title: 'Shop',
                data: null,
                "render": function(data, type, row) {
                    return '<a id="shop_url_'+data.id+'" href="'+globalVariables.baseUrl+'events/shop/'+data.id+'" style="background: #10b981;" class="btn btn-primary" target="_blank">Go To Shop</a>';
                },
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).closest('tr').addClass('eventRow'+ rowData.id);
                 }

            },
            {

                title: 'Url',
                data: null,
                "render": function(data, type, row) {
                    return '<a href="javascript:;" onclick="openShopUrlModal('+data.id+')" class="d-flex ml-2" target="_blank" data-toggle="modal" data-target="#copyUrlToClipboard"><i class="gg-copy"></i></a>';
                }

            },
            {

                title: 'Shop Design',
                data: null,
                "render": function(data, type, row) {
                    return '<a href="'+globalVariables.baseUrl+'events/viewdesign/'+data.id+'" style="background: #10a9b9;" class="btn btn-primary">Go To Design</a>'
                }

            }
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
                //let end_str_timestamp = data[8] + ' ' + data[10];
                //let end_timestamp = dayjs(end_str_timestamp);
                let start_str_timestamp = data[1] + ' ' + data[2];
                let start_timestamp = dayjs(start_str_timestamp);
                
                if (val == 'past' && current_timestamp >= start_timestamp) { return true;}
                if(val == 'future' && current_timestamp <= start_timestamp) {return true;}
                if(val == 'archived' && data[11] == 'Yes') { return true; }
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

function openShopUrlModal(id) {
    let url = $('#shop_url_'+id).attr('href');
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