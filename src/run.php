<?php
require_once "../config.php";
require_once "./workWithDB/DbConnectManager.php";
require_once "./workWithDB/CreateTables.php";

$Config = new Config();
$DB_testSite =  new DbConnectManager($Config->getDns(), $Config->getUser(), $Config->getPass());
$DB_testSite = $DB_testSite->getdbh();

$CreateTables = new CreateTables("./sql/tables.sql", $DB_testSite);
$CreateTables->createTables();

?>