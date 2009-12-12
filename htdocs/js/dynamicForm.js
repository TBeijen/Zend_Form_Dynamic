$(document).ready(function() {
    $('form .taskDay').dynamicForm();
});


jQuery.fn.dynamicForm = function() {
  return this.each(function(idx){
    var _container = this;
    var _template = $(_container).find('.template').eq(0);
    var _addButton = $(_container).find('.add').eq(0);
    _template.hide();

    // click handler
    var onClickAdd = function() {
        return function(event) {
            addLine();
            event.preventDefault();
            event.stopPropagation();
        }
    }
    $(_addButton).bind('click',{},onClickAdd());

    // duplicates the template and adds it
    var addLine = function() {
        var newElm = $(_template).clone();
        makeUnique(newElm);
        $(_container).children('.footer').before(newElm);
        newElm.show();
    }

    // replaces __template__ name part with unique timestamp
    var makeUnique = function(elm)
    {
        var unique = new Date().getTime();
        $(elm).children('input').each(function(idx) {
            var newName = $(this).attr('name').replace('__template__', unique);
            $(this).attr('name', newName);
        });
    }

  });
};
