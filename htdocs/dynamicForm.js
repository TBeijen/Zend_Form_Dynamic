$(document).ready(function() {
    $('#add').bind('click', {}, addElement);
    $('form .template').hide();
});

function addElement()
{
    var templateClone = $('.template').clone();
    makeUnique(templateClone);
    templateClone.removeClass();

    $('form input[type=text]:last').parent('li').after(templateClone);
    templateClone.show();
}

function makeUnique(elm)
{
    var unique = new Date().getTime();
    elm.children('input').each(function(idx) {
        var newName = $(this).attr('name').replace('__unique__', unique);
        $(this).attr('name', newName);
    });
}