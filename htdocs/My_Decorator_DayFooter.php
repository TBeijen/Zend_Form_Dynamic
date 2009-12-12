<?php
require_once('Zend/Form/Decorator/Abstract.php');

/**
 * DayForm Footer
 */
class My_Decorator_DayFooter extends Zend_Form_Decorator_Abstract
{
    public function render($content)
    {
        // we know the element name (=subform name) is a timestamp
        $elmName = $this->getElement()->getFullyQualifiedName();

        // construct footer
        $footer = '<div class="footer"><a class="add">add</a></div><hr />';

        // it's a footer, so don't bother about placement
        return $content . $footer;
    }
}