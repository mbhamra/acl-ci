
###################
# Codeigniter ACL with automatic fetch controllers / methods and insert into database for dynamic process #
##################
ACL stands for access control list. It is a way to restrict users access to features of your site depending on their
permissions. To make it easier to add permissions for users when changes are made to your site, permissions are
connected to the role rather than user. User can have multiple roles.

There is also a guest role which is activated on all users and guest user also
Where guest user action permission will be allowed to access that guest page

* **Automatically fetch controller and methods name and insert it into table for you.**
** You have to only the assign controller and methods permission to roles and all sets**

Controller and method will automatically validate by acl hook and if user has permission to access that page then it will give the true else it will redirect it to unauthorized page

This library uses the active record classes. So make sure _$active_record_ is set to _TRUE_ in your
/application/config/database.php file.

**Database**
You are able to have your table and fields named however you like. Those modifications will need to be reflected in the
AclModel.php, AcosModel.php, UsersModel.php, RolesModel.php, UserRolesModel.php files in model folder. 

* **acl_table**
    * Name of the database tables where users are stored

* **acl_users_fields**
    * Field names where user information is housed
        * id
             * Unique ID for user
        * role_id
             * Role ID of user

* **acl_table_permissions**
    * Name of the database tables where permissions are stored

* **acl_permissions_fields**
    * Field names where permission information is housed
        * id
            * Unique ID of permission
        * key
            * Unique string identifier of permission. This is used in your code to check for this permission

* **acl_table_role_permissions**
    * Name of the database tables where role permissions are stored

* **acl_role_permissions_fields**
    * Field names where role permission information is housed
        * id
             * Unique ID of role permission
        * role_id
             * Unique ID of role this permission belongs to
        permission_id
             * Unique ID of permission being assigned to the role

* **acl_user_session_key**
    * Name of the session key that stores the user ID

* **acl_restricted**
	* Array of controllers being restricted to role and/or user. See _Restricting By Controller_ for more details

# check permission for link in controller or view by using hasPermission function

	if(hasPermission($class, $method)){
		//true
	}

hasPermission function will check that user has permission to access the class and method and return as boolean.


################################################
# for support, mail me at info@mandiguru.co.in #
################################################
