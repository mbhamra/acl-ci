
#######################################################################################################
 Codeigniter ACL with automatic fetch controllers / methods and insert into database for dynamic process 
#######################################################################################################

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

**Instructions**
#Add @AclName attribute and comment before method for add controller and method in acl functionality 
	Example (in controller method)
	/**
	*
	* @AclName Name_You_Want
	*/
and then click on fetchNewPermission link on top of the web page, it will fetch all methods with associated @AclName keyword

# **check permission for link in controller or view by using hasPermission function**

	if(hasPermission($class, $method)){
		//true
	}

hasPermission function will check that user has permission to access the class and method and return as boolean.


################################################
 for support, mail me at info@mandiguru.co.in 
################################################
