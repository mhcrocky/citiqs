
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.0/css/mdb.min.css" rel="stylesheet">
<div id="vue_app">
    <div class="main-wrapper" style="text-align: center; display: block;">
        <div class="row container-fluid height-100">
            <div class="col-md-12" style="text-align:center; margin-bottom: 20px;">
                <?php if ($emails): ?>
                    <button type="button" style="margin: 10px 0" class="btn btn-primary" @click="addAgendaModal">Add
                        agenda
                    </button>
                    <a :href="baseURL+ 'emaildesigner'" class="btn btn-success">Email Designer</a>
                <?php else: ?>
                    <div style="margin: 10px 0">
                        You need to create an email template to be able create agenda <a
                                :href="baseURL+ 'emaildesigner/new'"><b>Click Here</b></a>
                    </div>
                <?php endif; ?>

            </div>

            <div class="col-md-12" style="text-align:center">
                <div class="table-responsive" style="text-align:center">
                    <table class="table table-striped" id="agenda_list">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Reservation Description</th>
                            <th>Reservation Date</th>
                            <th>Background Color
                            <th>Email Template</th>
                            <th>Online</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="agenda in agendas" :key="agenda.id">
                                <td scope="row">{{ agenda.id }}</td>
                                <td>{{ agenda.ReservationDescription }}</td>
                                <td>{{ dateFormat(agenda.ReservationDateTime) }}</td>
                                <td class="background-td " :class="'background-'+agenda.Background">
                                    {{ backgroundText(agenda.Background) }}
                                </td>
                                <td>
                                    <a :href="baseURL+ 'emaildesigner/edit/'+ agenda.email_id">
                                        {{ agenda.template_name }}
                                    </a>
                                </td>
                                <td v-if="agenda.online == 1">
                                    Yes
                                </td>
                                <td v-else>
                                    No
                                </td>
                                <td class="td_action text-center">
                                    <span class="span_action" @click="editAgenda(agenda)">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </span>
                                    <span class="span_action " @click="deleteConfirmAgenda(agenda)">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </span>
                                    <span class="span_action" @click="goToSpots(agenda)">
                                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="add_agenda_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add agenda</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="ReservationDescription">Reservation Description</label>
                            <input type="text" name="reservationDescription"
                                   v-model="agendaModalData.ReservationDescription" class="form-control"
                                   id="ReservationDescription" placeholder="Reservation Description">
                        </div>
                        <div class="form-group">
                            <label for="ReservationDate">Reservation Date</label>
                            <datepicker
                                    :format="format"
                                    :disabled-dates="disabledDates"
                                    v-model="agendaModalData.ReservationDateTime"
                                    placeholder="Reservation Date"
                                    input-class="form-control">
                            </datepicker>
                        </div>
                        <div class="form-group">
                            <label for="background_color">Background Color</label>
                            <select class="form-control" id="background_color" name="background_color"
                                    v-model="agendaModalData.Background">
                                <option value="blue-light" data-color="#4682B4">Blue Light</option>
                                <option value="yellow" data-color="#F9A602">Yellow</option>
                                <option value="purple-light" data-color="#af69ee">Purple Light</option>
                                <option value="green" data-color="#72B19F">Green</option>
                                <option value="orange" data-color="#E25F2A">Orange</option>
                                <option value="blue" data-color="#131e3a">Blue</option>
                                <option value="orange-light" data-color="#ff7162">Orange Light</option>
                                <option value="yankee" data-color="#446087">Yankee</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="descript">Email Template</label>
                            <search-select :options="emailsOptions"
                                           v-model="agendaModalData.email_id"
                                           placeholder="Select Email Template"></search-select>
                        </div>
                        <div class="form-group">
                            <label for="online">Status</label>
                            <select class="form-control" id="online" name="online"
                                    v-model="agendaModalData.online">
                                <option value="" disabled selected>Select agenda status</option>
                                <option value="1">Online</option>
                                <option value="0">Offline</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="online">Get Spots and Timeslots from:</label>
                            <select class="mdb-select md-form" multiple>
                                <option value="" disabled selected>---</option>
                                <option  v-for="agenda in agendas" :key="agenda.id" :value="agenda.id">{{ dateFormat(agenda.ReservationDateTime) }}</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="saveAgenda">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Delete Agenda
                </div>
                <div class="modal-body">
                    Are you sure ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok" @click="deleteAgenda()">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.0/js/mdb.min.js"></script>
<script>
$(document).ready(function() {
$('.mdb-select').materialSelect();
});
    var app = new Vue({
        el: '#vue_app',

        data: {
            agendas: JSON.parse('<?php echo json_encode($agendas);?>'),
            emails: JSON.parse('<?php echo json_encode($emails); ?>'),
            method: 'create',
            baseURL: "<?php echo base_url(); ?>",
            agendaModalData: {
                id: '',
                ReservationDescription: '',
                ReservationDateTime: '',
                Background: 'blue-light',
                email_id: null
            },
            format: 'dd-MM-yyyy',
            deleteAgendaTemp: null

        },
        components: {
            datepicker: vuejsDatepicker,
            'search-select': VueSearchSelect.ModelSelect
        },
        methods: {
            dateFormat(date) {
                if (!date) {
                    return '';
                }
                let date_obj = Date.parse(date)
                let dateTimeFormat = new Intl.DateTimeFormat('en', {day: '2-digit', month: '2-digit', year: 'numeric'})
                let [{value: month}, , {value: day}, , {value: year}] = dateTimeFormat.formatToParts(date_obj)
                return `${day}-${month}-${year}`;
            },
            backgroundText(background) {
                if (!background) {
                    return '';
                }
                let background_string = background.replace('-', ' ')
                let background_arr = background_string.split(' ');
                background_string = '';
                background_arr.forEach(word => {
                    background_string += word[0].toUpperCase() + word.slice(1) + ' ';
                });
                background_string = background_string.slice(0, -1);
                return background_string;
            },
            editAgenda(agenda) {
                this.method = 'edit';
                this.agendaModalData = Object.assign({}, agenda);
                $('#background_color').val(this.agendaModalData.Background).trigger('change');
                $('#add_agenda_modal').modal('show');
            },
            goToSpots(agenda) {
                location.href = this.baseURL + 'customer_panel/spots/' + agenda.id
            },
            addAgendaModal() {
                this.agendaModalData = {
                    id: '',
                    ReservationDescription: '',
                    ReservationDateTime: '',
                    Background: 'blue-light',
                    email_id: null
                };
                $('#add_agenda_modal').modal('show');
            },
            deleteConfirmAgenda(agenda) {
                this.deleteAgendaTemp = agenda;
                $('#confirm-delete').modal('show');
            },
            saveAgenda() {
                let formData = new FormData();
                formData.append("ReservationDescription", this.agendaModalData.ReservationDescription);
                formData.append("id", this.agendaModalData.id);
                formData.append("ReservationDateTime", this.dateFormat(this.agendaModalData.ReservationDateTime));
                formData.append("online", this.agendaModalData.online);
                formData.append("Background", this.agendaModalData.Background);
                formData.append("email_id", this.agendaModalData.email_id);


                axios.post(this.baseURL + 'ajaxdorian/saveAgenda', formData
                ).then((response) => {
                    if (this.method == 'edit') {
                        let agenda = response.data.data;
                        let index = this.getIndexByID(agenda.id);
                        Vue.set(this.agendas, index, agenda);
                    }

                    if (this.method == 'create') {
                        this.agendas.push(response.data.data);
                    }

                    $('#add_agenda_modal').modal('hide')

                })
                    .catch(error => {
                        console.log(error)
                    });
            },
            deleteAgenda() {
                if (!this.deleteAgendaTemp) {
                    $('#confirm-delete').modal('hide');
                    return false;
                }

                let formData = new FormData();
                formData.append("agenda_id", this.deleteAgendaTemp.id);

                axios.post(this.baseURL + 'ajaxdorian/deleteAgenda', formData
                ).then((response) => {
                    this.agendas.splice(this.getIndexByID(this.deleteAgendaTemp.id), 1);
                    this.deleteAgendaTemp = null;
                    $('#confirm-delete').modal('hide');
                })
                    .catch(error => {
                        console.log(error)
                    });

            },
            getIndexByID(id) {
                let f_index = null;
                this.agendas.forEach((agenda, index) => {
                    if (parseInt(agenda.id) == parseInt(id)) {
                        f_index = index;
                    }
                })
                return f_index;
            },
        },
        computed: {
            disabledDates() {
                var date = new Date();
                date.setDate(date.getDate() + 1);
                return {
                    to: new Date(date.getFullYear(), date.getMonth(), date.getDate())
                }
            },
            emailsOptions: function () {
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
        mounted: function () {
            this.$nextTick(function () {
                $('#background_color').colorselector();

                $('.dropdown-colorselector span.btn-colorselector').text(this.backgroundText(this.agendaModalData.Background));

                $('#background_color').change(() => {
                    this.agendaModalData.Background = $('#background_color').val();
                    $('.dropdown-colorselector span.btn-colorselector').text(this.backgroundText(this.agendaModalData.Background));
                })
            })
        }
    })
</script>


