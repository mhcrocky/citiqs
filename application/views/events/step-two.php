<style>
.btn-edit:hover {
    background: #2f6a2f !important;
}

.inp-height {
    height: 32px !important;
}
</style>
<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="editModalLabel">Edit Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" id="package-area-edit-1" type="checkbox"
                                checked="checked">
                            <label class="custom-control-label font-weight-bold text-dark" for="package-area-edit-1">
                                Can be used as guest ticket
                            </label>
                        </div>
                    </li>
                    <li>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" id="package-area-edit-2" type="checkbox"
                                checked="checked">
                            <label class="custom-control-label font-weight-bold text-dark" for="package-area-edit-2">
                                Ticket can be swapped on Ticketswap
                            </label>
                        </div>
                    </li>
                    <li>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" id="package-area-edit-3" type="checkbox"
                                checked="checked">
                            <label class="custom-control-label font-weight-bold text-dark" for="package-area-edit-3">
                                Partial access during event
                            </label>
                        </div>
                    </li>
                </ul>
                <hr class="w-100 mt-3 mb-3">
                <h3 class="font-weight-bold text-dark">Ticketfee per ticket</h3>
                <div class="row mb-2">
                    <div class="col-md-3 text-dark">Non shared ( Min 0.00 )</div>
                    <div class="col-md-3">
                        <input type="number" name="age" class="form-control inp-height" min="1" max="100" step="22"
                            value="1">
                    </div>

                    <div class="col-md-3">Shared ( Min 0.00 )</div>
                    <div class="col-md-3">
                        <input type="number" name="age" class="form-control inp-height" min="1" max="100" step="22"
                            value="1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 text-dark">Max Discount</div>
                    <div class="col-md-3">
                        <input type="number" name="age" class="form-control inp-height" min="1" max="100" step="22"
                            value="1">
                    </div>
                </div>
                <hr class="w-100 mt-3 mb-3">
                <h3 class="font-weight-bold text-dark">Ticket sales</h3>
                <div class="row">

                    <!--Grid column-->
                    <div class="col-md-6 mb-4">



                        <!-- Default unchecked -->
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="defaultChecked"
                                name="defaultExampleRadios" checked="">
                            <label class="custom-control-label text-dark" for="defaultChecked">On date and time</label>
                        </div>

                        <div class="my-2"></div>

                        <!-- Default checked -->
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="defaultUnchecked"
                                name="defaultExampleRadios">
                            <label class="custom-control-label text-dark" for="defaultUnchecked">
                                Automatically when ticket is almost sold out
                            </label>
                        </div>
                        </section>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col col-md-3">
                        From Date
                    </div>
                    <div class="col col-md-3">
                        <div class="input-group date">
                            <input type="text" class="form-control inp-height" id="event-date1" name="event-date1">
                            <span style="padding-top: 5px;" class="input-group-addon fa-input pl-2 pr-2">
                                <i style="color: #fff;font-size: 18px;" class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                    <div class="col col-md-3">
                        From Time
                    </div>
                    <div class="col col-md-3">
                        <div class="input-group">
                            <input type="time" class="form-control inp-height" id="event-time1" name="event-time1">
                            <span style="padding-top: 5px;" class="input-group-addon fa-input pl-2 pr-2">
                                <i style="color: #fff;font-size: 20px;" class="fa fa-clock-o"></i></span>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col col-md-3">
                        To Date
                    </div>
                    <div class="col col-md-3">
                        <div class="input-group date">
                            <input type="text" class="form-control inp-height" id="event-date2" name="event-date2">
                            <span style="padding-top: 5px;" class="input-group-addon fa-input pl-2 pr-2">
                                <i style="color: #fff;font-size: 18px;" class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                    <div class="col col-md-3">
                        To Time
                    </div>
                    <div class="col col-md-3">
                        <div class="input-group">
                            <input type="time" class="form-control inp-height" id="event-time2" name="event-time2">
                            <span style="padding-top: 5px;" class="input-group-addon fa-input pl-2 pr-2">
                                <i style="color: #fff;font-size: 20px;" class="fa fa-clock-o"></i></span>
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col col-md-3">
                        Sold out when expired
                    </div>
                    <div class="col col-md-3">
                        <ul>
                            <li>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="sold-out" type="checkbox">
                                    <label class="custom-control-label font-weight-bold text-dark" for="sold-out">

                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>


                </div>

                <hr class="w-100 mt-3 mb-3">
                <h3 class="font-weight-bold text-dark">Mail per amount of ticket sold</h3>
                <div class="row mb-3">
                    <div class="col col-md-3">Get email per</div>
                    <div class="col col-md-3">
                        <input type="number" name="per-email" class="form-control inp-height" min="1" max="100"
                            value="1">
                    </div>
                    <div class="col col-md-3">ticket sold</div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-3">On email address</div>
                    <div class="col col-md-6">
                        <input type="text" name="per-email" class="form-control inp-height">
                    </div>
                </div>





            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<main class="my-form">
    <div class="w-100 mt-5 p-3">
        <strong style="font-size: 16px;" class="ml-1">Tickets</strong>
        <table id="tickets" class="mt-2" style="width:100%">

        </table>
    </div>
</main>
<hr class="w-100 mt-5 mb-5">
<!--
<strong style="font-size: 16px;" class="ml-1">Add tickets</strong>
<div class="row mt-2">
    <div class="col-md-4 ml-1">
        <div class="input-group">
            <input type="submit" value="Ticket" style="background: #377E7F !important;border-radius:0"
                class="btn btn-primary form-control mb-3 text-left" id="event-time2" name="event-time2">
            <span style="background: #275C5D;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 ml-1">
        <div class="input-group">
            <input type="submit" value="Guest ticket" style="background: #C84746 !important;border-radius:0"
                class="btn btn-primary form-control mb-3 text-left" id="event-time2" name="event-time2">
            <span style="background: #B23938;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 ml-1">
        <div class="input-group">
            <input type="submit" value="Additional item" style="background: #E3A847 !important;border-radius:0"
                class="btn btn-primary form-control mb-3 text-left" id="event-time2" name="event-time2">
            <span style="background: #F1993F;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 ml-1">
        <div class="input-group">
            <input type="submit" value="Divider" style="background: #39495C !important;border-radius:0"
                class="btn btn-primary form-control mb-3 text-left" id="event-time2" name="event-time2">
            <span style="background: #2D3A4C;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 ml-1">
        <div class="input-group">
            <input type="submit" value="External ticket link" style="background: #39495C !important;border-radius:0"
                class="btn btn-primary form-control mb-3 text-left" id="event-time2" name="event-time2">
            <span style="background: #2D3A4C;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i></span>
        </div>
    </div>
</div>
<hr class="w-100 mt-5 mb-5">
-->
<div class="row">
    <div class="col-md-3 ml-1">
        <div class="input-group">
            <span style="background: #030F16;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-arrow-left"></i></span>
            <input type="submit" value="Next Step" style="background: #111B22 !important;border-radius:0"
                class="btn btn-primary form-control mb-3 text-left" id="event-time2" name="event-time2">

        </div>
    </div>
    <div class="col-md-3">
        <div class="input-group">
            <input type="submit" value="Save changes" style="background: #377E7F !important;border-radius:0"
                class="btn btn-primary form-control mb-3 text-left" id="event-time2" name="event-time2">
            <span style="background: #275C5D;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-check"></i></span>
        </div>
    </div>
    <div class="col-md-3 ml-1">
        <div class="input-group">
            <input type="submit" value="Next Step" style="background: #111B22 !important;border-radius:0"
                class="btn btn-primary form-control mb-3 text-left" id="event-time2" name="event-time2">
            <span style="background: #030F16;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-arrow-right"></i></span>
        </div>
    </div>
</div>