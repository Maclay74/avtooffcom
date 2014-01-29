$(document).ready(function(){
    updateRequests();
    $('.agent').popover()

});


function updatePagination(){
    var pages= $('.pagination li a');
    for (i=0; i < pages.length; i++) {
        page = pages[i].getAttribute('page')
        pages[i].setAttribute('onclick','updateRequests('+page+')')
    }
}


function updateRequests(page,event) {
    $('#page').attr("value",page)
    $.ajax({
        type: 'POST',
        url: '?event=expert&action=request&clean&page='+page,

        success: function(data) {
            $('#requestTable').html(data);
            updatePagination();

        },
        error:  function(xhr, str){
            alert('Ошибка сервера ' + xhr.responseCode);
        }
    });

}

function formRequest(id){
    window.location="?event=request&action=form&id="+id;
}



setInterval(function(){
    updateRequests($('#page').val());
    findWork();
    $('.agent').popover()
},2000)



function findWork() {
    var title = "";
    if($('.info').length || $('.error').length || $('.warning').length )
        title="ЗАЯВКА НА ТО!";
    else
        document.title ="АСТО";

    newTxt = "***********";

    if (title !="")
        if(document.title == title){
            document.title = newTxt;
        }else{
            document.title = title;
        }

}


function showTreeAgent(login) {

console.log(login);
    $('.modal-body').load("?event=expert&action=tree&clean&agent="+login);
    $('#agentInfo').modal('show')
}

function downloadRequest(id) {
    window.location="pdf.php?id="+id;
}