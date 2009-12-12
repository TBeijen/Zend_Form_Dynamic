<?php
require_once('Zend/Form/Decorator/Abstract.php');

/**
 * Create Decorator by extending Zend_Form_Decorator_Abstract or
 * implementing Zend_Form_Decorator_Interface
 */
class My_Decorator_TaskElement extends Zend_Form_Decorator_Abstract
{
    public function render($content)
    {
        // get element detils
        $elm = $this->getElement();
        $value = $elm->getValue();
        $elmName = $elm->getFullyQualifiedName();

        // construct inputs
        $isCompleted = isset($value['completed']) && $value['completed'];
        $descValue = (isset($value['desc'])) ? htmlspecialchars($value['desc']) : '';

        $inputDesc = sprintf(
            '<input type="text" name="%s" value="%s" />',
            $elmName . '[desc]',
            $descValue
        );
        $inputDone = sprintf(
            '<input type="checkbox" name="%s" value="1" %s />',
            $elmName . '[completed]',
            ($isCompleted) ? 'checked="checked"' : ''
        );

        // wrap in div, optionally adding attribute class
        $elmHtml = sprintf(
            '<div class="task %s">%s%s</div>',
            $elm->getAttrib('class'),
            $inputDesc,
            $inputDone
        );

        // this should be the first decorator but add the content for
        // consistency's sake
        return $content . $elmHtml;
    }


    protected function getElementHtml($record, $key, $prefix, $type='text')
    {
        $value = '';
        if (isset($record[$key])) {
            $value = htmlspecialchars($record[$key]);
        }

        $elmHtml = sprintf(
            '<input type="%s" class="%s" name="%s[%s]" value="%s" />',
            $type,
            $key,
            $prefix,
            $key,
            $value
        );
        return $elmHtml;
    }
}