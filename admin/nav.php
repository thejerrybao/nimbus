<?php 
/** Project Name: Nimbus (Circle K Club Management)
 ** Database Functions (nav.php)
 **
 ** Author: Jerry Bao (jbao@berkeley.edu)
 ** Author: Robert Rodriguez (rob.rodriguez@berkeley.edu)
 ** Author: Diyar Aniwar (diyaraniwar@berkeley.edu)
 ** Author: Sock Ryu (cki.sock@gmail.com)
 ** 
 ** CIRCLE K INTERNATIONAL
 ** COPYRIGHT 2015-2016 - ALL RIGHTS RESERVED
 **/

$valid_event_manage_views = ["list", "calendar", "event", "edit"];
$valid_roster_manage_views = ["list", "dues", "user", "status", "edit"];
$valid_mrp_views = ["mrpadd", "mrplist"];
?>
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Project Nimbus: Circle K Club Management</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <?= $_SESSION['nimbus_first_name'] ?> <?= $_SESSION['nimbus_last_name'] ?> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="/~circlek/index.php"><i class="fa fa-home fa-fw"></i> Back to ucbcki.org</a></li>
                <li><a href="/~circlek/selfinfo/events.php"><i class="fa fa-info-circle fa-fw"></i> My Events</a></li>
                <li><a href="/~circlek/admin/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control" placeholder="Search for event...">
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                    </div>
                    <!-- /input-group -->
                </li>
                <li <? if ($page == "index") { ?> class="active" <? } ?>><a href="index.php"><i class="fa fa-home fa-fw"></i> Dashboard</a></li>
                <li <? if ($page == "events") { ?> class="active" <? } ?>>
                    <a href="#"><i class="fa fa-calendar fa-fw"></i> Event Management<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a <? if ($page == "events" && $_GET['view'] == "create") { ?> class="active" <? } ?> href="events.php?view=create">Create Event</a></li>
                        <li <? if ($page == "events" && in_array($_GET['view'], $valid_event_manage_views)) { ?> class="active" <? } ?> >
                            <a href="#">Manage Events <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li><a <? if ($page == "events" && $_GET['view'] == "list") { ?> class="active" <? } ?> href="events.php?view=list">Events List</a></li>
                                <li><a <? if ($page == "events" && $_GET['view'] == "calendar") { ?> class="active" <? } ?> href="events.php?view=calendar">Events Calendar</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li <? if ($page == "blog") { ?> class="active" <? } ?>>
                    <a href="#"><i class="fa fa-thumb-tack fa-fw"></i> Blog Management<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a <? if ($page == "blog" && $_GET['view'] == "create") { ?> class="active" <? } ?> href="blog.php?view=create">Create Post</a></li>
                        <li><a <? if ($page == "blog" && $_GET['view'] == "list") { ?> class="active" <? } ?> href="blog.php?view=list">Manage Posts</a></li>
                        <li><a <? if ($page == "blog" && $_GET['view'] == "submissions") { ?> class="active" <? } ?> href="blog.php?view=submissions">Article Submissions</a></li>
                         
                    </ul>
                </li>
                <li <? if ($page == "roster") { ?> class="active" <? } ?>>
                    <a href="#"><i class="fa fa-user fa-fw"></i> Club Roster<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a <? if ($page == "roster" && $_GET['view'] == "add") { ?> class="active" <? } ?> href="roster.php?view=add">Add Member</a></li>
                        <li <? if ($page == "roster" && in_array($_GET['view'], $valid_roster_manage_views)) { ?> class="active" <? } ?> >
                            <a href="#">Manage Members <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li><a <? if ($page == "roster" && $_GET['view'] == "list") { ?> class="active" <? } ?> href="roster.php?view=list">Members List</a></li>
                                <li><a <? if ($page == "roster" && $_GET['view'] == "dues") { ?> class="active" <? } ?> href="roster.php?view=dues&action=set">Manage Dues Paid</a></li>
                                <li><a <? if ($page == "roster" && $_GET['view'] == "status") { ?> class="active" <? } ?> href="roster.php?view=status&action=deactivate">Manage Members Status</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li <? if ($page == "committees") { ?> class="active" <? } ?>>
                    <a href="#"><i class="fa fa-users fa-fw"></i> Club Committees<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a <? if ($page == "committees" && $_GET['view'] == "add") { ?> class="active" <? } ?> href="committees.php?view=add">Add Committee</a></li>
                        <li><a <? if ($page == "committees" && $_GET['view'] == "list") { ?> class="active" <? } ?> href="committees.php?view=list">Manage Committees</a></li>
                    </ul>
                </li>
                <? if ($_SESSION['nimbus_access'] > 1) { ?>
                <li <? if ($page == "tags") { ?> class="active" <? } ?>>
                    <a href="#"><i class="fa fa-certificate fa-fw"></i> Tag Management<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a <? if ($page == "tags" && $_GET['view'] == "add") { ?> class="active" <? } ?> href="tags.php?view=add">Add Tag</a></li>
                        <li><a <? if ($page == "tags" && $_GET['view'] == "list") { ?> class="active" <? } ?> href="tags.php?view=list">Manage Tags</a></li>
                        <li <? if ($page == "tags" && in_array($_GET['view'], $valid_mrp_views)) { ?> class="active" <? } ?>>
                            <a href="#">MRP<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li><a <? if ($page=="tags" && $_GET['view'] == "mrpadd") { ?> class="active" <? } ?> href="tags.php?view=mrpadd">Add Level</a></li>
                                <li><a <? if ($page=="tags" && $_GET['view'] == "mrplist") { ?> class="active" <? } ?> href="tags.php?view=mrplist">Manage Levels</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <? } ?>
                <? if ($_SESSION['nimbus_access'] > 3) { ?>
                <li <? if ($page == "admin" && $_GET['view'] == "access") { ?> class="active" <? } ?>>
                    <a href="#"><i class="fa fa-wrench fa-fw"></i> Administrative Tasks<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a <? if ($page == "admin" && $_GET['view'] == "access") { ?> class="active" <? } ?> href="admin.php?view=access">Manage Member Access</a></li>
                    </ul>
                </li>
                <? } ?>
                <? if ($_SESSION['nimbus_access'] > 2) { ?>
                    <li <? if ($page == "admin" && $_GET['view'] == "verify") { ?> class="active" <? } ?>><a href="admin.php?view=verify"><i class="fa fa-check fa-fw"></i> Verify Events</a></li>
                <? } ?>
                <li <? if ($page == "about") { ?> class= "active" } <? } ?>><a href="about.php"><i class="fa fa-question fa-fw"></i> About</a></li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
