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

.ui-draggable-handle { -ms-touch-action: none; touch-action: none; } 

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

<div style="margin-top: 3%;" class="main-content-inner">
    <div id="vue_app">
        <div class="main-wrapper" style="text-align: center; display: block;">
            <div class="row container-fluid height-100 mx-auto">
                <div class="col-md-12 mx-auto" style="text-align:center; margin-bottom: 20px;">
                    <a :href="baseURL+ 'customer_panel/agenda'" class="btn btn-primary">Back To Agenda</a>
                    <button type="button" style="margin: 10px 0" class="btn btn-primary" @click="addSpot">Add
                        Spot</button>
                    <a :href="baseURL+ 'emaildesigner'" class="btn btn-success">Email Designer</a>
                </div>
                <div class="col-md-12" style="text-align:center">
                    <div class="table-responsive" style="text-align:center">
                        <table class="table table-striped">
                            <thead>
                                <tr class="tab_head">
                                    <th>#</th>
                                    <th>Description</th>
                                    <th>Sold Out Description</th>
                                    <th>Pricing Description</th>
                                    <th>Fee Description</th>
                                    <th>Sort Order</th>
                                    <th>Number of persons</th>
                                    <th>Price</th>
                                    <th>Email Template</th>
                                    <!--<td>Voucher</td>-->
                                    <th>Max Bookings</th>
                                    <td>Send To Email</td>
                                    <td>Email</td>
                                    <th>Background Color</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="spot in spots" :key="spot.id" :data-spotId="spot.id" :data-order="spot.sort_order">
                                    <td scope="row">{{ spot.id }}</td>
                                    <td>{{ spot.descript }}</td>
                                    <td>{{ spot.soldoutdescript }}</td>
                                    <td>{{ spot.pricingdescript }}</td>
                                    <td>{{ spot.feedescript }}</td>
                                    <td>{{ spot.sort_order }}</td>
                                    <td>{{ spot.numberofpersons }}</td>
                                    <td>{{ spot.price }}</td>
                                    <td>
                                        <a href="javascript:;" @click="editEmailTemplate(spot.email_id, spot.template_name)" data-toggle="modal" data-target="#emailTemplateModal">
                                            {{ spot.template_name }}
                                        </a>
                                    </td>
                                    <!--
                                    <td v-for="voucher in vouchers">
                                        <a v-if="voucher.id == spot.voucherId" :href="baseURL+ 'voucher?voucherId=' + voucher.id">
                                            {{ voucher.template_name + '(' + voucher.description +  ')' }}
                                        </a>
                                    </td>
                                    -->
                                    <td>{{ spot.maxBooking }}</td>
                                    <td>{{ spot.send_to_email }}</td>
                                    <td>{{ spot.spot_email }}</td>
                                    <td class="background-td" :class="'background-'+spot.background_color">
                                    <div :style="'width:70px;height: 30px;background:'+ spot.background_color"><div>
                                </td>
                                    <td class="spot_table_image"><img :class="backgroundClass(spot.background)"
                                            :src="imgFullPath(spot.image)" alt=""></td>
                                    <td class="td_action">
                                        <span class="span_action spotImportant" @click="editSpot(spot)">
                                            <i title="Basic Edit" class="fa fa-magic" aria-hidden="true"></i>
                                        </span>
                                        <span class="span_action spotLabel d-none" @click="editSpot(spot)">
                                            <i title="Edit Spot Label" class="fa fa-tags" aria-hidden="true"></i>
                                        </span>
                                        <span class="span_action" @click="editSpot(spot)">
                                            <i title="Edit Spot" class="fa fa-pencil" aria-hidden="true"></i>
                                        </span>
                                        <span class="span_action " @click="deleteConfirmSpot(spot)">
                                            <i title="Delete Spot" class="fa fa-trash" aria-hidden="true"></i>
                                        </span>
                                        <span class="span_action" @click="goToTimeSlots(spot)">
                                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                        </span>
                                        <span title="Copy Spot" class="span_action" @click="copySpot(spot)">
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
                        Delete Spot
                    </div>
                    <div class="modal-body">
                        Are you sure ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger btn-ok" @click="deleteSpot()">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="add_spot_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add spot</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="descript">Agenda</label>
                                <search-select :options="agendasOptions" v-model="modalAgendaId"
                                    placeholder="Select agenda"></search-select>
                            </div>

                            <div class="form-group">
                                <label for="descript"><?php echo $this->language->tLine('Locatie omschrijving'); ?></label>
                                <input type="text" name="descript" v-model="spotModalData.descript" class="form-control"
                                    id="descript" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="soldoutdescript"><?php echo $this->language->tLine('Sold out Description'); ?></label>
                                <input type="text" name="soldoutdescript" v-model="spotModalData.soldoutdescript"
                                    class="form-control" id="soldoutdescript" placeholder="Sold out Description">
                            </div>
                            <div class="form-group">
                                <label for="pricingdescript"><?php echo $this->language->tLine('Pricing Description'); ?></label>
                                <input type="text" name="pricingdescript" v-model="spotModalData.pricingdescript"
                                    class="form-control" id="pricingdescript" placeholder="Pricing Description">
                            </div>
                            <div class="form-group">
                                <label for="feedescript"><?php echo $this->language->tLine('Fee Description'); ?></label>
                                <input type="text" name="feedescript" v-model="spotModalData.feedescript"
                                    class="form-control" id="feedescript" placeholder="Fee Description">
                            </div>
                            <div class="form-group">
                                <label for="spotLabel"><?php echo $this->language->tLine('Spot Label'); ?></label>
                                <select @change="selectSpotLabel()" class="form-control" id="spotLabelId"
                                    name="spotLabelId" v-model="spotModalData.spotLabelId">
                                    <option value="0" data-available="none" selected>None</option>
                                    <option v-for="spotLabel in spotsLabel" :value="spotLabel.id"
                                        :data-available="spotLabel.area_count" :key="spotLabel.id">
                                        {{spotLabel.area_label}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="available_items"><?php echo $this->language->tLine('Maximum available SPOTS'); ?></label>
                                <input type="text" name="available_items" v-model.lazy="spotModalData.available_items"
                                    class="form-control" id="available_items" placeholder="Available for booking">
                            </div>
                            <div class="form-group">
                                <label for="sort_order"><?php echo $this->language->tLine('Ranking Order'); ?></label>
                                <input type="number" name="sort_order" v-model="spotModalData.sort_order"
                                    class="form-control" id="sort_order" placeholder="Ranking Order">
                            </div>
                            <div class="form-group">
                                <label for="numberofpersons"><?php echo $this->language->tLine('Number Of Persons'); ?></label>
                                <input type="number" name="numberofpersons" v-model="spotModalData.numberofpersons"
                                    class="form-control" id="numberofpersons" placeholder="Number of persons">
                            </div>
                            <div class="form-group">
                                <label for="Price"><?php echo $this->language->tLine('Price'); ?></label>
                                <input type="number" step="0.01" name="Price" v-model="spotModalData.price"
                                    class="form-control" id="Price" placeholder="Price">
                            </div>
                            <div class="form-group">
                                <label for="Price"><?php echo $this->language->tLine('Max Bookings'); ?></label>
                                <input type="number" name="maxBooking" v-model="spotModalData.maxBooking"
                                    class="form-control" id="maxBooking" placeholder="Max Bookings" value="1">
                            </div>
                            <div class="form-group">
                                <label for="descript"><?php echo $this->language->tLine('Email Template'); ?></label>
                                <search-select :options="emailsOptions" v-model="spotModalData.email_id"
                                    placeholder="Select Email Template"></search-select>
                            </div>
                            <div class="form-group">
                                <label for="voucher"><?php echo $this->language->tLine('Voucher'); ?></label>
                                <search-select :options="vouchersOptions"
                                           v-model="spotModalData.voucherId"
                                           placeholder="Select Voucher"></search-select>
                            </div>
                            <div style="display: flex;" class="form-group">
                                <label style="margin-right:20px;" for="totime"><?php echo $this->language->tLine('Send To Email'); ?></label>
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
                            <div v-if="spotModalData.send_to_email == 1" class="form-group">
                                <label for="email">Email</label>
                                <input type="email" v-model="spotModalData.spot_email" class="form-control"
                                    placeholder="<?php echo $this->language->tLine('Email'); ?>">
                            </div>
                            <div class="form-group">
                            <label for="background_color">Background Color</label>
                            <select class="form-control" id="background_color" name="background_color"
                                    v-model="spotModalData.background_color">
                                <option value="#4682B4" data-color="#4682B4">Blue Light</option>
                                <option value="#F9A602" data-color="#F9A602">Yellow</option>
                                <option value="#af69ee" data-color="#af69ee">Purple Light</option>
                                <option value="#72B19F" data-color="#72B19F">Green</option>
                                <option value="#E25F2A" data-color="#E25F2A">Orange</option>
                                <option value="#131e3a" data-color="#131e3a">Blue</option>
                                <option value="#446087" data-color="#446087">Yankee</option>
                            </select>
                        </div>
                        
                            <div class="images justify-content-center d-flex flex-wrap">
                                <div class="form-group row">
                                    <label for="image" class="col-md-4 col-form-label text-md-left"><?php echo $this->language->tLine('Upload Image'); ?></label>
                                    <div class="col-md-8">


                                        <label class="file">
                                            <input type="file" class="border-50" name="userfile" id="userfile"
                                                onchange="imageUpload(this)" aria-label="File browser">
                                            <input type="hidden" id="imgChanged" aria-label="File browser">
                                            <span class="file-custom" data-content="Choose image ..."></span>
                                        </label>
                                        <div style="padding-left: 0;width: 100%;" class="col-sm-6">
                                            <img v-if="spotModalData.image" style="width: auto;"
                                                :src="imgFullPath(spotModalData.image)" id="preview"
                                                class="img-thumbnail bg-secondary">
                                            <input type="hidden" id="imgDeleted" value="0">
                                            <button v-if="spotModalData.image" type="button" onclick="deleteSpotImage()" class="btn btn-danger mt-1">
                                                Delete Image
                                            </button>

                                            <img v-else src="<?php echo base_url(); ?>assets/images/img-preview.png"
                                                id="preview" class="img-thumbnail">
                                            <button v-if="spotModalData.image == ''" type="button" onclick="deleteSpotImage()" class="btn btn-danger mt-1 d-none">
                                                Delete Image
                                            </button>
                                        </div>


                                    </div>
                                </div>

                            </div>
                            <div id="copyfrom" class="form-group">
                                <label for="online">Copy from:</label>
                                <select style="width: 100%;" id="spots" class="form-control js-spots-basic-multiple" name="SpotsTimeslots[]" multiple="multiple">
                                    <option v-for="spot in spots" :key="spot.id" :value="spot.id">{{ spot.descript }} </option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->language->tLine('Close'); ?></button>
                        <button type="button" id="saveSpot" class="btn btn-primary" @click="saveSpot"><?php echo $this->language->tLine('Save'); ?></button>
                        <button type="button" id="saveCopySpot" class="btn btn-primary d-none" @click="saveCopySpot"><?php echo $this->language->tLine('Save'); ?></button>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery-ui-touch-punch-touch_fix@0.2.5/jquery.ui.touch-punch.min.js"></script>

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
            spots: JSON.parse('<?php echo json_encode($spots);?>'),
            agendas: JSON.parse('<?php echo json_encode($agendas);?>'),
            emails: JSON.parse('<?php echo json_encode($emails); ?>'),
            vouchers: JSON.parse('<?php echo json_encode($vouchers); ?>'),
            spotsLabel: JSON.parse(`<?php echo json_encode($spotsLabel); ?>`),
            baseURL: "<?php echo base_url(); ?>",
            method: 'create',
            spotModalData: {
                descript: '',
                soldoutdescript: '',
                pricingdescript: '',
                feedescript: '',
                sort_order: '',
                numberofpersons: 1,
                price: 0,
                image: '',
                background: 'blue-light',
                background_color: '#4682B4',
                send_to_email: 0,
                spot_email: '',
                maxBooking: 1,
                agenda_id: null,
                email_id: null,
                spotLabelId: null,
                voucherId: null,
            },
            test: '',
            spot_images: [
                'twoontable.png',
                'sixtable.png',
                'fourontable.png',
                'eighttable.png',
                'sunbed.png',
                'terracereservation.png',
                'crocery.png',
                'bakery.png',
                'shopping_lady.png',
                'shopping_people.png'
            ],
            deleteSpotTemp: null

        },
        components: {
            'search-select': VueSearchSelect.ModelSelect
        },
        methods: {
            imgFullPath(src) {
                return this.baseURL + 'assets/home/images/' + src;
            },
            addSpot() {
                this.spotModalData = {
                    descript: '',
                    soldoutdescript: '',
                    pricingdescript: '',
                    feedescript: '',
                    available_items: 1,
                    sort_order: '',
                    price: 0,
                    numberofpersons: 1,
                    image: '',
                    background: 'blue-light',
                    background_color: '#4682B4',
                    send_to_email: 0,
                    spot_email: '',
                    maxBooking: 1,
                    agenda_id: null,
                    email_id: null,
                    spotLabelId: null,
                    voucherId: null
                }
                this.method = 'create';
                $('#add_spot_modal').modal('show');
            },
            selectSpotLabel() {
                let available = $("#spotLabelId option:selected").data("available");
                let id = $("#spotLabelId option:selected").val();
                if ($.isNumeric(available)) {
                    $("#available_items").prop("disabled", true);
                    this.spotModalData.available_items = available;
                } else {
                    $("#available_items").prop("disabled", false);
                    this.spotModalData.available_items = '';
                }
            },
            editSpot(spot) {
                this.method = 'edit';
                this.spotModalData = Object.assign({}, spot);
                $('#background_color').val(this.spotModalData.background_color).trigger('change');
                $('#add_spot_modal').modal('show');
                $('.modal-title').text('Edit Spot');
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
            copySpot(spot) {
                $('#soldoutdescript').closest(".form-group").hide();
                $('#feedescript').closest(".form-group").hide();
                $('#spotLabelId').closest(".form-group").hide();
                $('#copyfrom').hide();
                $('.modal-title').text('Copy Spot');
                this.spotModalData = Object.assign({}, spot);
                $('#background_color').val(this.spotModalData.background_color).trigger('change');
                $('#saveCopySpot').removeClass('d-none');
                $('#saveCopySpot').show();
                $('#saveSpot').hide();
                $('#add_spot_modal').modal('show');
            },
            goToTimeSlots(spot) {
                location.href = this.baseURL + 'customer_panel/time_slots/' + spot.id
            },
            backgroundClass(background) {
                return 'background-' + background;
            },
            selectSpotImage(image) {
                this.spotModalData.image = image;
            },
            getImageClasses(image) {
                let _vue = this;
                return {
                    [_vue.backgroundClass(_vue.spotModalData.background)]: true,
                    selected: image == _vue.spotModalData.image
                }
            },
            saveSpot() {
                let formData = new FormData();
                formData.append("descript", this.spotModalData.descript);
                formData.append("pricingdescript", this.spotModalData.pricingdescript);
                formData.append("soldoutdescript", this.spotModalData.soldoutdescript);
                formData.append("feedescript", this.spotModalData.feedescript);
                formData.append("available_items", this.spotModalData.available_items);
                formData.append("sort_order", this.spotModalData.sort_order)
                formData.append("numberofpersons", this.spotModalData.numberofpersons);
                formData.append("price", parseFloat(this.spotModalData.price).toFixed(2));
                formData.append("oldImage", this.spotModalData.image);
                formData.append("userfile", $("#userfile")[0].files[0]);
                formData.append("imgDeleted", $('#imgDeleted').val());
                formData.append("agenda_id", this.spotModalData.agenda_id);
                formData.append("maxBooking", this.spotModalData.maxBooking);
                formData.append("background_color", this.spotModalData.background_color);
                formData.append("send_to_email", this.spotModalData.send_to_email);
                formData.append("spot_email", this.spotModalData.spot_email);
                formData.append("email_id", this.spotModalData.email_id);
                formData.append("spotLabelId", this.spotModalData.spotLabelId);
                formData.append("voucherId", this.spotModalData.voucherId);
                formData.append("spots", $('#spots').val());
                if (this.spotModalData.id) {
                    formData.append("id", this.spotModalData.id);
                }

                axios.post(this.baseURL + 'ajaxdorian/saveAgendaSpot', formData).then((response) => {
                        if (this.method == 'edit') {
                            let spot = response.data.data;
                            let index = this.getIndexByID('spots', spot.id);
                            $('#imgChanged').val('false');
                            $('.file-custom').attr('content', 'Choose image ...');
                            $('#preview').attr('src', this.baseURL + 'assets/images/img-preview.png');
                            Vue.set(this.spots, index, spot);
                        }

                        if(response.data.status == 'error'){
                            iziToast.error({
                                title: 'Error',
                                message: response.data.msg,
                                position: 'topRight'
                            });

                            $('#add_spot_modal').modal('hide');
                            return ;
                        }

                        if (this.method == 'create') {
                            this.spots.push(response.data.data);
                        }

                        $('#add_spot_modal').modal('hide');


                    })
                    .catch(error => {
                        console.log(error)
                    });
            },
            saveCopySpot() {
                let formData = new FormData();
                formData.append("descript", this.spotModalData.descript);
                formData.append("pricingdescript", this.spotModalData.pricingdescript);
                formData.append("soldoutdescript", this.spotModalData.soldoutdescript);
                formData.append("feedescript", this.spotModalData.feedescript);
                formData.append("available_items", this.spotModalData.available_items);
                formData.append("sort_order", this.spotModalData.sort_order)
                formData.append("numberofpersons", this.spotModalData.numberofpersons);
                formData.append("price", parseFloat(this.spotModalData.price).toFixed(2));
                formData.append("oldImage", this.spotModalData.image);
                formData.append("userfile", $("#userfile")[0].files[0]);
                formData.append("imgDeleted", $('#imgDeleted').val());
                formData.append("agenda_id", this.spotModalData.agenda_id);
                formData.append("email_id", this.spotModalData.email_id);
                formData.append("maxBooking", this.spotModalData.maxBooking);
                formData.append("background_color", this.spotModalData.background_color);
                formData.append("spotLabelId", this.spotModalData.spotLabelId);
                formData.append("voucherId", this.spotModalData.voucherId);
                formData.append("spots", this.spotModalData.id);
                

                axios.post(this.baseURL + 'ajaxdorian/saveAgendaSpot', formData).then((response) => {
                        if (this.method == 'edit') {
                            let spot = response.data.data;
                            let index = this.getIndexByID('spots', spot.id);
                            $('#imgChanged').val('false');
                            $('.file-custom').attr('content', 'Choose image ...');
                            $('#preview').attr('src', this.baseURL + 'assets/images/img-preview.png');
                            Vue.set(this.spots, index, spot);
                        }

                        if(response.data.status == 'error'){
                            iziToast.error({
                                title: 'Error',
                                message: response.data.msg,
                                position: 'topRight'
                            });

                            $('#add_spot_modal').modal('hide');
                            return ;
                        }

                        if (this.method == 'create') {
                            this.spots.push(response.data.data);
                            $('#imgChanged').val('false');
                            $('.file-custom').attr('content', 'Choose image ...');
                            $('#preview').attr('src', this.baseURL + 'assets/images/img-preview.png');
                        }

                        $('#add_spot_modal').modal('hide');

                       

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
            selectAgenda() {
                let index = this.getIndexByID('agendas', this.spotModalData.agenda_id);
                this.spotModalData.background = this.agendas[index].Background;
            },
            deleteConfirmSpot(spot) {
                this.deleteSpotTemp = spot;
                $('#confirm-delete').modal('show');
            },
            deleteSpot() {
                if (!this.deleteSpotTemp) {
                    $('#confirm-delete').modal('hide');
                    return false;
                }

                let formData = new FormData();
                formData.append("id", this.deleteSpotTemp.id);

                axios.post(this.baseURL + 'ajaxdorian/deleteSpot', formData).then((response) => {
                        this.spots.splice(this.getIndexByID('spots', this.deleteSpotTemp.id), 1);
                        this.deleteSpotTemp = null;
                        $('#confirm-delete').modal('hide');
                    })
                    .catch(error => {
                        console.log(error)
                    });

            },
        },
        computed: {
            modalAgendaId: {
                get: function() {
                    return this.spotModalData.agenda_id;
                },
                set: function(value) {
                    this.spotModalData.agenda_id = value;
                    this.selectAgenda()
                }
            },
            checkboxValue: {
                get: function() {
                    if(this.spotModalData.send_to_email == 0){
                        return false;
                    }
                    return true;
                },
                set: function(value) {
                    if(value == true){
                        this.spotModalData.send_to_email = 1;
                    } else {
                        this.spotModalData.send_to_email = 0;
                        this.spotModalData.spot_email = '';
                    }
                   
                }
            },
            agendasOptions: function() {
                let agendaOptions = [];
                this.agendas.forEach((agenda) => {
                    if(this.agendas.length == 1){
                        this.spotModalData.agenda_id = agenda.id;
                    }
                    agendaOptions.push({
                        value: agenda.id,
                        text: agenda.ReservationDescription + ' ' + this.dateFormat(agenda
                            .ReservationDateTime)
                    });
                })
                return agendaOptions;
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
            this.$nextTick(function () {
                $('#background_color').colorselector();


                $('#background_color').change(() => {
                    this.spotModalData.background_color = $('#background_color').val();
                    
                })
            })
        }
    })

    $(document).on("click", ".browse", function() {
        var file = $(this).parents().find(".file");
        file.trigger("click");
    });
    $('input[type="file"]').change(function(e) {
        var fileName = e.target.files[0].name;


        var reader = new FileReader();
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });

    function imageUpload(el) {

        $('.file-custom').hover(function() {
            $(this).attr('data-content', el.files[0].name);
        });
        $('#imgDeleted').val(0);

    }

    function editImageUpload(el) {

        $('.file-custom').hover(function() {
            $(this).attr('data-content', el.files[0].name);
        });

        $("#imgChanged").val('true');
        $('#imgDeleted').val(0);

    }

    function deleteSpotImage() {
        if (window.confirm("Are you sure?")) {
            $('#preview').attr('src', '<?php echo base_url(); ?>assets/images/img-preview.png');
            $('#imgDeleted').val(1);
        }
        
    }

    (function(){
        $('#soldoutdescript').closest(".form-group").hide();
        $('#pricingdescript').closest(".form-group").hide();
        $('#feedescript').closest(".form-group").hide();
        $('#sort_order').closest(".form-group").hide();
        $('#spotLabelId').closest(".form-group").hide();
    }());

    $(document).on('click', '.spotImportant', function() {
        $('.form-group').hide();
        $('#soldoutdescript').closest(".form-group").show();
        $('#pricingdescript').closest(".form-group").show();
        $('#feedescript').closest(".form-group").show();
        $('#sort_order').closest(".form-group").show();
    });

    $(document).on('click', '.spotLabel', function() {
        $('.form-group').hide();
        $('#spotLabelId').closest(".form-group").show();
    });

    $(document).on('hidden.bs.modal', '#add_spot_modal', function () {
        $('.form-group').show();
        $('#copyfrom').show();
        $('#soldoutdescript').closest(".form-group").hide();
        $('#pricingdescript').closest(".form-group").hide();
        $('#feedescript').closest(".form-group").hide();
        $('#spotLabelId').closest(".form-group").hide();
        $('#sort_order').closest(".form-group").hide();
        $('.modal-title').text('Add Spot');
        $('#saveCopySpot').hide();
        $('#saveSpot').show();
    });

function updateEmailTemplate(id){
    createEmailTemplate("selectTemplateName", "customTemplateName", "customTemplateSubject", "templateType", id);
    setTimeout(() => {
        $('#closeEmailTemplate').click();
        $('#selectTemplateName').val('');
        $('#customTemplateName').val('');
    }, 500);
}
</script>

<?php if(isset($agendaId)): ?>
<script>

$(document).ready(function(){
    var x = window.matchMedia("(max-width: 770px)");
    checkIfDisableSortable(x);
});


$( "table" ).sortable({
    items: "tr:not(.tab_head)",
    cursor: 'move',
    opacity: 0.6,
    scroll: true,
    update: function() {
        var spots = [];
        $('tr:not(.tab_head)').each(function(index,element) {
            var sort = index + 1;
            var order = $(this).attr('data-order');
            if(sort == order){ return ;}
            spots[sort] = $(this).attr('data-spotId');
            app._data.__ob__.value.spots[index].sort_order = sort;
        });
        let data = {
            spots: JSON.stringify(spots)
        }

        let formData = new FormData();
        formData.append("spots", JSON.stringify(spots));

        axios.post(globalVariables.baseUrl + "customer_panel/spots_order", formData).then((response) => {
            //console.log(app);
            return true;
        });
    }
  });

function checkIfDisableSortable(x) {
  if (x.matches) { // If media query matches
    $( "table" ).sortable("disable");
  }

  return ;
}

</script>
<?php endif; ?>

</div>
