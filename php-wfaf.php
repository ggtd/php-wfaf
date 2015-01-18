<?php
# php-wfaf
# Web Form Aplication Firewall
# PHP version
# tomas@dobrotka.sk
# VER. 0.1SQLITE
# https://github.com/ggtd/php-wfaf

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('./data/form_firewall.db');
    }
}
class firewall
{
    function __construct($my_form_name)
    {
        //you can edit this:
        $this->LAST_POST_THRESHOLD     = 20;
        $this->MAX_POSTS_IN_TIME_FRAME = 3;
        $this->POSTS_TIME_FRAME        = 180;
        
        //do not edit this!:
        $this->ip                      = $_SERVER['REMOTE_ADDR'];
        $this->FORM                    = $my_form_name;
        $this->hash                    = md5($this->ip . "-" . $this->FORM);
        $this->TIME                    = time();
        $this->LAST_POST_BEFORE        = -1;
        $this->LAST_POST_TIME          = 0;
        $this->POSTS_IN_TIME           = 0;
        $this->STATUS                  = "ALLOW";
        $this->LTT                     = 0;
        $db                            = new MyDB();
        if (!$db) {
            echo $db->lastErrorMsg();
        } else {
            $sql           = "INSERT INTO FW_LOG (IP,HASH,TIMESTAMP,RSTATUS) VALUES ('$this->ip','$this->hash',$this->TIME,'$this->STATUS')";
            $db_ret_insert = $db->exec($sql);
            $db_ret_select = $db->query("SELECT * FROM FW_LOG WHERE HASH='$this->hash' AND TIMESTAMP>" . ($this->TIME - $this->POSTS_TIME_FRAME) . ";");
            while ($logline = $db_ret_select->fetchArray(SQLITE3_ASSOC)) {
                $this->POSTS_IN_TIME++;
                if ($this->LAST_POST_TIME == 0 OR $logline["TIMESTAMP"] <> $this->TIME AND $this->LAST_POST_TIME < $logline["TIMESTAMP"]) {
                    $this->LAST_POST_TIME   = $logline["TIMESTAMP"];
                    $this->LAST_POST_BEFORE = abs($this->LAST_POST_TIME - time());
                }
            }
            $db_ret_select = $db->query("DELETE FROM FW_LOG WHERE TIMESTAMP<" . ($this->TIME - $this->POSTS_TIME_FRAME) . ";");
            $db_ret_select = $db->query("VACUUM;");
            $db->close();
        }
         if ($this->LAST_POST_BEFORE>0 AND $this->LAST_POST_BEFORE <= $this->LAST_POST_THRESHOLD) {
            $this->STATUS = "BLOCK";
        }
        //calculate the PITT (Posts in Time / THRESHOLD) 
        $this->PITT = $this->POSTS_IN_TIME / $this->MAX_POSTS_IN_TIME_FRAME;
        if ($this->PITT >= 1) {
            $this->STATUS = "BLOCK";
        }
        //calculate the ODT (Overall data / THRESHOLD) 
        $this->ODT = $this->POSTS_IN_TIME / $this->POSTS_TIME_FRAME;
        if ($this->ODT > 1) {
            $this->STATUS = "BLOCK";
        }
    }
}
?>
