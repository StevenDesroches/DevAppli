<?php

namespace Student\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class Students_InternshipsTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function fetchAllWithEmployer()
    {
        $select = $this->tableGateway->getSql()->select();
        $select->join('internship_offers', 'internship_offers.id = students_internships.internship_id', ['internship_offers' => 'name'], 'left');
        $stmt = $this->tableGateway->getSql()->prepareStatementForSqlObject($select);
        $results = $stmt->execute();
        return $results;
    }

    public function getStudentInternship($student_id)
    {
        $student_id = (int) $student_id;
        $rowset = $this->tableGateway->select(['student_id' => $student_id]);
        return $rowset;
    }

    public function saveInternship(Students_Internships $students_internships)
    {
        $data = [
            'student_id' => $students_internships->student_id,
            'internship_id' => $students_internships->internship_id,
        ];

        $this->tableGateway->insert($data);
        return;
    }

    public function deleteInternship($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}