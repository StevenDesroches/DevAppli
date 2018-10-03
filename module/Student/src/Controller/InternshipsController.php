<?php

namespace Student\Controller;

use Student\Model\InternshipsTable;
use Zend\View\Model\ViewModel;

class InternshipsController extends BaseController
{
    private $table;

    public function __construct(InternshipsTable $table)
    {
        $this->table = $table;
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

        return new ViewModel(array(
            'internship' => $internship,
        ));
    }
}
