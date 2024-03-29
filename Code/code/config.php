<?php
   //Conexion con base de datos
   $host = 'localhost';
   $db   = 'SocialNetwork';
   $user = 'root';
   $pass = 'test-password';
   $charset = 'utf8mb4';

   $options = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
   ];
   $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
   try {
     $pdo  = new PDO($dsn, $user, $pass, $options);
   } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int)$e->getCode());
   }
?>