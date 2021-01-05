<main class="my-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div style="background: none;" class="card p-4">

                    <div class="card-body">
                        <form name="my-form" action="success.php" method="">
                            <div class="form-group row">
                                <label for="full_name" class="col-md-4 col-form-label text-md-left">
                                    <strong>Create event</strong>
                                </label>
                                <div class="col-md-6">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="event-name" class="col-md-4 col-form-label text-md-left">Event Name</label>
                                <div class="col-md-8">
                                    <input type="text" id="event-name" class="form-control" name="event-name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email_address"
                                    class="col-md-4 col-form-label text-md-left">Description</label>
                                <div class="col-md-8 description">
                                    <div id="editor"></div>
                                    <div id="log"></div>
                                </div>
                            </div>

                            <hr class="w-100 mt-5 mb-5">

                            <!--
                            <div class="form-group row">
                                <label for="shop-type" class="col-md-4 col-form-label text-md-left">Shop type</label>
                                <div class="col-md-4">
                                    <select id="shop-type" class="form-control">
                                        <option>Select option</option>
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="age" class="col-md-4 col-form-label text-md-left">Minimal
                                    Age</label>
                                <div class="col-md-4">
                                    <div class="w-100 age">
                                        <input id="age" type="number" name="age" class="form-control" min="1" max="100"
                                            step="22" value="1">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="free-event" class="col-md-4 col-form-label text-md-left">Free
                                    event</label>
                                <div class="col-md-4">
                                    <select id="free-event" class="form-control">
                                        <option>Select option</option>
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="corona-questions" class="col-md-4 col-form-label text-md-left">Corona
                                    questions <i id="corona-info" style="font-size: 16px;"
                                        class="fa fa-info-circle ml-1"></i></label>
                                <div class="col-md-4">
                                    <select id="corona-questions" class="form-control">
                                        <option>Select option</option>
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="reservation-shop" class="col-md-4 col-form-label text-md-left">Reservation
                                    shop <i id="reservation-info" style="font-size: 16px;"
                                        class="fa fa-info-circle ml-1"></i>
                                </label>
                                <div class="col-md-4">
                                    <select id="reservation-shop" class="form-control">
                                        <option>Select option</option>
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                    </select>
                                </div>
                            </div>

                            -->

                            <div class="form-group row">
                                <label for="event-type" class="col-md-4 col-form-label text-md-left">Event
                                    type(s)</label>
                                <div class="col-md-6">
                                    <input type="text" id="event-type" class="form-control" name="event-type"
                                        placeholder="Type or select an event type">
                                </div>
                            </div>

                            <hr class="w-100 mt-5 mb-5">

                            <div class="form-group row">
                                <label for="venue" class="col-md-4 col-form-label text-md-left">Venue</label>
                                <div class="col-md-6">
                                    <input type="text" id="venue" class="form-control" name="venue"
                                        placeholder="Enter a location">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-left">Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="address" class="form-control" name="address">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="city" class="col-md-4 col-form-label text-md-left">City</label>
                                <div class="col-md-6">
                                    <input type="text" id="city" class="form-control" name="city">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="postal-code" class="col-md-4 col-form-label text-md-left">Postal
                                    code</label>
                                <div class="col-md-6">
                                    <input type="text" id="postal-code" class="form-control" name="postal-code">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="country" class="col-md-4 col-form-label text-md-left">Country
                                </label>
                                <div class="col-md-6">
                                    <select id="country" class="form-control">
                                        <option>Select option</option>
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="event-date1" class="col-md-4 col-form-label text-md-left">Time of event
                                </label>
                                <div class="col-md-3">
                                    <div class="input-group date">
                                        <input type="text" class="form-control mb-3" id="event-date1" name="event-date1">
                                        <span style="padding-top: 9px;border-bottom-right-radius: 5px;border-top-right-radius: 5px;background: #275C5D;" class="input-group-addon pl-2 pr-2 mb-3">
                                        <i style="color: #fff;font-size: 18px;" class="fa fa-calendar"></i></span>
                                    </div>
                                    <hr style="margin-top: 0px;margin-bottom: 0px;border-top: none">
                                    <div class="input-group">
                                        <input type="time" class="form-control mb-3" id="event-time1" name="event-time1">
                                        <span style="padding-top: 11px;border-bottom-right-radius: 5px;border-top-right-radius: 5px;background: #275C5D;caret-color: transparent;" class="input-group-addon pl-2 pr-2 mb-3">
                                        <i style="color: #fff;font-size: 20px;" class="fa fa-clock-o"></i></span>
                                    </div>
                                    
                                </div>
                                <div class="col-md-3">
                                <div class="input-group date">
                                        <input type="text" class="form-control mb-3" id="event-date2" name="event-date2">
                                        <span style="padding-top: 9px;border-bottom-right-radius: 5px;border-top-right-radius: 5px;background: #275C5D;" class="input-group-addon pl-2 pr-2 mb-3">
                                        <i style="color: #fff;font-size: 18px;" class="fa fa-calendar"></i></span>
                                    </div>
                                    <hr style="margin-top: 0px;margin-bottom: 0px;border-top: none">
                                    <div class="input-group">
                                        <input type="time" class="form-control mb-3" id="event-time2" name="event-time2">
                                        <span style="padding-top: 11px;border-bottom-right-radius: 5px;border-top-right-radius: 5px;background: #275C5D;caret-color: transparent;" class="input-group-addon pl-2 pr-2 mb-3">
                                        <i style="color: #fff;font-size: 20px;" class="fa fa-clock-o"></i></span>
                                    </div>
                                </div>
                            </div>

                            <hr class="w-100 mt-5 mb-5">

                            <div class="col-md-6 offset-md-4">
                                <a href="<?php echo base_url();?>events/event" style="width: 200px;border-radius: 0px;background: #07071c;"
                                    class="btn btn-primary text-left">
                                    <strong>Next step</strong> <span style="margin-left: 100px;"><i
                                            class="fa fa-arrow-right" aria-hidden="true"></i></span>
</a>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    