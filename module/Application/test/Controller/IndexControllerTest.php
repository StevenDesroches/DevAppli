<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ApplicationTest\Controller;

use Application\Controller\IndexController;
use Application\Controller\UsersController;
use Application\Model\Employer;
use Application\Model\User;
use Application\Model\UserTable;
use PHPUnit\Util\PHP\AbstractPhpProcess;
use Zend\Db\ResultSet\ResultSet;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Db\Adapter\Adapter;

class IndexControllerTest extends AbstractHttpControllerTestCase
{

    private $adapter;

    public function setUp()
    {

        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.

        $this->adapter = new Adapter([
            'driver' => 'mysqli',
            'database' => 'internships',
            'username' => 'root',
            'password' => 'mysql',
            'hostname' => 'localhost',
        ]);


        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();
    }

    public function tearDown()
    {
        //$this->user->delete();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/', 'GET');
        $this->assertResponseStatusCode(302); //Redirection
        $this->assertModuleName('application');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('home');
    }

    public function testIndexActionViewModelTemplateRenderedWithinLayout()
    {
        $this->dispatch('/', 'GET');
        $this->assertQuery('.container .navbar-brand');
    }

    public function testInvalidRouteDoesNotCrash()
    {
        $this->dispatch('/invalid/route', 'GET');
        $this->assertResponseStatusCode(404);
    }

    public function testModulesLoaded()
    {
        $this->dispatch('/', 'GET');
        $this->assertModulesLoaded(array("Application", "Employer", "Student"));
    }

    public function testUsersNotEmpty()
    {

        $sql = "SELECT * FROM users";
        $statement = $this->adapter->createStatement($sql);
        $result = $statement->execute();
        $result->buffer();

        if ( $result->count() > 0 ) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false, "La table users ne contient pas de valeurs");
        }

    }

    public function testInternshipNotEmpty()
    {

        $sql = "SELECT * FROM internship_offers";
        $statement = $this->adapter->createStatement($sql);
        $result = $statement->execute();
        $result->buffer();

        if ( $result->count() > 0 ) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false, "La table internship_offers ne contient pas de valeurs");
        }

    }

    public function testEmployersNotEmpty()
    {

        $sql = "SELECT * FROM employers";
        $statement = $this->adapter->createStatement($sql);
        $result = $statement->execute();
        $result->buffer();

        if ( $result->count() > 0 ) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false, "La table employers ne contient pas de valeurs");
        }
    }

    public function testCoordinatorsNotEmpty()
    {

        $sql = "SELECT * FROM coordinators";
        $statement = $this->adapter->createStatement($sql);
        $result = $statement->execute();
        $result->buffer();

        if ( $result->count() > 0 )  {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false, "La table coordinators ne contient pas de valeurs");
        }
    }

    public function testStudentsNotEmpty()
    {

        $sql = "SELECT * FROM students";
        $statement = $this->adapter->createStatement($sql);
        $result = $statement->execute();
        $result->buffer();

        if ( $result->count() > 0 )  {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false, "La table students ne contient pas de valeurs");
        }
    }

    public function testUserTypesNotEmpty()
    {

        $sql = "SELECT * FROM user_types";
        $statement = $this->adapter->createStatement($sql);
        $result = $statement->execute();
        $result->buffer();

        if ( $result->count() > 0 )  {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false, "La table user_types ne contient pas de valeurs");
        }
    }
}
