<?php

namespace Student\Controller;

use phpDocumentor\Reflection\Types\Array_;
use Student\Model\InternshipsTable;
use Student\Model\EmployerTable;
use Student\Model\Students_InternshipsTable;
use Student\Model\StudentsTable;
use Zend\Db\Sql\Predicate\In;
use Zend\View\Model\ViewModel;

class Students_InternshipsController extends BaseController
{
    private $table;

    private $tableInternships;

    public function __construct(Students_InternshipsTable $table, InternshipsTable $tableInternships)
    {
        parent::__construct();

        $this->table = $table;
        $this->tableInternships = $tableInternships;
    }


    public function indexAction()
    {

        $user = $this->currentUser;
        $rowset = $this->table->getStudentInternship($user);
        $rowset2 = array();

        $rowNumb = $rowset->count();
        for ($i = 0; $i < $rowNumb; $i++ ){
            $row = $rowset->current();
            $rowset->next();

            $id = $row->internship_id;
            array_push($rowset2, $this->tableInternships->getInternship($id));
        }

        return new ViewModel(['rowset2' => $rowset2]);
    }
}
