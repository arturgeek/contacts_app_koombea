## About This App

This Appp was build using Laravel 8, it uses a mix of old fashion framework elements and new ES6 to handle some request.

To install this app you should

- Clone the repository.
- Create and Configure your database access on .env file.
- Make sure the right write permissions are on the storage folder.
- Run ***php artisan migrate*** to create the DDBB structure.
- Run ***php artisan serve*** to run the application.


### Run the Job to process the files

When you have already some files created with your user yo may use ***php artisan contactFiles:process*** in order to process the files and create new contacts.