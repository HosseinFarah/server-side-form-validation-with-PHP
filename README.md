# Project Overview

This project is a web application for managing and searching films. It's built with PHP for server-side logic, MySQL for database, and JavaScript for client-side interactivity. The application includes server-side form validation based on regex patterns with PHP and displays related missing errors for each field or missed patterns.

The database used in this project is the Sakila database, which can be downloaded from [here](https://downloads.mysql.com/docs/sakila-db.zip).

## Files

### new.php

This PHP script is responsible for adding new films to the database. It includes server-side form validation. Each field is validated based on specific criteria and regex patterns. If a field is empty or doesn't match the required pattern, an error is added to the `$errors` array. If there are any errors after the validation, they are passed to the `debuggeri()` function. If there are no errors, the film is added to the database.

### virheilmoitukset.php

This PHP script is used for handling different types of errors that might occur during the execution of the application. It defines different types of errors such as user input errors, database errors, and other server errors. It also defines the fields for a movie and their Finnish translations, as well as validation patterns for these fields.

### index.php

This is the main page of the application. It includes a search functionality that allows users to search for films by title or description. The search results are displayed in a table format. The page also displays the total number of films found in the database.

### script.js

This JavaScript file contains functions for handling the navigation bar responsiveness and form validation. It uses the Bootstrap validation styles to validate the search form on the main page.

### debuggeri.php

This PHP script is used for debugging purposes. It defines a custom error handler, a function for writing debug information to a log file, a function for filtering backtrace information, a function for writing backtrace information to a log file, and a shutdown function that gets executed when the script ends. It also allows for turning off the debugging by setting the DEBUG constant to false.

## Usage

To use this application, you need to have a server environment with PHP and MySQL installed. You can then clone the repository and set up the database using the provided SQL scripts. After that, you can start the server and open the application in a web browser.

## Contributing

Contributions are welcome. Please open an issue to discuss your ideas or submit a pull request with your changes.

## License

This project is licensed under the MIT License.