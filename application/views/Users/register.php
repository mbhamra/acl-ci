Registration Form
<?php
echo form_open();

echo form_label('Name','name'); echo '<br />';
echo form_input('name',isset($data['name'])?$data['name']:'', ['placeholder'=>'Name']);
echo form_error('name');
echo br(); 
echo form_label('Username','username'); echo '<br />';
echo form_input('username',isset($data['username'])?$data['username']:'', ['placeholder'=>'Username']);
echo form_error('username');
echo br();
echo form_label('Password','password'); echo '<br />';
echo form_password('password', '', ['placeholder'=>'Password']);
echo form_error('password');
echo br();
echo form_label('Confirm Password','cnpassword'); echo '<br />';
echo form_password('cnpassword', '', ['placeholder'=>'Confirm Password']);
echo form_error('cnpassword');
echo br(2);
echo form_submit('register','Register'); 
echo form_close();
?>