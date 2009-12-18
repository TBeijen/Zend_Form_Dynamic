<?php
require_once('Zend/Form.php');
require_once('Zend/View.php');
require_once('My_SubForm_TaskDay.php');

class My_Form_TaskWeek extends Zend_Form
{
    /**
     * Holds the keys as present in the defaults array
     * passed into setDefaults()
     * @var array
     */
    protected $defaultsKeys = array();

    /**
     * Prevents loading default decorators
     */
    public function init() 
    {
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
        // set defaults, which will propagate to newly created subforms
        parent::setDefaults($defaults);
        // store keys in array for future use
        $this->defaultsKeys = array_keys($defaults);
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
            $this->addSubForm($dayForm, (string) $day);
        }
    }


    /**
     * Zend_Form doesn't support numeric subform (and element) names.
     * Because of that getValues() returns numeric array-keys instead of
     * the timestamps that are supplied in setDefaults().
     * This wacky fix determines if indexed arrays are present and if so,
     * translates those back to the keys originally passed in.
     *
     * getValue(timestamp) works correct and doesn't need to be changed.
     * 
     * http://framework.zend.com/issues/browse/ZF-4204
     *
     * @param boolean $suppressArrayNotation
     * @return array
     */
    public function getValues($suppressArrayNotation = false) {
        $formValues = parent::getValues($suppressArrayNotation);

        $keys = array_keys($formValues);
        // check if indexed subforms are returned by looking for array-key 0.
        if (in_array('0',$keys)) {
            $values = array_values($formValues);
            foreach ($keys as $keyIdx => $keyVal) {
                if (is_numeric($keyVal) && isset($this->defaultsKeys[$keyVal])) {
                    $keys[$keyIdx] = $this->defaultsKeys[$keyVal];
                }
            }
            $formValues = array_combine($keys, $values);
        }
        return $formValues;
    }
}