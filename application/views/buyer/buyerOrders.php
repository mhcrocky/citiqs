<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div style="margin: 10px 10px 0px 10px">
    <table
        id="buyerOrders"
        class="table table-striped table-bordered"
        style="width:100%"
    >
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order amount (1)</th>
                <th>Service fee (2)</th>
                <th>Waiter tip (3)</th>
                <th>Refund amount (4)</th>
                <th>Voucher amount (5)</th>
                <th>
                    Total amount
                    <br/>
                    (1 + 2 + 3 - 4 - 5)
                </th>
                <th>Voucher code</th>
                <th>Created</th>
                <th>Vendor</th>
                <th>Spot name</th>
                <th>Service type</th>
                <th>Payment method</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div id="orderDetails" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Details for order "<span id="orderid"></span>"
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-condensed table-responsive">
                    <tr>
                        <td>Place:</td>
                        <td id="vendorusername"></td>
                    </tr>
                    <tr>
                        <td>Spot:</td>
                        <td id="spotname"></td>
                    </tr>
                    <tr>
                        <td>Service type:</td>
                        <td id="spottype"></td>
                    </tr>
                    <tr>
                        <td>Receipt:</td>
                        <td><a href="" target="_blank" id="receiptLink">Link</a></td>
                    </tr>
                </table>
                <section>
                    <h6>Products</h6>
                    <ul class="list-group" id="products">
                    </ul>
                </section>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
<script>
    'use strict';
    const buyerOrders = (function(){
        let globals = {
            'tableId' : 'buyerOrders'
        }
        Object.freeze(globals);
        return globals;
    }());
</script>