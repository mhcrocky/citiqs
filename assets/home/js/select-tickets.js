$("#pay").on('click', function(e){
  e.preventDefault();
  let total = $(".totalPrice").text();
  if(total != '00.00'){
      $("#my-form").submit();
  }
  return ;
});
function removeOrder(id, price) {
  var quantityValue = $("#orderQuantityValue_" + id).text();
  var totalPrice = $(".totalPrice").text()
  quantityValue = parseInt(quantityValue);
  totalPrice = parseInt(totalPrice);
  price = parseInt(price);
  if (quantityValue == 0) {
      return;
  }
  quantityValue--;
  totalPrice = totalPrice - price;
  $("#orderQuantityValue_" + id).text(quantityValue);
  $("#quantity_"+id).val(quantityValue);
  return $(".totalPrice").text(totalPrice.toFixed(2));
}

function addOrder(id, limit, price) {
  var quantityValue = $("#orderQuantityValue_" + id).text();
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
  $("#orderQuantityValue_" + id).text(quantityValue);
  $("#quantity_"+id).val(quantityValue);
  return $(".totalPrice").text(totalPrice.toFixed(2));
}
$(document).ready(function(){
  setInterval(() => {
  var CurrentDate = moment().format();
  $("#current_time").val(CurrentDate);
 
}, 1000);
});