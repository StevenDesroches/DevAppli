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
    private $studentTable;
    private $students;
    
    public function __construct(Database $db, UsersTable $table, StudentsTable $studentTable)
    {
        parent::__construct();
        $this->db = $db;
        $this->studentTable = $studentTable;
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
            $viewData = ['form' => $form];
            return $viewData;
        }

        $student = new Student();
        $user = new User();
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $user->exchangeArray($form->getData());
        $user->type = 1;
        $student->exchangeArray($form->getData());
        $user->email = $student->admission_number;
        $user_id = $this->table->saveUser($user);
        $student->exchangeArray($form->getData());
        $student->user_id = $user_id;
        $student->date_created = date('Y-m-d');
        $this->StudentTable->saveStudent($student);
        return $this->redirect()->toRoute('student_home');
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
