<?php 
/** Project Name: Nimbus (Circle K Club Management)
 ** Logout (logout.php)
 **
 ** Author: Jerry Bao (jbao@berkeley.edu)
 ** Author: Robert Rodriguez (rob.rodriguez@berkeley.edu)
 ** Author: Diyar Aniwar (diyaraniwar@berkeley.edu)
 ** 
 ** CIRCLE K INTERNATIONAL
 ** COPYRIGHT 2014-2015 - ALL RIGHTS RESERVED
 **/

require_once("dbfunc.php");
$userdb = new UserFunctions;
$userdb->logout();
header('Location: login.php');
?>