<?php
function member_import_upload() {
     $result = db_query('SELECT n.nid, n.title
                FROM {node} n WHERE n.type = :type', array(':type' => 'network'));
    $net_options=array();
    $networkOption='';
    foreach ($result as $record) {      
        $networkOption[$record->nid] = $record->title;
     }
   //  $networkOption.='<option value="00">Others</option>';
   //   $networkOption['00'] = 'others'; 

 

  $form['#attributes']['enctype'] = 'multipart/form-data';
  
   $form['upload'] = array(
    '#type' => 'file',
    '#title' => t('Select Memberlist file'),
     '#name' => 'memberupload',
    //'#required' => TRUE, // Always returns an error, even though a file is successfully uploaded
  );
  $form['network'] = array(
		'#type' => 'select',
		'#title' => t('Select Network'),
		'#options' => $networkOption,
		'#description' => t(''),
		'#attributes' => array('onchange' => 'netwokothers(this)'),
		'#required' => TRUE,
		);
 
   $form['submit'] = array(
	'#type' => 'submit',
	'#value' => 'Upload Member',
	);
   
   global $user;   
   if(in_array("administrator",$user->roles)) {
    return $form;
   } else {
     $form ='';
     return $form;
   }
}
