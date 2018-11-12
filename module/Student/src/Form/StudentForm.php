<?php
namespace Student\Form;

use Zend\Form\Form;

class StudentForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('student');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'Name',
            ],
        ]);
        $this->add([
            'name' => 'gpa',
            'type' => 'text',
            'options' => [
                'label' => 'GPA',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}