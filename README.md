Welcome to LemonCMS!
===================

**Server Requirements**
___

PHP >= 7.0.0
OpenSSL PHP Extension
PDO PHP Extension
Mbstring PHP Extension
Tokenizer PHP Extension
XML PHP Extension.


#### 

> **Tip:**  Before proceeding make sure you have **Composer** installed on your machine. 


Setup
----------

> **Clone project from this repository**
> 
	> - Run **composer install" command from terminal
	> - Open .env file and provide correct database and API auth information to be used
	> - Run **php artisan key:generate" commant from terminal
	> - Run **php artisan migrate" command from terminal
	> - Run **php artisan serve" command from terminal 
	> - RUn **php artisan receive:token command from termianl to generate new Access Token

> **TDD Javascript
>
	> - Run **npm install on your terminal, wait until the packages will be installed
	> - Run **npm test for starting a testing environment, at the same time run 'npm run watch' command which will allow you to watch all the javascript/css files under resources/assets folder.
	> - SPECS **All of the test files for Javascript must be stored under tests/Javascript folder with the extension spec.js. Otherwise you can reconfigure package.json 'npm test' command => 'scripts' : { 'test' }.
	
	Permissions Documentation
	
	https://github.com/spatie/laravel-permission