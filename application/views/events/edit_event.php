<main class="my-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div style="background: none;" class="card p-4">

                    <div class="card-body">
                        <form id="my-form" name="my-form" class="needs-validation"
                            action="<?php echo base_url(); ?>events/update_event/<?php echo $event->id; ?>"
                            method="POST" enctype="multipart/form-data" novalidate>
                            <div class="form-group row">
                                <label for="full_name" class="col-md-4 col-form-label text-md-left">
                                    <h3>
                                        <strong>Create event</strong>
                                    </h3>
                                </label>
                                <div class="col-md-6">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="event-name" class="col-md-4 col-form-label text-md-left">Event Name</label>
                                <div class="col-md-8">

                                    <input type="text" id="event-name" class="input-w form-control" name="eventname"
                                        value="<?php echo $event->eventname; ?>" required>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email_address"
                                    class="col-md-4 col-form-label text-md-left">Description</label>
                                <div class="col-md-8 description">
                                    <div id="editor"><?php echo $event->eventdescript; ?></div>
                                    <div id="log"></div>
                                    <input id="eventdescript" type="hidden" value="<?php echo $event->eventdescript; ?>"
                                        name="eventdescript">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label text-md-left">Upload Image</label>
                                <div class="col-md-8">


                                    <label class="file">
                                        <input type="file" name="userfile" id="file" onchange="editImageUpload(this)"
                                            aria-label="File browser example">
                                        <span class="file-custom" data-content="Choose image ..."></span>
                                    </label>
                                    <div style="padding-left: 0;" class="col-sm-6">
                                        <img src="<?php echo base_url(); ?>assets/images/events/<?php echo $event->eventImage; ?>"
                                            id="preview" class="img-thumbnail">
                                    </div>

                                    <input type="hidden" id="imgChanged" value="false" name="imgChanged">
                                    <input type="hidden" id="imgName" value="<?php echo $event->eventImage; ?>"
                                        name="imgName">


                                </div>
                            </div>

                            <hr class="w-100 mt-5 mb-5">

                            <!--
                            <div class="form-group row">
                                <label for="shop-type" class="col-md-4 col-form-label text-md-left">Shop type</label>
                                <div class="col-md-4">
                                    <select id="shop-type" class="form-control input-w">
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
                                        <input id="age" type="number" name="age" class="form-control input-w" min="1" max="100"
                                            step="22" value="1">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="free-event" class="col-md-4 col-form-label text-md-left">Free
                                    event</label>
                                <div class="col-md-4">
                                    <select id="free-event" class="form-control input-w">
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
                                    <select id="corona-questions" class="form-control input-w">
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
                                    <select id="reservation-shop" class="form-control input-w">
                                        <option>Select option</option>
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="event-type" class="col-md-4 col-form-label text-md-left">Event
                                    type(s)</label>
                                <div class="col-md-6">
                                    <input type="text" id="event-type" class="form-control input-w" name="event-type"
                                        placeholder="Type or select an event type">
                                </div>
                            </div>

                            <hr class="w-100 mt-5 mb-5">

                            -->

                            <div class="form-group row">
                                <label for="venue" class="col-md-4 col-form-label text-md-left">Venue</label>
                                <div class="col-md-6">
                                    <input type="text" id="venue" class="form-control input-w" name="eventVenue"
                                        placeholder="Enter a location" value="<?php echo $event->eventVenue; ?>"
                                        required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-left">Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="address" class="form-control input-w" name="eventAddress"
                                        value="<?php echo $event->eventAddress; ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="city" class="col-md-4 col-form-label text-md-left">City</label>
                                <div class="col-md-6">
                                    <input type="text" id="city" class="form-control input-w" name="eventCity"
                                        value="<?php echo $event->eventCity; ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="postal-code" class="col-md-4 col-form-label text-md-left">Postal
                                    code</label>
                                <div class="col-md-6">
                                    <input type="text" id="postal-code" class="form-control input-w" name="eventZipcode"
                                        value="<?php echo $event->eventZipcode; ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="country" class="col-md-4 col-form-label text-md-left">Country
                                </label>
                                <div class="col-md-6 font-weight-bold">
                                    <select id="country" class="form-control input-w font-weight-bold" required>
                                        <option class="text-weight-bold" value="">Select option</option>
                                        <?php foreach($countries as $country): ?>
                                        <?php if($event->eventCountry == $country): ?>
                                        <option class="font-weight-bold" value="<?php echo $country; ?>" selected>
                                            <?php echo $country; ?>
                                        </option>
                                        <?php else: ?>
                                        <option value="<?php echo $country; ?>"><?php echo $country; ?></option>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="hidden" id="eventCountry" name="eventCountry">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="event-date1" class="col-md-4 col-form-label text-md-left">Time of event
                                </label>
                                <div class="col-md-6">
                                    <div class="input-group date">
                                        <input type="text" class="form-control input-w input-date" id="event-date1"
                                            name="StartDate" value="<?php echo $event->StartDate; ?>" required>
                                        <input type="time" class="form-control input-w" id="event-time1"
                                            name="StartTime" value="<?php echo $event->StartTime; ?>" required>
                                        <span class="input-group-addon fa-input pl-2 pr-2">
                                            <i style="color: #fff;font-size: 18px;" class="fa fa-calendar"></i></span>
                                    </div>
                                    <!--
                                    <hr style="margin-top: 0px;margin-bottom: 0px;border-top: none">
                                    <div class="input-group">
                                        <input type="time" class="form-control input-w mb-3" id="event-time1"
                                            name="StartTime" required>
                                        <span style="padding-top: 14px;"
                                            class="input-group-addon fa-input pl-2 pr-2 mb-3">
                                            <i style="color: #fff;font-size: 20px;" class="fa fa-clock-o"></i></span>
                                    </div>
                                    -->

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="event-date1" class="col-md-4 col-form-label text-md-left">
                                </label>
                                <div class="col-md-6">
                                    <div class="input-group date">
                                        <input type="text" class="form-control input-w input-date" id="event-date2"
                                            name="EndDate" value="<?php echo $event->EndDate; ?>" value="" required>
                                        <input type="time" class="form-control input-w" id="event-time2" name="EndTime"
                                            value="<?php echo $event->EndTime; ?>" required>
                                        <span class="input-group-addon fa-input pl-2 pr-2">
                                            <i style="color: #fff;font-size: 18px;" class="fa fa-calendar"></i></span>
                                    </div>
                                    <!--
                                    <hr style="margin-top: 0px;margin-bottom: 0px;border-top: none">
                                    <div class="input-group">
                                        
                                        <span style="padding-top: 14px;"
                                            class="input-group-addon fa-input pl-2 pr-2 mb-3">
                                            <i style="color: #fff;font-size: 20px;" class="fa fa-clock-o"></i></span>
                                    </div>
                                    -->
                                </div>

                            </div>

                            <hr class="w-100 mt-5 mb-5">

                            <div class="col-md-6 offset-md-4">
                                <div class="input-group">
                                    <input type="submit" value="Save changes"
                                        style="background: #377E7F !important;border-radius:0;font-size: 15px;"
                                        class="btn btn-primary form-control mb-3 text-left font-weight-bold">
                                    <span style="background: #275C5D;padding-top: 14px;"
                                        class="input-group-addon pl-2 pr-2 mb-3">
                                        <i style="color: #fff;font-size: 18px;" class="fa fa-check"></i></span>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>