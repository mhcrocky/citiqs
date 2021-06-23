<style>
.multiselect-container.dropdown-menu.show {
    width: 100%;
} 
</style>

<div class="modal fade" id="emailTemplateModal" tabindex="-1" role="dialog" aria-labelledby="emailTemplateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="emailTemplateModalLabel"><?php echo $this->language->tLine('Choose Email Template'); ?>
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
                <label for="templateHtml"><?php echo $this->language->tLine('Edit template'); ?></label>
                <textarea id="templateHtml" name="templateHtml"></textarea>

            </div>
            <div class="modal-footer">
                <button type="submit" id="updateEmailTemplate" class="btn btn-primary"><?php echo $this->language->tLine('Choose Email Template'); ?><?php echo $this->language->tLine('Save changes'); ?></button>
            </div>

        </div>
    </div>
</div>

<div id="vue_app">
    <div class="main-wrapper" style="text-align: center; display: block;">
        <div class="row container-fluid height-100">
            <div class="col-md-12" style="text-align:center; margin-bottom: 20px;">
                <?php if ($emails): ?>
                    <button type="button" style="margin: 10px 0" class="btn btn-primary" @click="addAgendaModal">Add
                        agenda
                    </button>
                    <a :href="baseURL+ 'customer_panel/list_templates'" class="btn btn-success"><?php echo $this->language->tLine('Email Designer'); ?></a>
                <?php else: ?> 
                    <div style="margin: 10px 0">
						<?php echo $this->language->tLine('You need to create an email template to be able create agenda'); ?> <a
                                :href="baseURL+ 'add_template'"><b><?php echo $this->language->tLine('Click Here'); ?></b></a>
                    </div>
                <?php endif; ?>

            </div>

            <div class="col-md-12" style="text-align:center">
                <div class="table-responsive" style="text-align:center">
                    <table class="table table-striped" id="agenda_list">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->language->tLine('Description'); ?></th>
                            <th><?php echo $this->language->tLine('Date'); ?></th>
                            <th class="d-none"><?php echo $this->language->tLine('Background Color'); ?>
                            <th><?php echo $this->language->tLine('Email Template'); ?></th>
                            <!-- <th><?php echo $this->language->tLine('Voucher'); ?></th> -->
                            <th><?php echo $this->language->tLine('Max Spots'); ?></th>
                            <th><?php echo $this->language->tLine('Online'); ?></th>
                            <th><?php echo $this->language->tLine('Action'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="agenda in agendas" :key="agenda.id">
                                <td scope="row">{{ agenda.id }}</td>
                                <td>{{ agenda.ReservationDescription }}</td>
                                <td>{{ dateFormat(agenda.ReservationDateTime) }}</td>
                                <td class="background-td d-none" :class="'background-'+agenda.Background">
                                    {{ backgroundText(agenda.Background) }}
                                </td>
                                <td>
                                    <a href="javascript:;" @click="editEmailTemplate(agenda.email_id, agenda.template_name)" data-toggle="modal" data-target="#emailTemplateModal">
                                        {{ agenda.template_name }}
                                    </a>
                                </td>
                                <!--
                                <td v-for="voucher in vouchers">
                                    <a v-if="voucher.id == agenda.voucherId" :href="baseURL+ 'voucher?voucherId=' + voucher.id">
                                        {{ voucher.template_name + '(' + voucher.description +  ')' }}
                                    </a>
                                </td>
                                -->
                                <td>{{ agenda.max_spots }} </td>
                                <td v-if="agenda.online == 1">
									<?php echo $this->language->tLine('Yes'); ?>
                                </td>
                                <td v-else>
									<?php echo $this->language->tLine('No'); ?>
                                </td>
                                <td class="td_action text-center">
                                    <span title="Edit Agenda" class="span_action" @click="editAgenda(agenda)">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </span>
                                    <span title="Delete Agenda" class="span_action " @click="deleteConfirmAgenda(agenda)">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </span>
                                    <span class="span_action" @click="goToSpots(agenda)">
                                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    </span>
                                    <span title="Copy Agenda" class="span_action" @click="copyAgenda(agenda)">
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


    <div class="modal fade" id="add_agenda_modal">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo $this->language->tLine('Add agenda'); ?></h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="ReservationDescription"><?php echo $this->language->tLine('Description'); ?></label>
                            <input type="text" name="reservationDescription"
                                   v-model="agendaModalData.ReservationDescription" class="form-control"
							id="ReservationDescription" >
                        </div>
                        <div class="form-group">
                            <label for="ReservationDate"><?php echo $this->language->tLine('Date'); ?></label>
                            <datepicker
                                    :format="format"
                                    :disabled-dates="disabledDates"
                                    v-model="agendaModalData.ReservationDateTime"
                                    placeholder=""
                                    input-class="form-control">
                            </datepicker>
                        </div>
                        <div class="form-group d-none">
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
                            <label for="descript"><?php echo $this->language->tLine('Email Template'); ?></label>
                            <search-select :options="emailsOptions"
                                           v-model="agendaModalData.email_id"
                                           placeholder="Select Email Template"></search-select>
                        </div>
                        <div class="form-group">
                            <label for="voucher">Voucher</label>
                            <search-select :options="vouchersOptions"
                                           v-model="agendaModalData.voucherId"
                                           placeholder="Select Voucher"></search-select>
                        </div>
                        <div class="form-group">
                            <label for="online"><?php echo $this->language->tLine('Status'); ?></label>
                            <select class="form-control" id="online" name="online"
                                    v-model="agendaModalData.online">
                                <option value="" disabled selected><?php echo $this->language->tLine('Select agenda status'); ?></option>
                                <option value="1">Online</option>
                                <option value="0">Offline</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="max_spots"><?php echo $this->language->tLine('Maximaal aantal locaties'); ?></label>
                            <input type="text" name="max_spots"
                                   v-model="agendaModalData.max_spots" class="form-control"
                                   id="max_spots">
                        </div>


                        <div class="form-group">
                            <label for="max_spots"><?php echo $this->language->tLine('Max Spots'); ?></label>
                            <input type="text" name="max_spots"
                                   v-model="agendaModalData.max_spots" class="form-control"
                                   id="max_spots">
                        </div>
                        <div class="images justify-content-center d-flex flex-wrap">
                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label text-md-left"><?php echo $this->language->tLine('Upload Image'); ?></label>
                                <div class="col-md-8">


                                        <label class="file">
                                            <input type="file" class="border-50" name="agendaImage" id="agendaImage"
                                                onchange="agendaImageUpload(this)" aria-label="File browser">
                                            <input type="hidden" class="imgChanged" aria-label="File browser">
                                            <span class="file-custom" data-content="Choose image ..."></span>
                                        </label>
                                        <div style="padding-left: 0;width: 100%;" class="col-sm-6">
                                            <img v-if="agendaModalData.agendaImage" style="width: auto;"
                                                :src="imgFullPath(agendaModalData.agendaImage)"
                                                class="img-thumbnail bg-secondary agendaImagePreview">
                                            <input type="hidden" class="imgDeleted" value="0">
                                            <button v-if="agendaModalData.agendaImage" type="button" onclick="deleteAgendaImage()" class="btn btn-danger mt-1">
                                                Delete Image
                                            </button>

                                            <img v-else src="<?php echo base_url(); ?>assets/images/img-preview.png"
                                                class="img-thumbnail agendaImagePreview">
                                            <button v-if="agendaModalData.agendaImage == ''" type="button" onclick="deleteAgendaImage()" class="btn btn-danger mt-1 d-none">
                                                Delete Image
                                            </button>
                                        </div>


                                </div>
                            </div>

                        </div>

                        <div class="images justify-content-center d-flex flex-wrap">
                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label text-md-left"><?php echo $this->language->tLine('Upload Image'); ?></label>
                                <div class="col-md-8">


                                        <label class="file">
                                            <input type="file" class="border-50" name="backgroundImage" id="backgroundImage"
                                                onchange="backgroundImageUpload(this)" aria-label="File browser">
                                            <input type="hidden" class="backgroundImgChanged" aria-label="File browser">
                                            <span class="background-file-custom" data-content="Choose image ..."></span>
                                        </label>
                                        <div style="padding-left: 0;width: 100%;" class="col-sm-6">
                                            <img v-if="agendaModalData.backgroundImage" style="width: auto;"
                                                :src="imgFullPath(agendaModalData.backgroundImage)"
                                                class="img-thumbnail bg-secondary backgroundImagePreview">
                                            <input type="hidden" class="backgroundImgDeleted" value="0">
                                            <button v-if="agendaModalData.backgroundImage" type="button" onclick="deleteBackgroundImage()" class="btn btn-danger mt-1">
                                                Delete Image
                                            </button>

                                            <img v-else src="<?php echo base_url(); ?>assets/images/img-preview.png"
                                                class="img-thumbnail backgroundImagePreview">
                                            <button v-if="agendaModalData.backgroundImage == ''" type="button" onclick="deleteBackgroundImage()" class="btn btn-danger mt-1 d-none">
                                                Delete Image
                                            </button>
                                        </div>


                                </div>
                            </div>

                        </div>



                        <div class="form-group">
                            <label for="online">Copy from:</label>
                            <select style="width: 100%;" id="agendas" class="form-control js-spots-basic-multiple" name="SpotsTimeslots[]" multiple="multiple">
                                <option v-for="agenda in agendas" :key="agenda.id" :value="agenda.id">{{ agenda.ReservationDescription }} - {{ dateFormat(agenda.ReservationDateTime) }}</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->language->tLine('Close'); ?></button>
                    <button type="button" class="btn btn-primary" @click="saveAgenda"><?php echo $this->language->tLine('Save'); ?></button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="copy_agenda_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo $this->language->tLine('Add agenda'); ?></h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="copyReservationDescription"><?php echo $this->language->tLine('Description'); ?></label>
                            <input type="text" name="reservationDescription"
                                   v-model="agendaModalData.ReservationDescription" class="form-control"
                                   id="copyReservationDescription" placeholder="<?php echo $this->language->tLine('Description'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="ReservationDate"><?php echo $this->language->tLine('Date'); ?></label>
                            <datepicker
                                    :format="format"
                                    :disabled-dates="disabledDates"
                                    v-model="agendaModalData.ReservationDateTime"
                                    placeholder="<?php echo $this->language->tLine('Date'); ?>"
                                    input-class="form-control">
                            </datepicker>
                        </div>
                        <div class="form-group d-none">
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
                            <label for="voucher"><?php echo $this->language->tLine('Voucher'); ?></label>
                            <search-select :options="vouchersOptions"
                                           v-model="agendaModalData.voucherId"
                                           placeholder="Select Voucher"></search-select>
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
                            <label for="max_spots"><?php echo $this->language->tLine('Max Spots'); ?></label>
                            <input type="text" name="max_spots"
                                   v-model="agendaModalData.max_spots" class="form-control"
                                   id="max_spots">
                        </div>
                        <div class="images justify-content-center d-flex flex-wrap">
                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label text-md-left"><?php echo $this->language->tLine('Upload Image'); ?></label>
                                <div class="col-md-8">


                                        <label class="file">
                                            <input type="file" class="border-50" name="agendaImage" id="agendaImage-2"
                                                onchange="agendaImageUpload(this)" aria-label="File browser">
                                            <input type="hidden" class="imgChanged" aria-label="File browser">
                                            <span class="file-custom" data-content="Choose image ..."></span>
                                        </label>
                                        <div style="padding-left: 0;width: 100%;" class="col-sm-6">
                                            

                                            <img src="<?php echo base_url(); ?>assets/images/img-preview.png"
                                                 class="img-thumbnail agendaImagePreview">
                                            
                                        </div>


                                </div>
                            </div>

                        </div>

                        <div class="images justify-content-center d-flex flex-wrap">
                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label text-md-left"><?php echo $this->language->tLine('Upload Image'); ?></label>
                                <div class="col-md-8">


                                        <label class="file">
                                            <input type="file" class="border-50" name="backgroundImage" id="backgroundImage-2"
                                                onchange="backgroundImageUpload(this)" aria-label="File browser">
                                            <input type="hidden" class="backgroundImgChanged" aria-label="File browser">
                                            <span class="background-file-custom" data-content="Choose image ..."></span>
                                        </label>
                                        <div style="padding-left: 0;width: 100%;" class="col-sm-6">
     
                                            <img src="<?php echo base_url(); ?>assets/images/img-preview.png"
                                                 class="img-thumbnail backgroundImagePreview">

                                        </div>


                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="saveCopyAgenda">Save</button>
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

<script>
(function() {

    $('.js-spots-basic-multiple').select2();
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
            agendas: JSON.parse('<?php echo json_encode($agendas);?>'),
            emails: JSON.parse('<?php echo json_encode($emails); ?>'),
            vouchers: JSON.parse('<?php echo json_encode($vouchers); ?>'),
            method: 'create',
            baseURL: "<?php echo base_url(); ?>",
            agendaModalData: {
                id: '',
                ReservationDescription: '',
                ReservationDateTime: '',
                Background: 'blue-light',
                email_id: null,
                voucherId: null,
                agendaImage: '',
                backgroundImage: '',
                max_spots: '',
            },
            format: 'dd-MM-yyyy',
            deleteAgendaTemp: null

        },
        components: {
            datepicker: vuejsDatepicker,
            'search-select': VueSearchSelect.ModelSelect
        },
        methods: {
            imgFullPath(src) {
                return this.baseURL + 'assets/home/images/' + src;
            },
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
            copyAgenda(agenda) {
                this.agendaModalData = Object.assign({}, agenda);
                this.agendaModalData.ReservationDescription = '';
                this.agendaModalData.ReservationDateTime = '';
                $('#background_color').val(this.agendaModalData.Background).trigger('change');
                $('#copyReservationDescription').val(' ');
                $('#copy_agenda_modal').modal('show');
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
                    email_id: null,
                    voucherId: null,
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
                //formData.append("id", this.agendaModalData.id);
                formData.append("ReservationDateTime", this.dateFormat(this.agendaModalData.ReservationDateTime));
                formData.append("online", this.agendaModalData.online);
                formData.append("Background", this.agendaModalData.Background);
                formData.append("email_id", this.agendaModalData.email_id);
                formData.append("agendaImage", $("#agendaImage")[0].files[0]);
                formData.append("backgroundImage", $("#backgroundImage")[0].files[0]);
                formData.append("oldImage", this.agendaModalData.agendaImage);
                formData.append("backgroundOldImage", this.agendaModalData.backgroundImage);
                formData.append("imgDeleted", $('.imgDeleted').val());
                formData.append("backgroundImgDeleted", $('.backgroundImgDeleted').val());
                formData.append("max_spots", this.agendaModalData.max_spots);
                formData.append("voucherId", this.agendaModalData.voucherId);
                formData.append("agendas", $('#agendas').val());
                if (this.agendaModalData.id) {
                    formData.append("id", this.agendaModalData.id);
                }


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

                    $('#add_agenda_modal').modal('hide');

                })
                    .catch(error => {
                        console.log(error)
                    });
            },
            saveCopyAgenda() {
                let formData = new FormData();
                formData.append("ReservationDescription", this.agendaModalData.ReservationDescription);
                formData.append("ReservationDateTime", this.dateFormat(this.agendaModalData.ReservationDateTime));
                formData.append("online", this.agendaModalData.online);
                formData.append("Background", this.agendaModalData.Background);
                formData.append("email_id", this.agendaModalData.email_id);
                formData.append("agendaImage", $("#agendaImage-2")[0].files[0]);
                formData.append("backgroundImage", $("#backgroundImage-2")[0].files[0]);
                formData.append("max_spots", this.agendaModalData.max_spots);
                formData.append("voucherId", this.agendaModalData.voucherId);
                formData.append("agendas", this.agendaModalData.id);


                axios.post(this.baseURL + 'ajaxdorian/saveAgenda', formData
                ).then((response) => {
                    if (this.method == 'create') {
                        //console.log(response);
                        //console.log(response.data);
                        //console.log(response.data.data);
                        this.agendas.push(response.data.data);
                    }
            

                    $('#copy_agenda_modal').modal('hide');

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
                date.setDate(date.getDate());
                return {
                    to: new Date(date.getFullYear(), date.getMonth(), date.getDate())
                }
            },
            emailsOptions: function () {
                let emailsOptions = [{
                    value: '',
                    text: 'None'
                }];
                this.emails.forEach((email) => {
                    emailsOptions.push({
                        value: email.id,
                        text: email.template_name
                    });
                })
                return emailsOptions;
            },
            vouchersOptions: function () {
                let vouchersOptions = [{
                    value: '',
                    text: 'None'
                }];
                this.vouchers.forEach((voucher) => {
                    vouchersOptions.push({
                        value: voucher.id,
                        text: voucher.template_name + '(' + voucher.description +  ')'
                    });
                })
                return vouchersOptions;
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
    });

function updateEmailTemplate(id){
    createEmailTemplate("selectTemplateName", "customTemplateName", "customTemplateSubject", "templateType", id);
    setTimeout(() => {
        $('#closeEmailTemplate').click();
        $('#selectTemplateName').val('');
        $('#customTemplateSubject').val('');
        $('#customTemplateName').val('');
    }, 500);
}


$(document).on("click", ".browse", function() {
        var file = $(this).parents().find(".file");
        file.trigger("click");
    });
    $('input[name="agendaImage"]').change(function(e) {
        var fileName = e.target.files[0].name;


        var reader = new FileReader();
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            
            $(".agendaImagePreview").attr('src', e.target.result);
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });

    $('input[name="backgroundImage"]').change(function(e) {
        var fileName = e.target.files[0].name;


        var reader = new FileReader();
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            $(".backgroundImagePreview").attr('src', e.target.result);
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });

function agendaImageUpload(el) {

    $('.file-custom').hover(function() {
        $(this).attr('data-content', el.files[0].name);
    });

    $('.imgDeleted').val(0);

}

function backgroundImageUpload(el) {

$('.background-file-custom').hover(function() {
    $(this).attr('data-content', el.files[0].name);
});

$('.backgroundImgDeleted').val(0);

}


function deleteAgendaImage() {
if (window.confirm("Are you sure?")) {
    $('.agendaImagePreview').attr('src', '<?php echo base_url(); ?>assets/images/img-preview.png');
    $('.imgDeleted').val(1);
}

}

function deleteBackgroundImage() {
if (window.confirm("Are you sure?")) {
    $('.backgroundImagePreview').attr('src', '<?php echo base_url(); ?>assets/images/img-preview.png');
    $('.backgroundImgDeleted').val(1);
}

}
</script>


