<?php
require_once('My_Decorator_DayHeader.php');
require_once('My_Decorator_DayFooter.php');
require_once('My_Decorator_TaskElement.php');
require_once('Zend/Form/SubForm.php');
require_once('Zend/Form/Element.php');

class My_Form_TaskDay extends Zend_Form_SubForm
{
    /**
     * Prevents loading default decorators
     */
    public function init() {
        $this->setDisableLoadDefaultDecorators (true);

        $this->addSubForm(new Zend_Form_SubForm, 'current');
        $this->addSubForm(new Zend_Form_SubForm, 'new');

        $this->getSubForm('current')->setDecorators(array('FormElements'));
        $this->getSubForm('new')->setDecorators(array('FormElements'));

        // add template element
        $templateElement = $this->createTaskElement(
            '__template__',
            array()
        );
        $templateElement->setIgnore(true);
        $this->getSubForm('new')->addElement($templateElement);
    }

    /**
     * Adds decorators and calls parent
     * @return string
     */
    public function render() {
        $this->addDecorator('FormElements');
        $this->addDecorator(new My_Decorator_DayHeader());
        $this->addDecorator(new My_Decorator_DayFooter());
        $this->addDecorator('HtmlTag', array(
            'tag' => 'div',
            'class' => 'taskDay'
        ));
        return parent::render();
    }

    /**
     * Override setDefaults to dynamically generate elements
     * @param array $defaults
     */
    public function setDefaults($defaults)
    {
        $subform = $this->getSubForm('current');
        foreach ($defaults['current'] as $id => $values) {
            $subform->addElement($this->createTaskElement($id, $values));
        }
        // set defaults, which will propagate to newly created subforms & elements
        parent::setDefaults($defaults);
    }


    /**
     * Override isValid. This version will first dynamically add 'new' elements
     * based on the $data received.
     * @param array $data
     * @return boolean
     */
    public function isValid($data) {
        $subform = $this->getSubForm('new');
        // make sure new is array (won't be in values if nothing submitted)
        if (!isset($data['new'])) {
            $data['new'] = array();
        }
        foreach ($data['new'] as $idx => $values) {
            $subform->addElement($this->createTaskElement($idx, $data));
        }
        // call parent, which will populate newly created elements.
        return parent::isValid($data);
    }

    /**
     * Will set up a task-element and decorators
     * @param string $id
     * @param array $values
     * @param array $attribs
     * @return Zend_Form_Element
     */
    protected function createTaskElement($id, $values)
    {
        $elm = new Zend_Form_Element((string) $id);
        $elm->clearDecorators();
        $elm->addDecorator(new My_Decorator_TaskElement());
        $elm->setValue($values);

        return $elm;
    }
}