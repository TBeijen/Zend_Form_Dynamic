<?php
require_once('Zend/Form/Decorator/Abstract.php');

/**
 * Create Decorator by extending Zend_Form_Decorator_Abstract or
 * implementing Zend_Form_Decorator_Interface
 */
class My_Decorator_Hour extends Zend_Form_Decorator_Abstract
{
    public function render($content)
    {
        // get element
        $elm = $this->getElement();
        $value = $elm->getValue();
        $separator = $this->getSeparator();

        $elmName = $elm->getFullyQualifiedName();

        $elmHtml = '';
        $elmHtml .= $separator . $this->getElementHtml($value, 'id', $elmName, 'hidden' );
        $elmHtml .= $separator . $this->getElementHtml($value, 'desc', $elmName );
        $elmHtml .= $separator . $this->getElementHtml($value, 'h', $elmName );
        $elmHtml .= $separator . $this->getElementHtml($value, 'm', $elmName );

        // elm collection built, output
        $placement = $this->getPlacement();
        switch ($placement) {
            case self::APPEND:
                return $content . $separator . $elmHtml;
            case self::PREPEND:
                return $elmHtml . $separator . $content;
        }
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