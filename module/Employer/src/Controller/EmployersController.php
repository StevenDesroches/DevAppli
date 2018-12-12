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
        $uuid = $this->params()->fromRoute('uuid', 0);
        $request = $this->getRequest();

        if (!$request->isPost() && 0 === $uuid) {
            return $this->redirect()->toRoute('employer_home', ['action' => 'index']);
        }

        try {
            $employer = $this->table->getEmployerByUuid($uuid);
        } catch (Exception $e) {
            return $this->redirect()->toRoute('employer_home', ['action' => 'index']);
        }

        $form = new EmployerForm();
        $form->bind($employer);
        $form->get('submit')->setAttribute('value', 'Edit');

        
        $viewData = ['id' => $id, 'uuid' => $uuid, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }
        
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $employer->uuid = null;
        $employer->active = true;
        $this->table->saveEmployer($employer);

       
        return $this->redirect()->toRoute('employers', ['action' => 'index']);
    }
    
}
    
