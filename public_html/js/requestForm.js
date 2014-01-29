var page=1;
$(document).ready(function(){
    //$('.page1').hide();
    $('.page2').hide();
    $('.page3').hide();
    $('.page4').hide();
    $('.pager').hide();
});

function newDocument(){
    $('.page'+page).fadeIn();
    $('.pager').fadeIn();

}

function nextPage() {
    if (page==4) return;
    if(!validateForm("page"+page)) return;
    $('.page'+page).fadeOut(function(){
        page++;
        $('.page'+page).fadeIn();

    });

}

function previousPage() {
    if (page==1) return;
    $('.page'+page).fadeOut(function(){
        page--;
        $('.page'+page).fadeIn();
        console.log(page);
    });

}

function deleteRequest(){
    id = $('#requestId').val();
    window.location="?event=request&action=delete&id="+id;
}

function cancelRequest(){
    id = $('#requestId').val();
    window.location="?event=request&action=cancel&id="+id;

}

function save() {
    var data   = $('#requestForm').serialize();
    id = $('#requestId').val();
    if (validateForm('requestForm',0))
        $('#response').html("<div class='alert alert-info'> Отправка запроса...   </div>");

    $.ajax({
        type: "POST",
        url: "?event=request&clean&action=send&id="+id,
        data: data,
        success: function(e) { $('#response').html(e)},
        failed: function() {$('#response').html("<div class='alert alert-error'> Ошибка отправки данных в ЕАИСТО  </div>")}
    });


}