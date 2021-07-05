<main class="my-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div style="background: none;" class="card p-4">

                    <div class="card-body">

                        <div class="col-md-2 ml-auto">
                            <a href="<?php echo base_url(); ?>events">
                                <div class="input-group">
                                    <input type="button" value="<?php echo $this->language->tLine('Go Back'); ?>"
                                        style="background: #10b981 !important;border-radius:0;height:45px;"
                                        class="btn btn-primary form-control mb-3 text-left" data-toggle="modal"
                                        data-target="#guestlistModal">
                                    <span style="background: #275C5D;padding-top: 14px;"
                                        class="input-group-addon pl-2 pr-2 mb-3" data-toggle="modal"
                                        data-target="#guestlistModal">
                                        <i style="color: #fff;font-size: 18px;" class="ti ti-arrow-left"></i>
                                    </span>

                                </div>
                            </a>
                        </div>

                        <form id="my-form" name="my-form" class="needs-validation"
                            action="<?php echo base_url(); ?>events/update_event/<?php echo $event->id; ?>"
                            method="POST" enctype="multipart/form-data" novalidate>
                            <div class="form-group row">
                                <label for="full_name" class="col-md-4 col-form-label text-md-left">
                                    <h3 style="margin-top: 0px !important">
                                        <strong><?php echo $this->language->tLine('Edit event'); ?></strong>
                                    </h3>
                                </label>
                                <div class="col-md-6">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="event-name" class="col-md-4 col-form-label text-md-left">Event Name</label>
                                <div class="col-md-8">

                                    <input type="text" id="event-name" class="input-w form-control border-50"
                                        name="eventname" value="<?php echo $event->eventname; ?>" required>

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
                            <div class="form-group row upload-image">
                                <label for="image" class="col-md-4 col-form-label text-md-left">Upload Event Image</label>
                                <div class="col-md-8">


                                    <label class="file">
                                        <input type="file" name="userfile" id="file" onchange="editImageUpload(this)"
                                            aria-label="File browser example">
                                        <span id="imageUpload" class="file-custom"
                                            data-content="Choose image ..."></span>
                                    </label>
                                    <div style="padding-left: 0;" class="col-sm-6">
                                        <?php if($event->eventImage == ''): ?>
                                        <img src="<?php echo base_url(); ?>assets/images/img-preview.png" id="preview"
                                            class="img-thumbnail">
                                        <?php else: ?>
                                        <img src="<?php echo base_url(); ?>assets/images/events/<?php echo $event->eventImage; ?>"
                                            id="preview" class="img-thumbnail">
                                        <?php endif; ?>
                                    </div>

                                    <input type="hidden" id="imgChanged" value="false" name="imgChanged">
                                    <input type="hidden" id="imgName" value="<?php echo $event->eventImage; ?>"
                                        name="imgName">


                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="showBackgroundImage" class="col-md-4 col-form-label text-md-left">
                                    Show Background Image
                                </label>
                                <div class="col-md-6">
                                    <select
                                        id="showBackgroundImage"
                                        name="showBackgroundImage"
                                        class="form-control input-w border-50 field"
                                        onchange="toggleBgImgItems()"
                                        required
                                    >
                                        <option value="">Select option</option>
                                        <option value="1" <?php if($event->showBackgroundImage == '1'){ ?> selected <?php } ?>>Yes</option>
                                        <option value="0" <?php if($event->showBackgroundImage == '0'){ ?> selected <?php } ?>>No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row backgroundImage <?php if($event->showBackgroundImage == '0'){?> d-none <?php } ?>">
                                <label for="image" class="col-md-4 col-form-label text-md-left">Upload Background
                                    Image</label>
                                <div class="col-md-8">


                                    <label class="file">
                                        <input type="file" class="border-50" name="backgroundfile" id="background-file"
                                            onchange="editBackgroundUpload(this)" aria-label="File browser">
                                        <span class="file-custom" id="img-background"
                                            data-content="Choose image ..."></span>
                                    </label>
                                    <div style="padding-left: 0;" class="col-sm-6">
                                        <?php if($event->backgroundImage == ''): ?>
                                        <img src="<?php echo base_url(); ?>assets/images/img-preview.png"
                                            id="background-preview" class="img-thumbnail">
                                        <?php else: ?>
                                        <img src="<?php echo base_url(); ?>assets/images/events/<?php echo $event->backgroundImage; ?>"
                                            id="background-preview" class="img-thumbnail">
                                        <?php endif; ?>
                                    </div>

                                    <input type="hidden" id="backgroundImgChanged" value="false"
                                        name="backgroundImgChanged">
                                    <input type="hidden" id="backgroundImgName"
                                        value="<?php echo $event->backgroundImage; ?>" name="backgroundImgName">


                                </div>
                            </div>

                            <div class="form-group row backgroundImage <?php if($event->showBackgroundImage == '0'){?> d-none <?php } ?>">
                                <label for="image" class="col-md-4 col-form-label text-md-left">Square Background
                                    Image</label>
                                <div class="col-md-4">
                                    <select id="isSquared" name="isSquared"
                                        class="form-control input-w border-50 field">
                                        <option value="">Select option</option>
                                        <option value="1" <?php if($event->isSquared == '1'){ ?> selected <?php } ?>>Yes</option>
                                        <option value="0" <?php if($event->isSquared == '0'){ ?> selected <?php } ?>>No</option>
                                    </select>

                                </div>
                            </div>

                            <hr class="w-100 mt-5 mb-5">

                            <!--
                            <div class="form-group row">
                                <label for="shop-type" class="col-md-4 col-form-label text-md-left">Shop type</label>
                                <div class="col-md-4">
                                    <select id="shop-type" class="form-control border-50 input-w">
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
                                        <input id="age" type="number" name="age" class="form-control border-50 input-w" min="1" max="100"
                                            step="22" value="1">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="free-event" class="col-md-4 col-form-label text-md-left">Free
                                    event</label>
                                <div class="col-md-4">
                                    <select id="free-event" class="form-control border-50 input-w">
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
                                    <select id="corona-questions" class="form-control border-50 input-w">
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
                                    <select id="reservation-shop" class="form-control border-50 input-w">
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
                                    <input type="text" id="event-type" class="form-control border-50 input-w" name="event-type"
                                        placeholder="Type or select an event type">
                                </div>
                            </div>

                            <hr class="w-100 mt-5 mb-5">

                            -->


                            <div class="form-group row">
                                <label for="visibleToShop" class="col-md-4 col-form-label text-md-left">
                                Show To Main Shop
                                </label>
                                <div class="col-md-6">
                                    <select id="visibleToShop" name="visibleToShop"
                                        class="form-control input-w border-50 field" required>
                                        <option value="">Select option</option>
                                        <option value="1" <?php if($event->visibleToShop == '1'){ ?> selected <?php } ?>>Yes</option>
                                        <option value="0" <?php if($event->visibleToShop == '0'){ ?> selected <?php } ?>>No</option>
                                    </select>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="showInSameDate" class="col-md-4 col-form-label text-md-left">
                                Show In The Same Date
                                </label>
                                <div class="col-md-6">
                                    <select id="showInSameDate" name="showInSameDate"
                                        class="form-control input-w border-50 field" required>
                                        <option value="">Select option</option>
                                        <option value="1" <?php if($event->showInSameDate == '1'){ ?> selected <?php } ?>>Yes</option>
                                        <option value="0" <?php if($event->showInSameDate == '0'){ ?> selected <?php } ?>>No</option>
                                    </select>

                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="positionSoldoutAtBottom" class="col-md-4 col-form-label text-md-left">
                                Postion Of Sold Out Tickets
                                </label>
                                <div class="col-md-6">
                                    <select id="positionSoldoutAtBottom" name="positionSoldoutAtBottom"
                                        class="form-control input-w border-50 field" required>
                                        <option value="">Select option</option>
                                        <option value="0" <?php if($event->positionSoldoutAtBottom == '0'){ ?> selected <?php } ?>>Top</option>
                                        <option value="1" <?php if($event->positionSoldoutAtBottom == '1'){ ?> selected <?php } ?>>Bottom</option>
                                    </select>

                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="descriptionInShop" class="col-md-4 col-form-label text-md-left">Text showed in shop</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-w border-50" id="descriptionInShop" name="descriptionInShop"
                                        placeholder="Text showed in shop" 
                                        value="<?php echo $event->descriptionInShop; ?>" >
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="venue" class="col-md-4 col-form-label text-md-left">Venue</label>
                                <div class="col-md-6">
                                    <input type="text" id="venue" class="form-control border-50 input-w"
                                        name="eventVenue" placeholder="Enter a location"
                                        value="<?php echo $event->eventVenue; ?>" required>
                                </div>
                            </div>

                            <div class="form-group row wideField">
                                <label for="address" class="col-md-4 col-form-label text-md-left">Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="autocomplete"
                                        class="field form-control border-50 input-w" name="eventAddress"
                                        value="<?php echo $event->eventAddress; ?>" required>
                                </div>
                            </div>

                            <div class="form-group row wideField">
                                <label for="city" class="col-md-4 col-form-label text-md-left">City</label>
                                <div class="col-md-6">
                                    <input type="text" id="locality" class="field form-control border-50 input-w"
                                        name="eventCity" value="<?php echo $event->eventCity; ?>" required>
                                </div>
                            </div>

                            <div class="form-group row wideField">
                                <label for="postal-code" class="col-md-4 col-form-label text-md-left">Postal
                                    code</label>
                                <div class="col-md-6">
                                    <input type="text" id="postal_code" class="field form-control border-50 input-w"
                                        name="eventZipcode" value="<?php echo $event->eventZipcode; ?>" required>
                                </div>
                            </div>

                            <div class="form-group row wideField">
                                <label for="country" class="col-md-4 col-form-label text-md-left">Country
                                </label>
                                <div class="col-md-6 font-weight-bold">
                                    <select id="country" name="eventCountry"
                                        class="field form-control border-50 input-w font-weight-bold" required>
                                        <option class="text-weight-bold" value="">Select option</option>
                                        <?php if(count($countries) > 0): ?>
                                        <?php foreach($countries as $country): ?>
                                        <?php if($event->eventCountry == $country): ?>
                                        <option class="font-weight-bold" value="<?php echo $country; ?>"
                                            selected="selected">
                                            <?php echo $country; ?>
                                        </option>
                                        <?php else: ?>
                                        <option value="<?php echo $country; ?>"><?php echo $country; ?></option>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="event-date1" class="col-md-4 col-form-label text-md-left">Time of event
                                </label>
                                <div class="col-md-6">
                                    <div class="input-group date">
                                        <input type="text" class="form-control inp-group-radius-left input-w input-date"
                                            id="event-date1" name="StartDate"
                                            value="<?php echo date('d-m-Y', strtotime($event->StartDate)); ?>" required>
                                        <input type="time" class="form-control input-w" id="event-time1"
                                            name="StartTime" value="<?php echo $event->StartTime; ?>" required>
                                        <span class="input-group-addon fa-input pl-2 pr-2">
                                            <i style="color: #fff;font-size: 18px;" class="fa fa-calendar"></i></span>
                                    </div>
                                    <!--
                                    <hr style="margin-top: 0px;margin-bottom: 0px;border-top: none">
                                    <div class="input-group">
                                        <input type="time" class="form-control border-50 input-w mb-3" id="event-time1"
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
                                        <input type="text" class="form-control inp-group-radius-left input-w input-date"
                                            id="event-date2" name="EndDate"
                                            value="<?php echo date('d-m-Y', strtotime($event->EndDate)); ?>"
                                            onchange="checkTimestamp()" onfocus="timestampOnFocus()" required>
                                        <input type="time" class="form-control input-w" id="event-time2" name="EndTime"
                                            value="<?php echo $event->EndTime; ?>" onchange="checkTimestamp()"
                                            onfocus="timestampOnFocus()" required>
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
                            <div style="display: none;" class="form-group row timestamp-error">
                                <label class="col-md-4 col-form-label text-md-left">
                                </label>
                                <div id="timestamp-error" class="col-md-6"></div>

                            </div>

                            <hr class="w-100 mt-5 mb-5">

                            <div class="col-md-6 offset-md-4">
                                <div class="input-group">
                                    <input type="submit" id="submitEventForm" value="Save changes"
                                        style="background: #377E7F !important;border-radius:0;font-size: 15px;"
                                        class="btn btn-primary form-control inp-group-radius-left mb-3 text-left font-weight-bold">
                                    <span style="background: #275C5D;padding-top: 14px;"
                                        class="input-group-addon inp-group-radius-right pl-2 pr-2 mb-3">
                                        <i style="color: #fff;font-size: 18px;" class="fa fa-check"></i></span>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php if(isset($event->eventCountry)): ?>
<script>
(function() {
    let country = '<?php echo  $event->eventCountry; ?>';
    $('#country').val(country);
}());
</script>

<?php endif; ?>
