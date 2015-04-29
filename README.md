php-wfaf
========

Web Form Application Firewall - Form flood detector - PHP/SQLite Version

Background:
I am fan of web forms withou Captcha, this means to hande the validation in a special way, and handle with flooding from time to time. That is why this PHP class was created. It can act as hand-brake for PHP scripts that recieve data from web forms.

This PHP class is designed to protect Web Forms against flooding. (Without using captcha)
The best example of form like this could be a "Contact form" on a website. In real World
any form is submited by user onece in a time (Hours, Days, Weeks).
This means you can detect flooding very quick and in a very simple way.

The implementation and usage is designed to be as simple as possible:

```
<?php

include("php-wfaf.php");
$fw= new firewall("OPTIONAL-FORM-TAG");
if ($fw->STATUS=="ALLOW")
{
  //do what you need
  //send emails, write SQL insert query,...
};

?>
```

This PHP script is designed to count the Form Post actions from clients and decide if you want
to Allow or Block the request. So you don`t need to send thousands of email notifications or insert thousand of flooded lines into SQL tables.


*NOTE: I am using the term POST in documetation and script. This is not related to POST HTTP request method.
Post means any http client request that is made. See class usage examples for more info. You will get it.*

*This tool is not validating any input that is send from client to server.*

*The decision of ALLOW/BLOCK is based on 3 real-time calculated parameters.*

-1. Last request time.
This is a simple time based Rule, the default value is set to 20 seconds. It means that there
must be at least 20 seconds betwen the last and current form submission made by one IP address/Hash.

Youn can change the time, by changeing this line:
$this->LAST_POST_THRESHOLD     = 20;

-2. Number of requests made in preset time span.
The default rule is set 

You can change the settings, by changing these line:
$this->MAX_POSTS_IN_TIME_FRAME = 3;
$this->POSTS_TIME_FRAME        = 180;


-3. Overal number of requests in time. (Just a concept don`t use unless you know what it does)
It calculates all request made in time span. This has to be explain in future versions.
The first two rules are providing more configuration precission, so use the mumber 1 and 2 for your forms.



Special notes:
==============
There is no error handling or error loging implemented. Errors and debuding should be
done on user/sysadmin level. Do what you need.


TODO
====
* Add loging
* More documetation and examples.
* Add time based blocking
* Make documetation for HASH, that includes URL or User-Agent info, for even more precision.
* Add separate blocing table/text/htaccess file to be used.
* Decentralized or shared DB for HA and Cluseters
* MySQL pr PG DB usage.
* Rule n.3: Document, expand options, explain, tune config and usage




