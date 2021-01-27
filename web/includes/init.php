<?php
require __DIR__.'/Dotenv.php';

    ob_start();
    session_start();
    //  *************** For PostgreSQL
    use includes\DotEnv;

   (new DotEnv(__DIR__ . '/.env'))->load();

        $dsn = 'pgsql:host=' . $_ENV['DATABASE_HOST'] . ';dbname=' . $_ENV['DATABASE_NAME'];
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false
        ];
        $pdo = new PDO($dsn,$_ENV['DATABASE_USER'], $_ENV['DATABASE_PASSWORD'],$opt);
    //  *************** For MySQL
    //    $dsn = "mysql:host=localhost;dbname=login_course;port=3306;charset=utf8";
    //    $opt = [
    //        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    //        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    //        PDO::ATTR_EMULATE_PREPARES   => false
    //    ];
    //    $pdo = new PDO($dsn, $user, $pass, $opt);
    
    $root_directory = "geoportal";
    $from_email = "geospatialbhutan@gmail";
    $reply_email = "geospatialbhutan@gmail";
    include "php_functions.php";
?>
