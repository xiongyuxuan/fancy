# Fancy
#Note: login page and home page were written by Haiqi Dong

Bofore programming, please do these first:
1. create a database for the system; 
   -suggested sql statement:(for MySql 5.7.*)
   
	create database abc;
	create user guest;
	update mysql.user
     set authentication_string=PASSWORD("123456"),host="localhost"
     where user="guest";
	grant all on abc.* to guest@localhost;
	flush privileges;
	
2. modify 'connect.php' according to step 1;
	(skip this step if you followed suggestion in step 1)
	
3. excute 'createTables.php';

4. excute 'insertStudents.php';

5. excute 'checkTables.php'.

--End of the file.
