<?php 
/** Project Name: Nimbus (Circle K Club Management)
 ** Database Functions (header.php)
 **
 ** Author: Jerry Bao (jbao@berkeley.edu)
 ** Author: Robert Rodriguez (rob.rodriguez@berkeley.edu)
 ** Author: Diyar Aniwar (diyaraniwar@berkeley.edu)
 ** Author: Sock Ryu (cki.sock@gmail.com)
 ** 
 ** CIRCLE K INTERNATIONAL
 ** COPYRIGHT 2015-2016 - ALL RIGHTS RESERVED
 **/
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Project Nimbus - <?= $pageTitle ?></title>
    <link rel="icon" type="image/png" href="/~circlek/images/logos/logo_CKI_seal_small.png">
    <!-- Custom Fonts -->
    <link rel="stylesheet" type='text/css' href="/~circlek/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link href='//fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <!-- <link href="fonts/fonts.css" rel="stylesheet" type="text/css"> -->

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Chosen JQuery Plugin CSS -->
    <link href="css/chosen.css" rel="stylesheet" type="text/css">

    <? if ($customCSS) { ?>
    <!-- Page Specific CSS -->
    <link href="css/<?= $page ?>.css" rel="stylesheet" type="text/css">
    <? } ?>
    <link rel="stylesheet" type="text/css" href="/~circlek/admin/css/stylesheet.css" media="all">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>