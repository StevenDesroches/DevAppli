<?php

namespace Application\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class StudentTable
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

    public function fetchAllWithEmail()
    {
        $select = $this->tableGateway->getSql()->select();
        $select->join('users', 'users.id = students.user_id', ['email'], 'left'); 
        $stmt = $this->tableGateway->getSql()->prepareStatementForSqlObject($select);
        $results = $stmt->execute();
        return $results;
    }

    public function getStudent($id)
    {
        $id = (int) $id;
        $rowset= $this->tableGateway->select(['admission_number' => $id]);
        $row = $rowset->current();
        if (!row){
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }
        return $row;
    }

    public function editStudent($student)
    {
            $data = [
                'name'  => $student->name,
            'active'  => $student->active,
            'user_id'  => $student->user_id,
            ];

            $id = (int) $student->admission_number;

        $this->tableGateway->update($data, ['admission_number' => $id]);
    }

    public function deleteStudent($id)
    {
        $this->tableGateway->delete(['admission_number' => (int) $id]);
    }
}
