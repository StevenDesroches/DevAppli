<?php

namespace Application\Controller;

use Application\Model\Employer;
use Application\Model\EmployersTable;
use Application\Model\User;
use Application\Model\UsersTable;
use Application\Form\EmployerForm;
use Zend\View\Model\ViewModel;
use Application\Adapter\EmailAdapter;
use Zend\Mail\Message;
use \Datetime;


class EmployersController extends BaseController
{

    private $table;
    private $users;

    public function __construct(EmployersTable $table, UsersTable $users)
    {
        parent::__construct();
        $this->table = $table;
        $this->users = $users;
        array_push($this->allowedActions, 'sendMailUpdate');
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
        $employer->exchangeArray($form->getData());
        $user->exchangeArray($form->getData());
        $user->email = $employer->contact_email;
        $user->type = 2;
        $id_user = $this->users->saveUser($user);
       
        $employer->exchangeArray($form->getData());
        $employer->id_user = $id_user;
        $employer->date_created = date('Y-m-d');
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

    public function sendMailUpdateAction(){
        
        require constant('ROOT') . '/fuck_whodong.php';
        
        $employers = $this->table->fetchAll();
        try{
            $tokenRec = $_GET['token'];
        } catch(Exception $e){
            $tokenRec = null;
        } 

        if($token == $tokenRec && $tokenRec != null){
            foreach($employers as $employer){

                $date_now = new DateTime();
                $date_created = new DateTime($employer->date_created);
                if(!empty($employer->uuid) && $date_now->diff($date_created)->format("%a") == '15'){

                    $mail = new Message();
                    $mail->setBody('Bonjour,<br/> Vous avez dépassé le délai de 15 jours'
                    . ' pour mettre à jour vos informations de contact veillez appuyer '
                    . '<a href="' . $this->url()->fromRoute('employer_employers', ['action' => 'edit', 'id' => $employer->id, 'uuid' => $employer->uuid ], 
                    ['force_canonical' => true]) . '">ici</a>'
                    );
                    $mail->setFrom('noreply@gestionstage.com', 'GestionStage');
                    $mail->addTo($employer->contact_email, $employer->name);
                    $mail->setSubject('Mise à jour - Milieu de stage');

                    EmailAdapter::getInstance()->sendMail($mail);
                }
            }
        }
    }
}
    
