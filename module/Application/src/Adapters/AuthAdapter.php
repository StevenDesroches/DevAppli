<?php

namespace Application\Adapters;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;

$authAdapter = new AuthAdapter($db, 'users', 'email', 'password');

?>