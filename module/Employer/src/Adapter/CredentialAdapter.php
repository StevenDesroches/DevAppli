<?php

namespace Employer\Adapter;

use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;
use Zend\Authentication\Result as AuthenticationResult;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Db\Sql;
use Zend\Db\Sql\Expression as SqlExpr;
use Zend\Db\Sql\Predicate\Operator as SqlOp;

class CredentialAdapter extends CredentialTreatmentAdapter
{
    public $user_type;

    public function setUserType($user_type)
    {
        $this->user_type = $user_type;
    }

    protected function authenticateCreateSelect()
    {
        // build credential expression
        if (empty($this->credentialTreatment) || (strpos($this->credentialTreatment, '?') === false)) {
            $this->credentialTreatment = '?';
        }
        $credentialExpression = new SqlExpr(
            '(CASE WHEN ?' . ' = ' . $this->credentialTreatment . ' THEN 1 ELSE 0 END) AS ?',
            [$this->credentialColumn, $this->credential, 'zend_auth_credential_match'],
            [SqlExpr::TYPE_IDENTIFIER, SqlExpr::TYPE_VALUE, SqlExpr::TYPE_IDENTIFIER]
        );
        // get select
        $dbSelect = clone $this->getDbSelect();
        $dbSelect->from($this->tableName)
            ->columns(['*', $credentialExpression])
            ->where(new SqlOp($this->identityColumn, '=', $this->identity))
            ->where(new SqlOp('user_type', '=', $this->user_type));
        return $dbSelect;
    }
}