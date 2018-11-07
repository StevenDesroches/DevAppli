<?php

namespace Application\Controller;

use Application\Model\Employer;
use Application\Model\EmployersTable;
use Application\Model\User;
use Application\Model\UsersTable;
use Application\Form\EmployerForm;
use Zend\View\Model\ViewModel;

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

    public function addAction()
    {
        $form = new EmployerForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if(! $request->isPost())
        {
            $viewData = ['form' => $form];
            return $viewData;
        }

        $employer = new Employer();
        $user = new User();
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }
        $user->exchangeArray($form->getData());
        $user->type = 2;
        $id_user = $this->users->saveUser($user);
       
        $employer->exchangeArray($form->getData());
        $employer->id_user = $id_user;
        $this->table->saveEmployer($employer);
        return $this->redirect()->toRoute('employers', ['action' => 'index']);
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
    public function deleteAction()
    {

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('employers');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteEmployer($id);
            }

            return $this->redirect()->toRoute('employers');
        }

        return [
            'id'    => $id,
            'employer' => $this->table->getEmployer($id),
        ];
    }
    }
    
