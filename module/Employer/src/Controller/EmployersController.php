<?php

namespace Employer\Controller;

use Employer\Model\Employer;
use Employer\Model\EmployersTable;
use Employer\Model\User;
use Employer\Model\UsersTable;
use Employer\Form\EmployerForm;
use Zend\View\Model\ViewModel;
use Zend\Mail;

class EmployersController extends BaseController
{

    private $table;
    private $users;

    public function __construct(EmployersTable $table, UsersTable $users)
    {
        parent::__construct();
        $this->table = $table;
        $this->users = $users;
    }

    public function indexAction()
    {
        return new ViewModel(['employers' => $this->table->fetchAll()]);
    }


    public function editAction()
    {

        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('employers', ['action' => 'index']);
        }

        try {
            $employer = $this->table->getEmployer($id);
        } catch (Exception $e) {
            return $this->redirect()->toRoute('employers', ['action' => 'index']);
        }

        $form = new EmployerForm();
        $form->bind($employer);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($employer->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveEmployer($employer);

       
        return $this->redirect()->toRoute('employers', ['action' => 'index']);
    }
    
}
    
