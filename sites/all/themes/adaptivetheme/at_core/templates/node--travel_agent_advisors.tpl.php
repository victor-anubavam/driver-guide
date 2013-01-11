<?php
/**
 * @file
 * Adaptivetheme implementation to display a node.
 *
 * Adaptivetheme variables:
 * AT Core sets special time and date variables for use in templates:
 * - $submitted: Submission information created from $name and $date during
 *   adaptivetheme_preprocess_node(), uses the $publication_date variable.
 * - $datetime: datetime stamp formatted correctly to ISO8601.
 * - $publication_date: publication date, formatted with time element and
 *   pubdate attribute.
 * - $datetime_updated: datetime stamp formatted correctly to ISO8601.
 * - $last_update: last updated date/time, formatted with time element and
 *   pubdate attribute.
 * - $custom_date_and_time: date time string used in $last_update.
 * - $header_attributes: attributes such as classes to apply to the header element.
 * - $footer_attributes: attributes such as classes to apply to the footer element.
 * - $links_attributes: attributes such as classes to apply to the nav element.
 * - $is_mobile: Bool, requires the Browscap module to return TRUE for mobile
 *   devices. Use to test for a mobile context.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 * @see adaptivetheme_preprocess_node()
 * @see adaptivetheme_process_node()
 */

/**
 * Hiding Content and Printing it Separately
 *
 * Use the hide() function to hide fields and other content, you can render it
 * later using the render() function. Install the Devel module and use
 * <?php print dsm($content); ?> to find variable names to hide() or render().
 */
hide($content['comments']);
hide($content['links']);
?>
<article id="node-<?php print $node->nid; ?> agentlandpage" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php print render($title_prefix); ?>
  <?php if ($title && !$page): ?>
    <header<?php print $header_attributes; ?>>
      <?php if ($title): ?>
        <h1<?php print $title_attributes; ?>>
          <a href="<?php print $node_url; ?>" rel="bookmark"><?php //print $title; ?></a>
        </h1>
      <?php endif; ?>
    </header>
  <?php endif; ?>

  <?php if(!empty($user_picture) || $display_submitted): ?>
    <footer<?php print $footer_attributes; ?>>
      <?php print $user_picture; ?>
      <p class="author-datetime"><?php print $submitted; ?></p>
    </footer>
  <?php endif;
  //echo "<pre>";
  //print_r($content);
  //echo "</pre>";
  
  ?>

  <div<?php print $content_attributes; ?>> 
        <h2 class="field-label">TRAVEL AGENT NAME: <span class="contNorm"><?php print $title; ?></span></h2>
  </div>
  <input type="hidden" name="node_hid" id="node_hid" value="<?php print $node->nid; ?>"/>
        <div class="outer-field">
            <div class="inner-field">
                <h2 class="field-label">Email Id: <span class="contNorm"><?php if(isset($content['field_company_email_id']['#object']->field_company_email_id['und'][0]['email'])){ print $content['field_company_email_id']['#object']->field_company_email_id['und'][0]['email'];} ?></span></h2>
        <h2 class="field-label">Agency: <span class="contNorm"><?php if(isset($node->field_agency['und'][0]['taxonomy_term']->name)){echo $node->field_agency['und'][0]['taxonomy_term']->name;}?></span></h2>
            </div>
    </div>
    <div>
         <div class="outer-field">
         <h2 class="field-label">CONTACT PERSON</h2>
         <div class="inner-field">
         <h2 class="field-label">First Name: <span class="contNorm"><?php if(isset($content['field_at_first_name']['#object']->field_at_first_name['und'][0]['value'])){ print $content['field_at_first_name']['#object']->field_at_first_name['und'][0]['value'];} ?></span></h2>
         <h2 class="field-label">Last Name: <span class="contNorm"><?php if(isset($content['field_last_name']['#object']->field_last_name['und'][0]['value'])){ print $content['field_last_name']['#object']->field_last_name['und'][0]['value'];} ?></span></h2>
         <h2 class="field-label">Position: <span class="contNorm"><?php if(isset($content['field_position']['#object']->field_position['und'][0]['value'])){ print $content['field_position']['#object']->field_position['und'][0]['value'];} ?></span></h2>
         </div>
        </div>
         <div class="outer-field">
         <!--<h2 class="field-label">DEADLINES FOR QUARTER FEES PAYMENTS</h2>-->
         <div class="inner-field">
         <h2 class="field-label">Agent Working('field'): <span class="contNorm"><?php if(isset($content['field_agent_type'][0]['#markup'])){ print $content['field_agent_type'][0]['#markup'];} ?></span></h2>
         </div>
         </div>
         <div class="outer-field">
         <h2 class="field-label">Agent Working Address</h2>
         <div class="inner-field">
         <h2 class="field-label">Country: <span class="contNorm"><?php if(isset($content['field_agent_country'][0]['#markup'])){ print $content['field_agent_country'][0]['#markup'];} ?></span></h2>
         <h2 class="field-label">State: <span class="contNorm"><?php if(isset($content['field_agent_state'][0]['#markup'])){ print $content['field_agent_state'][0]['#markup'];} ?></span></h2>
         <h2 class="field-label">City: <span class="contNorm"><?php if(isset($content['field_agent_city'][0]['#markup'])){ print $content['field_agent_city'][0]['#markup'];} ?></span></h2>
         <h2 class="field-label">Zip Code: <span class="contNorm"><?php if(isset($content['field_agent_zip_code'][0]['#markup'])){ print $content['field_agent_zip_code'][0]['#markup'];} ?></span></h2>
         <h2 class="field-label">Street Address: <span class="contNorm"><?php if(isset($content['field_street_and_number'][0]['#markup'])){ print $content['field_street_and_number'][0]['#markup'];} ?></span></h2>
         </div>
         </div>
         <div class="outer-field">
         <h2 class="field-label">Agency Address</h2>
         <div class="inner-field">
         <h2 class="field-label">Country: <span class="contNorm"><?php if(isset($content['field_country_addr'][0]['#markup'])){ print $content['field_country_addr'][0]['#markup'];} ?></span></h2>
         <h2 class="field-label">State: <span class="contNorm"><?php if(isset($content['field_statte'][0]['#markup'])){ print $content['field_statte'][0]['#markup'];} ?></span></h2>
         <h2 class="field-label">City: <span class="contNorm"><?php if(isset($content['field_cityy'][0]['#markup'])){ print $content['field_cityy'][0]['#markup'];} ?></span></h2>
         <h2 class="field-label">Zip Code: <span class="contNorm"><?php if(isset($content['field_zip_codde'][0]['#markup'])){ print $content['field_zip_codde'][0]['#markup'];} ?></span></h2>
         <h2 class="field-label">Street Address: <span class="contNorm"><?php if(isset($content['field_street_adress'][0]['#markup'])){ print $content['field_street_adress'][0]['#markup'];} ?></span></h2>
         </div>
         </div>
         <div class="outer-field">
         <!--<h2 class="field-label">DEADLINES FOR QUARTER FEES PAYMENTS</h2>-->
         <div class="inner-field">
         <h2 class="field-label">Website URL: <span class="contNorm"><?php if(isset($content['field_website_url'][0]['#markup'])){ print $content['field_website_url'][0]['#markup'];} ?></span></h2>
         </div>
         </div>
         </div>
    </div>  

  <?php if ($links = render($content['links'])): ?>
    <nav<?php print $links_attributes; ?>><?php print $links; ?></nav>
  <?php endif; ?>
  <?php print render($content['comments']); ?>
  <?php print render($title_suffix); ?>
    
    
</article>

<?php
$nodeID = arg(1);
if((arg(0) == 'node') && (!empty($nodeID))) { ?>
<div class="Client-list">
    <h3 class="page-title" style="margin-bottom: 0px;">Client List </h3>
    <a id="bluebutton" href="/client-registration" style="float:right;">Add client</a><br><br>
       <?php       
        $gid = db_query("select gid from og where etid=".arg(1)."")->fetchField();
        if(!empty($gid))
        $result = db_query("select etid from og_membership where gid= ".$gid." and entity_type='user'");
        print '<ul>';
        foreach($result as $record) {            
            $userArry = user_load($record->etid); ?>
            <li><div ><span style="margin-right: 20px; width: 150px;float:left;"> <?php echo $userArry->name; ?></span><a  href="javascript:void(0);" onclick="removeClient('<?php echo $gid; ?>','<?php echo $record->etid; ?>');" class="btnLink">REMOVE</a></div></li>            
            <?php
            } ?>
            </ul>
	
</div>
<?php } ?>