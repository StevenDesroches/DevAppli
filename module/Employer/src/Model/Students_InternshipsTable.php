<?php

namespace Employer\Model;

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

    public function getInternship($id)
    {
        $intern_id = (int) $id;
        $rowset = $this->tableGateway->select(['internship_id' => $intern_id]);
        return $rowset;
    }

    public function deleteInternship($id)
    {
        $this->tableGateway->delete(['internship_id' => (int) $id]);
    }

    public function saveRelationInternship($id, $id2)
    {
        $this->tableGateway->delete(['internship_id' => (int) $id]);
        $data = [
            'student_id' => (int) $id,
            'internship_id' => (int) $id2,
        ];

        $this->tableGateway->insert($data);
        return;
    }
}