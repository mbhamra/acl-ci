
<?php
if(isset($error)){
    echo $error;
    echo br(2);
}
echo form_open();

echo form_label('Username','username'); echo '<br />';
echo form_input('username',null, ['placeholder'=>'Username']);
echo form_error('username');
echo br();
echo form_label('Password','password'); echo '<br />';
echo form_password('password',null, ['placeholder'=>'Password']);
echo form_error('password');

echo br(2);
echo form_submit('login','Login'); 
echo form_close();
?>