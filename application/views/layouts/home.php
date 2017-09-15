<html>
    <head>
        <title><?php echo isset($title_for_layout)?$title_for_layout : " Welcome " ?> - ACL Codeigniter</title>
    </head>
    <body>
        <header>
            <?php if(hasPermission('users', 'register')) { echo anchor('users/register', 'Register User'); echo ' | '; } ?>
            
            <?php
            if(hasPermission('users','index')){
                ?>
                <a href="<?php echo base_url('index.php/users/'); ?>">Users</a> | 
            <?php 
            }
            if(hasPermission('roles','index')){
                ?>
                <a href="<?php echo base_url('index.php/roles'); ?>">Roles</a>  |
                <?php
            }
            if(isset($data['loggedUser']) && !empty($data['loggedUser'])){
                ?>
                <a href="<?php echo base_url('index.php/login/logout'); ?>">Logout</a>  |
                <?php
            } else {
                ?>
                <a href="<?php echo base_url('index.php/login'); ?>">Login</a>  |
                <?php
            }
            ?>
            <a href="<?php echo base_url('index.php/acos/fetch'); ?>">Fetch Permission</a> 
        </header>
        <hr />
        <div class="container">
<?php
//load the view passed by controller method
$this->load->view($template,$data);
?>
        </div>
    </body>
</html>

