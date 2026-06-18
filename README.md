# AccessTech E-Commerce Platform

AccessTech is a PHP-based e-commerce platform designed to connect customers, sellers, and administrators in a single system. The platform allows sellers to upload assistive technology products, customers to browse and purchase products, and administrators to manage the entire system.

## Project Structure

```
accesstech/
│
├── config/
│   └── db.php
│
├── includes/
│   ├── session.php
│   ├── functions.php
│   └── navbar.php
│
├── uploads/
│   ├── products/
│   └── documents/
│
├── assets/
│   ├── style.css
│   └── images, js
│
├── admin/
│   ├── dashboard.php
│   ├── manage-products.php
│   └── manage-users.php
│
├── seller/
│   ├── dashboard.php
│   ├── upload-product.php
│   └── my-products.php
│
├── customer/
│   ├── my-orders.php
│   └── profile.php
│
├── db/
│   └── accesstech.sql
│
├── index.php
├── products.php
├── product-detail.php
├── about.php
├── support.php
├── cart.php
├── checkout.php
├── community.php
├── login.php
├── register.php
└── logout.php
```

---

# Requirements

Before running this project, make sure you have:

* PHP 8.0 or higher
* MySQL or MariaDB
* Apache Server (XAMPP, WAMP, Laragon, or similar)
* Web Browser (Chrome, Firefox, Edge, etc.)
* Git (optional, for cloning the repository)

---

# Installation Guide

## Step 1: Clone the Repository

Open your terminal or command prompt and run:

```bash
git clone https://github.com/Sebatunzi/Alain-s_php_web.git
```

Move into the project directory:

```bash
cd Alain-s_php_web
```

Alternatively, download the ZIP file from GitHub and extract it into your web server directory (htdocs for XAMPP).

---

## Step 2: Place the Project in Your Web Server

### XAMPP

Copy the project folder to:

```text
C:\xampp\htdocs\
```

Result:

```text
C:\xampp\htdocs\accesstech
```

### WAMP

Copy the project folder to:

```text
C:\wamp64\www\
```

### Laragon

Copy the project folder to:

```text
C:\laragon\www\
```

---

## Step 3: Create the Database

The project already includes a database file:

```text
db/accesstech.sql
```

Follow these steps:

### 1. Start Apache and MySQL

Open XAMPP Control Panel and start:

* Apache
* MySQL

### 2. Open phpMyAdmin

Visit:

```text
http://localhost/phpmyadmin
```

### 3. Create a New Database

Click **New** and create a database named:

```sql
accesstech
```

### 4. Import the SQL File

1. Select the newly created database.
2. Click **Import**.
3. Choose:

```text
db/accesstech.sql
```

4. Click **Go**.

This will automatically create all required tables and sample data for the project.

---

## Step 4: Configure Database Connection

Open:

```text
config/db.php
```

Update the database credentials if necessary:

```php
<?php
$host = "localhost";
$dbname = "accesstech";
$username = "root";
$password = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname",
        $username,
        $password
    );
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
```

For most XAMPP installations:

```text
Username: root
Password: (leave blank)
```

---

## Step 5: Run the Project

Open your browser and navigate to:

```text
http://localhost/accesstech
```

The home page should load successfully.

---

# User Roles

## Customer

Customers can:

* Register an account
* Login
* Browse products
* Add products to cart
* Checkout orders
* View order history
* Update profile information
* Participate in the community section

---

## Seller

Sellers can:

* Login to seller dashboard
* Upload products
* Upload manuals and documents
* Manage their products
* View product information

---

## Administrator

Administrators can:

* Access admin dashboard
* Manage products
* Manage users
* Monitor platform activities
* Control system content

---

# Upload Directories

Product images are stored in:

```text
uploads/products/
```

Documents and manuals are stored in:

```text
uploads/documents/
```

Ensure these folders have write permissions enabled.

---

# Troubleshooting

## Database Connection Error

Check:

* MySQL is running.
* Database name matches `accesstech`.
* Credentials in `config/db.php` are correct.

---

## Images Not Uploading

Check:

* `uploads/products/` exists.
* Folder permissions allow writing.

---

## SQL Import Fails

Verify:

* You created the database first.
* You imported the correct file:

```text
db/accesstech.sql
```

---

## Blank Page

Enable PHP error reporting:

```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

This will help identify issues during development.

---

# Technologies Used

* PHP
* MySQL
* HTML5
* CSS3
* JavaScript
* PDO (PHP Data Objects)

---

# Contribution

1. Fork the repository.
2. Create a new branch.

```bash
git checkout -b feature/new-feature
```

3. Commit your changes.

```bash
git commit -m "Added new feature"
```

4. Push the branch.

```bash
git push origin feature/new-feature
```

5. Open a Pull Request.

---

# License

This project is provided for educational and academic purposes. Feel free to use, modify, and improve it according to your requirements.
