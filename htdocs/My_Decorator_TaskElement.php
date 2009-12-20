<?php
require_once('Zend/Form/Decorator/Abstract.php');

/**
 * Decorator responsible for rendering composite task element
 */
class My_Decorator_TaskElement extends Zend_Form_Decorator_Abstract
{
    /**
     * Renders both desc and completed input elements.
     * @param string $content
     * @return string
     */
    public function render($content)
    {
        // get element details
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
        $inputCompleted = sprintf(
            '<input type="checkbox" name="%s" value="1" %s />',
            $elmName . '[completed]',
            ($isCompleted) ? 'checked="checked"' : ''
        );

        // wrap in div, optionally adding attribute class
        $elmHtml = sprintf(
            '<div class="task %s">%s%s</div>',
            ($elm->getName() == '__template__') ? 'template' : '',
            $inputDesc,
            $inputCompleted
        );

        // this should be the first decorator but add the content for
        // consistency's sake
        return $content . $elmHtml;
    }
}