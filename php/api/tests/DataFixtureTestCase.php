<?php
/**
 * Created by PhpStorm.
 * User: robm
 * Date: 20/09/2019
 * Time: 22:45
 */

namespace App\Tests;


use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DataFixtureTestCase extends WebTestCase
{
    /** @var  Application $application */
    protected static $application;

    /** @var  Client $client */
    protected $client;

    protected $entityManager;
    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $this->client = static::createClient();
        $this->entityManager = static::$container->get('doctrine.orm.entity_manager');
        self::runCommand('doctrine:database:drop --force');
        self::runCommand('doctrine:database:create');
        self::runCommand('doctrine:schema:create');
        self::runCommand('doctrine:fixtures:load --append --no-interaction');

        parent::setUp();
    }

    protected static function runCommand($command)
    {
        $command = sprintf('%s --quiet', $command);

        return self::getApplication()->run(new StringInput($command));
    }

    protected static function getApplication()
    {

        //@FIXME temporarily disabling singleton as it is breaking tests
//        if (null === self::$application) {
//            self::bootKernel();
//            self::$application = new Application(self::$kernel);
//            self::$application->setAutoExit(false);
//        }
//        return self::$application;

            self::bootKernel();
            $application = new Application(self::$kernel);
            $application->setAutoExit(false);
            return $application;
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {

      //  self::$application = null;
      //  self::runCommand('doctrine:database:drop --force');

        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}