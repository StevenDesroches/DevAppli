<?php

namespace Application\Controller;

use Application\Model\StudentTable;
use Application\Form\StudentForm;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;

class StudentsController extends BaseController
{
 
    private $table;

    public function __construct(StudentTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel(['students' => $this->table->fetchAllWithEmail(),]);

    }

    public function addAction()
    {   
        $request = $this->getRequest();
        if(! $request->isPost())
        {
            $form = new StudentForm();
            $form->get('submit')->setAttribute('value', 'Add');
            $viewData = ['form' => $form];
            return $viewData;
        }
    }
 
    public function editAction()
    {

        $id = (int) $this->params()->fromRoute('admission_number', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('students', ['action' => 'index']);
        }

        try {
            $student = $this->table->getStudent($id);
        } catch (Exception $e) {
            return $this->redirect()->toRoute('students', ['action' => 'index']);
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

       
        return $this->redirect()->toRoute('students', ['action' => 'index']);
    }


    public function deleteAction()
    {

        $id = (int) $this->params()->fromRoute('admission_number', 0);
        if (!$id) {
            return $this->redirect()->toRoute('students');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('admission_number');
                $this->table->deleteStudent($id);
            }

            return $this->redirect()->toRoute('students');
        }

        return [
            'admission_number'    => $id,
            'student' => $this->table->getStudent($id),
        ];
    }
    
}