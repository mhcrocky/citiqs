
<form id="my-form" action="<?php echo base_url(); ?>events/your_tickets" method="POST">
    <section>
        <div class="container">
            <div class="row row-menu">
                <div class="col-12 col-md-4">
                    <h2 class="color-primary mb-5"><?php echo $eventName; ?></h2>
                    <ul class="items-gallery">
                        <li>
                            <img src="<?php echo base_url(); ?>assets/images/events/<?php echo $eventImage; ?>" alt="">
                        </li>
                    </ul>
                </div>
                <!-- end col -->
                <input type="hidden" id="current_time" name="current_time">
                <div class="col-12 col-md-8 pl-md-5">
                    <h4 class="font-weight-bold mt-4 mt-md-3 mb-2 mb-md-4">Tickets</h4>
                    <?php if (!empty($tickets)) : ?>
                    <div class="menu-list">
                        <?php foreach ($tickets as $ticket): ?>
                        <input type="hidden" id="quantity_<?php echo $ticket['ticketId']; ?>" name="quantity[]"
                            value="0">
                        <input type="hidden" name="id[]" value="<?php echo $ticket['ticketId']; ?>">
                        <input type="hidden" name="descript[]" value="<?php echo $ticket['ticketDescription']; ?>">
                        <input type="hidden" name="price[]" value="<?php echo $ticket['ticketPrice']; ?>">
                        <div class="menu-list__item">
                            <div class="menu-list__name">
                                <b class="menu-list__title">Description</b>
                                <div>
                                    <p class="menu-list__ingredients"><?php echo $ticket['ticketDescription']; ?></p>
                                </div>
                            </div>
                            <div class="menu-list__right-col ml-auto">
                                <div class="menu-list__price">
                                    <b class="menu-list__price--discount"><?php echo $ticket['ticketPrice']; ?>€</b>
                                </div>
                                <b class="menu-list__type">quantity</b>
                                <div class="quantity-section">
                                    <button class="quantity-button"
                                        onclick="removeTicket('<?php echo $ticket['ticketId']; ?>','<?php echo $ticket['ticketPrice']; ?>')">-</button>
                                    <input id="ticketQuantityValue_<?php echo $ticket['ticketId']; ?>" type="number"
                                        value="0" oninput="ticketQuantity(this,'<?php echo $ticket['ticketId']; ?>')"
                                        onchange="ticketQuantity(this,'<?php echo $ticket['ticketId']; ?>')"
                                        onkeyup="absVal(this);" placeholder="0" class="quantity-input">
                                    <button type="button" class="quantity-button"
                                        onclick="addTicket('<?php echo $ticket['ticketId']; ?>', '<?php echo $ticket['ticketQuantity']; ?>', '<?php echo $ticket['ticketPrice']; ?>')">+</button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <!-- end menu list item -->
                        <div id="fixedbutton" class=" w-100 mr-2">
                            <div class="w-100 pt-2 pb-2 bg-light">
                                <button type="button" class="btn btn-danger mb-2 mr-2 w-100 btn-block">TOTAL: €<span
                                        class="totalPrice">00.00</span></button>
                                <button id="next" type="submit" class="btn btn-danger mr-2 w-100 btn-block">NEXT</button>
                            </div>
                        </div>

                    </div>
                    <?php endif; ?>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->


        </div>
    </section>
</form>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script>
$("#next").on('click', function(e){
  e.preventDefault();
  let total = $(".totalPrice").text();
  if(total != '00.00'){
      $("#my-form").submit();
  }
  return ;
});
function absVal(el) {
    let value = $(el).val();
    alert(el.value);
    let absVal = Math.abs(value);
    return $(el).val(absVal);
}

function removeTicket(id, price) {
    var quantityValue = $("#ticketQuantityValue_" + id).val();
    var totalPrice = $(".totalPrice").text()
    quantityValue = parseInt(quantityValue);
    totalPrice = parseInt(totalPrice);
    price = parseInt(price);
    if (quantityValue == 0) {
        return;
    }
    quantityValue--;
    totalPrice = totalPrice - price;
    $("#ticketQuantityValue_" + id).val(quantityValue);
    $("#quantity_" + id).val(quantityValue);
    return $(".totalPrice").text(totalPrice.toFixed(2));
}

function addTicket(id, limit, price) {
    var quantityValue = $("#ticketQuantityValue_" + id).val();
    var totalPrice = $(".totalPrice").text()
    quantityValue = parseInt(quantityValue);
    totalPrice = parseInt(totalPrice);
    price = parseInt(price);
    limit = parseInt(limit);
    if (quantityValue == limit) {
        return;
    }
    quantityValue++;
    totalPrice = totalPrice + price;
    $("#ticketQuantityValue_" + id).val(quantityValue);
    $("#quantity_" + id).val(quantityValue);
    return $(".totalPrice").text(totalPrice.toFixed(2));
}
$(document).ready(function() {
    setInterval(() => {
        var CurrentDate = moment().format();
        $("#current_time").val(CurrentDate);

    }, 1000);
});
</script>