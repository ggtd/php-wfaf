<h1>Web Form Application Firewall DEMO site</h1>
<hr>
<?php

include("php-wfaf.php");

$fw= new firewall("FORM1");
?>

<br>My TIME: <?php echo $fw->TIME;?> (UNIX)
<br>Last post TIME: <?php echo $fw->LAST_POST_TIME;?> (UNIX)
<br>Last post before: <?php echo $fw->LAST_POST_BEFORE;?>seconds
<br>

Courently  <?php echo $fw->POSTS_IN_TIME;?> POSTS in last <?php echo $fw->POSTS_TIME_FRAME;?> seconds<br>
<hr>
PITT  <?php echo $fw->PITT;?><br>
ODT  <?php echo $fw->ODT;?><br>
<hr>
STATUS: <?php echo $fw->STATUS;?><br>

<hr>

<b>Refresh this page, to emulate request, and watch the runtime info from $fw Objekt</b>
