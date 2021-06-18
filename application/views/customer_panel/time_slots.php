
<style>
li {
    list-style-type: none;



    &:nth-of-type(1) {
        .custom-checkbox .custom-control-input:checked~.custom-control-label::after {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3E%3Cpath fill='%230fff00' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3E%3C/svg%3E");
        }

        .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
            background-color: #5bc0de;
        }
    }


}

</style>

<div class="modal fade" id="emailTemplateModal" tabindex="-1" role="dialog" aria-labelledby="emailTemplateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="emailTemplateModalLabel">Choose Email Template
                </h5>
                <button type="button" class="close" id="closeEmailTemplate" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select style="display: none;" id="selectTemplateName" class="form-control">
                    <option value="">Select template</option>
                </select>
                <label for="customTemplateName">Template Name</label>
                <input type="text" id="customTemplateName" name="customTemplateName" class="form-control" />
                <br />
                <label for="customTemplateSubject">Subject</label>
                <input type="text" id="customTemplateSubject" name="templateSubject" class="form-control" />
                <br />
                <label for="templateType">Template Type</label>
                <select class="form-control w-100" id="templateType" name="templateType">
                    <option value="" disabled>Select type</option>
                    <option value="general">General</option>
                    <option value="reservations">Reservations</option>
                    <option value="tickets">Tickets</option>
                    <option value="vouchers">Vouchers</option>
                </select>
                <br />
                <label for="templateHtml">Edit template</label>
                <textarea id="templateHtml" name="templateHtml"></textarea>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="updateEmailTemplate" class="btn btn-primary">Save changes</button>
            </div>

        </div>
    </div>
</div>

    <div id="vue_app">
        <div class="main-wrapper" style="text-align: center; display: block;">
            <div class="row container-fluid height-100 mx-auto">
                <div class="col-md-12 mx-auto" style="text-align:center; margin-bottom: 20px;">
                    <a :href="baseURL+ 'customer_panel/spots/<?php echo $agendaId; ?>'" class="btn btn-primary">Back To
                        Spots</a>
                    <button type="button" style="margin: 10px 0" class="btn btn-primary" @click="addTimeSlot">Add Time
                        Slot
                    </button>
                    <a :href="baseURL+ 'emaildesigner'" class="btn btn-success">Email Designer</a>
                </div>

                <div class="col-md-12" style="text-align:center">
                    <div class="table-responsive" style="text-align:center">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Description</th>
                                    <th>From Time</th>
                                    <th>To Time</th>
                                    <th>Multiple Timeslots</th>
                                    <th>Duration</th>
                                    <th>Overflow</th>
                                    <th>Email Template</th>
                                    <!--<th>Voucher</th>-->
                                    <th>Price</th>
                                    <th>Reservation Fee</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="timeslot in timeslots" :key="timeslot.id">
                                    <td scope="row">{{ timeslot.id }}</td>
                                    <td>{{ timeslot.timeslotdescript }}</td>
                                    <td>{{ timeslot.fromtime }}</td>
                                    <td>{{ timeslot.totime }}</td>
                                    <td v-if="timeslot.multiple_timeslots == 1">Yes</td>
                                    <td v-else>No</td>
                                    <td>{{ timeslot.duration }}</td>
                                    <td>{{ timeslot.overflow }}</td>
                                    <td>
                                        <a href="javascript:;" @click="editEmailTemplate(timeslot.email_id, timeslot.template_name)" data-toggle="modal" data-target="#emailTemplateModal">
                                            {{ timeslot.template_name }}
                                        </a>
                                    </td>
                                    <!--
                                    <td v-for="voucher in vouchers">
                                        <a v-if="voucher.id == timeslot.voucherId" :href="baseURL+ 'voucher?voucherId=' + voucher.id">
                                            {{ voucher.template_name + '(' + voucher.description +  ')' }}
                                        </a>
                                    </td>
                                    -->
                                    <td>{{ timeslot.price }}</td> 
                                    <td>{{ timeslot.reservationFee }}</td>
                                    <td class="td_action">
                                        <span class="span_action" @click="editTimeSlot(timeslot)">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </span>
                                        <span class="span_action " @click="deleteConfirmTimeSlot(timeslot)">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </span>
                                        <span title="Copy Timeslot" class="span_action" @click="copyTimeslot(timeslot)">
                                            <i class="fa fa-copy" aria-hidden="true"></i>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        Delete Time Slot
                    </div>
                    <div class="modal-body">
                        Are you sure ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger btn-ok" @click="deleteTimeSlot()">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="add_time_slot_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add Time Slot</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="descript"><?php echo $this->language->tLine('Spot'); ?></label>
                                <search-select :options="spotsOptions" v-model="modalSpotId" placeholder="Select Spot">
                                </search-select>
                            </div>

                            <div class="form-group">
                                <label for="timeslotdescript"><?php echo $this->language->tLine('Name'); ?></label>
                                <input type="text" name="timeslotdescript" v-model="timeSlotModalData.timeslotdescript"
                                    class="form-control" id="descript">
                            </div>

                            <div class="form-group">
                                <label for="available_items"><?php echo $this->language->tLine('Maximum available SPOTS'); ?></label>
                                <input type="text" name="available_items" v-model="timeSlotModalData.available_items"
                                    class="form-control" id="available_items" placeholder="<?php echo $this->language->tLine('Maximum available SPOTS'); ?>">
                            </div>

                            <div class="form-group">
                                <label for="fromtime"><?php echo $this->language->tLine('From Time'); ?></label>
                                <input type="time" name="fromtime" id="fromtime" class="form-control"
                                    placeholder="<?php echo $this->language->tLine('From Time'); ?>" onfocus="checkField(this)" required>
                            </div>
                            <div class="form-group">
                                <label for="totime"><?php echo $this->language->tLine('To Time'); ?></label>
                                <input type="time" name="totime" id="totime" class="form-control"
                                    placeholder="<?php echo $this->language->tLine('To Time'); ?>" onfocus="checkField(this)" required>
                            </div>
                            <div style="display: flex;" class="form-group">
                                <label style="margin-right:20px;" for="totime"><?php echo $this->language->tLine('Multiple Timeslots'); ?></label>
                                <ul>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" id="visible" type="checkbox" v-model="checkboxValue">
                                            <label class="custom-control-label font-weight-bold text-dark"
                                                for="visible">
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div v-if="timeSlotModalData.multiple_timeslots == 1" class="form-group">
                                <label for="totime"><?php echo $this->language->tLine('Duration'); ?></label>
                                <input type="number" v-model="durationToMin" class="form-control"
                                    placeholder="<?php echo $this->language->tLine('Duration'); ?>(<?php echo $this->language->tLine('minutes'); ?>)">
                            </div>
                            <div v-if="timeSlotModalData.multiple_timeslots == 1" class="form-group">
                                <label for="totime"><?php echo $this->language->tLine('Overflow'); ?></label>
                                <input type="number" v-model="overflowToMin" class="form-control"
                                    placeholder="<?php echo $this->language->tLine('Overflow'); ?>(<?php echo $this->language->tLine('minutes'); ?>)">
                            </div>
                            <div class="form-group">
                                <label for="descript"><?php echo $this->language->tLine('Email Template'); ?></label>
                                <search-select :options="emailsOptions" v-model="timeSlotModalData.email_id"
                                    placeholder="Select Email Template"></search-select>
                            </div>
                            <div class="form-group">
                                <label for="voucher"><?php echo $this->language->tLine('Voucher'); ?></label>
                                <search-select :options="vouchersOptions"
                                           v-model="timeSlotModalData.voucherId"
                                           placeholder="Select Voucher"></search-select>
                            </div>
                            <div class="form-group">
                                <label for="Price">Price</label>
                                <input type="number" step="0.01" name="Price" v-model="timeSlotModalData.price"
                                    class="form-control" id="Price">
                            </div>
                            <div class="form-group">
                                <label for="reservationFee">Reservation Fee</label>
                                <input type="number" step="0.01" name="reservationFee" v-model="timeSlotModalData.reservationFee"
                                    class="form-control" id="reservationFee">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="saveTimeSlot">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script>
    (function () {
        $('#add_time_slot_modal').on('hidden.bs.modal', function () {
            $('#fromtime').val('');
            $('#totime').val('');
        });
        $('.btn').attr('style', 'border-radius:0px !important');
    })();

    const templateGlobals = (function() {
        let globals = {
            'templateHtmlId': 'templateHtml',
        }
        
        Object.freeze(globals);
        
        return globals;
    }());
    
    var app = new Vue({
        el: '#vue_app',

        data: {
            timeslots: JSON.parse('<?php echo json_encode($timeslots);?>'),
            spots: JSON.parse('<?php echo json_encode($spots);?>'),
            emails: JSON.parse('<?php echo json_encode($emails); ?>'),
            vouchers: JSON.parse('<?php echo json_encode($vouchers); ?>'),
            baseURL: "<?php echo base_url(); ?>",
            timeOptions: {
                format: 'HH:mm:ss',
                useCurrent: false,
                showClear: true,
                showClose: true,
            },
            method: 'create',
            timeSlotModalData: {
                timeslotdescript: '',
                available_items: null,
                fromtime: '',
                totime: '',
                multiple_timeslots: 0,
                duration: null,
                overflow: null,
                price: '',
                reservationFee: '',
                spot_id: null,
                email_id: null,
                voucherId: null
            },
            deleteTimeSlotTemp: null

        },
        components: {
            'search-select': VueSearchSelect.ModelSelect
        },
        methods: {
            addTimeSlot() {
                this.timeSlotModalData = {
                    timeslotdescript: '',
                    available_items: 1,
                    fromtime: '',
                    totime: '',
                    multiple_timeslots: 0,
                    duration: null,
                    overflow: null,
                    price: '',
                    reservationFee: '',
                    spot_id: null,
                    email_id: null,
                    id: null,
                    voucherId: null
                };
                this.method = 'create';
                $('#add_time_slot_modal').modal('show');
            },
            editTimeSlot(timeslot) {
                this.time = 'edit';
                this.timeSlotModalData = Object.assign({}, timeslot);
                $('#fromtime').val(timeslot.fromtime);
                $('#totime').val(timeslot.totime);
                $('#add_time_slot_modal').modal('show');
            },
            editEmailTemplate(id, template_name = '') {
                var template_type = 'reservations';
                $('#templateType').val(template_type);
                $.post(globalVariables.baseUrl + "customer_panel/get_email_template",{ id: id }, function (data) {
                    data = JSON.parse(data);
                    let templateContent = data.templateContent;
                    let template_subject = data.template_subject;
                    $('#customTemplateName').val(template_name);
                    $('#customTemplateSubject').val(template_subject);
                    $('#templateType').val(template_type);
                    $('#updateEmailTemplate').attr('onclick','updateEmailTemplate('+id+')');
                    templateContent = templateContent.replaceAll('[QRlink]', globalVariables.baseUrl+'assets/images/qrcode_preview.png');
                    tinymce.activeEditor.setContent(templateContent);
                });
            },
            copyTimeslot(timeslot) {
                this.timeSlotModalData = Object.assign({}, timeslot);
                let formData = new FormData();
                formData.append("timeslotdescript", this.timeSlotModalData.timeslotdescript);
                formData.append("available_items", this.timeSlotModalData.available_items);
                formData.append("fromtime", this.timeSlotModalData.fromtime);
                formData.append("totime", this.timeSlotModalData.totime);
                formData.append("multiple_timeslots", this.timeSlotModalData.multiple_timeslots);
                formData.append("duration", this.timeSlotModalData.duration);
                formData.append("overflow", this.timeSlotModalData.overflow);
                formData.append("price", this.timeSlotModalData.price);
                formData.append("reservationFee", this.timeSlotModalData.reservationFee);
                formData.append("spot_id", this.timeSlotModalData.spot_id);
                formData.append("email_id", this.timeSlotModalData.email_id);
                formData.append("voucherId", this.timeSlotModalData.voucherId);
                this.method = 'create';

                axios.post(this.baseURL + 'ajaxdorian/saveTimeSLot', formData).then((response) => {
                        this.timeslots.push(response.data.data);
                     })
                    .catch(error => {
                        console.log(error)
                    });
            },
            timeConvert(n) {
                var num = parseInt(n);
                var hours = (num / 60);
                var rhours = Math.floor(hours);
                var minutes = (hours - rhours) * 60;
                var rminutes = Math.round(minutes);
                return rhours + ":" + rminutes;
            },
            saveTimeSlot() {
                let formData = new FormData();
                let fromtime = $('#fromtime').val();
                let totime = $('#totime').val();
                if(fromtime == '' && totime == ''){
                    $('#fromtime').attr('style', 'border-color: #df4759;');
                    $('#totime').attr('style', 'border-color: #df4759;');
                    return ;
                }
                if(fromtime == ''){
                    $('#fromtime').attr('style', 'border-color: #df4759;');
                    return ;
                }
                if(totime == ''){
                    $('#totime').attr('style', 'border-color: #df4759;');
                    return ;
                }
                formData.append("timeslotdescript", this.timeSlotModalData.timeslotdescript);
                formData.append("available_items", this.timeSlotModalData.available_items);
                formData.append("fromtime", fromtime);
                formData.append("totime", totime);
                formData.append("multiple_timeslots", this.timeSlotModalData.multiple_timeslots);
                formData.append("duration", this.timeSlotModalData.duration);
                formData.append("overflow", this.timeSlotModalData.overflow);
                formData.append("price", this.timeSlotModalData.price);
                formData.append("reservationFee", this.timeSlotModalData.reservationFee);
                formData.append("spot_id", this.timeSlotModalData.spot_id);
                formData.append("email_id", this.timeSlotModalData.email_id);
                formData.append("voucherId", this.timeSlotModalData.voucherId);

                if (this.timeSlotModalData.id) {
                    formData.append("id", this.timeSlotModalData.id);
                    this.method = 'edit';
                } else {
                    this.method = 'create';
                }

                axios.post(this.baseURL + 'ajaxdorian/saveTimeSLot', formData).then((response) => {
                        if (this.method == 'edit') {
                            let timeslot = response.data.data;
                            let index = this.getIndexByID('timeslots', timeslot.id);
                            Vue.set(this.timeslots, index, timeslot);
                        }

                        if (this.method == 'create') {
                            this.timeslots.push(response.data.data);
                        }

                        $('#add_time_slot_modal').modal('hide')

                    })
                    .catch(error => {
                        console.log(error)
                    });
            },
            getIndexByID(array, id) {
                let f_index = null;
                this[array].forEach((agenda, index) => {
                    if (parseInt(agenda.id) == parseInt(id)) {
                        f_index = index;
                    }
                })
                return f_index;
            },
            timeFormat(time) {
                return moment(moment().format('YYYY-MM-DD') + 'T' + time).format('h:mm a');
            },
            convertToMins(time) {
                if (time == null) {
                    return '';
                }
                let timeM = time.split(':');
                let minutes = parseInt(timeM[0]) * 60 + parseInt(timeM[1]);
                return minutes;
            },
            dateFormat(date) {
                if (!date) {
                    return '';
                }
                let date_obj = Date.parse(date)
                let dateTimeFormat = new Intl.DateTimeFormat('en', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                })
                let [{
                    value: month
                }, , {
                    value: day
                }, , {
                    value: year
                }] = dateTimeFormat.formatToParts(date_obj)
                return `${day}-${month}-${year}`;
            },
            deleteConfirmTimeSlot(timeslot) {
                this.deleteTimeSlotTemp = timeslot;
                $('#confirm-delete').modal('show');
            },
            deleteTimeSlot() {
                if (!this.deleteTimeSlotTemp) {
                    $('#confirm-delete').modal('hide');
                    return false;
                }

                let formData = new FormData();
                formData.append("id", this.deleteTimeSlotTemp.id);

                axios.post(this.baseURL + 'ajaxdorian/deleteTimeSlot', formData).then((response) => {
                        this.timeslots.splice(this.getIndexByID('timeslots', this.deleteTimeSlotTemp.id),
                            1);
                        this.deleteTimeSlotTemp = null;
                        $('#confirm-delete').modal('hide');
                    })
                    .catch(error => {
                        console.log(error)
                    });

            },
        },
        computed: {
            modalSpotId: {
                get: function() {
                    return this.timeSlotModalData.spot_id;
                },
                set: function(value) {
                    this.timeSlotModalData.spot_id = value;
                }
            },
            durationToMin: {
                get: function() {
                    return this.convertToMins(this.timeSlotModalData.duration);
                },
                set: function(value) {
                    this.timeSlotModalData.duration = this.timeConvert(value);
                }
            },
            overflowToMin: {
                get: function() {
                    return this.convertToMins(this.timeSlotModalData.overflow);
                },
                set: function(value) {
                    this.timeSlotModalData.overflow = this.timeConvert(value);
                }
            },
            checkboxValue: {
                get: function() {
                    if(this.timeSlotModalData.multiple_timeslots == 0){
                        return false
                    }
                    return true;
                },
                set: function(value) {
                    if(value == true){
                        this.timeSlotModalData.multiple_timeslots = 1;
                    } else {
                        this.timeSlotModalData.multiple_timeslots = 0;
                        this.timeSlotModalData.duration = null;
                        this.timeSlotModalData.overflow = null;
                    }
                   
                }
            },
            spotsOptions: function() {
                let spotsOptions = [];
                this.spots.forEach((spot) => {
                    if(this.spots.length == 1){
                        this.timeSlotModalData.spot_id = spot.id;
                    }
                    spotsOptions.push({
                        value: spot.id,
                        text: spot.descript + ' ' + this.dateFormat(spot
                            .ReservationDateTime)
                    });
                })
                return spotsOptions;
            },
            emailsOptions: function() {
                let emailsOptions = [];
                this.emails.forEach((email) => {
                    emailsOptions.push({
                        value: email.id,
                        text: email.template_name
                    });
                })
                return emailsOptions;
            },
            vouchersOptions: function () {
                let vouchersOptions = [];
                this.vouchers.forEach((voucher) => {
                    vouchersOptions.push({
                        value: voucher.id,
                        text: voucher.template_name + '(' + voucher.description +  ')'
                    });
                })
                return vouchersOptions;
            }
        },
        mounted: function() {
            this.$nextTick(function() {

            })
        }
    })

    function checkField(el) {
        $(el).attr('style','');
    }
    
function updateEmailTemplate(id){
    createEmailTemplate("selectTemplateName", "customTemplateName", "customTemplateSubject", "templateType", id);
    setTimeout(() => {
        $('#closeEmailTemplate').click();
        $('#selectTemplateName').val('');
        $('#customTemplateName').val('');
    }, 500);
}

</script>
