<?php
#this PHP file will create an empty SQLite database with tahle scructure for php-wfaf
#execute this in command line or via http request.
#just be sure to that the folder ./data/ is created and writable by Web server.



   class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('./data/form_firewall.db');
      }
   }
   $db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   } else {
      echo "Opened database successfully\n";
   }

   $sql =<<<EOF
      CREATE TABLE FW_LOG
      (IP           CHAR(15)    NOT NULL,
      HASH           CHAR(40)     NOT NULL,
      RSTATUS           CHAR(8)     NOT NULL,
      TIMESTAMP         REAL);
EOF;

   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      echo "Table created successfully\n";
   }
   $db->close();







?>
