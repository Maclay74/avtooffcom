$(document).ready(function(){
    updateRequests();
    getAgents();


});

var update = 1;

selectRequest.selected = {};
var sum = 0;
var msg = "";

function updatePagination(){
    var pages= $('.pagination li a');
    for (i=0; i < pages.length; i++) {
        page = pages[i].getAttribute('page')
        pages[i].setAttribute('onclick','updateRequests('+page+')')
    }
}

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
            update = 1;
            var msg   = $('#Filter').serialize();
        }


        if (formName=="Search") {
            update = 0;
            var msg   = $('#Search').serialize();

            if ($('#name').val().length == 0 && $('#number').val().length == 0) {
                var msg   = $('#Filter').serialize();
                update = 1;
            }

            }

    }

    $.ajax({
        type: 'POST',
        url: '?event=cashier&action=request&clean',
        data: msg,

        success: function(data) {
            $('#requestTable').html(data);
            updatePagination();

        },
        error:  function(xhr, str){
            alert('Ошибка сервера ' + xhr.responseCode);
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
        url: '?event=cashier&action=stat&clean',
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

function selectRequest(id,event) {

    if(event) {
        sourse = event.srcElement || event.target;
    }
    if (sourse.checked){
            selectRequest.selected[id] = true;
            price = $($(sourse).parent().parent().find('td')[7]).html();
            sum += price*1;
            $('#sum').html(sum);
    }

   else{
            selectRequest.selected[id] = false;
            price = $($(sourse).parent().parent().find('td')[7]).html();
            sum -= price*1;
            $('#sum').html(sum);

    }

}

function sendSelected() {
    var selected = selectRequest.selected;


    $.ajax({
        url: "?event=cashier&action=pay&clean",
        data: 'selected=' + JSON.stringify(selected),
        processData: false,
        dataType: "json",
        success: function(a) { updateRequests(); sum = 0; $('#sum').html(sum);},
        error:function() {updateRequests(); sum = 0; $('#sum').html(sum); }
    });
}

function selectAll(event){

    if(event)
        sourse = event.srcElement || event.target;

    if (sourse.checked == true){

        checked =  $(":checkbox[class='large']").filter(function() { return $(this).prop('checked')})
        selectRequest.selected = {};

        for (i = 0; i < checked.length; i++) {
            checked[i].checked = false;
            selectRequest.selected[checked[i].id] = false;
            price = $($( checked[i]).parent().parent().find('td')[7]).html();
            sum -= price*1;
        }

        all = $(":checkbox[class='large']");
        selectRequest.selected = {};

        for (i = 0; i < all.length; i++) {
            all[i].checked = true;
            selectRequest.selected[all[i].id] = true;
            price = $($( all[i]).parent().parent().find('td')[7]).html();
            sum += price*1;
        }

        $('#sum').html(sum);

    }

    else{
        checked =  $(":checkbox[class='large']").filter(function() { return $(this).prop('checked')})
        selectRequest.selected = {};

        for (i = 0; i < checked.length; i++) {
            checked[i].checked = false;
            selectRequest.selected[checked[i].id] = false;
            price = $($( checked[i]).parent().parent().find('td')[7]).html();
            sum -= price*1;
        }

    }

}

function change1c(id) {

    $.ajax({
        url: "?event=cashier&action=change1c&id="+id,
        success: function(e) {

        },
        error:function() {updateRequests(); }
    });
}

function formRequest(id){
    window.location="?event=request&action=form&id="+id;
}

function getAgents() {
    agent=$('#managers').val();
    $('#agents').load("?event=cashier&clean&action=agents&agent="+agent)
}

setInterval(function(){
    if (update)
        updateRequests();
},2000)

