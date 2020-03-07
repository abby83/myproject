==============================================================
General Notes
==============================================================
This small application is developed with Symfony, a PHP framework, and Mysql database. Please follow the below setups which is required to run the application in browser

==============================================================
Platform Setup
==============================================================
1) Install latest version Xampp/Wampp/LAMP stack to run in OS. This stack comes with Apache server, PHP and Mysql which is minimum criteria to run the application.
2) To clone the application into server root path(if using xampp then under htdocs folder) use the below Github link
        https://github.com/abby83/myproject.git
3) Once the application has been cloned into server root path please run the below commands from cli from root path
		(i)   composer install                         //Install all the vendors bundles mentioned in composer.json(required for this application)
        (ii)  php bin/console doctrine:schema:create  // This will create all schemas used into the application
        (iii) php bin/console make:fixtures:load     // this will load one default user for authentication

4) Username: admin
   password: admin@123

