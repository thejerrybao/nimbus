<?php 
/** Project Name: Nimbus (Circle K Report Form System)
 ** Event Administration (events.php)
 **
 ** Author: Jerry Bao (jbao@berkeley.edu)
 ** Author: Robert Rodriguez (rob.rodriguez@berkeley.edu)
 ** Author: Diyar Aniwar (diyaraniwar@berkeley.edu)
 ** 
 ** CIRCLE K INTERNATIONAL
 ** COPYRIGHT 2014-2015 - ALL RIGHTS RESERVED
 **/

require_once("dbfunc.php");
$db = new DatabaseFunctions;

switch ($_POST["form_submit_type"]) {
    case "create_event":
        break;
    default:
        echo "No Form Submit Type Passed.";
}
?>

