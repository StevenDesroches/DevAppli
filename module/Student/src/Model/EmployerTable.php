<?php

namespace Student\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class EmployerTable
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

    public function getEmployer($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveEmployer(Employer $employer)
    {
        $data = [
            'name' => $employer->name,
            'email' => $employer->email,
            'adress' => $employer->adress,
            'city' => $employer->city,
            'province' => $employer->province,
            'postal_code' => $employer->postal_code,
            'active' => $employer->active,
            'id_employer' => $employer->id_employer,
        ];

        $id = (int) $employer->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getEmployer($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update employer with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteEmployer($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}