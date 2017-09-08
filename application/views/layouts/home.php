<html>
    <head>
        <title><?php echo isset($title_for_layout)?$title_for_layout : " Welcome " ?> - ACL Codeigniter</title>
    </head>
    <body>
<?php
//load the view passed by controller method
$this->load->view($template,$data);
?>
    </body>
</html>

