<?php

namespace Employer\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class StudentsTable
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

    public function getCurrentStudent(){
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('Student'));

        return $auth->getIdentity()->getId();
    }

    public function getStudent($id)
    {
        $id = (int) $id;
        $rowset= $this->tableGateway->select(['admission_number' => $id]);
        $row = $rowset->current();
        return $row;
    }

    public function saveStudent(Student $student)
    {
        $data = [
            'admission_number' => $student->admission_number,
            'name' => $student->name,
            'active' => $student->active,
            'user_id' => $student->user_id,
            'file' => $student->file,
        ];

        $id = (int) $student->admission_number;

        if (! $this->getStudent($id)) {
            $this->tableGateway->insert($data);
            return;
        }
    }

    public function editStudent($student)
    {
            $data = [
                'name'  => $student->name,
            'active'  => $student->active,
            'user_id'  => $student->user_id,
            ];

            $id = (int) $student->admission_number;

            if (! $this->getStudent($id)) {
                throw new RuntimeException(sprintf(
                    'Cannot update student with identifier %d; does not exist',
                    $id
                ));
            }

        $this->tableGateway->update($data, ['admission_number' => $id]);
    }

    public function deleteStudent($id)
    {
        $this->tableGateway->delete(['admission_number' => (int) $id]);
    }
}
