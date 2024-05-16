<?php

$db = 'adminpanel';

$config = [
    'mysql_host' => 'localhost',
    'mysql_user' => 'root',
    'mysql_password' => ''
];

$mysqli = new mysqli(
    $config['mysql_host'],
    $config['mysql_user'],
    $config['mysql_password']
);

if ($mysqli->connect_error) {
    die('Errore nella connessione al database: ' . $mysqli->connect_error);
}

//CREATE DATABASE
$sql = 'CREATE DATABASE IF NOT EXISTS ' . $db;
if (!$mysqli->query($sql)) {
    die('Errore nella creazione del database: ' . $mysqli->error);
}

//SELECT DATABASE
$sql = 'USE ' . $db;
$mysqli->query($sql);


$sql = 'CREATE TABLE IF NOT EXISTS users ( 
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(255) NOT NULL, 
    lastname VARCHAR(255) NOT NULL, 
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role varchar(255) NOT NULL DEFAULT "user"
)';

if (!$mysqli->query($sql)) {
    die('Error creating table: ' . $mysqli->error);
}

//QUERY INFO FROM TABLE
$sqlSelect = 'SELECT * FROM users;';
$res = $mysqli->query($sqlSelect);

if ($res->num_rows === 0) {
    $password = password_hash('Pa$$w0rd!', PASSWORD_DEFAULT);
      //INSERT INFO INTO TABLE
    $sqlInsert = 'INSERT INTO users (firstname, lastname, email, password, role) 
        VALUES ("John", "Doe", "johndoe@mailnator.com", "'.$password.'","admin" );';
  
    if(!$mysqli->query($sql)) { echo($mysqli->connect_error); }
    else {
        echo 'Record aggiunto con successo!!!';
    }
}


?>
