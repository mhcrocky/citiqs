<html>

<body>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/vuejs-datepicker"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajaxdorian/libs/axios/0.19.2/axios.min.js">
    </script>

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
                    <div style="text-align:center">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Description</th>
                                    <th>From Time</th>
                                    <th>To Time</th>
                                    <th>Duration</th>
                                    <th>Overflow</th>
                                    <th>Email Template</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="timeslot in timeslots" :key="timeslot.id">
                                    <td scope="row">{{ timeslot.id }}</td>
                                    <td>{{ timeslot.timeslotdescript }}</td>
                                    <td>{{ timeFormat(timeslot.fromtime) }}</td>
                                    <td>{{ timeFormat(timeslot.totime) }}</td>
                                    <td>{{ timeslot.duration }}</td>
                                    <td>{{ timeslot.overflow }}</td>
                                    <td><a :href="baseURL + 'emaildesigner/edit/'+ timeslot.email_id">{{ timeslot.template_name
                                    }}</a></td>
                                    <td>{{ timeslot.price }}</td>
                                    <td class="td_action">
                                        <span class="span_action" @click="editTimeSlot(timeslot)">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </span>
                                        <span class="span_action " @click="deleteConfirmTimeSlot(timeslot)">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
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
                                <label for="descript">Spot</label>
                                <search-select :options="spotsOptions" v-model="modalSpotId" placeholder="Select Spot">
                                </search-select>
                            </div>

                            <div class="form-group">
                                <label for="timeslotdescript">Description</label>
                                <input type="text" name="timeslotdescript" v-model="timeSlotModalData.timeslotdescript"
                                    class="form-control" id="descript" placeholder="Description">
                            </div>

                            <div class="form-group">
                                <label for="available_items">Available for booking</label>
                                <input type="text" name="available_items" v-model="timeSlotModalData.available_items"
                                    class="form-control" id="available_items" placeholder="Available for booking">
                            </div>

                            <div class="form-group">
                                <label for="fromtime">From Time</label>
                                <input type="time" v-model="timeSlotModalData.fromtime" class="form-control"
                                    placeholder="From Time">
                            </div>
                            <div class="form-group">
                                <label for="totime">To Time</label>
                                <input type="time" v-model="timeSlotModalData.totime" class="form-control"
                                    placeholder="To Time">
                            </div>
                            <div class="form-group">
                                <label for="totime">Duration</label>
                                <input type="number" v-model="durationToMin" class="form-control"
                                    placeholder="Duration(minutes)">
                            </div>
                            <div class="form-group">
                                <label for="totime">Overflow</label>
                                <input type="number" v-model="overflowToMin" class="form-control"
                                    placeholder="Overflow(minutes)">
                            </div>
                            <div class="form-group">
                                <label for="descript">Email Template</label>
                                <search-select :options="emailsOptions" v-model="timeSlotModalData.email_id"
                                    placeholder="Select Email Template"></search-select>
                            </div>
                            <div class="form-group">
                                <label for="Price">Price</label>
                                <input type="number" step="0.01" name="Price" v-model="timeSlotModalData.price"
                                    class="form-control" id="Price" placeholder="Price">
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


    <script>
    var app = new Vue({
        el: '#vue_app',

        data: {
            timeslots: JSON.parse('<?php echo json_encode($timeslots);?>'),
            spots: JSON.parse('<?php echo json_encode($spots);?>'),
            emails: JSON.parse('<?php echo json_encode($emails); ?>'),
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
                duration: null,
                overflow: null,
                price: '',
                spot_id: null,
                email_id: null,
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
                    duration: null,
                    overflow: null,
                    price: '',
                    spot_id: null,
                    email_id: null,
                    id: null
                };
                this.method = 'create';
                $('#add_time_slot_modal').modal('show');
            },
            editTimeSlot(timeslot) {
                this.time = 'edit';
                this.timeSlotModalData = Object.assign({}, timeslot);
                $('#add_time_slot_modal').modal('show');
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
                formData.append("timeslotdescript", this.timeSlotModalData.timeslotdescript);
                formData.append("available_items", this.timeSlotModalData.available_items);
                formData.append("fromtime", this.timeSlotModalData.fromtime);
                formData.append("totime", this.timeSlotModalData.totime);
                formData.append("duration", this.timeSlotModalData.duration);
                formData.append("overflow", this.timeSlotModalData.overflow);
                formData.append("price", this.timeSlotModalData.price);
                formData.append("spot_id", this.timeSlotModalData.spot_id);
                formData.append("email_id", this.timeSlotModalData.email_id);
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
            spotsOptions: function() {
                let spotsOptions = [];
                this.spots.forEach((spot) => {
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
            }
        },
        mounted: function() {
            this.$nextTick(function() {

            })
        }
    })
    </script>

</body>

</html>