# Simple Laravel CRUD

This a simple demo project, written in PHP/Laravel, that I made as a job selection process challenge.
The project requirements were:
  - Use PHP, Laravel and MySQL
  - Basic CRUD of the Brazilian Federal States, containing the State Name and it's short version
  - A history log
  - Authentication and Authorization, including permission management

### The implementation:
  - I made the State list public, so anyone accessing the project's home page will be able to view them. Login is required to modify the list
  - For Authorization, I created two independent permissions: ```manage-states```, ```audit```. The first one allow the user to actually use the CRUD. The later allows the user to view the history logs. There's also an ```admin``` permission, which is the only one able to manage the users's permissions;
  - I've included three users in the database Seed. On on each "permission level". Cretentials are:
    - ```admin@example.com / password```. The admin user
    - ```one@example.com / password```. Able to ```manage-states``` and ```audit```
    - ```two@example.com / password```. Able to only ```manage-states```
  
### Implementation Details:  
  - I chose to use Angular, since the job specs cited the AJAX requests would be a ***plus***;
  - I deliberately chose not to write tests, since this is a very simple demo, and I have other projects to attend to;
  - I also deliberately chose not to write the language files. The code, though, supports localization;
  - Althugh Laravel uses ORM, i've included a MySQL database dump in the **database** directory;
  - I'm not familiarized with *gulp*, so I manually added my asses to the ***public*** folder

### Running the project
1. Clone the repo and get [Composer](https://getcomposer.org)
2. Inside the project directory, run ```composer install``` 
3. Create a ```.env``` file, containing your database details. Laravel includes an ```.env.example```
4. Inside the project directory, run ```php artisan migrate --seed```
5. Inside the project directory, run ```php artisan serve```. [Voilà](http://127.0.0.1:8000)

If you have any problems, please feel free to open an Issue

### What I used
* [PHP](https://www.php.com) - Version 5.6.17
* [Laravel 5.3](https://laravel.com/) - Version 5.3
* [MySQL](https://www.mysql.com/) - Version 5.5.53
* [AngularJS](https://angularjs.org/) - Version 1.5.8
* [Twitter Bootstrap](https://angularjs.org/) - Version 3.3.7
* [jQuery](https://jquery.com/) - Version 3.1.1. Twitter Bootstrap requirement
* [VirtualBox](https://www.virtualbox.org/) - Version 5.0.16, running Debian 8.1
* [PHPStom](https://www.jetbrains.com/phpstorm/) - Version 2016.2. Awesome IDE
