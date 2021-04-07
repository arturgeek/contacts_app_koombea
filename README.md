## About This App

This Appp was build using Laravel 8, it uses a mix of old fashion framework elements and new ES6 to handle some request.

To install this app you should

- Clone the repository.
- Create and Configure your database access on .env file.
- Make sure the right write permissions are on the storage folder.
- Run ***php artisan migrate*** to create the DDBB structure.
- Run ***php artisan serve*** to run the application.

When you open the site, you should create a new account following the *create new account* button, then you log in and you are ready to go.

You have access to the dashboard, right now only have access to Contacts and Files.

## Upload new file
You should go to the module and add a new file you can download a model right there, when you select your file it will present a the headers present in your file and next to each header a select field which will help you configure the relevant fields on your file.

Once the relvant fields are all selected the commit button will appear and if everything goes fine, it should show you the new file.

### Run the Job to process the files

When you have already some files created with your user yo may use ***php artisan contactFiles:process*** in order to process the files and create new contacts.

### Check errors

If some field has any error, the list will show a button to toggle the error for each file.

## Check your contacts

You can go to the contacts module to confirm which contacts where created based on the requirements.