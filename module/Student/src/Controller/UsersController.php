<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Student\Controller;

use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Application\Adapter\CredentialAdapter;
use Zend\Authentication\Storage\Session;
use Student\Model\User;
use Student\Model\UsersTable;
use Student\Model\Student;
use Student\Form\StudentForm;
use Student\Model\StudentsTable;
use \Zend\Db\Adapter\Adapter as Database;

class UsersController extends BaseController
{
    private $db;
    private $table;
    private $students;
    
    public function __construct(Database $db, UsersTable $table, StudentsTable $students)
    {
        parent::__construct();
        $this->db = $db;
        $this->table = $table;
        $this->students = $students;
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
            $authAdapter->setUserType(1);
        
            $auth = new AuthenticationService();
            $auth->setStorage(new Session('Student'));

            $result = $auth->authenticate($authAdapter); 
            $this->redirect()->toRoute("student_home", ['action' => 'index']);
        }
        
    }

    public function addAction()
    {
        $form = new StudentForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if(! $request->isPost())
        {
            //$form = new EmployerForm();
            //$form->get('submit')->setAttribute('value', 'Add');
            $viewData = ['form' => $form];
            return $viewData;
        }

        $student = new Student();
        $user = new User();
        //$form->setInputFilter($employer->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $user->exchangeArray([ 'email' => $form->getData()['admission_number'], 'password' => $form->getData()['password']]);
        $user->type = 1;
        $user_id = $this->table->saveUser($user);
        $student->exchangeArray($form->getData());
        $student->user_id = $user_id;
        $this->table->saveStudent($student);
        return $this->redirect()->toRoute('students');
    }

    public function logoutAction()
    {
        $auth = new AuthenticationService();
            $auth->setStorage(new Session('Student'));
        if($auth->hasIdentity()) 
        { 
            $auth->clearIdentity();
            return $this->redirect()->toRoute('student_users', ['action' => 'login']);
        } 
    }
}
