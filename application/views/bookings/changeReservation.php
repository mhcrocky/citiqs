<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="main-wrapper">
    <div class="col-half background-blue" id="info424">
        <div style="padding:20px">
            <form method="post" onsubmit="return changeReservation(this)">
                <fieldset>
                    <legend style="color:#fff">Change reservation</legend>
                    <div class="form-group">
                        <label for="oldReservationId">Old reservation transaction id:</label>
                        <input
                            type="text"
                            class="form-control"
                            id="oldReservationId"
                            name="oldReservationId"
                            data-form-check="1"
                            data-min-length="1"
                            data-error-message="Old reservation transaction id is requried"
                        >
                    </div>
                    <div class="form-group">
                        <label for="newReservationId">New reservation transaction id:</label>
                        <input
                            type="text"
                            class="form-control"
                            id="newReservationId"
                            name="newReservationId"
                            data-form-check="1"
                            data-min-length="1"
                            data-error-message="New reservation transaction id is requried"
                        >
                    </div>
                    <button type="submit" class="btn btn-default">Change</button>
                </fieldset>
            </form>
        </div>
    </div>
    <div class="col-half  background-yankee timeline-content">

    </div>
</div>
