<?php 
/** Project Name: Nimbus (Circle K Club Management)
 ** About Page (about.php)
 **
 ** Author: Jerry Bao (jbao@berkeley.edu)
 ** Author: Robert Rodriguez (rob.rodriguez@berkeley.edu)
 ** Author: Diyar Aniwar (diyaraniwar@berkeley.edu)
 ** 
 ** CIRCLE K INTERNATIONAL
 ** COPYRIGHT 2014-2015 - ALL RIGHTS RESERVED
 **/

session_start();
if (!isset($_SESSION['nimbus_user_id'])) { header('Location: ../login.php'); }
else if ($_SESSION['nimbus_access'] == 0) { echo "You don't have access to this page."; exit; }

$page = "about";
$pageTitle = "About Project Nimbus";
$customCSS = false;
$customJS = false;
?>

<!DOCTYPE html>
<html lang="en">

<? require_once("header.php"); ?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <? require_once("nav.php"); ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">About Project Nimbus</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4">
                    <h3 style="margin-top: 0px;">Developers</h4>
                    <p>Jerry Bao (<a href="mailto:jbao@berkeley.edu">jbao@berkeley.edu</a>)<br />2013-2014 CNH Circle K District Technology Chair</p>
                    <p>Robert Rodriguez (<a href="mailto:rob.rodriguez@berkeley.edu">rob.rodriguez@berkeley.edu</a>)<br /> 2013-2014 UC Berkeley Circle K Technology Chair</p>
                    <p>Diyar Aniwar (<a href="mailto:diyaraniwar@berkeley.edu">diyaraniwar@berkeley.edu</a>)<br /> 2014-2015 UC Berkeley Circle K Technology Chair</p>
                </div>
                <div class="col-lg-4">
                    <h3 style="margin-top: 0px;">Technology Used</h4>
                    <p>PHP 5+<br />
                        HTML5/CSS3<br />
                        JQuery<br />
                        Javascript<br />
                        SB Admin 2.0 Framework<br />
                        Bootstrap<br />
                        Chosen JQuery Plugin<br />
                        Font Awesome Icons<br />
                    </p>
                </div>
                <div class="col-lg-4">
                    <h3 style="margin-top: 0px;">A Word From the Devs</h4>
                    <p>This project was developed in response to a need for a new system at UC Berkeley to manage the club's events and hours. With over 1000+ hours spent
                        on the project and 10k+ lines of code written in a mix of PHP, HTML5, JS, and JQuery, we're proud of what we've accomplished. We want to thank everyone
                        who's supported us in our endeavors and ultimately want to thank Circle K, for providing us with some of the best memores of our college life. We do this
                        all for Circle K, the organization we love.</p>
                    <p> - Jerry Bao, Robert Rodriguez, Diyar Aniwar</p>
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <? require_once("scripts.php"); ?>

</body>
</html>
