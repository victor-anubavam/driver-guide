<?php
$gid='';
$memList= array();
if(isset($_REQUEST['gid']) && trim($_REQUEST['gid'])!='')
{
$gid=trim($_REQUEST['gid']);




$res_memlist=db_query("SELECT node.nid as nid,og_node.etid AS og_node_etid, og_membership_node.gid AS og_membership_node_gid, og_node.gid AS og_node_gid, node.created AS node_created
FROM 
{node} node
LEFT JOIN {og} og_node ON node.nid = og_node.etid AND og_node.entity_type = 'node'
LEFT JOIN {og_membership} og_membership_node ON node.nid = og_membership_node.etid AND og_membership_node.entity_type = 'node'
WHERE (( (og_membership_node.gid = '".$gid."' ) )AND(( (node.status = '1') )))
ORDER BY node_created DESC");
  foreach ($res_memlist as $row) {
    $memList[]=$row->nid;
  }
 // print_r($memList);
}
?>
<div>
    <div class="commMsg"></div>
<table>
    <thead>
        <tr>
            <th>Agent / Advisors</th>
            <th width="20%">Action</th>           
        </tr>
    </thead>            
    <tbody>
<?php
for($i=0;$i<count($rows);$i++)
{
?>
        <tr>
            <td><?php echo $rows[$i]['title'] ?></td>
            <td width="20%" style="float:left" id="mem_<?php echo $rows[$i]['nid']; ?>">
                <?php
                if(in_array($rows[$i]['nid'], $memList))
                {
                   ?><a  href="javascript:void(0);" onclick="removeAgentMembers('<?php echo $gid; ?>','<?php echo $rows[$i]['nid']; ?>');" class="btnLink"><div class="btn">REMOVE</div></a> 
                   <?php
                }
                else
                { ?>
                <a  href="javascript:void(0);" onclick="addAgentMembers('<?php echo $gid; ?>','<?php echo $rows[$i]['nid']; ?>');" class="btnLink"><div class="btn">ADD</div></a>
                <?php
                }
                ?>
            </td>
        </tr>
<?php
}
?>
    </tbody>
</table>
</div>