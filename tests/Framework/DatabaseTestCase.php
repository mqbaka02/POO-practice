<?php
namespace Tests\Framework;

use PDO;
use Phinx\Config\Config;
use Phinx\Migration\Manager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

class DatabaseTestCase extends TestCase
{
    /**
     * @var PDO
     */
    protected $pdo;

    public function setUp(): void
    {
        $pdo= new PDO('sqlite::memory:', null, null, [
            PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION
        ]);

        $configArray= require('phinx.php');
        $configArray['environments']['testing']= [
            'adapter'=> 'sqlite',
            'connection'=> $pdo
        ];
        $config= new Config($configArray);
        $manager= new Manager($config, new StringInput(''), new NullOutput());
        $manager->migrate('testing');
        $manager->seed('testing');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        $this->pdo= $pdo;
    }
}
