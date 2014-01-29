$(document).ready(function(){
    updateRequests();


});



function updatePagination(){
    var pages= $('.pagination li a');
    for (i=0; i < pages.length; i++) {
        page = pages[i].getAttribute('page')
        pages[i].setAttribute('onclick','updateRequests('+page+')')
    }
}

var update = 1;

function updateRequests(page,event) {

    if (page)
        $('#Filter #page').val(page);

    var msg   = $('#Filter').serialize();


    if(event) {
        sourse = event.srcElement || event.target;

        if(sourse.tagName == "FORM")
            var formName=sourse.getAttribute("id");

        if(sourse.tagName == "A")
            var formName="Filter";

        if (formName=="Filter") {
            var msg   = $('#Filter').serialize();
            update = 1;
        }

        if (formName=="Search") {
            if ($('#name').val().length > 0 || $('#number').val().length > 0 ) {
                update = 0;
                var msg   = $('#Search').serialize();
            }
            else
                var msg   = $('#Filter').serialize();


        }

    }



    $.ajax({
        type: 'POST',
        url: '?event=agent&action=request&clean&hash',
        data: msg,

        success: function(data) {
            $('#requestTable').html(data);
            updatePagination();

        },
        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        }
    });

    updateStat(page);
}

function updateStat(page) {

    if (page)
        $('#Filter #page').val(page);

    var msg   = $('#Filter').serialize();

    $.ajax({
        type: 'POST',
        url: '?event=agent&action=stat&clean',
        data: msg,
        success: function(data) {
            $('#stat').html(data);
            updatePagination();

        },
        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        }
    });


}

function editAgent(id) {
    window.location.href = "?event=agent&action=form&id="+id
}

function newAgent(id) {
    window.location.href = "?event=agent&action=form"
}

function formRequest(id){
    window.location="?event=request&action=form&id="+id;
}

function deleteRequest(id){

    $('#deleteDialog').modal('hide');
    //window.location="?event=request&action=delete&id="+id;
    $.ajax("?event=request&action=delete&id="+id);


}

function deleteDialog(reg,id){
    console.log();

    $("#deleteDialog").find('.text').html("Вы действительно хотите удалить заявку <b>"+reg+"</b>?");
    $("#deleteDialog").find("#confirm").attr("onclick","deleteRequest("+id+")");
    $('#deleteDialog').modal('show');

}



function downloadRequest(id) {
    window.location="pdf.php?id="+id;
}

setInterval(function(){
    if (update) {
        updateRequests();
        console.log("updated")
    }
},2000)