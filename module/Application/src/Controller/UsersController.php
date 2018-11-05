<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Application\Adapter\CredentialAdapter;
use Application\Model\Employer;
use Application\Model\EmployerTable;
use Application\Form\EmployerForm;

class UsersController extends BaseController
{  
    public function __construct($db)
    {
        parent::__construct($db);
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

            //$authAdapter->setUserType(0);
            
        
            $auth = new AuthenticationService();

            $result = $auth->authenticate($authAdapter);           
             $this->redirect()->toRoute("home", ['action' => 'index']);
        }
        
    }

    public function logoutAction()
    {
        $auth = new AuthenticationService(); 
        if($auth->hasIdentity()) 
        { 
            $auth->clearIdentity();
            return $this->redirect()->toRoute('users', ['action' => 'login']);
        } 
    }

       public function addEmployerAction()
       {
        $form = new EmployerForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if(! $request->isPost())
        {
            //$form = new EmployerForm();
            //$form->get('submit')->setAttribute('value', 'Add');
            $viewData = ['form' => $form];
            return $viewData;
        }

        $employer = new Employer();
        //$form->setInputFilter($employer->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $employer->exchangeArray($form->getData());
        $this->table->saveEmployer($employer);
        return $this->redirect()->toRoute('users', ['action' => 'login']);
        }
    }
