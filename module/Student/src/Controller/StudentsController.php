<?php

namespace Student\Controller;

use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Application\Model\Student;
use Application\Model\StudentsTable;
use Application\Form\StudentForm;


class StudentsController extends BaseController
{

    private $table;

    public function __construct(StudentsTable $table)
    {
        parent::__construct();
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel(['students' => $this->table->fetchAll()]);

    }

    public function editAction()
    {


        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('student_home', ['action' => 'index']);
        }

        try {
            $student = $this->table->getStudent($id);
        } catch (Exception $e) {
            return $this->redirect()->toRoute('student_home', ['action' => 'index']);
        }

        $form = new StudentForm();
        $form->bind($student);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['admission_number' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($student->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->editStudent($student);

       
        return $this->redirect()->toRoute('student_home', ['action' => 'index']);
    }


}