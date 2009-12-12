<?php
require_once('Zend/View.php');
require_once('My_Decorator_Hour.php');

class My_Form_Renderer_Hour
{
    /**
     * Form instance
     * @var Zend_Form
     */
    protected $form;

    /**
     * Constructor requiring Zend_Form instance to be rendered
     * @param Zend_Form $form
     */
    public function __construct(Zend_Form $form, $form_id = null)
    {
        // create view and specify doctype to have self-closing tags.
        $view = new Zend_View();
        $view->setBasePath(dirname(__FILE__));
        $view->doctype('XHTML1_TRANSITIONAL');

        $this->form = $form;
        $this->form->setView(new Zend_View());
        $this->form->setAttrib('class', 'form_dynamic');
        if (!is_null($form_id)) {
            $this->form->setAttrib('id', $form_id);
        }
    }

    /**
     * Setup decorators and properties and return render output
     * 
     * @return string
     */
    public function render()
    {
        $this->setupElements();
        $this->setupForm();
        return $this->form->render();
    }


    public function setupElements()
    {
        $hourForm = $this->form->getSubForm('hour_existing');
        $hourForm->clearDecorators();
        $hourForm->addDecorator('FormElements');

        $newForm = $this->form->getSubForm('hour_new');
        $newForm->clearDecorators();
        $newForm->addDecorator('FormElements');

        foreach($hourForm->getElements() as $elmKey => $elm) {
            $elm->clearDecorators();
            $elm->addDecorator(new My_Decorator_Hour());

            $elm->addDecorator('HtmlTag',array('tag'=>'li'));
        }

        foreach($newForm->getElements() as $elmKey => $elm) {
            $elm->clearDecorators();
            $elm->addDecorator(new My_Decorator_Hour());

            $class = '';
            if (strpos($elm->getFullyQualifiedName(), '__unique__') !== false) {
                $class = 'template';
            }
            $elm->addDecorator('HtmlTag',array('tag'=>'li', 'class'=>$class));
        }

        $this->form->addElement('submit','submit');
    }

    /**
     * Set form decorators. basically replacing the default <dl> with a <ul>
     */
    protected function setupForm()
    {
        // remove default decorators and add own
        $this->form->clearDecorators();
        $this->form->addDecorator('FormElements');
        $this->form->addDecorator('HtmlTag', array('tag' => 'ul'));
        $this->form->addDecorator('Form');
    }
}