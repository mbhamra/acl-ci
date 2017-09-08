
<?php
echo form_open();

echo form_label('Name','name'); echo '<br />';
echo form_input('name',isset($data['name'])?$data['name']:'', ['placeholder'=>'Name']);
echo form_error('name');

echo br(2);
?>
<label>Role Permissions</label>
<ul>
<?php
$class = '';
$i = 0;
foreach($acos as $aco){
    if($class != $aco['class']){
        $class = $aco['class'];
        if($i > 0) { echo '</li></ul>'; }
        $i++;
        //print the class name
        ?> 
        <li> <b> <?php echo $aco['class']; ?> </b><ul>
        <?php
    }
    ?>
                <li> <?php 
                $checked = isset($data['role_permission']) && in_array($aco['id'], $data['role_permission'])?true:false;
                echo form_checkbox('role_permission[]', $aco['id'], $checked); echo form_label($aco['method']); ?>  </li>
                <?php
}
?>
            </ul>
</li>
</ul>
    <?php
echo br(2);
echo form_submit('save','Save'); 
echo anchor('/roles/','Cancel');
echo form_close();
?>