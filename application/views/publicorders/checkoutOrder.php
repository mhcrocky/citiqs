<main class="container" style="text-align:left; margin-bottom:20px">
    <h1>Checkout order</h1>
    <div class="row">
        <form method="post" action="<?php echo base_url() . 'publicorders/submitOrder'; ?>">
            <filedset>
                <legend>Fill up the form. All fields are mandatory</legend>
                <input type="text" name="user[roleid]" value="<?php echo $buyerRole; ?>" required readonly hidden />
                <input type="text" name="user[usershorturl]" value="<?php echo $usershorturl; ?>" required readonly hidden />
                <input type="text" name="user[salesagent]" value="<?php echo $buyerRole; ?>" required readonly hidden />
                <div class="form-group col-sm-6">
                    <label for="first_name">First name:</label>
                    <input type="text" class="form-control" id="first_name" name="user[first_name]" placeholder="First name" required autofocus />
                </div>
                <div class="form-group col-sm-6">
                    <label for="second_name">Second name:</label>
                    <input type="text" class="form-control" id="second_name" name="user[second_name]" placeholder="Second name" required />
                </div>
                <div class="form-group col-sm-6">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="user[email]" placeholder="Email" required />
                </div>
                <div class="form-group col-sm-6">
                    <label for="mobile">Mobile (without country prefix):</label>
                    <input type="text" class="form-control" id="mobile" name="user[mobile]" placeholder="Mobile" pattern=[0-9]+ required />
                </div>
                <div class="table-responsive col-sm-12" style="margin-top:15px">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $total = 0;
                            $quantity = 0;
                            foreach ($orderDetails as $id => $details) {
                            ?>
                                <tr>
                                    <td><?php echo $details['name'][0]; ?></td>
                                    <td><?php echo $details['category'][0]; ?></td>
                                    <td><?php echo $details['shortDescription'][0]; ?></td>
                                    <td><?php echo $details['quantity'][0]; ?></td>
                                    <td><?php echo number_format($details['amount'][0], 2, ",", "."); ?> &euro;</td>
                                </tr>
                                <input
                                    type="number"
                                    name="orderExtended[<?php echo $id; ?>][quantity]"
                                    value="<?php echo $details['quantity'][0]; ?>"
                                    readonly required hidden />
                            <?php
                                $total += filter_var($details['amount'][0], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                                $quantity += intval($details['quantity'][0]);
                            }
                        ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Total:</td>
                                <td><?php echo $quantity; ?></td>
                                <td><?php echo number_format($total, 2, ",", "."); ?> &euro;</td>
                            </tr>
                            <input type="number" value="<?php echo $total; ?>" readonly required hidden name="order[amount]" />
                        </tbody>
                    </table>
                </div>
            </filedset>
            <input type="submit" class="btn btn-primary" value="Checkout" />
        </form>
    </div>
</main>
