<?php 
if(hasPermission('roles','add')){
    ?>
    <a href="<?php echo base_url('/index.php/roles/add') ?>">Add Role</a><br/><br />
<?php
}
?>

<table border="1" style="border-collapse: collapse">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        
        <?php
        foreach($roles AS $role){
            ?>
        <tr>
            <td><?php echo $role['id'] ?></td>
            <td><?php echo $role['name'] ?></td>
            <td><?php if(hasPermission('roles','edit')) { echo anchor('roles/edit/'.$role['id'],'Edit'); } ?></td>
            <td><?php if(hasPermission('roles','delete')) { echo anchor('roles/delete/'.$role['id'],'Delete'); /*please set the confirmation before delete for security*/ } ?></td>
        </tr>
        <?php
        }
        ?>
        
    </tbody>
</table>
