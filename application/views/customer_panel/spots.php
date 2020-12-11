
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<div style="margin-top: 3%;" class="main-content-inner">
<div id="vue_app">
    <div class="main-wrapper" style="text-align: center; display: block;">
        <div class="row container-fluid height-100 mx-auto">
            <div class="col-md-12 mx-auto" style="text-align:center; margin-bottom: 20px;">
                <a :href="baseURL+ 'customer_panel/agenda'" class="btn btn-primary">Back To Agenda</a>
                <button type="button" style="margin: 10px 0" class="btn btn-primary" @click="addSpot">Add Spot</button>
                <a :href="baseURL+ 'emaildesigner'" class="btn btn-success">Email Designer</a>
            </div>
            <div class="col-md-12" style="text-align:center">
                <div style="text-align:center">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th>Sold Out Description</th>
                            <th>Pricing Description</th>
                            <th>Fee Description</th>
                            <th>Sort Order</th>
                            <th>Number of persons</th>
                            <th>Price</th>
                            <th>Email Template</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="spot in spots" :key="spot.id">
                            <td scope="row">{{ spot.id }}</td>
                            <td>{{ spot.descript }}</td>
                            <td>{{ spot.soldoutdescript }}</td>
                            <td>{{ spot.pricingdescript }}</td>
                            <td>{{ spot.feedescript }}</td>
                            <td>{{ spot.sort_order }}</td>
                            <td>{{ spot.numberofpersons }}</td>
                            <td>{{ spot.price }}</td>
                            <td><a :href="baseURL+ 'emaildesigner/edit/'+ spot.email_id">{{ spot.template_name }}</a></td>
                            <td class="spot_table_image" ><img :class="backgroundClass(spot.background)" :src="imgFullPath(spot.image)" alt=""></td>
                            <td class="td_action">
                                <span class="span_action" @click="editSpot(spot)">
                                    <i class="fa fa-pencil" aria-hidden="true" ></i>
                                </span>
                                <span class="span_action "@click="deleteConfirmSpot(spot)" >
                                    <i class="fa fa-trash" aria-hidden="true" ></i>
                                </span>
                                <span class="span_action" @click="goToTimeSlots(spot)">
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
                            <search-select :options="agendasOptions"
                                           v-model="modalAgendaId"
                                           placeholder="Select agenda"></search-select>
                        </div>

                        <div class="form-group">
                            <label for="descript">Description</label>
                            <input type="text" name="descript"
                                   v-model="spotModalData.descript" class="form-control"
                                   id="descript" placeholder="Description">
                        </div>
                        <div class="form-group">
                            <label for="soldoutdescript">Sold out Description</label>
                            <input type="text" name="soldoutdescript"
                                   v-model="spotModalData.soldoutdescript" class="form-control"
                                   id="soldoutdescript" placeholder="Sold out Description">
                        </div>
                        <div class="form-group">
                            <label for="pricingdescript">Pricing Description</label>
                            <input type="text" name="pricingdescript"
                                   v-model="spotModalData.pricingdescript" class="form-control"
                                   id="pricingdescript" placeholder="Pricing Description">
                        </div>
                        <div class="form-group">
                            <label for="feedescript">Fee Description</label>
                            <input type="text" name="feedescript"
                                   v-model="spotModalData.feedescript" class="form-control"
                                   id="feedescript" placeholder="Fee Description">
                        </div>
                        <div class="form-group">
                            <label for="spotLabel">Spot Label</label>
                            <select @change="selectSpotLabel()" class="form-control" id="spotLabelId" name="spotLabelId"
                                    v-model="spotModalData.spotLabelId">
                                <option value="0" data-available="none" selected>None</option>
                                <option v-for="spotLabel in spotsLabel" :value="spotLabel.id" :data-available="spotLabel.area_count" :key="spotLabel.id">{{spotLabel.area_label}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="available_items">Available for booking</label>
                            <input type="text" name="available_items"
                                   v-model.lazy="spotModalData.available_items" class="form-control"
                                   id="available_items" placeholder="Available for booking">
                        </div>
                        <div class="form-group">
                            <label for="sort_order">Order</label>
                            <input type="number" name="sort_order"
                                   v-model="spotModalData.sort_order" class="form-control"
                                   id="sort_order" placeholder="Order">
                        </div>
                        <div class="form-group">
                            <label for="numberofpersons">Number Of Persons</label>
                            <input type="number" name="numberofpersons"
                                   v-model="spotModalData.numberofpersons" class="form-control"
                                   id="numberofpersons" placeholder="Number of persons">
                        </div>
                        <div class="form-group">
                            <label for="Price">Price</label>
                            <input type="number" step="0.01" name="Price"
                                   v-model="spotModalData.price" class="form-control"
                                   id="Price" placeholder="Price">
                        </div>
                        <div class="form-group">
                            <label for="descript">Email Template</label>
                            <search-select :options="emailsOptions"
                                           v-model="spotModalData.email_id"
                                           placeholder="Select Email Template"></search-select>
                        </div>
                        <div class="images justify-content-center d-flex flex-wrap">
                            <img v-for="(image, index) in spot_images"
                                 :key="image"
                                 :src="imgFullPath(image)"
                                 class="spot_image"
                                 :class="getImageClasses(image)"
                                 @click="selectSpotImage(image)">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="saveSpot">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>


    var app = new Vue({
        el: '#vue_app',

        data: {
            spots: JSON.parse('<?php echo json_encode($spots);?>'),
            agendas: JSON.parse('<?php echo json_encode($agendas);?>'),
            emails: JSON.parse('<?php echo json_encode($emails); ?>'),
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
                agenda_id: null,
                email_id: null,
                spotLabelId: null
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
            imgFullPath (src) {
                return this.baseURL + 'assets/home/images/' + src;
            },
            addSpot () {
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
                    agenda_id: null,
                    email_id: null,
                    spotLabelId: null
                }
                this.method = 'create';
                $('#add_spot_modal').modal('show');
            },
            selectSpotLabel(){
                let available = $("#spotLabelId option:selected").data( "available" );
                let id = $("#spotLabelId option:selected").val();
                if($.isNumeric(available)){
                    $( "#available_items" ).prop( "disabled", true );
                    this.spotModalData.available_items = available;
                } else {
                    $( "#available_items" ).prop( "disabled", false );
                    this.spotModalData.available_items = '';
                }
            },
            editSpot (spot) {
                this.method = 'edit';
                this.spotModalData = Object.assign({}, spot);
                $('#add_spot_modal').modal('show');
            },
            goToTimeSlots(spot) {
                location.href = this.baseURL + 'customer_panel/time_slots/' + spot.id
            },
            backgroundClass (background) {
                return 'background-' + background;
            },
            selectSpotImage (image) {
                this.spotModalData.image = image;
            },
            getImageClasses (image) {
                let _vue = this;
                return {
                    [_vue.backgroundClass(_vue.spotModalData.background)] : true,
                    selected: image == _vue.spotModalData.image
                }
            },
            saveSpot () {
                let formData = new FormData();
                formData.append("descript", this.spotModalData.descript);
                formData.append("pricingdescript", this.spotModalData.pricingdescript);
                formData.append("soldoutdescript", this.spotModalData.soldoutdescript);
                formData.append("feedescript", this.spotModalData.feedescript);
                formData.append("available_items", this.spotModalData.available_items);
                formData.append("sort_order", this.spotModalData.sort_order)
                formData.append("numberofpersons", this.spotModalData.numberofpersons);
                formData.append("price", parseFloat(this.spotModalData.price).toFixed(2));
                formData.append("image", this.spotModalData.image);
                formData.append("agenda_id", this.spotModalData.agenda_id);
                formData.append("email_id", this.spotModalData.email_id);
                formData.append("spotLabelId", this.spotModalData.spotLabelId);
                if (this.spotModalData.id) {
                    formData.append("id", this.spotModalData.id);
                }

                axios.post(this.baseURL + 'ajaxdorian/saveAgendaSpot', formData
                ).then((response) => {
                    if (this.method == 'edit') {
                        let spot = response.data.data;
                        let index = this.getIndexByID('spots',spot.id);
                        Vue.set(this.spots, index, spot);
                    }

                    if (this.method == 'create') {
                        this.spots.push(response.data.data);
                    }

                    $('#add_spot_modal').modal('hide')

                })
                    .catch(error => {
                        console.log(error)
                    });
            },
            getIndexByID(array ,id) {
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
                let dateTimeFormat = new Intl.DateTimeFormat('en', {day: '2-digit', month: '2-digit', year: 'numeric'})
                let [{value: month}, , {value: day}, , {value: year}] = dateTimeFormat.formatToParts(date_obj)
                return `${day}-${month}-${year}`;
            },
            selectAgenda () {
                let index = this.getIndexByID('agendas',this.spotModalData.agenda_id);
                this.spotModalData.background = this.agendas[index].Background;
            },
            deleteConfirmSpot (spot) {
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

                axios.post(this.baseURL + 'ajaxdorian/deleteSpot', formData
                ).then((response) => {
                    this.spots.splice(this.getIndexByID('spots',this.deleteSpotTemp.id), 1);
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
                get: function () {
                    return this.spotModalData.agenda_id;
                },
                set: function (value) {
                    this.spotModalData.agenda_id = value;
                    this.selectAgenda()
                }
            },
            agendasOptions: function ()  {
                let agendaOptions = [];
                this.agendas.forEach((agenda)  => {
                    agendaOptions.push({
                        value: agenda.id,
                        text: agenda.ReservationDescription + ' ' + this.dateFormat(agenda.ReservationDateTime)
                    });
                })
                return agendaOptions;
            },
            emailsOptions: function ()  {
                let emailsOptions = [];
                this.emails.forEach((email)  => {
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

            })
        }
    })
</script>

</div>

