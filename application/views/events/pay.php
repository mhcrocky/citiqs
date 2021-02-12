
<div class="limiter">
    <div class="container-login100">
        <div style="background: #fff !important;" class="wrap-login100">
            <div style="background: #fff !important;">
                <img style="width:100%" class="image-responsive" src="<?php echo base_url() ?>assets/images/events/<?php echo $this->session->userdata("eventImage"); ?>">
            </div>
            <form class="login100-form validate-form" action="<?php echo base_url(); ?>events/payment_proceed"
                method="POST">
                <div class="wrap-input100 validate-input m-b-26" data-validate="Email is required">
                    <span class="label-input100">Email</span>
                    <input class="input100" type="email" id="email" name="email" placeholder="Email Address" required>
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input m-b-18" data-validate="Address is required">
                    <span class="label-input100">Address</span>
                    <input class="input100" type="text" id="address" name="address" placeholder="Address" required>
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input m-b-18">
                    <span class="label-input100">Gender</span>
                    <select class="input100">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="nogender">No Gender</option>
                    </select>
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input m-b-18">
                    <span class="label-input100">Age</span>
                    <input class="input100" type="date" id="birthday" name="birthday" placeholder="Age" required>
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input m-b-18" data-validate="Phone Number is required">
                    <span class="label-input100">Phone Number</span>
                    <input class="input100" type="tel" name="mobileNumber" placeholder="Phone Number (Optional)">
                    <span class="focus-input100"></span>
                </div>

                <!--
                <div class="flex-sb-m w-full p-b-30">
                    <div class="contact100-form-checkbox">
                        <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                        <label class="label-checkbox100" for="ckb1">
                            
                        </label>
                    </div>
                    <div>
                        <a href="#" class="txt1">
                            
                        </a>
                    </div>
                </div>
                -->

                <div style="width: 100%;" class="w-100 mr-right text-right mt-5">
                    <button id="pay" class="btn btn-danger btn-lg btn-block mt-2">
                        PAY
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 