<?php
require_once('My_SubForm_TaskDay.php');

class My_Form_TaskDay extends My_SubForm_TaskDay
{
    /**
     * Wrapper around My_SubForm_TaskDay that turns it into a 'normal' form
     * by adding form decorators and setting isArray to false
     */
    public function init()
    {
        parent::init();
        $this->setIsArray(false);
    }

    /**
     * Override setups as done in subForm.
     * Adds decorators and calls parent
     * @return string
     */
    protected function preRender() {
        // set view, do only when rendering
        $view = new Zend_View();
        $view->doctype('XHTML1_TRANSITIONAL');
        $this->setView($view);

        // add submit, only having viewHelper decorator
        $this->addElement('submit','submit');
        $this->getElement('submit')->setIgnore(true);
        $this->getElement('submit')->clearDecorators();
        $this->getElement('submit')->AddDecorator('ViewHelper');

        $this->addDecorator('FormElements');
        $this->addDecorator(new My_Decorator_DayHeader());
        $this->addDecorator(new My_Decorator_DayFooter());
        $this->addDecorator('HtmlTag', array(
            'tag' => 'div',
            'class' => 'taskDay'
        ));
        $this->addDecorator('Form');
    }
}