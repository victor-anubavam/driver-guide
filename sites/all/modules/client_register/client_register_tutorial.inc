<?php

function client_register_tutorial()
{
	return t('This is a set of nine form ');
}

function client_register_tutorial_9($form, &$form_state) {	
	// We will have many fields with the same name, so we need to be able to
	// access the form hierarchically.
	$form['#tree'] = TRUE;

	$form['description'] = array(
	'#type' => 'item',
	'#title' => t('<h1 class="title">Client Registration</h1>'),
	);

	if (empty($form_state['num_names'])) {
		$form_state['num_names'] = 1;
	}
   //echo "<pre>";print_r($form_state) ;exit; 
	// Build the number of name fieldsets indicated by $form_state['num_names']
	for ($i = 1; $i <= $form_state['num_names']; $i++) {
            
            
		$form['name'][$i] = array(
		'#type' => 'fieldset',
		'#title' => t(''),
		'#collapsible' => TRUE,
		'#collapsed' => FALSE,
		);
                
                $form['name'][$i]['comp_name'] = array(
		'#type' => 'textfield',
		'#title' => t("my client's Company Name"),
		'#size' => 30,
		'#description' => t(''),		
		);
               
                $form['name'][$i]['city'] = array(
		'#type' => 'textfield',
		'#title' => t("my client 's City"),
		'#size' => 30,
		'#description' => t(''),		
		);
                
                $form['name'][$i]['dept'] = array(
		'#type' => 'textfield',
		'#title' => t("my client's department"),
		'#size' => 30,
		'#description' => t(''),		
		);
                
              
                
                $form['name'][$i]['fname'] = array(
		'#type' => 'textfield',
		'#title' => t("my client's First Name"),
		'#size' => 30,
		'#maxlength' => 50,
		'#required' => TRUE,
		);                
                  
                $form['name'][$i]['lname'] = array(
		'#type' => 'textfield',
		'#title' => t("my client's Last Name"),
		'#size' => 30,
		'#maxlength' => 50,
		'#required' => TRUE,
		);
                
                $form['name'][$i]['position'] = array(
		'#type' => 'select',
		'#title' => t("my client's Position"),		
		'#options' => array(
		'' => t('- Select one -'),
		'travelagent'=>t('Travel agent'),
		'travel-advisor'=>t('Travel advisor'),
                    'independent-associate'=>t('Independent Issociate'),
                    'independent-travel-agent'=>t('Independent Travel Agent'),
                    ),
		'#description' => t(''),
                    ); 
                
                $form['name'][$i]['email'] = array(
		'#type' => 'textfield',
		'#title' => t("my client's Email Id"),
		'#size' => 30,
		'#maxlength' => 20,
		'#required' => TRUE,
		);
                
                $form['name'][$i]['address'] = array(
		'#type' => 'textfield',
		'#title' => t("my client's Address"),
		'#size' => 30,
		'#maxlength' => 50,		
		);
                
                   
                $form['name'][$i]['sname'] = array(
		'#type' => 'textfield',
		'#title' => t("my client's User name"),
		'#size' => 30,
		'#maxlength' => 20,
		'#required' => TRUE,
		);
                
		$form['name'][$i]['pass'] = array(
		'#type' => 'password',
		'#title' => t('Password'),
		'#size' => 30,
		'#maxlength' => 20,
		'#required' => TRUE,
		);
		$form['name'][$i]['conpassword'] = array(
		'#type' => 'password',
		'#title' => t('Confirm Password'),
		'#size' => 30,
		'#maxlength' => 20,
		'#required' => TRUE,
		);
		
                $optionsitems =  array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12,13=>13,14=>14,15=>15,16=>16,17=>17,18=>18,19=>19,20=>20,
				       25=>25,30=>30,35=>35,40=>40,45=>45,50=>50,60=>60,70=>70,80=>80,90=>90,100=>100);
		
		$form['name'][$i]['commission'] = array(
		'#type' => 'select',
		'#title' => t("my client's Commission %"),
		
		'#options' => $optionsitems,		
		'#required' => TRUE,
		);
               
                
                $form['name'][$i]['Iacceptconditions'] = array(
		'#type' => 'checkboxes',
		'#title' => t(''),
		'#options' => array (1 => 'I accept the <a href="#">terms and conditions</a>'),
		'#default_value'=> 1,
		'#required' => TRUE,
		'#value' => 1,
		);
                

	}
	$form['submit'] = array(
	'#type' => 'submit',
	'#value' => 'Sign Up for Client',
	);
	

	// Adds "Add another name" button
	// $form['add_name'] = array(
	//    '#type' => 'submit',
	//    '#value' => t('Add another name'),
	//    '#submit' => array('client_register_tutorial_9_add_name'),
	// );

	// If we have more than one name, this button allows removal of the
	// last name.
	if ($form_state['num_names'] > 1) {
		$form['remove_name'] = array(
		'#type' => 'submit',
		'#value' => t('Remove latest name'),
		'#submit' => array('client_register_tutorial_9_remove_name'),
		// Since we are removing a name, don't validate until later.
		'#limit_validation_errors' => array(),
		);
	}

	return $form;
}

/**
 * Submit handler for "Add another name" button on client_register_tutorial_9().
 *
 * $form_state['num_names'] tells the form builder function how many name
 * fieldsets to build, so here we increment it.
 *
 * All elements of $form_state are persisted, so there's no need to use a
 * particular key, like the old $form_state['storage']. We can just use
 * $form_state['num_names'].
 */
function client_register_tutorial_9_add_name($form, &$form_state) {
	// Everything in $form_state is persistent, so we'll just use
	// $form_state['add_name']
	$form_state['num_names']++;

	// Setting $form_state['rebuild'] = TRUE causes the form to be rebuilt again.
	$form_state['rebuild'] = TRUE;
}


function client_register_tutorial_9_remove_name($form, &$form_state) {
	if ($form_state['num_names'] > 1) {
		$form_state['num_names']--;
	}

	// Setting $form_state['rebuild'] = TRUE causes the form to be rebuilt again.
	$form_state['rebuild'] = TRUE;
}

/**
 * Validate function for client_register_tutorial_9().
 *
 * Adds logic to validate the form to check the validity of the new fields,
 * if they exist.
 */
function client_register_tutorial_9_validate($form, &$form_state)
{
	
	
	/*for ($i = 1; $i <= $form_state['num_names']; $i++)
	*/{
		
		$uname = $form_state['values']['name'][1]['sname'];
		$pass = $form_state['values']['name'][1]['pass'];
		$email = $form_state['values']['name'][1]['email'];

                $acceptCond = $form_state['values']['name'][1]['Iacceptconditions'][1];
                 
		if ($error = user_validate_name($uname) && $uname != '')
		{
			form_set_error('name', $error);			
			$isError='Y';
		}
		elseif ((bool) db_select('users')->fields('users', array('name'))->condition('name', db_like($uname), 'LIKE')->range(0, 1)->execute()->fetchField()) {
			$isError='Y';
			form_set_error('name', t('The name %name is already taken.', array('%name' => $uname)));
		}

       //vaildation for i accept terms and condition
		if($acceptCond == 0){
			form_set_error('Iacceptconditions', t('You need to accept the terms and conditions'));
			}
        
        
		// Validate the e-mail address.
		if ($error = user_validate_mail($email))
		{
			if($email != ''){
			form_set_error('mail', $error);			
			$isError='Y';
			}
		}
		elseif ((bool) db_select('users')->fields('users', array('uid'))->condition('mail', db_like($email), 'LIKE')->range(0, 1)->execute()->fetchField()) {
			// Format error message dependent on whether the user is logged in or not.
			// echo "The e-mail address $email is already registered";
			$isError='Y';
			form_set_error('mail', t('The e-mail address %email is already registered. <a href="@password">Have you forgotten your password?</a>', array('%email' => $email, '@password' => url('user/password'))));
		}
		if(trim($form_state['values']['name'][1]['pass'])=='') {
			$isError='Y';
			//form_set_error('password', t('Please enter  password.', array()));
		}
		elseif(trim($form_state['values']['name'][1]['conpassword'])=='') {
			$isError='Y';
			form_set_error('confirm_password', t('Please enter confirm password.', array()));

		}
		elseif(trim($form_state['values']['name'][1]['pass'])!=trim($form_state['values']['name'][1]['conpassword']))
		{
			$isError='Y';
			form_set_error('chk_password', t('Password is mismatched!.', array()));
		}


		if (!valid_email_address($email))
		{
			//form_set_error('submitted][email_address', t('The email address appears to be invalid.'));
		}


	}
}

/**
 * Submit function for client_register_tutorial_9().
 */
function client_register_tutorial_9_submit($form, &$form_state)
{
	require_once DRUPAL_ROOT . '/' . variable_get('password_inc', 'includes/password.inc');
	require_once DRUPAL_ROOT . '/' . variable_get('form.inc', 'includes/form.inc');
	
	$output = t("Form has been submitted.");

        $company = $form_state['values']['name'][1]['comp_name'];
        $city = $form_state['values']['name'][1]['city'];
        $dept = $form_state['values']['name'][1]['dept'];
        $mail = $form_state['values']['name'][1]['email'];        
        $fname = $form_state['values']['name'][1]['fname'];
        $lname = $form_state['values']['name'][1]['lname'];
        $position = $form_state['values']['name'][1]['position'];
        $address = $form_state['values']['name'][1]['address'];
        $sname = $form_state['values']['name'][1]['sname'];
        $pass = $form_state['values']['name'][1]['pass'];
        $commission = $form_state['values']['name'][1]['commission'];
        
        $isError='N';

	//$body_text = 'This is the body text I want entered with the node.';
/*
	$node = new stdClass();
	$node->type = 'client_register_advisors';
	node_object_prepare($node);
	$node->language = LANGUAGE_NONE;
        
         */
	
	//$output .= t($node->nid."  : created sucessfully....");

	if($isError=='N')
	{
		//echo "in error ==N";
		$account = new stdClass;
                
                $account->field_company[LANGUAGE_NONE][0]['email'] = $company;
                $account->field_city[LANGUAGE_NONE][0]['value'] = $city;
                $account->field_department[LANGUAGE_NONE][0]['value'] = $dept;
                $account->field_first_name[LANGUAGE_NONE][0]['value'] = $fname;
                $account->field_last_name[LANGUAGE_NONE][0]['value'] = $lname;       
                $account->field_position[LANGUAGE_NONE][0]['value'] = $position; 
                $account->field_address[LANGUAGE_NONE][0]['value'] = $address;
                $account->field_commission[LANGUAGE_NONE][0]['value'] = $commission;
                
		$account->is_new = TRUE;
		$account->name = $sname;//$node->field_uname['und'][0]['value'];
		$account->pass = user_hash_password($pass);
		$account->mail = $mail;
		$account->init = $mail;
		$account->status = true;
		$account->roles = array(
                    2 => 'authenticated',
                    8 => 'Client',
                  );//[5] = 'travel agent';//array(DRUPAL_AUTHENTICATED_RID => TRUE);
		$account->timezone = variable_get('date_default_timezone', '');
		user_save($account);                
                if(isset($account->uid) && trim($account->uid)!='')
                {
                    db_query("INSERT INTO users_roles (uid, rid) VALUES ('".$account->uid."', '8')");
                }   
		
                     
	}

	global $user;
	$groupnid =  db_query("select nid from node where uid= ".$user->uid."")->fetchField();
	$gid = db_query("select gid from og where etid=".$groupnid."")->fetchField();
	$memid = db_query("select uid from users where mail='".$account->mail."'")->fetchField();
	$created=time();
	
	    db_query("INSERT INTO og_membership (type, etid, entity_type, gid, state, created)
VALUES ('og_membership_type_default', '".$memid."','user', '".$gid."', '".OG_STATE_ACTIVE."','".$created."')");
	   /* echo "INSERT INTO og_membership (type, etid, entity_type, gid, state, created)
VALUES ('og_membership_type_default', '".$memid."','user', '".$gid."', '".OG_STATE_ACTIVE."','".$created."')";*/
	
    /*db_query("INSERT INTO field_data_group_audience (entity_type, bundle, entity_id, revision_id, language, delta, group_audience_gid, group_audience_state, group_audience_created )
VALUES ('node', 'travel_agent_advisors', '".$memid."', '".$memid."', 'und','0','".$gid."', '1','".$created."')");*/
	
	$form_state['redirect'] = 'user';
}

?>