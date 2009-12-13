<?php
require_once('Zend/Form.php');
require_once('Zend/View.php');
require_once('My_SubForm_TaskDay.php');

class My_Form_TaskWeek extends Zend_Form
{
    /**
     * The $_POST/$_GET key where form values will be placed in
     * @var string
     */
    protected $_name = 'tasks';
    
    /**
     * Prevents loading default decorators
     */
    public function init() 
    {
        // make sure subforms start 'within' tasks key
        $this->setIsArray(true);
        $this->setName($this->_name);
        $this->setDisableLoadDefaultDecorators (true);
    }

    /**
     * Adds decorators and calls parent
     * @return string
     */
    public function render()
    {
        // set view, do only when rendering
        $view = new Zend_View();
        $view->doctype('XHTML1_TRANSITIONAL');
        $this->setView($view);

        // add submit, only having viewHelper decorator
        $this->addElement('submit','submit');
        $this->getElement('submit')->clearDecorators();
        $this->getElement('submit')->AddDecorator('ViewHelper');

        $this->addDecorator('FormElements');
        $this->addDecorator('HtmlTag', array(
            'tag' => 'div',
            'class' => 'taskWeek'
        ));
        $this->addDecorator('Form');
        
        return parent::render();
    }

    /**
     * Override setDefaults to dynamically generate subforms
     * @param array $defaults
     */
    public function setDefaults($defaults)
    {
        // first add the subforms
        $this->setSubForms($defaults);
//        var_dump($defaults);
        // set defaults, which will propagate to newly created subforms
        parent::setDefaults($defaults);
    }

    /**
     * Will add a subform per day that is present in the defaults data.
     * (Be sure to provide a day key, even if no tasks exist_
     * @param array $defaults
     */
    public function setSubForms($defaults)
    {
        $this->clearSubForms();
        $dates = array_keys($defaults);
        foreach ($dates as $day) {
            $dayForm = new My_SubForm_TaskDay();
            $this->addSubForm($dayForm, $day);
        }
    }
}