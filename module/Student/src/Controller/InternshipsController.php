<?php

namespace Student\Controller;

use Student\Model\InternshipsTable;
use Student\Model\EmployerTable;
use Student\Model\Students_InternshipsTable;
use Zend\View\Model\ViewModel;

class InternshipsController extends BaseController
{
    private $table;

    private $tableEmployer;

    private $tableStudentInternship;

    public function __construct(InternshipsTable $table, EmployerTable $tableEmployer, Students_InternshipsTable $tableStudentInternship)
    {
        parent::__construct();
        $this->table = $table;
        $this->tableEmployer = $tableEmployer;
        $this->tableStudentInternship = $tableStudentInternship;
    }


    public function indexAction()
    {
        return new ViewModel(['internships' => $this->table->fetchAllWithEmployer(),]);
    }


    public function detailsAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('student_internships');
        }
        $internship = $this->table->getInternship($id);

        $employer = $this->tableEmployer->getEmployer( ($internship->id_employer) );

        return new ViewModel(array(
            'internship' => $internship,
            'employer' => $employer,
        ));
    }

    public function postulerAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('student_internships');
        }
        $id2 = $this->currentUser;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->tableStudentInternship->saveRelationInternship($id2, $id);
            }

            return $this->redirect()->toRoute('student_internships');
        }

        $internship = $this->table->getInternship($id);

        $employer = $this->tableEmployer->getEmployer( ($internship->id_employer) );

        return new ViewModel(array(
            'id' => $id,
            'internship' => $internship,
            'employer' => $employer,
        ));
    }
}
