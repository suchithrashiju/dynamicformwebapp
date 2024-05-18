# Dynamic Form App

Dynamic Form App is a web application built with Laravel 11 that allows users to create, manage, and submit dynamic forms. This application leverages MySQL for data storage.

## Table of Contents

-   [Installation](#installation)
-   [Usage](#usage)
-   [Configuration](#configuration)
-   [Contributing](#contributing)
-   [License](#license)
-   [Credits](#credits)

## Installation

### Prerequisites

-   PHP 8.1 or higher
-   Composer
-   MySQL
-   Node.js and npm

### Steps

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/suchithrashiju/dynamicformwebapp.git
    cd dynamicformwebapp
    ```
2.  **Install PHP dependencies:**

    ```bash
    composer install
    ```

3.  **Install JavaScript dependencies:**

    ```bash
    npm install
    npm run dev
    ```

4.  **Copy the .env.example file to .env:**
    cp .env.example .env

5.  **Set up your .env file:**
    Update the .env file with your database credentials and other necessary configuration.

    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password

    MAIL_MAILER=log
    MAIL_HOST=127.0.0.1
    MAIL_PORT=2525
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"

    EMAIL_RECIPIENT=demo@gmail.com


    ```

6.  **Generate an application key:**
    php artisan key:generate
7.  **Run database migrations:**
    php artisan migrate
8.  **Seed the database:**
    php artisan db:seed
9.  **Create a job for sending email notifications on successful form creation:**

```bash

php artisan make:job SendEmailNotification

```

This command will generate a new job class named SendEmailNotification. You can then implement the logic for sending email notifications in this job.

9.  **Start the development server:**

```bash
  php artisan serve
```

10. **Run queue jos:**

```bash
php artisan queue:work --queue=emails
```

Usage
Admin Dashboard

    Admin Login:
        Navigate to the admin login page.
        Enter your admin credentials to access the dashboard.
        Use the following credentials to log in:
            Email: admin@cp360.com
            Password: cp360PWD

    Dashboard Features:
        List Dynamic Forms: View all created dynamic forms.
        Create Dynamic Form: Add new dynamic forms with various field types.
        Edit Dynamic Form: Modify existing forms.
        Delete Dynamic Form: Remove forms that are no longer needed.

Public Access

    View Form List:
        The public can navigate to the form list page to see all available forms.

    Submit Form:
        The public can select a form from the list, fill it out, and submit it.

Features

    Admin Dashboard: Secure login for administrators to manage forms.
    Dynamic Form Creation: Easily create forms with different field types.
    Form Management: Edit and delete forms as needed.
    Public Access: View and submit forms without needing an account.
    Database Seeding: Prepopulate the database with sample data for testing.

Configuration
Environment Variables

    APP_NAME: The name of your application.
    DB_CONNECTION: The database connection type (e.g., mysql).
    DB_HOST: The database host.
    DB_PORT: The database port.
    DB_DATABASE: The database name.
    DB_USERNAME: The database username.
    DB_PASSWORD: The database password.
    MAIL_MAILER: The mailer to use (e.g., log).
    MAIL_HOST: The mail host.
    MAIL_PORT: The mail port.
    MAIL_USERNAME: The mail username.
    MAIL_PASSWORD: The mail password.
    MAIL_ENCRYPTION: The mail encryption type (e.g., null).
    MAIL_FROM_ADDRESS: The email address that emails are sent from.
    MAIL_FROM_NAME: The name that emails are sent from.
    EMAIL_RECIPIENT: The default recipient email address.

Customizing the Application

Modify the configuration files in the config directory as needed. This includes database settings, caching, and other application-specific settings.
Contributing
How to Contribute

    Fork the repository.
    Create a new branch (git checkout -b feature/your-feature-name).
    Make your changes.
    Commit your changes (git commit -m 'Add some feature').
    Push to the branch (git push origin feature/your-feature-name).
    Open a pull request.

Coding Standards

    Follow PSR-12 coding standards.
    Ensure all new features have corresponding tests.

License

This project is licensed under the MIT License. See the LICENSE file for details.
Credits

    Author: Suchithra
    Contributors: List of contributors

Acknowledgments

    Laravel Framework 11
    MySQL
