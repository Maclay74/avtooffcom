
$(document).ready(function(){


    inputs = ($("input"));
    console.log(inputs)

    for (i=0; i < inputs.length;i++) {
        if (!$('#'+inputs[i].id).is(":visible")) continue;

        $(inputs[i]).bind("input",function() {
            validateTypo(this,getPattern(this));
        })
    }

})

function getPattern(element) {

    name = element.getAttribute("id");
    validate = element.getAttribute("validatod");

    if (validate) {
        if (validate=="text")
            return /^[. , _ \-a-zA-Zа-яА-Я0-9]+$/

        if (validate=="login")
            return /^[_a-zA-Z0-9]{3,15}$/

        if (validate=="password")
            return /^[_a-zA-Z0-9]{4,16}$/

        if (validate=="price")
            return /\d+/

        if (validate=="number")
            return /\d+/

        // Поля для заявок

        if (validate=="VIN") // Вин - 17 символов
            return /^([a-zA-Z0-9]{17})$/

        if (validate=="doc_number") // Номер документа - 6 цифр
            return /^([\d+]{6})$/

        if (validate=="doc_seria") // Серия документа - 4 знака
            return /^([_a-zA-Zа-яА-Я0-9]{4})$/

        if (validate=="year") // Год: 4 цифры
            return /^([\d+]{4})$/

    }



}

function validateTypo(element, pattern) {
    if(!pattern)
        pattern = /\S+/

console.log(pattern);

    if (!element)
        return false;
    value= $(element).val();
    parent = $(element).parent().parent();

    if (value.match(pattern)) {
        $(parent).find("#okay").attr("style","");
        $(parent).find("#remove").attr("style","display:none");
        return true;
    }

    $(parent).find("#okay").attr("style","display:none");
    $(parent).find("#remove").attr("style","");
    return false;
}

function validatePrice(element, pattern) {

    if(!pattern)
        pattern = /\S+/

    if (!element)
        return false;

    value= $(element).val();
    parent = $(element).parent().parent();
    if (value.match(pattern)) {
        if (value > 0) {
            $(parent).find("#okay").attr("style","");
            $(parent).find("#remove").attr("style","display:none");
            return true;
        }
    }
    $(parent).find("#okay").attr("style","display:none");
    $(parent).find("#remove").attr("style","");
    return false;
}

function validateForm(name,submit) {
    result = true;

    form = $("#"+name);

    inputs = form.find($("input"));


    for (i=0; i < inputs.length;i++) {

       if (!$('#'+inputs[i].id).is(":visible")) continue;


        name = inputs[i].getAttribute("id");
        validate = inputs[i].getAttribute("validatod");

        if (validate) {
            if (validate=="text")
                if (!validateTypo($("#"+name),/^[. , _ \-a-zA-Zа-яА-Я0-9]+$/)) result = false;

            if (validate=="login")
                if (!validateTypo($("#"+name),/^[_a-zA-Z0-9]{3,15}$/)) result = false;

            if (validate=="password")
                if (!validateTypo($("#"+name),/^[_a-zA-Z0-9]{4,16}$/)) result = false;

            if (validate=="price")
                if (!validateTypo($("#"+name),/\d+/)) result = false;

            if (validate=="number")
                if (!validateTypo($("#"+name),/\d+/)) result = false;

             // Поля для заявок

            if (validate=="VIN") // Вин - 17 символов
                if (!validateTypo($("#"+name),/^([a-zA-Z0-9]{17})$/))   result = false;

            if (validate=="doc_number") // Номер документа - 6 цифр
                if (!validateTypo($("#"+name),/^([\d+]{6})$/)) result = false;

            if (validate=="doc_seria") // Серия документа - 4 знака
                if (!validateTypo($("#"+name),/^([_a-zA-Z0-9]{4})$/)) result = false;

            if (validate=="year") // Год: 4 цифры
                if (!validateTypo($("#"+name),/^([\d+]{4})$/)) result = false;


        }
   }
    console.log(submit);
    if (submit){
        console.log(result);
        if(result)
            form.submit();
    }
    else
    {
        return result;
    }

}

