<?php

namespace Application\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class InternshipsTable
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
        $select->join('employers', 'employers.id = internship_offers.id_employer', ['employer' => 'name'], 'left'); 
        $stmt = $this->tableGateway->getSql()->prepareStatementForSqlObject($select);
        $results = $stmt->execute();
        return $results;
    }

    public function getInternship($id)
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

    public function saveInternship(Internship $internship)
    {
        $data = [
            'name' => $internship->name,
            'date_posted' => $internship->date_posted,
            'description' => $internship->description,
            'active' => $internship->active,
            'id_employer' => $internship->id_employer,
        ];

        $id = (int) $internship->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getInternship($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update internship with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteInternship($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}