/**
 * Will make taskform dynamic. Requirements on element it operates on:
 * - It has 1 'add' button: element with classname 'add'
 * - It has 1 element that can be duplicated: classname 'template'
 * - Input elements within the template have a __template__ in the name attr.
 *   that can be replaced by a unique identifier
 * - Lines are in within an element with classname 'task'. Duplicated element
 *   will be placed after the last found .task element.
 */
jQuery.fn.dynamicForm = function() {
  return this.each(function(idx){
    var _container = this;
    var _template = $(_container).find('.template').eq(0);
    var _addButton = $(_container).find('.add').eq(0);
    _template.hide();

    // click handler & bind to add button
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
        $(_container).find('.task:last').after(newElm);
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
