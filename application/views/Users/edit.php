
User Edit Form
<?php

echo form_open();

echo form_label('Name','name'); echo '<br />';
echo form_input('name',isset($data['name'])?$data['name']:'', ['placeholder'=>'Name']);
echo form_error('name');
echo br(); 
echo form_label('Username','username'); echo br();
echo form_input('username',isset($data['username'])?$data['username']:'', ['placeholder'=>'Username', 'readonly']);
echo form_error('username');
echo br();
echo form_label('Roles','user_roles'); echo br();

echo form_dropdown('user_roles[]', $roles, $data['user_roles'], ['multiple'=>'multiple']);
echo form_error('user_roles');
echo br(2);
echo form_submit('save','Update'); 
echo anchor('/users/','Cancel');
echo form_close();
?>