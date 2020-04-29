<?php
  // mysql.inc.php - This file will be used to establish the database connection.
  class myConnectDB extends mysqli{
    public function __construct($hostname="34.94.184.101",
        $user="root",
        $password="gatsuga69!",
        $dbname="oceania"){
      parent::__construct($hostname, $user, $password, $dbname);
    }
  }
?>
