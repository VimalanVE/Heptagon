## Heptagon's Machine Test

### Requirement : 
● Laravel Auth: Log in as an administrator

● Use database seeds to create the first user(Admin) with
email admin@admin.com and password should be in the
strong format with the encrypted one.

● CRUD functionality (Create / Read / Update / Delete) for two
menu items: Companies and Employees.
Note: Employee submission should be happening in the
AJAX call.

● Companies DB table consists of these fields: Company Name
(required), Company Email, Company Logo (minimum
100×100), Company Website & Active/Inactive
Note: In Company list page, additionally need a column like
“Total employees” and it should be fetched from the
employees’ table based on the company.

● Employees DB table consists of these fields: First name
(required), Last name (required), Company (foreign key to
Companies), Email, Phone, Designation & Active/Inactive

● Use database migrations to create those schemas above

● Store companies logos in storage/app/public folder and
make them accessible from public

● Use basic Laravel resource controllers with default methods
– index, create, store etc.

● Use Laravel’s validation function, using Request classes

● Use Laravel’s pagination for showing Companies/Employees
list, 10 entries per page

● Use Laravel make:auth as default Bootstrap-based design
theme, but remove the ability to register

● Also, create a bulk upload button in both list pages and it
should be uploaded by using any of the queue concepts like
RabbitMQ, etc.

● Near Bulk upload, create a button as “Download Template”
to download the template for upload the
employees/companies.

● All the sensitive information should be encrypted in the
URL/Link like if employee/company id passed in the edit
page, it should be encrypted.

### Implementation :
This application is an Admin Panel that permits a user who is logged in as Administrative user to manage records of companies and their employees. 

Clone this repository
```
git clone https://github.com/AwaMelvine/laravel-manage-companies.git
```
Create a MySQL database and give it  a name say `heptagon_db`
Create a `.env` file in the root of your application and replace the username, password and database fields with your corresponding MySQL database details

In the root folder of the application, run the command
```
php artisan migrate --seed
```
This will run the migration files which will create the necessary tables and seed the users table with an admin user whose email is `admin@admin.com` and password `Admin@123`.

The migration command also assigns a role called `Admin` to the administrative user which can distinguish the administrative user from other users in the application. 
