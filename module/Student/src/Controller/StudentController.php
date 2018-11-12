<?php
namespace Student\Controller;

use Student\Model\StudentTable;
use Student\Form\StudentForm;
use Student\Model\Student;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class StudentController extends AbstractActionController
{
    private $table;

    public function __construct(StudentTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'students' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new StudentForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $student = new Student();
        $form->setInputFilter($student->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $student->exchangeArray($form->getData());
        $this->table->saveStudent($student);
        return $this->redirect()->toRoute('student');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('student', ['action' => 'add']);
        }

        // Retrieve the student with the specified id. Doing so raises
        // an exception if the student is not found, which should result
        // in redirecting to the landing page.
        try {
            $student = $this->table->getStudent($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('student', ['action' => 'index']);
        }

        $form = new StudentForm();
        $form->bind($student);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($student->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveStudent($student);

        // Redirect to student list
        return $this->redirect()->toRoute('student', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('student');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteStudent($id);
            }

            // Redirect to list of students
            return $this->redirect()->toRoute('student');
        }

        return [
            'id'    => $id,
            'student' => $this->table->getStudent($id),
        ];
    }
}