<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<ul class="metismenu" id="menu">
    <li>
        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-shopping-cart-full"></i><span><?php echo $this->language->tLine('Buyer'); ?></span></a>
        <ul class="collapse">
            <li>
                <a  href="<?php echo $this->baseUrl; ?>buyer_orders">
                    <i class="ti-gift"></i>&nbsp;
                    <span><?php echo $this->language->tLine('Orders'); ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->baseUrl; ?>buyer_tickets">
                    <i class="ti-receipt"></i>&nbsp;
                    <span><?php echo $this->language->tLine('Tickets'); ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->baseUrl; ?>buyer_reservations">
                    <i class="ti-pin-alt"></i>&nbsp;
                    <span><?php echo $this->language->tLine('Reservations'); ?></span>
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="<?php echo $this->baseUrl; ?>logout">
            <i class="ti-shift-left"></i>&nbsp;
            <span><?php echo $this->language->tLine('Logout'); ?></span>
        </a>
    </li>
    <li>
        <a href="<?php echo $this->baseUrl; ?>legal">
            <i class="ti-bookmark-alt"></i>&nbsp;
            <span><?php echo $this->language->tLine('Legal'); ?></span>
        </a>
    </li>
</ul>
