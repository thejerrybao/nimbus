<?php 
/** Project Name: Nimbus (Circle K Club Management)
 ** Form Data Processing (processdata.php)
 **
 ** Author: Jerry Bao (jbao@berkeley.edu)
 ** Author: Robert Rodriguez (rob.rodriguez@berkeley.edu)
 ** Author: Diyar Aniwar (diyaraniwar@berkeley.edu)
 ** 
 ** CIRCLE K INTERNATIONAL
 ** COPYRIGHT 2014-2015 - ALL RIGHTS RESERVED
 **/
ini_set('display_errors', 1);

require_once("dbfunc.php");
$committeedb = new CommitteeFunctions;
$eventdb = new EventFunctions;
$userdb = new UserFunctions;
$tagdb = new TagFunctions;
$blogdb = new BlogFunctions;
$location = 'Location: ';

switch ($_POST['form_submit_type']) {
    case "login":
        $userData = $userdb->login($_POST['username'], $_POST['password']);
        if ($userData) {
            session_start();
            $_SESSION['nimbus_user_id'] = $userData['user_id'];
            $_SESSION['nimbus_access'] = $userData['access'];
            $_SESSION['nimbus_first_name'] = $userData['first_name'];
            $_SESSION['nimbus_last_name'] = $userData['last_name'];
            $location .= 'index.php';
        } else {
            $message = "ERROR: Incorrect username/password!";
            setcookie("errormsg", $message, time()+3);
            $location .= 'login.php';
        } 
        break;
    case "create_event":
        $eventData = array(
            "name" => $_POST['name'],
            "chair_id" => $_POST['chair_id'],
            "start_datetime" => strtotime($_POST['start_datetime']),
            "end_datetime" => strtotime($_POST['end_datetime']),
            "description" => $_POST['description'],
            "location" => $_POST['location'],
            "meeting_location" => $_POST['meeting_location'],
            "color" => $_POST['color'],
            "online_signups" => $_POST['online_signups'],
            "online_end_datetime" => strtotime($_POST['online_end_datetime']));
        if ($eventData['start_datetime'] > $eventData['end_datetime']) {
            $message = "ERROR: Start Date and Time cannot be after End Date and Time!";
            setcookie("errormsg", $message, time()+3);
            $location .= 'events.php?view=create';
        } else if ($eventData['online_end_datetime'] > $eventData['start_datetime'] && $eventData['online_signups']) {
            $message = "ERROR: Online End Date Time cannot be after Start Date Time!";
            setcookie("errormsg", $message, time()+3);
            $location .= 'events.php?view=create';
        } else if ($eventdb->createEvent($eventData, $_POST['tag_ids'])) {
            $message = "SUCCESS: Event \"" . $eventData['name'] . "\" successfully created!";
            setcookie("successmsg", $message, time()+3);
            $location .= 'events.php?view=list&month=' . idate('m') . '&year=' . date('Y');
        } else {
            $message = "DATABASE ERROR: Event could not be created!";
            setcookie("errormsg", $message, time()+3);
            $location .= 'events.php?view=create';
        }
        break;
    case "edit_event":
        $status = $_POST['status'];
        if ($status == 0) {
            $_POST['pros'] = $_POST['cons'] = $_POST['do_again'] = "Fill me in!";
            $_POST['funds_raised'] = 0.00;
            $_POST['service_hours'] = $_POST['admin_hours'] = $_POST['social_hours'] = 0;
        }
        if (strtotime($_POST['end_datetime']) <= time() && $_POST['status'] == 0) { $status = 1; }
        else if (strtotime($_POST['end_datetime']) >= time() && $_POST['status'] == 1) { $status = 0; }
        $eventData = array(
            "name" => $_POST['name'],
            "chair_id" => $_POST['chair_id'],
            "start_datetime" => strtotime($_POST['start_datetime']),
            "end_datetime" => strtotime($_POST['end_datetime']),
            "description" => $_POST['description'],
            "location" => $_POST['location'],
            "meeting_location" => $_POST['meeting_location'],
            "color" => $_POST['color'],
            "online_signups" => $_POST['online_signups'],
            "online_end_datetime" => strtotime($_POST['online_end_datetime']),
            "status" => $status,
            "pros" => $_POST['pros'],
            "cons" => $_POST['cons'],
            "do_again" => $_POST['do_again'],
            "funds_raised" => $_POST['funds_raised'],
            "service_hours" => $_POST['service_hours'],
            "admin_hours" => $_POST['admin_hours'],
            "social_hours" => $_POST['social_hours']);
        if ($eventData['start_datetime'] > $eventData['end_datetime']) {
            $message = "ERROR: Start Date and Time cannot be after End Date and Time!";
            setcookie("errormsg", $message, time()+3);
            $location .= 'events.php?view=edit&id=' . $_POST['event_id'];
        } else if ($eventData['online_end_datetime'] > $eventData['start_datetime'] && $eventData['online_signups']) {
            $message = "ERROR: Online End Date Time cannot be after Start Date Time!";
            setcookie("errormsg", $message, time()+3);
            $location .= 'events.php?view=edit&id=' . $_POST['event_id'];
        } else if ($eventdb->setEvent($_POST['event_id'], $eventData, $_POST['tag_ids'])) {
            $message = "SUCCESS: Event \"" . $eventData['name'] . "\" successfully edited!";
            setcookie("successmsg", $message, time()+3);
            $location .= 'events.php?view=event&id=' . $_POST['event_id'];
        } else {
            $message = "DATABASE ERROR: Event could not be edited!";
            setcookie("errormsg", $message, time()+3);
            $location .= 'events.php?view=edit&id=' . $_POST['event_id'];
        }
        break;
    case "delete_event":
        if ($eventdb->deleteEvent($_POST['event_id'])) {
            $message = "SUCCESS: Event successfully deleted!";
            setcookie("successmsg", $message, time()+3);
            $location .= 'events.php?view=list';
        } else { 
            $message = "DATABASE ERROR: Event could not be deleted!";
            setcookie("errormsg", $message, time()+3);
            $location .= 'events.php?view=event&id=' . $_POST['event_id'];
        }
        break;
    case "confirm_event":
        if ($eventdb->setEventStatus($_POST['event_id'], 2)) {
            $message = "SUCCESS: Event successfully confirmed!";
            setcookie("successmsg", $message, time()+3);
        } else {
            $message = "DATABASE ERROR: Event could not be confirmed!";
            setcookie("errormsg", $message, time()+3);
        }
        $location .= 'events.php?view=event&id=' . $_POST['event_id'];
        break;
    case "verify_event_approve";
        if ($eventdb->setEventStatus($_POST['event_id'], 3)) {
            $message = "SUCCESS: Event successfully approved!";
            setcookie("successmsg", $message, time()+3);
        } else {
            $message = "DATABASE ERROR: Event could not be approved!";
            setcookie("errormsg", $message, time()+3);
        }
        $location .= 'admin.php?view=verify';
        break;
    case "verify_event_deny";
        if ($eventdb->setEventStatus($_POST['event_id'], 1)) {
            $message = "SUCCESS: Event successfully denied!";
            setcookie("successmsg", $message, time()+3);
        } else {
            $message = "DATABASE ERROR: Event could not be denied!";
            setcookie("errormsg", $message, time()+3);
        }
        $location .= 'admin.php?view=verify';
        break;
    case "add_event_attendees":
        foreach ($_POST['user_ids'] as $user_id) {
            if (!$eventdb->addEventAttendee($_POST['event_id'], $user_id)) {
                $message = "DATABASE ERROR: A member could not be added as an attendee!";
                setcookie("errormsg", $message, time()+3);
                break;
            }
        }
        if (!isset($_COOKIE['errormsg'])) {
            $message = "SUCCESS: Selected members were added as attendees!";
            setcookie("successmsg", $message, time()+3);
        }
        $location .= 'events.php?view=event&id=' . $_POST['event_id'];
        break;
    case "delete_event_attendees":
        foreach ($_POST['user_ids'] as $user_id) {
            if (!$eventdb->deleteEventAttendee($_POST['event_id'], $user_id)) {
                $message = "DATABASE ERROR: A member could not be deleted as an attendee!";
                setcookie("errormsg", $message, time()+3);
                break;
            }
        }
        if (!isset($_COOKIE['errormsg'])) {
            $message = "SUCCESS: Selected members were deleted as attendees!";
            setcookie("successmsg", $message, time()+3);
        }
        $location .= 'events.php?view=event&id=' . $_POST['event_id'];
        break;
    case "add_override_hours":
        foreach ($_POST['user_ids'] as $user_id) {
            if (!$eventdb->addOverrideHours($_POST['event_id'], $user_id)) {
                $message = "DATABASE ERROR: A member could not be added to the override hours list!";
                setcookie("errormsg", $message, time()+3);
                break;
            }
        }
        if (!isset($_COOKIE['errormsg'])) {
            $message = "SUCCESS: Selected members were added to the override hours list!";
            setcookie("successmsg", $message, time()+3);
        }
        $location .= 'events.php?view=overridehours&id=' . $_POST['event_id'];
        break;
    case "delete_override_hours":
        foreach ($_POST['user_ids'] as $user_id) {
            if (!$eventdb->deleteOverrideHours($_POST['event_id'], $user_id)) {
                $message = "DATABASE ERROR: A member could not be deleted from the override hours list!";
                setcookie("errormsg", $message, time()+3);
                break;
            }
        }
        if (!isset($_COOKIE['errormsg'])) {
            $message = "SUCCESS: Selected members were deleted from the override hours list!";
            setcookie("successmsg", $message, time()+3);
        }
        $location .= 'events.php?view=overridehours&id=' . $_POST['event_id'];
        break;
    case "set_override_hours":
        foreach ($_POST['members_override'] as $member_override) {
            if (!$eventdb->setOverrideHours($_POST['event_id'], $member_override['user_id'], $member_override['hours'])) {
                $message = "DATABSE ERROR: A member's override hours could not be set!";
                setcookie("errormsg", $message, time()+3);
                break;
            }
        }
        if (!isset($_COOKIE['errormsg'])) {
            $message = "SUCCESS: Override hours were successfully set!";
            setcookie("successmsg", $message, time()+3);
        }
        $location .= 'events.php?view=overridehours&id=' . $_POST['event_id'];
        break;
    case "add_other_attendee":
        $otherAttendeeData = array(
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'club' => $_POST['club'],
            'kiwanis_branch' => $_POST['kiwanis_branch']);
        if ($eventdb->addEventOtherAttendee($_POST['event_id'], $otherAttendeeData)) {
            $message = "SUCCESS: " . $otherAttendeeData['first_name'] . " " . $otherAttendeeData['last_name'] . " was added to the other attendees list!";
            setcookie("successmsg", $message, time()+3);
        } else { 
            $message = "DATABASE ERROR: " . $otherAttendeeData['first_name'] . " " . $otherAttendeeData['last_name'] . " could not be added to the other attendees list!";
            setcookie("errormsg", $message, time()+3);
        }
        $location .= 'events.php?view=otherattendees&id=' . $_POST['event_id'];
        break;
    case "delete_other_attendees":
        foreach ($_POST['ids'] as $id) {
            if (!$eventdb->deleteEventOtherAttendee($_POST['event_id'], $id)) {
                $message = "DATABASE ERROR: An attendee could not be deleted from the other attendees list!";
                setcookie("errormsg", $message, time()+3);
                break;
            }
        }
        if (!isset($_COOKIE['errormsg'])) {
            $message = "SUCCESS: Selected attendees were deleted from the other attendees list!";
            setcookie("successmsg", $message, time()+3);
        }
        $location .= 'events.php?view=otherattendees&id=' . $_POST['event_id'];
        break;
    case "add_user":
        if (!isset($_POST['username'])) {
            $_POST['username'] = null;
            $_POST['password'] = password_hash("", PASSWORD_BCRYPT);
            $_POST['phone'] = "";
        }
        $userData = array(
            "first_name" => $_POST['first_name'],
            "last_name" => $_POST['last_name'],
            "username" => $_POST['username'],
            "password" => $_POST['password'],
            "email" => $_POST['email'],
            "phone" => $_POST['phone']);
        if ($userdb->addUser($userData)) {
            $message = "SUCCESS: " . $userData['first_name'] . " " . $userData['last_name'] . " was added to the database!";
            setcookie("successmsg", $message, time()+3);
        } else {
            $message = "DATABASE ERROR: User could not be added!";
            setcookie("errormsg", $message, time()+3);
        }
        $location .= 'roster.php?view=add';
        break;
    case "set_user":
        if ($userdb->setName($_POST['user_id'], $_POST['first_name'], $_POST['last_name'])
            && $userdb->setEmail($_POST['user_id'], $_POST['email'])
            && $userdb->setPhone($_POST['user_id'], $_POST['phone'])) {
            $message = "SUCCESS: " . $_POST['first_name'] . " " . $_POST['last_name'] . " was successfully edited!";
            setcookie("successmsg", $message, time()+3);
            $location .= 'roster.php?view=user&id=' . $_POST['user_id'];
        } else {
            $message = "DATABASE ERROR: User could not be edited!";
            setcookie("errormsg", $message, time()+3);
            $location .= 'roster.php?view=edit&id=' . $_POST['user_id'];
        }
        break;
    case "set_dues_paid":
        if ($userdb->setDuesPaidUser($_POST['non_dues_paid'], 1)) {
            $message = "SUCCESS: Selected members were set as Dues Paid!";
            setcookie("successmsg", $message, time()+3);
        } else {
            $message = "DATABASE ERROR: One or more members could not be set as Dues Paid!";
            setcookie("errormsg", $message, time()+3);
        }
        $location .= 'roster.php?view=dues&action=set';
        break;
    case "unset_dues_paid":
        if ($userdb->setDuesPaidUser($_POST['dues_paid'], 0)) {
            $message = "SUCCESS: Selected members were unset as Dues Paid!";
            setcookie("successmsg", $message, time()+3);
        } else {
            $message = "DATABASE ERROR: One or more members could not be unset as Dues Paid!";
            setcookie("errormsg", $message, time()+3);
        }
        $location .= 'roster.php?view=dues&action=unset';
        break;
    case "activate_users":
        if ($userdb->setActiveUser($_POST['non_active_users'], 1)) {
            $message = "SUCCESS: Selected members were Activated!";
            setcookie("successmsg", $message, time()+3);
        } else {
            $message = "DATABASE ERROR: One or more members could not be Activated!";
            setcookie("errormsg", $message, time()+3);
        }
        $location .= 'roster.php?view=status&action=activate';
        break;
    case "deactivate_users":
        if ($userdb->setActiveUser($_POST['active_users'], 0)) {
            $message = "SUCCESS: Selected members were Deactivated!";
            setcookie("successmsg", $message, time()+3);
        } else {
            $message = "DATABASE ERROR: One or more members could not be Deactivated!";
            setcookie("errormsg", $message, time()+3);
        }
        $location .= 'roster.php?view=status&action=deactivate';
        break;
    case "add_committee":
        if ($committeedb->addCommittee($_POST['name'])) {
            $message = "SUCCESS: " . $_POST['name'] . " committee was added!";
            setcookie("successmsg", $message, time()+3);
            $location .= 'committees.php?view=list';
        } else {
            $message = "DATABASE ERROR: Committee could not be added!";
            setcookie("errormsg", $message, time()+3);
            $location .= 'committees.php?view=add';
        }
        break;
    case "delete_committee":
        if ($committeedb->deleteCommittee($_POST['committee_id'])) {
            $message = "SUCCESS: Committee was successfully deleted!";
            setcookie("successmsg", $message, time()+3);
            $location .= 'committees.php?view=list';
        } else {
            $message = "DATABASE ERROR: Committee could not be deleted!";
            setcookie("errormsg", $message, time()+3);
            $location .= 'committees.php?view=committee&id=' . $_POST['committee_id'];
        }
        break;
    case "add_committee_members":
        foreach ($_POST['user_ids'] as $user_id) {
            if (!$committeedb->addCommitteeMember($_POST['committee_id'], $user_id)) {
                $message = "DATABASE ERROR: A member could not be added to the committee!";
                setcookie("errormsg", $message, time()+3);
                break;
            }
        }
        if (!isset($_COOKIE['errormsg'])) {
            $message = "SUCCESS: Selected members were added to the committee!";
            setcookie("successmsg", $message, time()+3);
        }
        $location .= 'committees.php?view=committee&id=' . $_POST['committee_id'];
        break;
    case "delete_committee_members":
        foreach ($_POST['user_ids'] as $user_id) {
            if (!$committeedb->deleteCommitteeMember($_POST['committee_id'], $user_id)) {
                $message = "DATABASE ERROR: A member could not be deleted from the committee!";
                setcookie("errormsg", $message, time()+3);
                break;
            }
        }
        if (!isset($_COOKIE['errormsg'])) {
            $message = "SUCCESS: Selected members were deleted from the committee!";
            setcookie("successmsg", $message, time()+3);
        }
        $location .= 'committees.php?view=committee&id=' . $_POST['committee_id'];
        break;
    case "set_access":
        if ($userdb->setUserAccess($_POST['user_ids'], $_POST['access'])) {
            $message = "SUCCESS: Selected members access were changed!";
            setcookie("successmsg", $message, time()+3);
        } else {
            $message = "DATABASE ERROR: One or more members access could not be set!";
            setcookie("errormsg", $message, time()+3);
        }
        $location .= 'admin.php?view=access';
        break;
    case "add_tag":
        if ($_POST['mrp_tag'] == 0) {
            $tagData = array(
                "name" => $_POST['name'],
                "abbr" => $_POST['abbr'],
                "auto_manage" => 0,
                "mrp_tag" => $_POST['mrp_tag'],
                "number" => 0);
        } else {
            $tagData = array(
                "name" => $_POST['name'],
                "abbr" => $_POST['abbr'],
                "auto_manage" => $_POST['auto_manage'],
                "mrp_tag" => $_POST['mrp_tag'],
                "number" => $_POST['number']);
        }
        if ($tagdb->addTag($tagData)) {
            $message = "SUCCESS: " . $_POST['name'] . " tag was added!";
            setcookie("successmsg", $message, time()+3);
            $location .= 'tags.php?view=list';
        } else {
            $message = "DATABASE ERROR: Tag could not be added!";
            setcookie("errormsg", $message, time()+3);
            $location .= 'tags.php?view=add';
        }
        break;
    case "delete_tag":
        foreach ($_POST['tag_ids'] as $tag_id) {
            if (!$tagdb->deleteTag($tag_id)) {
                $message = "DATABASE ERROR: A tag could not be deleted!";
                setcookie("errormsg", $message, time()+3);
                break;
            }
        } if (!isset($_COOKIE['errormsg'])) {
            $message = "SUCCESS: Selected tags were deleted!";
            setcookie("successmsg", $message, time()+3);
        }
        $location .= 'tags.php?view=list';
        break;
    case "add_mrp":
        $MRPData = array(
            "name" => $_POST['name'],
            "hours" => $_POST['hours']); 
        if ($tagdb->addMRPLevel($MRPData)) {
            $message = "SUCCESS: " . $_POST['name'] . " MRP Level was added!";
            setcookie("successmsg", $message, time()+3);
            $location .= 'tags.php?view=mrplist';
        } else {
            $message =  "DATABASE ERROR: MRP Level could not be added!";
            setcookie("errormsg", $message, time()+3);
            $location .= ' tags.php?view=mrpadd';
        }
        break;
    case "create_post":
        $postData = array(
            "title" => $_POST['title'],
            "author_id" => $_POST['author_id'],
            "publish_datetime" => strtotime($_POST['publish_datetime']),
            "story" => $_POST['story'],
            "newsletter" => $_POST['newsletter']);
         if ($postData['publish_datetime'] > time()) {
            $message = "ERROR: Publish Date and Time cannot be in the future!";
            setcookie("errormsg", $message, time()+3);
            $location .= 'blog.php?view=create';
        } else if ($blogdb->createBlogPost($postData)) {
            $message = "SUCCESS: Post \"" . $postData['title'] . "\" successfully created!";
            setcookie("successmsg", $message, time()+3);
            $location .= 'blog.php?view=list&month=' . idate('m') . '&year=' . date('Y');
        }  else {
            $message = "DATABASE ERROR: Post could not be created!";
            setcookie("errormsg", $message, time()+3);
            $location .= 'blog.php?view=create';
        }            
        break;
    case "delete_post":
        if ($blogdb->deletePost($_POST['post_id'])) {
            $message = "SUCCESS: Post successfully deleted!";
            setcookie("successmsg", $message, time()+3);
            $location .= 'blog.php?view=manage';
        } else { 
            $message = "DATABASE ERROR: Event could not be deleted!";
            setcookie("errormsg", $message, time()+3);
            $location .= 'blog.php?view=manage&id=' . $_POST['event_id'];
        }
        break;
    case "edit_post":
        $postData = array(
            "title" => $_POST['title'],
            "author_id" => $_POST['author_id'],
            "publish_datetime" => strtotime($_POST['publish_datetime']),
            "story" => $_POST['story'],
            "newsletter" => $_POST['newsletter']);
         if ($postData['publish_datetime'] > time()) {
            $message = "ERROR: Publish Date and Time cannot be in the future!";
            setcookie("errormsg", $message, time()+3);
            $location .= 'blog.php?view=create';
        } else if ($blogdb->setPost($_POST['post_id'],$postData)) {
            $message = "SUCCESS: Post \"" . $postData['title'] . "\" successfully edited!";
            setcookie("successmsg", $message, time()+3);
            $location .= 'blog.php?view=list&month=' . idate('m') . '&year=' . date('Y');
        }  else {
            $message = "DATABASE ERROR: Post could not be changed!";
            setcookie("errormsg", $message, time()+3);
            $location .= 'blog.php?view=list&month=' . idate('m') . '&year=' . date('Y');
        }            
        break;
        break; 
    
    default:
        echo "No Form Submit Type Passed.";
}

header($location);

?>

