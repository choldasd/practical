# PracticalTest
To run project -
Create DB name as "practical" 

DB Schema - 
php artisan migrate 
php artisan db:seed

On local -
Company - 
https://localhost/practical

Admin - 
https://localhost/practical/admin

Username - applocumadmin@yopmail.com
Password - Password@123


Basic Laravel Auth: ability to log in as an administrator
• Admin can perform CRUD Operation (Create / Read / Update / Delete) for
Companies and Employees
 - Done
• Companies will have their own login and can not see other companies details.
 - Done

• Basically, there will be one portal in which Admin and Companies can log in. If Admin
will log in, He/she can manage all the companies and all its employees and can do CRUD.
If Companies will log in, It can manage all its employees and can do CRUD on it.
 - Done

• Use database seeds to create the first user with email applocumadmin@yopmail.com
and password “Password@123”
 - Done

• Normal Email Regex validation and Password validations will be such that password
must contain at least one uppercase, one lowercase and one symbol with at least 8
characters
 - Done

• CRUD functionality (Create / Read / Update / Delete) for two menu items: Companies
and Employees using JQuery AJAX.
 - Done

• Create update feature using Ajax with the popup.
 - Done

• Email notification: send email to admin email whenever a new company is entered.
 - Done. commented code in Admin/CompanyController.

• Companies DB table consists of these fields: Name (Required), email(Required), logo
(minimum 100×100), website
 - Done

• Employees DB table consists of these fields: Full name (required), Company (foreign key
to Companies), email(Required), phone(Required)
 - Done

• Use database migrations to create those schemas above
 - Done

• Store companies logos in storage/app/public folder and make them accessible from
public
 - Done

• Use basic Laravel resource controllers with default methods – index, create, store etc.
 - Done

• Use Laravel’s validation function, using Request classes
 - Remaining. I tried but unable to get correct json to show error message on page.

• Use Laravel’s pagination for showing Companies/Employees list, 10 entries per page.
- Done.

• Use Laravel make:auth as default Bootstrap-based design theme, but remove the ability
to register
- Done.
