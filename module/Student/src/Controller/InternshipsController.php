<?php

namespace Student\Controller;

use Student\Model\InternshipsTable;
use Student\Model\EmployerTable;
use Zend\View\Model\ViewModel;

class InternshipsController extends BaseController
{
    private $table;

    private $tableEmployer;

    public function __construct(InternshipsTable $table, EmployerTable $tableEmployer)
    {
        parent::__construct();
        $this->table = $table;
        $this->tableEmployer = $tableEmployer;
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
}
