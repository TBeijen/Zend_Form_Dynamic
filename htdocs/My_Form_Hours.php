<?php
require_once('Zend/Form.php');
require_once('Zend/Form/SubForm.php');
require_once('Zend/Form/Element/Text.php');

class My_Form_Hours extends Zend_Form
{
    protected $data;

    protected $key_existing = 'hour_existing';
    protected $key_new= 'hour_new';

    public function init() {
    }


    public function setData($data)
    {
        $this->data = $data;
        $this->buildForm();
    }


    public function buildForm() {
        $this->clearElements();
        $hourForm = new Zend_Form_SubForm();

        foreach ($this->data as $record) {
            $elm = new Zend_Form_Element((string) $record['id']);
            $elm->setValue($record);

            $hourForm->addElement($elm);
        }
        $this->addSubForm($hourForm, $this->key_existing);
        
        // add template element
        $newForm = new Zend_Form_SubForm();

        $elm = new Zend_Form_Element('__unique__');
        $newForm->addElement($elm);

        // add elements based on $_POST, (this is crap but will do for now)
        if (isset($_POST['hour_new'])) {
            foreach ($_POST['hour_new'] as $idx=>$values) {
                if ($idx != '__unique__') {
                    $elm = new Zend_Form_Element($idx);
                    $elm->setValue($values);

                    $newForm->addElement($elm);
                }
            }
        }
        
        $this->addSubForm($newForm, $this->key_new);
    }
}