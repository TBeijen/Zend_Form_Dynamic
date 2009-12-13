<?php
require_once('Zend/Validate/Abstract.php');

/**
 * Create Validator by extending Zend_Validate_Abstract or
 * implementing Zend_Validate_Interface
 */
class My_Validator_TaskElement extends Zend_Validate_Abstract
{
    protected $isValid = null;

    protected $isNew = false;

    /**
     * Will validate desc. part of $value.
     * Desc cannot be empty if existing task OR completed is checked
     * @param <type> $value
     * @return <type>
     */
    public function isValid($value) {
        $this->isValid = true;
        $completedChecked = (isset($value['completed']) && $value['completed']);
        if ($this->isNew == false || $completedChecked) {
            if (!isset($value['desc']) || !strlen(trim($value['desc']))>0) {
                $this->isValid = false;
            }
        }
        return $this->isValid;
    }

    /**
     * Returns error messages
     * @return array
     */
    public function getMessages() {
        if ($this->isValid === false) {
            return array(
                'missingDesc' => 'The description cannot be empty'
            );
        }
        return array();
    }

    /**
     * Will configure behaviour by specifying if the task element as a 'new'
     * one, or an element containing a prev. stored task.
     * @param boolean $isNew
     */
    public function setIsNew($isNew = false) {
        $this->isNew = (bool) $isNew;
    }
}