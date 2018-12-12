<?php

namespace Employer\Controller;

use Employer\Model\UsersTable;
use phpDocumentor\Reflection\Types\Array_;
use Employer\Model\InternshipsTable;
use Employer\Model\EmployersTable;
use Employer\Model\Students_InternshipsTable;
use Employer\Model\StudentsTable;
use Zend\Db\Sql\Predicate\In;
use Zend\View\Model\ViewModel;
use Zend\Mail\Message;
use Application\Adapter\EmailAdapter;


class Students_InternshipsController extends BaseController
{
    private $table;

    private $tableInternships;

    private $tableStudent;

    private $tableUsers;

    private $tableEmployers;

    public function __construct(Students_InternshipsTable $table, InternshipsTable $tableInternships,
                                StudentsTable $tableStudent, UsersTable $tableUsers, EmployersTable $tableEmployers)
    {
        parent::__construct();

        $this->table = $table;
        $this->tableInternships = $tableInternships;
        $this->tableStudent = $tableStudent;
        $this->tableUsers = $tableUsers;
        $this->tableEmployers = $tableEmployers;
    }


    public function indexAction()
    {
        $userEmail = $this->currentUser;
        $employerCourant = $this->tableEmployers->getEmployerFromUser($userEmail);
        $rowsetInternships = $this->tableInternships->getInternshipWhereEmployer($employerCourant->id);
        $rowsetStudents = array();

        $rowNumb = $rowsetInternships->count();
        for ($i = 0; $i < $rowNumb; $i++ ){
            $row = $rowsetInternships->current();
            $rowsetInternships->next();
            $id = $row->id;

            $rowset2 = $this->table->getInternship($id);

            $rowNumb2 = $rowset2->count();
            for ($i = 0; $i < $rowNumb2; $i++ ){
                $row = $rowset2->current();
                $rowset2->next();
                $id = $row->student_id;

                array_push($rowsetStudents, $this->tableStudent->getStudent($id));
            }
        }
        return new ViewModel(['rowsetStudents' => $rowsetStudents]);
    }

    public function notifierAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('employer_StudentsInternships');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');

                $user = $this->tableUsers->getUser($id);

                $has_A = strpos($user->email, '@') !== false;
                $has_Dot = strpos($user->email, '.') !== false;

                $mail = new Message();
                $mail->setBody('Bonjour,<br/> Je voudrais planifier une rencontre pour le stage.');
                $mail->setFrom('noreply@gestionstage.com', 'GestionStage');

                if($has_A && $has_Dot){
                    $mail->addTo($user->email);
                }

                $mail->addTo('stevendesroches@hotmail.com', 'Steven Desroches');
                $mail->setSubject('Planification de rencontre - Stage');

                EmailAdapter::getInstance()->sendMail($mail);
            }

            return $this->redirect()->toRoute('employer_StudentsInternships');
        }

        return [
            'id'    => $id,
        ];
    }
}
