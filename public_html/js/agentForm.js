var icon = 1;
function showNewPrice(event) {
    sourse = event.srcElement || event.target;
    icon = 1-icon;
    $("#newPrice").toggle((400));
   if (icon) {
       $(event.srcElement).attr("class","icon-plus")
      $("#price").prop('disabled', false);
   }
   else {
       $(event.srcElement).attr("class","icon-minus")
       $("#price").prop('disabled', true);

   }

}