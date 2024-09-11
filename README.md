
# GearUp Rentals

GearUp Rentals is an online platform for renting sports equipment and organizing events (Rozgrywki) for sports enthusiasts. Users can list their own sports gear for rent, browse available offers, and participate in or create sports events.


## Features

- **User Authentication:** Users can sign up, log in, and manage their accounts.
- **Sports Equipment Rental:** Users can create and manage rental offers for sports equipment.
- **Event Creation:** Users can create and manage sports events (Rozgrywki).
- **Event Participation:** Users can join available events and participate in sports activities.
- **Search and Filter:** Users can search for offers and filter based on their needs.
- **Rental Management:** Users can book, request, and manage rentals for specific periods.


## Tech Stack

- **Front-end:** HTML, CSS, JavaScript, Bootstrap
- **Back-end:** PHP
- **Database:** MySQL (MariaDB)
- **Server:** Apache (XAMPP or LAMP)


## Installation

**Requirements**
- Apache server (XAMPP)
- PHP 7.x or higher
- MySQL or MariaDB database

**Steps**

1. Clone the repository to your local machine:
```bash
git clone https://github.com/Jakubowsky97/GearUp-Rentals/
```
2. Set up a MySQL database and import the gearup.sql file provided in the repository:
```bash
mysql -u root -p < gearup_database.sql
```
3. Configure your database connection in dbh.php:
```php
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gearup_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```
4. Place the project folder in the root directory of your Apache server (e.g., htdocs for XAMPP users).
5. Start the Apache and MySQL services (if using XAMPP, you can use the control panel).
6. Visit http://localhost/gearup-rentals/Web in your browser to start using the website.