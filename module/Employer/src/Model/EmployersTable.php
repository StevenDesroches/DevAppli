<?php

namespace Employer\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class EmployersTable
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

    public function getEmployerFromIdUser($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id_user' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function getEmployerByUuid($uuid)
    {
        $id = (int) $uuid;
        $rowset = $this->tableGateway->select(['uuid' => $uuid]);
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
            'adress' => $employer->adress,
            'contact_email' => $employer->contact_email,
            'city' => $employer->city,
            'province' => $employer->province,
            'postal_code' => $employer->postal_code,
            'active' => $employer->active,
            'date_created' => $employer->date_created,
            'id_user' => $employer->id_user,
            'uuid' => $employer->uuid,
        ];

        $id = (int) $employer->id;

        if ($id === 0) {
            return $this->tableGateway->insert($data);
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