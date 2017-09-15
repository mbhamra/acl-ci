
<table border="1" style="border-collapse: collapse">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Username</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        
        <?php
        foreach($users AS $user){
            ?>
        <tr>
            <td><?php echo $user['id'] ?></td>
            <td><?php echo $user['name'] ?></td>
            <td><?php echo $user['username'] ?></td>
            <td><?php if(hasPermission('users','edit')) { echo anchor('/index.php/users/edit/'.$user['id'], 'Edit'); } ?></td>
        </tr>
        <?php
        }
        ?>
        
    </tbody>
</table>
