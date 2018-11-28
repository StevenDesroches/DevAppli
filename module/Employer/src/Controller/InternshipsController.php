<?php

namespace Employer\Controller;

use Employer\Model\InternshipsTable;
use Employer\Model\Internship;
use Employer\Model\EmployersTable;
use Zend\View\Model\ViewModel;
use Employer\Form\InternshipsForm;

class InternshipsController extends BaseController 
{
    private $table;
    private $employersTable;
    public function __construct(InternshipsTable $table, EmployersTable $employersTable)
    {  
        parent::__construct();
        $this->table = $table;
        $this->employersTable = $employersTable;
    }


    public function indexAction()
    {
        return new ViewModel(['internships' => $this->table->fetchAllWithEmployer(),]);
    }

    public function addAction()
    {
        $form = new InternshipsForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if(! $request->isPost())
        {
            $viewData = ['form' => $form, 'employer' => $this->employersTable->getEmployerFromUser($this->currentUser)];
            return $viewData;
        }

        $internship = new Internship();
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form, 'employer' => $this->employersTable->getEmployerFromUser($this->currentUser)];
        }

        $internship->exchangeArray($form->getData());
        $internship->date_posted=date("Y-m-d H:i:s");
        $this->table->saveInternship($internship);
        return $this->redirect()->toRoute('employer_internships');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('employer_internships', ['action' => 'index']);
        }

        try {
            $internship = $this->table->getInternship($id);
            var_dump($internship);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('employer_internships', ['action' => 'index']);
        }

        $form = new InternshipsForm();
        $form->bind($internship);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($internship->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->editStudent($internship);

       
        return $this->redirect()->toRoute('employer_internships', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('employer_internships');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteInternship($id);
            }

            return $this->redirect()->toRoute('employer_internships');
        }

        return [
            'id'    => $id,
            'internship' => $this->table->getInternship($id),
        ];
    }
}