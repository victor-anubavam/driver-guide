<?php

function travel_agency_tutorial()
{
	return t('This is a set of nine form ');
}

function travel_agency_tutorial_9($form, &$form_state) {
	drupal_set_title("Travel Agency Registration | private-Transfer");
	drupal_add_js(drupal_get_path('theme', 'privatetransfer_theme').'/scripts/custom_script.js');	
	drupal_add_js(drupal_get_path('module', 'travel_agency') .'/js/travelagency.js');	
	$form['#tree'] = TRUE;
	$form['description'] = array(
	'#type' => 'item',
	'#title' => t('<h1 class="title">Travel Agency Registration</h1>'),
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
                
                 $form['name'][$i]['email'] = array(
		'#type' => 'textfield',
		'#title' => t("Email Id"),
		'#size' => 30,
	        '#attributes' => array('onchange' => 'memberfilter(this)'),
		'#description' => t(''),
		'#required' => TRUE,
		);
		 
		   $result = db_query('SELECT n.nid, n.title
                FROM {node} n WHERE n.type = :type', array(':type' => 'network'));
                $net_options=array();               
                foreach ($result as $record) {
                    $net_options[$record->nid]=$record->title;
                 }
		//$net_options['00'] = 'others';
                $form['name'][$i]['network_name'] = array(
		'#type' => 'select',		
		'#title' => t('Network name'),
		'#required' => TRUE,		
		'#options' => $net_options,
		'#attributes' => array('onchange' => 'memberfilter(this)'),
		'#description' => t(''),
                );
		/*$form['name'][$i]['networkotherdetails']= array(
		'#type' => 'fieldset',
		'#title' => t('Network Details'),
		'#collapsible' => TRUE,
		'#collapsed' => FALSE,
		);
		 $form['name'][$i]['networkotherdetails']['network_name_others'] = array(
		'#type' => 'textfield',
		'#title' => t('Network Name'),
		'#required' => TRUE,				
		'#description' => t(''),
                );
		$form['name'][$i]['networkotherdetails']['network_cfirst_name_others'] = array(
		'#type' => 'textfield',
		'#title' => t('Contact Person first name'),
		'#required' => TRUE,				
		'#description' => t(''),
                );
		$form['name'][$i]['networkotherdetails']['network_clast_name_others'] = array(
		'#type' => 'textfield',
		'#title' => t('Contact Person last name'),
		'#required' => TRUE,				
		'#description' => t(''),
                );*/
		$form['name'][$i]['network_name']['#attributes']['class'][] = 'networklist';
		
                $result = db_query('SELECT n.nid, n.title
                FROM {node} n WHERE n.type = :type', array(':type' => 'group'));
                
		$memb_options=array();               
                foreach ($result as $record) {
                    $memb_options[$record->nid]=$record->title;
                 }
		$memb_options['00'] = 'others';
		
                $form['name'][$i]['member_name'] = array(
		'#type' => 'select',
		'#title' => t('Member Name'),
		'#options' => $memb_options,
		'#description' => t(''),
		'#attributes' => array('onchange' => 'displayothermember(this)'),
		'#required' => TRUE,
		);
		$form['name'][$i]['memberotherdetails']= array(
		'#type' => 'fieldset',
		'#title' => t('Member Details'),
		'#collapsible' => TRUE,
		'#collapsed' => FALSE,
		);
		  
               $form['name'][$i]['memberotherdetails']['member_others_name'] = array(
		'#type' => 'textfield',
		'#title' => t('Member Name'),		
		'#description' => t(''),
		//'#required' => TRUE,
		);
	       $form['name'][$i]['memberotherdetails']['member_others_firstname'] = array(
		'#type' => 'textfield',
		'#title' => t('First Name'),		
		'#description' => t(''),
		//'#required' => TRUE,
		);
	       $form['name'][$i]['memberotherdetails']['member_others_lastname'] = array(
		'#type' => 'textfield',
		'#title' => t('Last Name'),		
		'#description' => t(''),
		//'#required' => TRUE,
		);
	       $form['name'][$i]['memberotherdetails']['member_others_companymail'] = array(
		'#type' => 'textfield',
		'#title' => t('Company Email Id '),		
		'#description' => t(''),
		//'#required' => TRUE,
		);
	       $form['name'][$i]['memberotherdetails']['member_name_contactnum'] = array(
		'#type' => 'textfield',
		'#title' => t('Telephone '),		
		'#description' => t(''),
		//'#required' => TRUE,
		);
              
                
                
                $form['name'][$i]['sname'] = array(
		'#type' => 'textfield',
		'#title' => t('User name'),
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
                
                $form['contact'][$i] = array(
		'#type' => 'fieldset',
		'#title' => t('Contact person'),
		'#collapsible' => TRUE,
		'#collapsed' => FALSE,
		);
                
                 $form['contact'][$i]['fname'] = array(
		'#type' => 'textfield',
		'#title' => t('First Name'),
		'#size' => 30,
		'#maxlength' => 50,
		'#required' => TRUE,
		);
                
                  
                $form['contact'][$i]['lname'] = array(
		'#type' => 'textfield',
		'#title' => t('Last Name'),
		'#size' => 30,
		'#maxlength' => 50,
		'#required' => TRUE,
		);
                
                 $form['contact'][$i]['con_email'] = array(
		'#type' => 'textfield',
		'#title' => t("Email Id"),
		'#size' => 30,
		'#description' => t(''),
		'#required' => TRUE,
		);
                 
                 $form['contact'][$i]['position'] = array(
		'#type' => 'select',
		'#title' => t('Position In Agency '),
		'#required' => TRUE,
		'#options' => array(
		'' => t('- Select one -'),
		'travelagent'=>t('Travel agent'),
		'travel-advisor'=>t('Travel advisor'),
                    'independent-associate'=>t('Independent Issociate'),
                    'independent-travel-agent'=>t('Independent Travel Agent'),
                    ),
		'#description' => t(''),
                    ); 
		

                $form['agency'][$i] = array(
		'#type' => 'fieldset',
		'#title' => t('Agency Address'),
		'#collapsible' => TRUE,
		'#collapsed' => FALSE,
		);
                
		$form['agency'][$i]['agncountry'] = array(
		'#type' => 'select',
		'#title' => t('Country'),
		'#required' => TRUE,
		'#options' => array(
		'' => t('- Select one -'),
		'AF'=>t('Afghanistan'),
		'AX'=>t('Aland Islands'),
		'AL'=>t('Albania'),
                'DZ'=>t('Algeria'),
		'AS'=>t('American Samoa'),
                'AD'=>t('Andorra'),
                'AO'=>t('Angola'),
                'AI'=>t('Anguilla'),
                'AQ'=>t('Antarctica'),
                'AG'=>t('Antigua and Barbuda'),
		'AR'=>t('Argentina'),
                'AM'=>t('Armenia'),
                'AW'=>t('Aruba'),
		'AT'=>t('Austria'),
		'AU'=>t('Australia'),		
		'AZ'=>t('Azerbaijan'),
                'BD'=>t('Bangladesh'),
                'BS'=>t('Bahamas'),
                'BH'=>t('Bahrain'),
		'BB'=>t('Barbados'),
                'BY'=>t('Belarus'),
		'BE'=>t('Belgium'),
                'BZ'=>t('Belize'),
                'BJ'=>t('Benin'),
		'BM'=>t('Bermuda'),
                'BT'=>t('Bhutan'),      
		'BO'=>t('Bolivia'),
		'BV'=>t('Bouvet Island'),
                'BA'=>t('Bosnia and Herzegovina'),
		'BW'=>t('Botswana'),
		'BR'=>t('Brazil'),
		'VG'=>t('British Virgin Islands'),
                'IO'=>t('British Indian Ocean Territory'),
                'BN'=>t('Brunei'),
                'BG'=>t('Bulgaria'),
		'BF'=>t('Burkina Faso'),				
		'BI'=>t('Burundi'),
                'KH'=>t('Cambodia'),
                'CM'=>t('Cameroon'),
                'CA'=>t('Canada'),
                'CV'=>t('Cape Verde'),
                'KY'=>t('Cayman Islands'),
                'CF'=>t('Central African Republic'),
                'TD'=>t('Chad'),
                'CL'=>t('Chile'),
                'CN'=>t('China'),
                'CX'=>t('Christmas Island'),
                'CC'=>t('Cocos (Keeling) Islands'),
                'CO'=>t('Colombia'),
                'KM'=>t('Comoros'),
                'CG'=>t('Congo (Brazzaville)'),
		'CD'=>t('Congo (Kinshasa)'),		
                'CK'=>t('Cook Islands'),		
		'CR'=>t('Costa Rica'),
                'HR'=>t('Croatia'),
		'CU'=>t('Cuba'),
		'CY'=>t('Cyprus'),
		'CZ'=>t('Czech Republic'),
                'DK'=>t('Denmark'),
                'DJ'=>t('Djibouti'),
		'DM'=>t('Dominica'),
		'DO'=>t('Dominican Republic'),
                'EC'=>t('Ecuador'),		
		'EG'=>t('Egypt'),
                'SV'=>t('El Salvador'),
                'GQ'=>t('Equatorial Guinea'),
		'ER'=>t('Eritrea'),
                'EE'=>t('Estonia'),
                'ET'=>t('Ethiopia'),		
                'FK'=>t('Falkland Islands'),
                'FO'=>t('Faroe Islands'),
		'FJ'=>t('Fiji'),
                'FI'=>t('Finland'),
                'FR'=>t('France'),
		'GF'=>t('French Guiana'),
		'PF'=>t('French Polynesia'),
                'TF'=>t('French Southern Territories'),
		'GA'=>t('Gabon'),
                'GM'=>t('Gambia'),
                'GE'=>t('Georgia'),
                'DE'=>t('Germany'),
                'GH'=>t('Ghana'),
		'GI'=>t('Gibraltar'),
                'GR'=>t('Greece'),
                'GL'=>t('Greenland'),
		'GD'=>t('Grenada'),
		'GP'=>t('Guadeloupe'),
                'GU'=>t('Guam'),
                'GT'=>t('Guatemala'),
		'GG'=>t('Guernsey'),
		'GN'=>t('Guinea'),
		'GW'=>t('Guinea-Bissau'),
		'GY'=>t('Guyana'),
		'HT'=>t('Haiti'),
		'HM'=>t('Heard Island and McDonald Islands'),
		'HN'=>t('Honduras'),
                'HK'=>t('Hong Kong S.A.R., China'),		
		'HU'=>t('Hungary'),
                'IS'=>t('Iceland'),
                'IN'=>t('India'),
		'ID'=>t('Indonesia'),
		'IR'=>t('Iran'),
                'IQ'=>t('Iraq'),
		'IE'=>t('Ireland'),
                'IM'=>t('Isle of Man'),
		'IL'=>t('Israel'),
                'IT'=>t('Italy'),
                'CI'=>t('Ivory Coast'),		
		'JM'=>t('Jamaica'),
                'JP'=>t('Japan'),
                'JE'=>t('Jersey'),
		'JO'=>t('Jordan'),
                'KZ'=>t('Kazakhstan'),
		'KE'=>t('Kenya'),
                'KI'=>t('Kiribati'),                                
		'KW'=>t('Kuwait'),
		'KG'=>t('Kyrgyzstan'),			               
		'LA'=>t('Laos'),
                'LV'=>t('Latvia'),
		'LB'=>t('Lebanon'),
                'LS'=>t('Lesotho'),
                'LR'=>t('Liberia'),
                'LY'=>t('Libya'),
		'LI'=>t('Liechtenstein'),		
		'LT'=>t('Lithuania'),
		'LU'=>t('Luxembourg'),
                'MO'=>t('Macao S.A.R., China'),
                'MK'=>t('Macedonia'),
                'MG'=>t('Madagascar'),
                'MW'=>t('Malawi'),
		'MY'=>t('Malaysia'),
                'MV'=>t('Maldives'),
                'ML'=>t('Mali'),
                'MT'=>t('Malta'),
                'MH'=>t('Marshall Islands'),
                'MQ'=>t('Martinique'),
                'MR'=>t('Mauritania'),
                'MU'=>t('Mauritius'),
                'YT'=>t('Mayotte'),
                'MX'=>t('Mexico'),
                'FM'=>t('Micronesia'),
		'MD'=>t('Moldova'),
                'MC'=>t('Monaco'),
                'MN'=>t('Mongolia'),
                'ME'=>t('Montenegro'),
                'MS'=>t('Montserrat'),
		'MA'=>t('Morocco'),		
		'MZ'=>t('Mozambique'),		
		'MM'=>t('Myanmar'),
		'NA'=>t('Namibia'),
                'NR'=>t('Nauru'),
                'NP'=>t('Nepal'),
                'NL'=>t('Netherlands'),
                'AN'=>t('Netherlands Antilles'),
		'NC'=>t('New Caledonia'),
                'NZ'=>t('New Zealand'),
                'NI'=>t('Nicaragua'),
		'NE'=>t('Niger'),
                'NG'=>t('Nigeria'),
                'NU'=>t('Niue'),
		'NF'=>t('Norfolk Island'),
                'MP'=>t('Northern Mariana Islands'),
                'KP'=>t('North Korea'),
		'NO'=>t('Norway'),		
		'OM'=>t('Oman'),
                'PK'=>t('Pakistan'),
                'PW'=>t('Palau'),
                'PS'=>t('Palestinian Territory'),
		'PA'=>t('Panama'),
                'PG'=>t('Papua New Guinea'),
                'PY'=>t('Paraguay'),
		'PE'=>t('Peru'),                
		'PH'=>t('Philippines'),
                'PN'=>t('Pitcairn'),
		'PL'=>t('Poland'),
                'PT'=>t('Portugal'),
		'PR'=>t('Puerto Rico'),
		'QA'=>t('Qatar'),
		'RE'=>t('Reunion'),
		'RO'=>t('Romania'),		
		'RU'=>t('Russia'),
		'RW'=>t('Rwanda'),
		'BL'=>t('Saint Barthelemy'),
		'SH'=>t('Saint Helena'),
                'KN'=>t('Saint Kitts and Nevis'),
                'LC'=>t('Saint Lucia'),
                'MF'=>t('Saint Martin (French part)'),
                'PM'=>t('Saint Pierre and Miquelon'),
                'VC'=>t('Saint Vincent and the Grenadines'),
                'WS'=>t('Samoa'),
                'SM'=>t('San Marino'),
                'ST'=>t('Sao Tome and Principe'),
                'SA'=>t('Saudi Arabia'),
                'SN'=>t('Senegal'),
                'RS'=>t('Serbia'),
                'SC'=>t('Seychelles'),
                'SL'=>t('Sierra Leone'),
                'SG'=>t('Singapore'),
                'SK'=>t('Slovakia'),
		'SI'=>t('Slovenia'),
                'SB'=>t('Solomon Islands'),
		'SO'=>t('Somalia'),		
                'ZA'=>t('South Africa'),
                'GS'=>t('South Georgia and the South Sandwich Islands'),
                'KR'=>t('South Korea'),
                'LK'=>t('Sri Lanka'),
		'ES'=>t('Spain'),
                'SD'=>t('Sudan'),
                'SR'=>t('Suriname'),
                'SJ'=>t('Svalbard and Jan Mayen'),
		'SZ'=>t('Swaziland'),
                'SE'=>t('Sweden'),
                'CH'=>t('Switzerland'),
                'SY'=>t('Syria'),
		'TW'=>t('Taiwan'),
                'TJ'=>t('Tajikistan'),
		'TZ'=>t('Tanzania'),
		'TG'=>t('Togo'),
		'TH'=>t('Thailand'),
		'TL'=>t('Timor-Leste'),
		'TK'=>t('Tokelau'),
		'TO'=>t('Tonga'),
		'TT'=>t('Trinidad and Tobago'),
		'TN'=>t('Tunisia'),
                'TR'=>t('Turkey'),
		'TM'=>t('Turkmenistan'),
                'TC'=>t('Turks and Caicos Islands'),
		'TV'=>t('Tuvalu'),
		'UG'=>t('Uganda'),
                'UA'=>t('Ukraine'),
                'AE'=>t('United Arab Emirates'),
                'GB'=>t('United Kingdom'),
                'US'=>t('United States'),
		'UM'=>t('United States Minor Outlying Islands'),
		'UY'=>t('Uruguay'),
		'UZ'=>t('Uzbekistan'),
                'VI'=>t('U.S. Virgin Islands'),
                'VU'=>t('Vanuatu'),
		'VA'=>t('Vatican'),
		'VE'=>t('Venezuela'),		
		'VN'=>t('Vietnam'),
		'WF'=>t('Wallis and Futuna'),
                'EH'=>t('Western Sahara'),
		'YE'=>t('Yemen'),
		'ZM'=>t('Zambia'),
		'ZW'=>t('Zimbabwe'),
		),
		'#description' => t(''),

		);
	
                
                
                $form['agency'][$i]['agnstate'] = array(
		'#type' => 'textfield',
		'#title' => t('State'),
		'#size' => 30,
		'#maxlength' => 50,
		'#required' => TRUE,
		);
                     
                $form['agency'][$i]['agncity'] = array(
		'#type' => 'textfield',
		'#title' => t('City'),
		'#size' => 30,
		'#maxlength' => 50,
		'#required' => TRUE,
		);
                                
                $form['agency'][$i]['agnzipcode'] = array(
		'#type' => 'textfield',
		'#title' => t('Zip Code '),
		'#size' => 30,
		'#maxlength' => 50,
		'#required' => TRUE,
		);
                
                
                                              
                $form['agency'][$i]['agenstreetaddress'] = array(
		'#type' => 'textfield',
		'#title' => t('Street Address '),
		'#size' => 30,
		'#maxlength' => 50,
		'#required' => TRUE,
		);
                
                $form['agency_name'][$i] = array(
		'#type' => 'fieldset',
		'#title' => t(''),
		'#collapsible' => TRUE,
		'#collapsed' => FALSE,
		);

                $form['agency_name'][$i]['agencyname'] = array(
		'#type' => 'textfield',
		'#title' => t('Agency Name'),
		'#size' => 30,
		'#maxlength' => 50,
		'#required' => TRUE,
		);
                
               
                
                 $form['agency_name'][$i]['agency_business_filds'] = array(
		'#type' => 'select',
		'#title' => t('Agency Business Filds'),
		'#required' => TRUE,
		'#options' => array(
		'' => t('- Select one -'),
		'leisure'=>t('Leisure'),
		'corporate'=>t('Corporate'),
                'meeting and incentive'=>t('Meeting and Incentive'),
		'entertainment'=>t('Entertainment'),
                'performance-improvement-solutions'=>t('Performance Improvement Solutions'),
		     ),
		'#description' => t(''),
                    );
                 
              
                    
                $form['agency_name'][$i]['web_url'] = array(
		'#type' => 'textfield',
		'#title' => t('Website URL'),
		'#size' => 30,
		'#maxlength' => 50,
		'#required' => TRUE,
		);
                    
               
                
                
                $form['agency_name'][$i]['Iacceptconditions'] = array(
		'#type' => 'checkboxes',
		'#title' => t(''),
		'#options' => array (1 => 'I accept the <a href="terms-travel-agency">terms and conditions</a>'),
		'#default_value'=> 1,
		'#required' => TRUE,
		'#value' => 1,
		);
                

	}
	$form['submit'] = array(
	'#type' => 'submit',
	'#value' => 'Sign Up for Agency',
	'#attributes' => array('onClick' => 'displayotherdetails()'),
	);
	

	// Adds "Add another name" button
	// $form['add_name'] = array(
	//    '#type' => 'submit',
	//    '#value' => t('Add another name'),
	//    '#submit' => array('travel_agency_tutorial_9_add_name'),
	// );

	// If we have more than one name, this button allows removal of the
	// last name.
	if ($form_state['num_names'] > 1) {
		$form['remove_name'] = array(
		'#type' => 'submit',
		'#value' => t('Remove latest name'),
		'#submit' => array('travel_agency_tutorial_9_remove_name'),
		// Since we are removing a name, don't validate until later.
		'#limit_validation_errors' => array(),
		);
	}

	return $form;
}

/**
 * Submit handler for "Add another name" button on travel_agency_tutorial_9().
 *
 * $form_state['num_names'] tells the form builder function how many name
 * fieldsets to build, so here we increment it.
 *
 * All elements of $form_state are persisted, so there's no need to use a
 * particular key, like the old $form_state['storage']. We can just use
 * $form_state['num_names'].
 */
function travel_agency_tutorial_9_add_name($form, &$form_state) {
	// Everything in $form_state is persistent, so we'll just use
	// $form_state['add_name']
	$form_state['num_names']++;

	// Setting $form_state['rebuild'] = TRUE causes the form to be rebuilt again.
	$form_state['rebuild'] = TRUE;
}


function travel_agency_tutorial_9_remove_name($form, &$form_state) {
	if ($form_state['num_names'] > 1) {
		$form_state['num_names']--;
	}

	// Setting $form_state['rebuild'] = TRUE causes the form to be rebuilt again.
	$form_state['rebuild'] = TRUE;
}

/**
 * Validate function for travel_agency_tutorial_9().
 *
 * Adds logic to validate the form to check the validity of the new fields,
 * if they exist.
 */
function travel_agency_tutorial_9_validate($form, &$form_state)
{
	
	
	/*for ($i = 1; $i <= $form_state['num_names']; $i++)
	*/{
		//echo $form_state[]
		//echo "<pre>";print_r($form_state);echo "</pre>";
	//exit;
		$uname = $form_state['values']['name'][1]['sname'];
		$pass = $form_state['values']['name'][1]['pass'];
		$email = $form_state['values']['name'][1]['email'];

                $acceptCond = $form_state['values']['agency_name'][1]['Iacceptconditions'][1];
                 
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
		
		if($form_state['values']['name'][1]['member_name'] == "00"){
			
			$form_state['complete form']['name'][1]['memberotherdetails']['#attributes']['class'][0] = "display-colles" ;
			//echo "<pre>";print_r($form_state['complete form']['name'][1]['memberotherdetails']);echo "</pre>";
			
			//member_others_name
			//exit;
			if(trim($form_state['values']['name'][1]['memberotherdetails']['member_others_name'])==''){
				$isError='Y';
				form_set_error("member_others_name", t('Member name is required.', array()));
				$form_state['complete form']['name'][1]['memberotherdetails']['member_others_name']['#required'] = true;
			}
			if(trim($form_state['values']['name'][1]['memberotherdetails']['member_others_firstname'])==''){
				$isError='Y';
				form_set_error('member_others_firstname', t('Member first name is required.', array()));
				$form_state['complete form']['name'][1]['memberotherdetails']['member_others_firstname']['#required'] = true;
			}
			if(trim($form_state['values']['name'][1]['memberotherdetails']['member_others_lastname'])==''){
				form_set_error('member_others_lastname', t('Member last name is required.', array()));
				$form_state['complete form']['name'][1]['memberotherdetails']['member_others_lastname']['#required'] = true;
			}
			if(trim($form_state['values']['name'][1]['memberotherdetails']['member_others_companymail'])==''){
				form_set_error('member_others_companymail', t('Member company e-mail is required.', array()));
				$form_state['complete form']['name'][1]['memberotherdetails']['member_others_companymail']['#required'] = true;
			}
			if(trim($form_state['values']['name'][1]['memberotherdetails']['member_name_contactnum'])==''){
				form_set_error('member_name_contactnum', t('Member contact number is required.', array()));
				$form_state['complete form']['name'][1]['memberotherdetails']['member_name_contactnum']['#required'] = true;
			}			
			
			if (!valid_email_address($form_state['values']['name'][1]['memberotherdetails']['member_others_companymail'])) {			
				form_set_error('member_others_companymail',t('Member company mail id is not valid.', array()));
				$form_state['complete form']['name'][1]['memberotherdetails']['member_others_companymail']['#required'] = true;
			}
		}


	}
}

/**
 * Submit function for travel_agency_tutorial_9().
 */
function travel_agency_tutorial_9_submit($form, &$form_state)
{
	require_once DRUPAL_ROOT . '/' . variable_get('password_inc', 'includes/password.inc');
	require_once DRUPAL_ROOT . '/' . variable_get('form.inc', 'includes/form.inc');
	
	$output = t("Form has been submitted.");
        
        $mail = $form_state['values']['name'][1]['email'];
        $member_name = $form_state['values']['name'][1]['member_name'];
        $network_name = $form_state['values']['name'][1]['network_name'];	
        $sname = $form_state['values']['name'][1]['sname'];
        $pass = $form_state['values']['name'][1]['pass'];
        $fname = $form_state['values']['contact'][1]['fname'];
        $lname = $form_state['values']['contact'][1]['lname'];
        $con_email = $form_state['values']['contact'][1]['con_email'];
        $position = $form_state['values']['contact'][1]['position'];
        $agncountry = $form_state['values']['agency'][1]['agncountry'];
        $agnstate = $form_state['values']['agency'][1]['agnstate'];
        $agncity = $form_state['values']['agency'][1]['agncity'];
        $agnzipcode = $form_state['values']['agency'][1]['agnzipcode'];
        $agenstreetaddress = $form_state['values']['agency'][1]['agenstreetaddress'];
        $Stitle = $form_state['values']['agency_name'][1]['agencyname'];
        $agency_business_filds = $form_state['values']['agency_name'][1]['agency_business_filds'];
        $web_url = $form_state['values']['agency_name'][1]['web_url'];
	$isError='N';
      
	$body_text = 'This is the body text I want entered with the node.';

	$node = new stdClass();
	$node->type = 'travel_agency';
	node_object_prepare($node);
        
        $node->field_company_email_id[LANGUAGE_NONE][0]['email'] = $mail;
        $node->field_member_name[LANGUAGE_NONE][0]['tid'] = $member_name;
        $node->field_network_name[LANGUAGE_NONE][0]['tid'] = $network_name;
        $node->field_first_name[LANGUAGE_NONE][0]['value'] = $fname;
        $node->field_last_name[LANGUAGE_NONE][0]['value'] = $lname;
        $node->field_contact_email_id[LANGUAGE_NONE][0]['email'] = $con_email;
        $node->field_position_in_network[LANGUAGE_NONE][0]['value'] = $position;        
        $node->field_country_addr[LANGUAGE_NONE][0]['iso2'] = $agncountry;
        $node->field_statte[LANGUAGE_NONE][0]['value'] = $agnstate;
        $node->field_cityy[LANGUAGE_NONE][0]['value'] = $agncity;
        $node->field_zip_codde[LANGUAGE_NONE][0]['value'] = $agnzipcode;
        $node->field_street_adress[LANGUAGE_NONE][0]['value'] = $agenstreetaddress;        
        $node->title = $Stitle;       
        $node->field_agency_busines_filds[LANGUAGE_NONE][0]['value'] = $agency_business_filds;
        $node->field_website_url[LANGUAGE_NONE][0]['url'] = $web_url; 
        $node->field_website_url[LANGUAGE_NONE][0]['title'] = $web_url; 
        $node->field_network[LANGUAGE_NONE][0]['nid'] = $network_name;
	$node->language = LANGUAGE_NONE;
	
	
	
	//$output .= t($node->nid."  : created sucessfully....");
	if($isError=='N')
	{
		//echo "in error ==N";
		/*$account = new stdClass;
		$account->is_new = TRUE;
		$account->name = $sname;//$node->field_uname['und'][0]['value'];
		$account->pass = user_hash_password($pass);
		$account->mail = $mail;
		$account->init = $mail;
		$account->status = true;               
                $account->roles = array(
                    2 => 'authenticated',
                    4 => 'travel agency',
                  );
                        
                
		$account->timezone = variable_get('date_default_timezone', '');
		user_save($account);*/
		
		$account = new stdClass;
                $account->is_new = TRUE;
                $email  = db_query("select mail from users where mail ='".$mail."'")->fetchField();
                          
                if(empty($email)) {
		$username  = db_query("select mail from users where name ='".str_replace("'","\'",$sname)."'")->fetchField();                           
		
		if(empty($username)) {
		 $account->name = $sname;//$node->field_uname['und'][0]['value'];
		} else {
		 $account->name = $sname.rand();//$node->field_uname['und'][0]['value'];
		}                            
		$account->pass = user_hash_password($account->name);
		$account->mail = $mail;
		$account->init = $mail;
		$account->status = true;               
		$account->roles = array(
		    2 => 'authenticated',
		    4 => 'travel agency',
		);
		$account->timezone = variable_get('date_default_timezone', '');
		user_save($account);
		}
		//print_r($account);
		$uid = db_query("select uid from users where name='".$account->name."' and mail ='".$account->mail."'")->fetchField();
		$node->uid = $uid;
		//print_r($node);
		node_save($node);
		//exit;
		$groupAdminId = $node->uid;
                        drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
						
			global $user;
			
			//change this line and put your username and password instead of 'admin' and 'password'
			$accountNew = user_authenticate($sname, $pass);
			$user = user_load($accountNew, TRUE);
			drupal_session_regenerate();
		      
		      // Sending Welcome to mail to Newly created Agency user					      
			$my_module = 'travelagency';
			$my_mail_token = 'bar';
			$from = variable_get('system_mail', 'info@privatetransfer.com');			
			
			$muid = db_query("SELECT uid FROM {users} WHERE mail = :mail", array(':mail' => $mail))->fetchField();
			 //message Complete Your Profile info
                        $recipients = array(user_load($muid));
                       
			//$messageDetails = node_load(832);
				
			//$subject = $messageDetails->title;
                        $subject = 'Travel agency account created';			
			
                        $body ='<br/>You have successfully created the Agency account in Private-Transfer
                                <br/>Now you can access your services.
                                <br/><br/>with regards
                                <br/>Private-Transfer team';
			$message = array(
			'id' => $my_module . '_' . $my_mail_token,
			'to' => $mail,
			'subject' => $subject,
			'body' => '<p>'.$body.'</p>',
			       'headers' => array(
			       'From' => $from,
			       'Sender' => $from,
			       'Return-Path' => $from,
			       'Content-Type'  => 'text/html; charset=UTF-8; format=flowed',
			       ),
			       );
			       $system = drupal_mail_system($my_module, $my_mail_token);
			       if ($system->mail($message)) {
				// Success.
				/*drupal_set_message(t('The email has been send.'));*/
				drupal_set_message(t('Message has been sent.'));
			       }
			       else {
				// Failure.
				drupal_set_message(t('The email send Error.....'));
			       }		     
                   
 
	}
	
      
	if (($node->field_member_name['und'][0]['tid'] == "00")) {
		$nodeArry = array();
		$nodeArry['title']  = $form_state['input']['name'][1]['memberotherdetails']['member_others_name'];
		$nodeArry['firstname'] = $form_state['input']['name'][1]['memberotherdetails']['member_others_firstname'];
		$nodeArry['lastname'] = $form_state['input']['name'][1]['memberotherdetails']['member_others_lastname'];
		$nodeArry['emailid']  = $form_state['input']['name'][1]['memberotherdetails']['member_others_companymail'];
		$nodeArry['telephone']  = $form_state['input']['name'][1]['memberotherdetails']['member_name_contactnum'];
		
		$accountMem = new stdClass;
                $accountMem->is_new = TRUE;
                $email  = db_query("select mail from users where mail ='".$nodeArry['emailid']."'")->fetchField();
                          
                if(empty($email)) {
		$username  = db_query("select mail from users where name ='".str_replace("'","\'",$nodeArry['firstname'])."'")->fetchField();                           
		
		if(empty($username)) {
		 $accountMem->name = $nodeArry['firstname'];//$node->field_uname['und'][0]['value'];
		} else {
		 $accountMem->name = $nodeArry['firstname'].rand();//$node->field_uname['und'][0]['value'];
		}                            
		$accountMem->pass = user_hash_password($accountMem->name);
		$accountMem->mail = $nodeArry['emailid'];
		$accountMem->init = $nodeArry['emailid'];
		$accountMem->status = true;               
		$accountMem->roles = array(
		    2 => 'authenticated',
		    7 => 'Members  Head Quarters Admin',
		);
		$accountMem->timezone = variable_get('date_default_timezone', '');
		user_save($accountMem);
		}
		$uid = db_query("select uid from users where name='".$accountMem->name."' and mail ='".$accountMem->mail."'")->fetchField();
			    
		$node = new stdClass();
                $node->type = 'group';
                node_object_prepare($node);
		$node->title = $nodeArry['title'];
		$node->field_hqfirst_name[LANGUAGE_NONE][0]['value'] = $nodeArry['firstname'];
                $node->field_last_name[LANGUAGE_NONE][0]['value'] = $nodeArry['lastname'];               
                $node->field_contact_email_id[LANGUAGE_NONE][0]['email'] =  $nodeArry['emailid'];
                $node->field_company_email_id[LANGUAGE_NONE][0]['email'] =  $nodeArry['emailid'];
		$node->field_telephone[LANGUAGE_NONE][0]['value'] = $nodeArry['telephone'];
		$node->field_network[LANGUAGE_NONE][0]['nid'] = $network_name;
		$node->uid = $uid;
		$result = node_save($node);
		
			$my_module = 'travelagency';
			$my_mail_token = 'bar';
			$from = variable_get('system_mail', 'info@privatetransfer.com');			
			
			
                        $subject = 'Travel agency Registration - other category';			
			
                       	
                        $body = "<br/> New travel agency has been registered under other member headquarter category : 
                                <br/>Agency Name : ".$Stitle."
                                <br/>Member Name : ".$nodeArry['title']."
                                <br/><br>--Private-Transfer team";
				
			$message = array(
			'id' => $my_module . '_' . $my_mail_token,
			'to' => 'info@privatetransfer.com',
			'subject' => $subject,
			'body' => '<p>'.$body.'</p>',
			'headers' => array(
			'From' => $from,
			'Sender' => $from,
			'Return-Path' => $from,
			'Content-Type'  => 'text/html; charset=UTF-8; format=flowed',
			),
			);
			       $system = drupal_mail_system($my_module, $my_mail_token);
			       if ($system->mail($message)) {
				// Success.
				/*drupal_set_message(t('The email has been send.'));*/
				drupal_set_message(t('Message has been sent.'));
			       }
			       else {
				// Failure.
				drupal_set_message(t('The email send Error.....'));
			       }		     
                   
	} else {
	$gid = db_query("select gid from og where etid=".$member_name."")->fetchField();
	$memid = db_query("select nid from node where title='".$Stitle."'")->fetchField();
	
	$nid = db_query("select nid from node WHERE title='".str_replace("'","\'",$Stitle)."' and type='travel_agency'")->fetchField();                            
        $currentGrouid = db_query("select gid from og where etid='".$nid."'")->fetchField();
			 
	/*$currentGrouid = db_query("select gid from og where label='".$Stitle."'")->fetchField();*/
	$created=time();
	
        db_query("INSERT INTO og_membership (type, etid, entity_type, gid, state, created)
VALUES ('og_membership_type_default', '".$memid."','node', '".$gid."', '".OG_STATE_ACTIVE."','".$created."')");
	   
    db_query("INSERT INTO field_data_group_audience (entity_type, bundle, entity_id, revision_id, language, delta, group_audience_gid, group_audience_state, group_audience_created )
VALUES ('node', 'travel_agency', '".$memid."', '".$memid."', 'und','0','".$gid."', '1','".$created."')");
    
    db_query("INSERT INTO og_users_roles(uid,rid,gid) values('".$groupAdminId."',3,'".$currentGrouid."')");
    
     }
	//new school user id
	/*$nuid = db_query("SELECT uid FROM {users} WHERE mail = :mail", array(':mail' => $mail))->fetchField();
	//update newschool owner id
	$num_updated = db_update('node') // Table name no longer needs {}
	->fields(array(
	'uid' => $nuid,
	))
	->condition('nid',$node->nid)
	->execute();

	//update school member information

	$ogid = db_query("SELECT gid FROM {og} WHERE etid = :etid", array(':etid' => $node->nid))->fetchField();
	// db_query("UPDATE {og_membership} SET etid = $nuid WHERE gid = %d", $ogid);

	$query = db_update('og_membership')
	->fields(array('etid' => $nuid,))
	->condition('gid',$ogid);
	$query->execute();






	//  for ($i = 1; $i <= $form_state['num_names']; $i++) {
	//    $output .= t("@num: @first @country (@Email)... ", array('@num' => $i, '@first' => $form_state['values']['name'][$i]['sname'],
	//      '@country' =>  $form_state['values']['name'][$i]['country'], '@Email' =>  $form_state['values']['name'][$i]['email']));
	//  }
	//drupal_set_message($output);*/
	
	$form_state['redirect'] = 'user';
}

?>