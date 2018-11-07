<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Employer\Controller;

use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Employer\Adapter\CredentialAdapter;
use Employer\Model\Employer;
use Employer\Model\EmployersTable;
use Employer\Form\EmployerForm;
use Employer\Model\User;
use Employer\Model\UsersTable;
use \Zend\Db\Adapter\Adapter as Database;
use Zend\Authentication\Storage\Session;

class UsersController extends BaseController
{
    private $table;
    private $employerTable;
    private $db;

    public function __construct(UsersTable $table, EmployersTable $employerTable, Database $db)
    {
        parent::__construct();
        $this->table = $table;
        $this->employerTable = $employerTable;
        $this->db = $db;
        array_push($this->allowedActions, 'add');
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function loginAction()
    {
        if(!$this->getRequest()->isPost())
        {
            return new ViewModel();
        }
        else
        {
            $authAdapter = new CredentialAdapter($this->db, 'users', 'email', 'password');
            $authAdapter->setIdentity($this->params()->fromPost('email'));
            $authAdapter->setCredential(md5($this->params()->fromPost('password')));
            $authAdapter->setUserType(2);
        
            $auth = new AuthenticationService();
            $auth->setStorage(new Session('Employer'));

            $result = $auth->authenticate($authAdapter); 
            $this->redirect()->toRoute("employer_home", ['action' => 'index']);
        }
        
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
        $id_user = $this->table->saveUser($user);
        $employer->exchangeArray($form->getData());
        $employer->id_user = $id_user;
        $this->employerTable->saveEmployer($employer);
        return $this->redirect()->toRoute('employer_home');
    }

    public function logoutAction()
    {
        $auth = new AuthenticationService(); 
        $auth->setStorage(new Session('Employer'));
        if($auth->hasIdentity()) 
        { 
            $auth->clearIdentity();
            return $this->redirect()->toRoute('employer_users', ['action' => 'login']);
        } 
    }
}
