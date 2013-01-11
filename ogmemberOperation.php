<?php
define('DRUPAL_ROOT', getcwd());
$base_url = 'http://'.$_SERVER['HTTP_HOST']; // THIS IS IMPORTANT
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL); // Could be DRUPAL_BOOTSTRAP_SESSION if that's all you need.

  //Get the group id
  $gid = '';
  $memid='';
  $retval='';
    if(isset($_REQUEST['gid']) && trim($_REQUEST['gid']))
    {
        $gid = trim($_REQUEST['gid']);
    }
    if(isset($_REQUEST['memid']) && trim($_REQUEST['memid']))
    {
        $memid = trim($_REQUEST['memid']);
    }
  
      
    if($_REQUEST['process'] == 'add-member'){ 
    $created=time();
    $result=db_query("SELECT * from og_membership WHERE gid='".$gid."' AND etid='".$memid."'");
    if($result->rowCount()) {
        db_query("UPDATE field_data_group_audience SET deleted='0' WHERE group_audience_gid='".$gid."' AND entity_id='".$memid."'");
    }
    else {
        db_query("INSERT INTO og_membership (type, etid, entity_type, gid, state, created)
    VALUES ('og_membership_type_default', '".$memid."','node', '".$gid."', '".OG_STATE_ACTIVE."','".$created."')");
        
       /* echo "INSERT INTO field_data_group_audience (entity_type, bundle, entity_id, revision_id, language, delta, group_audience_gid, group_audience_state, group_audience_created )
    VALUES ('node', 'group', '".$memid."', '".$memid."', 'und','0','".$gid."', '1','".$created."')";
    exit;*/
        db_query("INSERT INTO field_data_group_audience (entity_type, bundle, entity_id, revision_id, language, delta, group_audience_gid, group_audience_state, group_audience_created )
    VALUES ('node', 'group', '".$memid."', '".$memid."', 'und','0','".$gid."', '1','".$created."')");
    }
    $retval="Added member to Head Quarters successfully";  
    echo json_encode($retval);
    }
    
    if($_REQUEST['process'] == 'add-agent-member') {
    $created=time();
    $result=db_query("SELECT* from og_membership WHERE gid='".$gid."' AND etid='".$memid."'");
    if($result->rowCount()) {
        db_query("UPDATE field_data_group_audience SET deleted='0' WHERE group_audience_gid='".$gid."' AND entity_id='".$memid."'");
    }
    else {
        db_query("INSERT INTO og_membership (type, etid, entity_type, gid, state, created)
    VALUES ('og_membership_type_default', '".$memid."','node', '".$gid."', '".OG_STATE_ACTIVE."','".$created."')");
        db_query("INSERT INTO field_data_group_audience (entity_type, bundle, entity_id, revision_id, language, delta, group_audience_gid, group_audience_state, group_audience_created )
    VALUES ('node', 'travel_agent_advisors', '".$memid."', '".$memid."', 'und','0','".$gid."', '1','".$created."')");
    }
    $retval="Member Added";  
    echo json_encode($retval);
    
    }
 
  if($_REQUEST['process'] == 'remove-member'){  
  //Remove this node to the group
  db_query("UPDATE field_data_group_audience SET deleted=1 WHERE group_audience_gid='".$gid."' AND entity_id='".$memid."'");
  $retval=$node."Removed member from Head Quarters successfully";
  echo json_encode($retval);
  }
  
  if($_REQUEST['process'] == 'remove-agent-member'){  
  //Remove this node to the group
  db_query("UPDATE field_data_group_audience SET deleted=1 WHERE group_audience_gid='".$gid."' AND entity_id='".$memid."'");
  $retval=$node."Member removed from the travel agency";
  echo json_encode($retval);
  }
  
  if($_REQUEST['process'] == 'remove-client') {
    db_query("delete from og_membership where etid=".$memid." and gid=".$gid."");
    $retval="Client has been removed from the agent list";
    echo json_encode($retval);

  }
  
  
 
  
  
?>
