<?php

namespace etronic\phpmvc\db;

use etronic\phpmvc\Application;

class Database
{



    public \PDO $pdo;


    public function __construct(array $config)
    {


        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        // var_dump($config);
        // exit;


        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations()
    {
        $this->createMigrationsTables();
        $appliedMigation= $this->getAppliedMigrations();

        $newMigration = [];


        $files=scandir(Application::$ROOT_DIR.'/migrations');
        $toApplyMigrations=array_diff($files, $appliedMigation);

        foreach ($toApplyMigrations as $migration){


            if($migration==='.' || $migration=='..'){

                continue;
            }

            require_once Application::$ROOT_DIR.'/migrations/'.$migration;
            $className=pathinfo($migration,PATHINFO_FILENAME);
            $instance=new $className();
            $this->log("Appling migration for $migration");
            $instance->up();
            $this->log("Applied migration for $migration");
            $newMigration[]=$migration;
            
        }

        if(!empty($newMigration)){

            $this->saveMigrations($newMigration);
        }else{
            $this->log( "All migrations are applied");
        }

      

    }

    public function createMigrationsTables()
    {

        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;";

        $this->pdo->exec($sql);
    }

    public function getAppliedMigrations(){

        $statement=$this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }


    public function saveMigrations(array $migrations){

       $quray =implode(",", array_map(fn($m)=>"('$m')",$migrations));


       $statement= $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $quray ");
       $statement->execute();


    }


    public function prepare($sql){

       return  $this->pdo->prepare($sql);

    }

    protected function log($message){

        echo '['.date('Y-m-d H:i:s').']: '.$message.PHP_EOL;
    }
}
