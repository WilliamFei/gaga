
function isMobile(phoneNum)
{
    var reg = /^((1[3-8][0-9])+\d{8})$/;
    return reg.test(phoneNum);
}


function showWindow(jqElement)
{
     jqElement.css("visibility", "visible");
    $(".wrapper-mask").css("visibility", "visible").append(jqElement);
}

function removeWindow(jqElement)
{
    jqElement.remove();
    $(".wrapper-mask").css("visibility", "hidden");
    $("#all-templates").append(jqElement);
}



function addTemplate(jqElement)
{
    $("#all-templates").append(jqElement);
}


