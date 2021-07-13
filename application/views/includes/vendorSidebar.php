<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<ul class="metismenu" id="menu">
    <?php if (!$_SESSION['payNlServiceIdSet']) { ?>
        <div style="background-color: orangered" >
            <li data-menuid="0" data-toggle="modal" data-target="#setPayNlServiceId">
                <a href="javascript:void(0)">
                    <i class="ti-flag" style="background-color: orangered"></i>
                    <span><?php echo $this->language->tLine('FINISH ACCOUNT SETUP'); ?></span>
                </a>
            </li>
        </div>
    <?php } ?>
    <?php if ($_SESSION['businessTypeId'] != 26) { ?>
        <li data-menuid="0"><a href="<?php echo $this->baseUrl;?>loggedin"><i class="ti-home"></i><span><?php echo $this->language->tLine('Homepage'); ?></span></a></li>
     <?php } ?>
    <?php if ($_SESSION['businessTypeId'] != 26) { ?>
    <li data-menuid="2">
        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-shopping-cart-full"></i><span><?php echo $this->language->tLine('Marketing & Loyalty'); ?></span></a>
        <ul class="collapse">
            <li data-menuid="2.6"><a href="<?php echo $this->baseUrl; ?>voucher/index"><i class="ti-gift"></i> <span><?php echo $this->language->tLine('Vouchers add/edit'); ?></span></a>
            <li data-menuid="2.7"><a href="<?php echo $this->baseUrl; ?>voucher/send"><i class="ti-receipt"></i> <span><?php echo $this->language->tLine('Send Vouchers'); ?></span></a>
			<li data-menuid="2.5"><a href="<?php echo $this->baseUrl; ?>campaigns"><i class="ti-receipt"></i> <span><?php echo $this->language->tLine('Campaign add/edit'); ?></span></a>
<!--			<li data-menuid="2.5"><a href="--><?php //echo $this->baseUrl; ?><!--lists"><i class="ti-receipt"></i> <span>--><?php //echo $this->language->tLine('Create lists'); ?><!--</span></a>-->
<!--			<li data-menuid="2.9"><a href="--><?php //echo $this->baseUrl; ?><!--emaillists"><i class="ti-receipt"></i> <span>--><?php //echo $this->language->tLine('Connect emails lists'); ?><!--</span></a>-->
<!--			<li data-menuid="2.10"><a href="--><?php //echo $this->baseUrl; ?><!--campaignslists"><i class="ti-receipt"></i> <span>--><?php //echo $this->language->tLine('Connect campaign & lists'); ?><!--</span></a>-->
<!--			<li data-menuid="2.10"><a href="--><?php //echo $this->baseUrl; ?><!--customeremail"><i class="ti-receipt"></i> <span>--><?php //echo $this->language->tLine('list members'); ?><!--</span></a>-->
			<li data-menuid="2.11"><a href="<?php echo $this->baseUrl; ?>customeremail/sent"><i class="ti-receipt"></i> <span><?php echo $this->language->tLine('Campaigns Sent'); ?></span></a>
				tiqs.com/alfred/customeremail/
<!--            <li data-menuid="2.1"><a href="--><?php //echo $this->baseUrl; ?><!--marketing/targeting"><i class="ti-pin-alt"></i><span>--><?php //echo $this->language->tLine('Targeting'); ?><!--</span></a></li>-->
<!--            <li data-menuid="2.2"><a href="--><?php //echo $this->baseUrl; ?><!--marketing/selection"><i class="ti-comment"></i> <span>--><?php //echo $this->language->tLine('Notification Messaging'); ?><!--</span></a></li>-->
            <!--											<li data-menuid="2.3"><a href="--><?php //echo $this->baseUrl; ?><!--dashboard"><i class="ti-user"></i> <span>RSVP Pre-register</span></a></li>-->
            <!--											<li data-menuid="2.4"><a href="--><?php //echo $this->baseUrl; ?><!--dashboard"><i class="ti-pencil-alt"></i> <span>E-mail Campaigns</span></a></li>-->
            <!--											<li data-menuid="2.5"><a href="--><?php //echo $this->baseUrl; ?><!--visitors"><i class="ti-user"></i> <span>Visitors</span></a></li>-->

            <!--												<ul class="collapse">-->
            <!--													<li data-menuid="2.6.1">-->
            <!--														<a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/settings">-->
            <!--															<i class="ti-shopping-cart-full"></i>-->
            <!--															<span>Add/design vouchers</span>-->
            <!--														</a>-->
            <!--													</li>-->
            <!--													<li data-menuid="2.6.2">-->
            <!--														<a href="--><?php //echo $this->baseUrl. 'booking_agenda/design'; ?><!--"-->
            <!--														><i class="ti-clipboard"></i> <span>Voucher statistics</span>-->
            <!--														</a>-->
            <!--													</li>-->
            <!--												</ul>-->
            <!--											</li>-->
        </ul>
    </li>
    <?php } ?>
    <?php if ($_SESSION['businessTypeId'] != 26) { ?>

    <li data-menuid="3">
        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-bar-chart"></i><span><?php echo $this->language->tLine('Finance'); ?></span></a>

			<ul class="collapse">
				<li data-menuid="3.2"><a href="<?php echo $this->baseUrl; ?>businessreports"><i class="ti-layers-alt"></i> <span><?php echo $this->language->tLine('Transactions QR Menu'); ?></span></a></li>
				<li data-menuid="3.2"><a href="<?php echo $this->baseUrl; ?>customer_panel/financial_report"><i class="ti-layers-alt"></i> <span><?php echo $this->language->tLine('Transactions Reservations'); ?></span></a></li>
				<li data-menuid="3.3"><a href="<?php echo $this->baseUrl; ?>events/financial_report"><i class="ti-layers-alt"></i> <span><?php echo $this->language->tLine('Transactions E-Tickets'); ?></span></a></li>
				<li data-menuid="3.4"><a href="<?php echo $this->baseUrl; ?>invoices"><i class="ti-layout"></i> <span><?php echo $this->language->tLine('Invoices'); ?></span></a></li>

				<li data-menuid="3.1.1"><a href="<?php echo $this->baseUrl; ?>clearing"><i class="ti-wallet"></i> <span><?php echo $this->language->tLine('PAY-OUT QR Menu'); ?></span></a></li>
<!--				<li data-menuid="3.1.2"><a href="--><?php //echo $this->baseUrl; ?><!--clearingreservations"><i class="ti-layers-alt"></i> <span>--><?php //echo $this->language->tLine('PAY-OUT Reservations'); ?><!--</span></a></li>-->
<!--				<li data-menuid="3.1.3"><a href="--><?php //echo $this->baseUrl; ?><!--clearingtickets"><i class="ti-layers-alt"></i> <span>--><?php //echo $this->language->tLine('PAY-OUT E-Tickets'); ?><!--</span></a></li>-->
				<li><a href="<?php echo $this->baseUrl; ?>payment_methods"><i class="ti-credit-card"></i><span><?php echo $this->language->tLine('Payment methods'); ?></span></a></li>
			</ul>

			<!--		<ul class="collapse">-->
			<!--			<li data-menuid="3.1">-->
			<!--				<a href="javascript:void(0)" aria-expanded="true"><i class="ti-bag"></i><span>--><?php //echo $this->language->tLine('Pay-out'); ?><!--</span></a>-->
			<!---->
			<!--			</li>-->
			<!---->
			<!--            <li data-menuid="3.2">-->
			<!--                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-bag"></i><span>--><?php //echo $this->language->tLine('Transactions'); ?><!--</span></a>-->
			<!--                <ul class="collapse">-->
			<!--   </ul>-->
			<!--            </li>-->
         <?php if (intval($_SESSION['userId']) === $this->tiqsMainId) { ?>
                <li data-menuid="3.5"><a href="<?php echo $this->baseUrl; ?>all_payment_methods"><i class="ti-pencil-alt"></i><span><?php echo $this->language->tLine('All payment methods'); ?></span></a></li>
            <?php } ?>

            <!--											<li><a href="--><?php //echo $this->baseUrl; ?><!--dashboard"><i class="ti-pencil-alt"></i> <span>Payment links</span></a></li>-->
            <!--											<li>-->
            <!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Settings</span></a>-->
            <!--												<ul class="collapse">-->
            <!--													<li>-->
            <!--														<a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/settings">-->
            <!--															<i class="ti-shopping-cart-full"></i>-->
            <!--															<span>PSP keycode</span>-->
            <!--														</a>-->
            <!--													</li>-->
            <!--													<li>-->
            <!--														<a href="--><?php //echo $this->baseUrl. 'booking_agenda/design'; ?><!--"-->
            <!--														><i class="ti-clipboard"></i> <span>Payment plan</span>-->
            <!--														</a>-->
            <!--													</li>-->
            <!--												</ul>-->
            <!--											</li>-->
<!--        </ul>-->
    <li>
    <?php } ?>
    <?php if ($_SESSION['businessTypeId'] != 26) { ?>
    <li data-menuid="4"><a href="javascript:void(0)" aria-expanded="true"><i class="ti-view-grid"></i><span><?php echo $this->language->tLine('QR Menu'); ?> & <?php echo $this->language->tLine('Cash desk'); ?></span></a>
        <ul class="collapse">
			<li data-menuid="10.7"><a href="<?php echo $this->baseUrl; ?>openandclose"><i class="ti-time"></i> <span><?php echo $this->language->tLine('Open and Close'); ?></span></a></li>
			<li data-menuid="4.1"><a href="<?php echo $this->baseUrl; ?>orders"><i class="ti-stats-up"></i><span><?php echo $this->language->tLine('Orders'); ?></span></a></li>
            <li data-menuid="4.2"><a href="<?php echo $this->baseUrl; ?>pos"><i class="ti-bar-chart"></i><span><?php echo $this->language->tLine('Cash desk'); ?></span></a></li>
            <li data-menuid="4.3"><a href="<?php echo $this->baseUrl; ?>productsonoff/active"><i class="ti-power-off"></i> <span><?php echo $this->language->tLine('Products ON/OFF'); ?></span></a></li>
			<li data-menuid="4.4.3"><a href="<?php echo $this->baseUrl; ?>products/active"><i class="ti-bag"></i> <span><?php echo $this->language->tLine('Products ADD/EDIT'); ?></span></a></li>
			<li data-menuid="4.4.2"><a href="<?php echo $this->baseUrl; ?>product_types"><i class="ti-layers-alt"></i> <span><?php echo $this->language->tLine('Product Types'); ?></span></a></li>
			<li data-menuid="4.4.1"><a href="<?php echo $this->baseUrl; ?>product_categories"><i class="ti-layout-accordion-separated"></i> <span><?php echo $this->language->tLine('Category'); ?></span></a></li>
			<li data-menuid="4.6.2"><a href="<?php echo $this->baseUrl; ?>spots"><i class="ti-flag-alt"></i><span><?php echo $this->language->tLine('Spots'); ?></span></a></li>
			<li data-menuid="4.7.3"><a href="<?php echo $this->baseUrl; ?>qrcode"><i class="ti-shopping-cart"></i> <span><?php echo $this->language->tLine('QR spot link'); ?></span></a></li>
			<li><a href="<?php echo $this->baseUrl; ?>areas"><i class="ti-flag-alt"></i><span><?php echo $this->language->tLine('Areas'); ?></span></a></li>
			<li data-menuid="4.6.1"><a href="<?php echo $this->baseUrl; ?>printers"><i class="ti-printer"></i><span><?php echo $this->language->tLine('Printers'); ?></span></a></li>
			<li data-menuid="4.7.2"><a href="<?php echo $this->baseUrl; ?>viewdesign"><i class="ti-shopping-cart"></i> <span><?php echo $this->language->tLine('Design'); ?></span></a></li>
			<li data-menuid="4.7.1"><a href="<?php echo $this->baseUrl; ?>emaildesigner"><i class="ti-email"></i> <span><?php echo $this->language->tLine('Landing page'); ?></span></a></li>
			<li data-menuid="4.5.1"><a href="<?php echo $this->baseUrl; ?>video"><i class="ti-video-camera"></i> <span><?php echo $this->language->tLine('Video'); ?></span></a></li>
			<li data-menuid="4.8.2"><a href="<?php echo $this->baseUrl; ?>dayreport"><i class="ti-layers-alt"></i> <span><?php echo $this->language->tLine('Day report'); ?></span></a></li>
			<li data-menuid="4.8.3"><a href="<?php echo $this->baseUrl; ?>vatreport"><i class="ti-bag"></i> <span><?php echo $this->language->tLine('Payment report'); ?></span></a></li>
			<li data-menuid="4.8.1"><a href="<?php echo $this->baseUrl; ?>warehouse"><i class="ti-layout-accordion-separated"></i> <span><?php echo $this->language->tLine('Product report'); ?></span></a></li>
			<li data-menuid="4.9.1"><a href="<?php echo $this->baseUrl . 'make_order?vendorid=' . $this->session->userdata('userId'); ?>" target="_blank"><i class="ti-shopping-cart-full"></i> <span><?php echo $this->language->tLine('Url QR Menu'); ?></span></a></li>
<!--			<li data-menuid="4.9.2">-->
<!--				<a href="--><?php //echo $this->baseUrl . 'check424/' . $this->session->userdata('userId'); ?><!--" target="_blank">-->
<!--					<i class="ti-book"></i>-->
<!--					<span>--><?php //echo $this->language->tLine('Url Visitor registration'); ?><!--</span>-->
<!--				</a>-->
<!--			</li>-->

<!--			<i class="ti-shopping-cart-full"></i> <span>--><?php //echo $this->language->tLine('QR Menu'); ?><!--</span>-->

			<!--			<li data-menuid="4.4">-->
			<!--                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-bag"></i><span>--><?php //echo $this->language->tLine('Products'); ?><!--</span></a>-->
			<!--                <ul class="collapse">-->
			<!--              </ul>-->
			<!--            </li>-->
			<!--            <li data-menuid="4.5">-->
			<!--                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-video-camera"></i><span>--><?php //echo $this->language->tLine('video'); ?><!--</span></a>-->
			<!--                <ul class="collapse">-->
			<!--                    <li data-menuid="4.5.1"><a href="--><?php //echo $this->baseUrl; ?><!--video"><i class="ti-video-camera"></i> <span>--><?php //echo $this->language->tLine('Manage'); ?><!--</span></a></li>-->
			<!--                </ul>-->
			<!--            </li>-->
			<!---->
			<!--            <li data-menuid="4.6">-->
			<!--                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-ink-pen"></i><span>--><?php //echo $this->language->tLine('Areas, printers & spots'); ?><!--</span></a>-->
			<!--                <ul class="collapse">-->
			<!--                    <li><a href="--><?php //echo $this->baseUrl; ?><!--areas"><i class="ti-flag-alt"></i><span>--><?php //echo $this->language->tLine('Areas'); ?><!--</span></a></li>-->
			<!--                    <li data-menuid="4.6.1"><a href="--><?php //echo $this->baseUrl; ?><!--printers"><i class="ti-printer"></i><span>--><?php //echo $this->language->tLine('Printers'); ?><!--</span></a></li>-->
			<!--                    <li data-menuid="4.6.2"><a href="--><?php //echo $this->baseUrl; ?><!--spots"><i class="ti-flag-alt"></i><span>--><?php //echo $this->language->tLine('Spots'); ?><!--</span></a></li>-->
			<!--                </ul>-->
			<!--            </li>-->
			<!--            -->
			<!--            <li data-menuid="4.7">-->
			<!--                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-ink-pen"></i><span>--><?php //echo $this->language->tLine('Settings'); ?><!--</span></a>-->
			<!--                <ul class="collapse">-->
			<!--                    <li data-menuid="4.7.1"><a href="--><?php //echo $this->baseUrl; ?><!--emaildesigner"><i class="ti-email"></i> <span>--><?php //echo $this->language->tLine('Email'); ?><!--</span></a></li>-->
			<!--                    <li data-menuid="4.7.2"><a href="--><?php //echo $this->baseUrl; ?><!--viewdesign"><i class="ti-shopping-cart"></i> <span>--><?php //echo $this->language->tLine('QR Menu'); ?><!--</span></a></li>-->
			<!--                    <li data-menuid="4.7.3"><a href="--><?php //echo $this->baseUrl; ?><!--qrcode"><i class="ti-shopping-cart"></i> <span>--><?php //echo $this->language->tLine('QR Sticker link'); ?><!--</span></a></li>-->
			<!--                </ul>-->
			<!--            </li>-->
			<!--            <li data-menuid="4.8">-->
			<!--                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-bag"></i><span>--><?php //echo $this->language->tLine('Statistics'); ?><!--</span></a>-->
			<!--                <ul class="collapse">-->
			<!--                    <li data-menuid="4.8.1"><a href="--><?php //echo $this->baseUrl; ?><!--warehouse"><i class="ti-layout-accordion-separated"></i> <span>--><?php //echo $this->language->tLine('Reports'); ?><!--</span></a></li>-->
			<!--                    <li data-menuid="4.8.2"><a href="--><?php //echo $this->baseUrl; ?><!--dayreport"><i class="ti-layers-alt"></i> <span>Day-report</span></a></li>-->
			<!--                    <li data-menuid="4.8.3"><a href="--><?php //echo $this->baseUrl; ?><!--vatreport"><i class="ti-bag"></i> <span>Payment-report</span></a></li>-->
			<!--                </ul>-->
			<!--            </li>-->
			<!--            <li data-menuid="4.9">-->
			<!--                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-share"></i><span>--><?php //echo $this->language->tLine('Your links'); ?><!--</span></a>-->
			<!--                <ul class="collapse">-->

			<!--                </ul>-->
			<!--            </li>-->
            <!--											<li data-menuid="12.1">-->
            <!--												<a href="--><?php //echo $this->baseUrl . 'make_order?vendorid=' . $this->session->userdata('userId'); ?><!--" target="_blank">-->
            <!--													<i class="ti-shopping-cart-full"></i> <span>--><?php //echo $this->language->tLine('URL link'); ?><!--</span>-->
            <!--												</a>-->
            <!--											</li>-->
            
        </ul>
    </li>
    <?php } ?>
    <?php if ($_SESSION['businessTypeId'] != 999) { ?>
    <li data-menuid="5">
        <?php if ($_SESSION['businessTypeId'] == 26) { ?>
            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-calendar"></i><span><?php echo $this->language->tLine('Bezichtigingen'); ?></span></a>
        <?php } ?>
        <?php if ($_SESSION['businessTypeId'] != 26) { ?>
            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-calendar"></i><span><?php echo $this->language->tLine('Reservations'); ?></span></a>
        <?php } ?>

        <ul class="collapse">
            <li data-menuid="5.1"><a href="<?php echo $this->baseUrl;?>customer_panel/agenda"><i class="ti-agenda"></i> <span><?php echo $this->language->tLine('Reservations ADD/EDIT'); ?></span></a></li>
            <li data-menuid="5.2"><a href="<?php echo $this->baseUrl;?>customer_panel/manual_reservations"><i class="ti-ticket"></i> <span><?php echo $this->language->tLine('Manual booking'); ?></span></a></li>
			<li data-menuid="5.5"><a href="<?php echo $this->baseUrl; ?>customer_panel/financial_report2"><i class="ti-bar-chart"></i> <span><?php echo $this->language->tLine('Sales'); ?></span></a></li>
            <li data-menuid="5.3"><a href="<?php echo $this->baseUrl;?>customer_panel/booking_tickets"><i class="ti-stats-up"></i> <span><?php echo $this->language->tLine('Statistics'); ?></span></a></li>
			<li data-menuid="5.6.1"><a href="<?php echo $this->baseUrl;?>customer_panel/settings"><i class="ti-shopping-cart-full"></i><span><?php echo $this->language->tLine('Terms and conditions'); ?></span></a></li>
			<li data-menuid="5.6.2"><a href="<?php echo $this->baseUrl;?>agenda_booking/design"><i class="ti-clipboard"></i> <span><?php echo $this->language->tLine('Design Agenda view'); ?></span></a></li>
			<li data-menuid="12.3"><a href="<?php echo $this->baseUrl. "agenda_booking/" . $userShortUrl; ?>" data-toggle="modal" data-target="#copyAgendaBookingUrlModal"><i class="ti-agenda"></i> <span><?php echo $this->language->tLine('Url Agenda view'); ?></span></a></li>
			<li data-menuid="12.4"><a href="<?php echo $this->baseUrl. "booking_agenda/" . $userShortUrl; ?>" data-toggle="modal" data-target="#copyBookingAgendaUrlModal"><i class="ti-clipboard"></i> <span><?php echo $this->language->tLine('Url list view'); ?></span></a></li>
        </ul>
    </li>
    <?php } ?>
    <?php if ($_SESSION['businessTypeId'] != 26) { ?>
        <li data-menuid="6">
        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-ticket"></i><span><?php echo $this->language->tLine('e-ticketing'); ?></span></a>
        <ul class="collapse">
			<li data-menuid="1"><a href="<?php echo $this->baseUrl;?>dashboard"><i class="ti-dashboard"></i><span><?php echo $this->language->tLine('Dashboard'); ?></span></a></li>
			<li data-menuid="6.1"><a href="<?php echo $this->baseUrl;?>events/create"><i class="ti-agenda"></i> <span><?php echo $this->language->tLine('Create your event'); ?></span></a></li>
            <li data-menuid="6.2"><a href="<?php echo $this->baseUrl;?>events"><i class="ti-ticket"></i> <span><?php echo $this->language->tLine('Your Events'); ?></span></a></li>
			<li data-menuid="5.3"><a href="<?php echo $this->baseUrl;?>events/tags_stats"><i class="ti-stats-up"></i> <span><?php echo $this->language->tLine('Statistics'); ?></span></a></li>
<!--			<li data-menuid="6.3"><a href="--><?php //echo $this->baseUrl;?><!--events/marketing"><i class="ti-email"></i> <span>--><?php //echo $this->language->tLine('Email marketing'); ?><!--</span></a></li>-->
<!--            <li data-menuid="6.3"><a href="--><?php //echo $this->baseUrl;?><!--events/emaildesigner"><i class="ti-email"></i> <span>--><?php //echo $this->language->tLine('Email Designer'); ?><!--</span></a></li>-->
            <li data-menuid="6.4"><a href="<?php echo $this->baseUrl;?>events/tags"><i class="ti-email"></i> <span>tags and pixels</span></a></li>
			<li data-menuid="6.5"><a href="<?php echo $this->baseUrl;?>events/scannedin"><i class="ti-email"></i> <span>scanner results</span></a></li>
            <li data-menuid="6.6"><a href="<?php echo $this->baseUrl;?>events/viewdesign"><i class="ti-ticket"></i> <span><?php echo $this->language->tLine('Shop settings'); ?></span></a></li>

            <!--											<li data-menuid="6.5">-->
            <!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Settings</span></a>-->
            <!--												<ul class="collapse">-->
            <!--													-->
            <!--													<li data-menuid="6.5.1"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span>Your Events</span></a></li>-->
            <!---->
            <!--													<li data-menuid="6.5.2"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>RSVP/Guest lists</a></li>-->
            <!--													<li data-menuid="6.5.3"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>3rd party</a></li>-->
            <!--													<li data-menuid="6.5.4"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Discount codes</a></li>-->
            <!--													<li data-menuid="6.5.5"><a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/reservations_report"><i class="ti-write"></i> <span>Secure ticket box</span></a></li>-->
            <!--													<li data-menuid="6.5.6"><a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/report"><i class="ti-clipboard"></i> <span>Create barcodes</span></a></li>-->
            <!--												-->
            <!--												</ul>-->
            <!--											</li>-->
            <!--											<li data-menuid="6.6">-->
            <!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Statistics</span></a>-->
            <!--												<ul class="collapse">-->
            <!--													<li data-menuid="6.6.1"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span>Event main Statistics</span></a></li>-->
            <!--													<li data-menuid="6.6.2"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Detail sales statistics</a></li>-->
            <!--													<li data-menuid="6.6.3"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Detail event reports</a></li>-->
            <!--													<li data-menuid="6.6.4"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Detail buyer reports</a></li>-->
            <!--													<li data-menuid="6.6.5"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Grand partner insights</a></li>-->
            <!--													<li data-menuid="6.6.6"><a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/reservations_report"><i class="ti-write"></i> <span>Reservations Report</span></a></li>-->
            <!--													<li data-menuid="6.6.7"><a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/report"><i class="ti-clipboard"></i> <span>Report</span></a></li>-->
            <!--													<li data-menuid="6.6.8"><a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/pivot"><i class="ti-bar-chart"></i> <span>Export</span></a></li>-->
            <!--												</ul>-->
            <!--											</li>-->
            <!---->
            <!---->
            <!---->
            <!--											<li data-menuid="6.7">-->
            <!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>POS</span></a>-->
            <!--												<ul class="collapse">-->
            <!--													<li data-menuid="6.7.1"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>POS entrance settings</a></li>-->
            <!--												</ul>-->
            <!--											</li>-->
            <!--											<li data-menuid="6.8">-->
            <!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Entrance</span></a>-->
            <!--												<ul class="collapse">-->
            <!--													-->
            <!--													<li data-menuid="6.8.1"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Scanning results</a></li>-->
            <!--													<li data-menuid="6.8.2"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Scanning details</a></li>-->
            <!--													-->
            <!--												</ul>-->
            <!--											</li>-->
            <!--											<li data-menuid="6.9">-->
            <!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Scanners</span></a>-->
            <!--												<ul class="collapse">-->
            <!--													-->
            <!--													<li data-menuid="6.9.1"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span>Scanner settings</span></a></li>-->
            <!--													-->
            <!--												</ul>-->
            <!--											</li>-->
            <!---->
            <!--											<li data-menuid="6.10">-->
            <!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Event fans</span></a>-->
            <!--												<ul class="collapse">-->
            <!--													<li data-menuid="6.10.1"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/agenda"><i class="ti-agenda"></i> <span>Rewards</span></a></li>-->
            <!--													<li data-menuid="6.10.2"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span>Requests</span></a></li>-->
            <!--													<li data-menuid="6.10.3"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Teams</a></li>-->
            <!--													<li data-menuid="6.10.4"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Statistics</a></li>-->
            <!--													<li data-menuid="6.10.5"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Assigned to events</a></li>-->
            <!--													<li data-menuid="6.10.6"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>invite by mail template</a></li>-->
            <!--													<li data-menuid="6.10.7"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>invite from fan-base</a></li>-->
            <!--												</ul>-->
            <!--											<li data-menuid="6.11">-->
            <!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Event proppers</span></a>-->
            <!--												<ul class="collapse">-->
            <!--													<li data-menuid="6.11.1"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/agenda"><i class="ti-agenda"></i> <span>Rewards</span></a></li>-->
            <!--													-->
            <!--													<li data-menuid="6.11.2"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span>Requests</span></a></li>-->
            <!--													<li data-menuid="6.11.3"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Teams</a></li>-->
            <!--													<li data-menuid="6.11.4"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Statistics</a></li>-->
            <!--													<li data-menuid="6.11.5"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Assigned to events</a></li>-->
            <!--													<li data-menuid="6.11.6"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>invite by mail template</a></li>-->
            <!--													<li data-menuid="6.11.7"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>invite from fan-base</a></li>-->
            <!--													-->
            <!--													-->
            <!--												</ul>-->
            <!--                                            </li>-->
            <!--											<li data-menuid="6.12">-->
            <!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Settings</span></a>-->
            <!--												<ul class="collapse">-->
            <!--													<li data-menuid="6.12.1">-->
            <!--														<a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/settings">-->
            <!--															<i class="ti-shopping-cart-full"></i>-->
            <!--															<span>Terms and conditions</span>-->
            <!--														</a>-->
            <!--													</li>-->
            <!--													<li data-menuid="6.12.2">-->
            <!--														<a href="--><?php //echo $this->baseUrl. 'agenda_booking/design'; ?><!--"-->
            <!--														><i class="ti-clipboard"></i> <span>Design Agenda reservations</span>-->
            <!--														</a>-->
            <!--													</li>-->
            <!--												</ul>-->
                                                        <!-- </li> -->
        </ul>
    </li>
    <?php } ?>
    <?php if ($_SESSION['businessTypeId'] != 26) { ?>
    <li data-menuid="7">
        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-home"></i><span><?php echo $this->language->tLine('Floorplan'); ?></span></a>
        <ul class="collapse">
            <li data-menuid="7.1"><a href="<?php echo $this->baseUrl;?>floorplans"><i class="ti-settings"></i> <span><?php echo $this->language->tLine('Floorplans'); ?></span></a></li>
            <li data-menuid="7.2"><a href="<?php echo $this->baseUrl;?>add_floorplan"><i class="ti-settings"></i> <span><?php echo $this->language->tLine('Add floorplan'); ?></span></a></li>
        </ul>
    </li>
    <li data-menuid="8">
        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-direction-alt"></i><span><?php echo $this->language->tLine('Lost & Found'); ?></span></a>
        <ul class="collapse">
            <li data-menuid="8.1"><a href="https://tiqs.com/lostandfound"><i class="ti-direction-alt"></i> <span><?php echo $this->language->tLine('Go to Lost & Found'); ?></span></a></li>
        </ul>
    </li>
    <li data-menuid="9">
        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-user"></i><span><?php echo $this->language->tLine('Users'); ?></span></a>
        <ul class="collapse">
            <li data-menuid="9.1"><a href="<?php echo $this->baseUrl;?>employee"><i class="ti-user"></i> <span><?php echo $this->language->tLine("Employee's"); ?></span></a></li>
        </ul>
    </li>
    <?php } ?>
    <?php if ($_SESSION['businessTypeId'] != 999) { ?>
    <li data-menuid="10">
        <a href="javascript:void(0)"  aria-expanded="true"><i class="ti-id-badge"></i><span><?php echo $this->language->tLine('Business Profile'); ?> </span></a>
        <ul class="collapse">
            <li data-menuid="10.1"><a href="<?php echo $this->baseUrl; ?>address"><i class="ti-location-pin"></i> <span><?php echo $this->language->tLine('Address'); ?></span></a></li>
            <li data-menuid="10.2"><a href="<?php echo $this->baseUrl; ?>changepassword"><i class="ti-flickr"></i> <span><?php echo $this->language->tLine('Change Password'); ?></span></a></li>
            <li data-menuid="10.3"><a href="<?php echo $this->baseUrl; ?>paymentsettings"><i class="ti-receipt"></i> <span><?php echo $this->language->tLine('Payment Settings'); ?></span></a></li>
            <li data-menuid="10.4"><a href="<?php echo $this->baseUrl; ?>shopsettings"><i class="ti-shopping-cart"></i> <span><?php echo $this->language->tLine('Shop Settings'); ?></span></a></li>
            <li data-menuid="10.5"><a href="<?php echo $this->baseUrl; ?>logo"><i class="ti-image"></i> <span><?php echo $this->language->tLine('Logo'); ?></span></a></li>
            <li data-menuid="10.6"><a href="<?php echo $this->baseUrl; ?>termsofuse"><i class="ti-align-justify"></i> <span><?php echo $this->language->tLine('Terms of Use'); ?></span></a></li>
            <li data-menuid="10.7"><a href="<?php echo $this->baseUrl; ?>openandclose"><i class="ti-time"></i> <span><?php echo $this->language->tLine('Open and Close'); ?></span></a></li>
            <li data-menuid="10.8"><a href="<?php echo $this->baseUrl; ?>userapi"><i class="ti-location-pin"></i> <span>API</span></a></li>
            <li><a href="<?php echo $this->baseUrl; ?>paynl_merchant"><i class="ti-location-pin"></i> <span><?php echo $this->language->tLine('KYC Documents'); ?></span></a></li>
            <li data-menuid="10.9"><a href="<?php echo $this->baseUrl; ?>reset_times"><i class="ti-time"></i> <span><?php echo $this->language->tLine('Reset times'); ?></span></a></li>
            <li data-menuid="11.0"><a href="<?php echo $this->baseUrl; ?>reports_settings"><i class="fa fa-list"></i> <span><?php echo $this->language->tLine('Reports settings'); ?></span></a></li>                                            
        </ul>
    </li>
    <!--									<li>-->
    <!--										<a href="javascript:void(0)" aria-expanded="true"><i class="ti-calendar"></i><span>Online integration</span></a>-->
    <!--										<ul class="collapse">-->
    <!--											<li>-->
    <!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-bag"></i><span>iframes</span></a>-->
    <!--												<ul class="collapse">-->
    <!--													<li><a href="--><?php //echo $this->baseUrl; ?><!--viewdesign"><i class="ti-shopping-cart"></i> <span>Store</span></a></li>-->
    <!--													<li><a href="--><?php //echo $this->baseUrl; ?><!--viewdesign"><i class="ti-shopping-cart"></i> <span>Agenda</span></a></li>-->
    <!--													<li><a href="--><?php //echo $this->baseUrl; ?><!--viewdesign"><i class="ti-shopping-cart"></i> <span>Reservations</span></a></li>-->
    <!--													<li><a href="--><?php //echo $this->baseUrl; ?><!--viewdesign"><i class="ti-shopping-cart"></i> <span>ticketshop</span></a></li>-->
    <!--												</ul>-->
    <!--											</li>-->
    <!--										</ul>-->
    <!--									</li>-->

    <!--                                    <li data-menuid="11">-->
    <!--                                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i><span>Connect</span></a>-->
    <!--                                        <ul class="collapse">-->
    <!--											<li data-menuid="11.1"><a href="--><?php //echo $this->baseUrl; ?><!--visma/config"><i class="ti-credit-card"></i> <span>Visma Accounting</span></a></li>-->
    <!--                                            <li data-menuid="11.2"><a href="http://localhost/tiqsbox/index.php/Admin"><i class="ti-package"></i> <span>Tiqsbox</span></a></li>-->
    <!--                                        </ul>-->
    <!--                                    </li>-->

    <?php } ?>
    <?php if ($_SESSION['businessTypeId'] != 26) { ?>
        <li data-menuid="9">
            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-mobile"></i><span><?php echo $this->language->tLine('APP'); ?></span></a>
            <ul class="collapse">
                <li data-menuid="14.1"><a href="<?php echo $this->baseUrl;?>"><i class="ti-mobile"></i> <span><?php echo $this->language->tLine("Settings"); ?></span></a></li>
            </ul>
        </li>

        <li data-menuid="13">
        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-layout-width-default"></i><span><?php echo $this->language->tLine('Templates'); ?></span></a>
        <ul class="collapse">
            <li data-menuid="13.1"><a href="<?php echo $this->baseUrl; ?>list_template"><i class="ti-layout-width-full"></i> <span><?php echo $this->language->tLine('Templates'); ?></span></a></li>
            <li data-menuid="13.1"><a href="<?php echo $this->baseUrl; ?>add_template"><i class="ti-layout-width-default-alt"></i> <span><?php echo $this->language->tLine('Add template'); ?></span></a></li>
        </ul>
    </li>
    <?php } ?>
    <li><a href="<?php echo $this->baseUrl; ?>logout"><i class="ti-shift-left"></i> <span><?php echo $this->language->tLine('Logout'); ?></span></a></li>
    <li><a href="<?php echo $this->baseUrl; ?>legal"><i class="ti-bookmark-alt"></i> <span><?php echo $this->language->tLine('Legal'); ?></span></a></li>
</ul>
