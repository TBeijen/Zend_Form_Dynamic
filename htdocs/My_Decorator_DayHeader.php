<?php
require_once('Zend/Form/Decorator/Abstract.php');

/**
 * DayForm Header
 */
class My_Decorator_DayHeader extends Zend_Form_Decorator_Abstract
{
    public function render($content)
    {
        // we know the element name (=subform name) is a timestamp
        $elmName = $this->getElement()->getName();

        // construct header
        $header = '<h3>Tasks for ' . strftime('%a, %d %b', $elmName) . '</h3>';

        // it's a header, so don't bother about placement
        return $header . $content;
    }
}