<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'bookstore_db';

// Create connection (without specifying database)
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

// Check connection
if (!$conn) {
    die('Could not connect to MySQL: ' . mysqli_connect_error());
}

// Create the database 'bookstore_db' if it doesn't exist
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
$result = mysqli_query($conn, $sql_create_db);

if (!$result) {
    die("Error creating database: " . mysqli_error($conn));
}

// Close the connection without selecting database
mysqli_close($conn);

// Reconnect to MySQL with the specified database
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check connection again
if (!$conn) {
    die('Could not connect to MySQL: ' . mysqli_connect_error());
}

// Create table 'courses'
$sql_courses = 'CREATE TABLE IF NOT EXISTS courses (
    course_id INT NOT NULL AUTO_INCREMENT,
    course_title VARCHAR(50) NOT NULL,
    PRIMARY KEY (course_id)
)';

$retval = mysqli_query($conn, $sql_courses);
if (!$retval) {
    die('Could not create table courses: ' . mysqli_error($conn));
}

// Create table 'stationery' (renamed for correctness)
$sql_stationery = 'CREATE TABLE IF NOT EXISTS stationery (
    stationery_id INT NOT NULL AUTO_INCREMENT,
    stationery_title VARCHAR(50) NOT NULL,
    PRIMARY KEY (stationery_id)
)';

$retval = mysqli_query($conn, $sql_stationery);
if (!$retval) {
    die('Could not create table stationery: ' . mysqli_error($conn));
}

// Create table 'tools'
$sql_tools = 'CREATE TABLE IF NOT EXISTS tools (
    tool_id INT(10) NOT NULL AUTO_INCREMENT,
    tool_title VARCHAR(100) NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    keyword VARCHAR(255) DEFAULT NULL,
    stationery_id INT NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    price DECIMAL(10,2) NOT NULL,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(100) NOT NULL,
    PRIMARY KEY (tool_id),
    FOREIGN KEY (stationery_id) REFERENCES stationery(stationery_id) ON DELETE CASCADE
)';

$retval = mysqli_query($conn, $sql_tools);
if (!$retval) {
    die('Could not create table tools: ' . mysqli_error($conn));
}

// Create table 'books'
$sql_books = 'CREATE TABLE IF NOT EXISTS books (
    book_id INT(10) NOT NULL AUTO_INCREMENT,
    book_title VARCHAR(100) NOT NULL,
    author VARCHAR(100) NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    keyword VARCHAR(255) DEFAULT NULL,
    course_id INT NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    price DECIMAL(10,2) NOT NULL,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(100) NOT NULL,
    PRIMARY KEY (book_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE
)';

$retval = mysqli_query($conn, $sql_books);
if (!$retval) {
    die('Could not create table books: ' . mysqli_error($conn));
}


$sql_cart = 'CREATE TABLE IF NOT EXISTS cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT(10) DEFAULT NULL,
    tool_id INT(10) DEFAULT NULL,
    ip_address VARCHAR(255),
    quantity INT(100) DEFAULT 1,
    booktype ENUM("digital", "printed") DEFAULT NULL,  
    FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE,
    FOREIGN KEY (tool_id) REFERENCES tools(tool_id) ON DELETE CASCADE
)';


$retval = mysqli_query($conn, $sql_cart);
if (!$retval) {
    die('Could not create table cart: ' . mysqli_error($conn));
}


$sql_user = 'CREATE TABLE IF NOT EXISTS user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_username VARCHAR(100) NOT NULL,
    user_email VARCHAR(100) NOT NULL,
    user_password VARCHAR(255) NOT NULL,
    user_image VARCHAR(255) DEFAULT NULL,
    user_ip VARCHAR(100) NOT NULL,
    user_address VARCHAR(255) NOT NULL,
    user_contact VARCHAR(20) NOT NULL
    )';

$retval = mysqli_query($conn, $sql_user);
if (!$retval) {
    die('Could not create table user: ' . mysqli_error($conn));
}


$sql_orders = 'CREATE TABLE IF NOT EXISTS orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount_due INT(255) NOT NULL,
    invoice_number INT(255) NOT NULL,   
    order_date TIMESTAMP NOT NULL,
    order_status VARCHAR(255) NOT NULL,
    book_id VARCHAR(2) NULL,
    tool_id VARCHAR(2) NULL,
    quantity INT(11) NOT NULL
)';

$retval = mysqli_query($conn, $sql_orders);
if (!$retval) {
    die('Could not create table orders: ' . mysqli_error($conn));
}

$sql_pend_orders = 'CREATE TABLE IF NOT EXISTS pending_orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount_due INT NOT NULL,
    invoice_number INT(255) NOT NULL,
    total_products INT(255) NOT NULL, 
    book_id VARCHAR(2) NULL,
    tool_id VARCHAR(2) NULL,
    order_status VARCHAR(255) NOT NULL
)';


$retval = mysqli_query($conn, $sql_pend_orders);
if (!$retval) {
    die('Could not create table pending_orders: ' . mysqli_error($conn));
}

$sql_confirm_payment = 'CREATE TABLE IF NOT EXISTS user_payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    user_id INT NOT NULL,
    invoice_number INT NOT NULL,
    amount INT NOT NULL,
    payment_mode VARCHAR(255) NOT NULL,
    date TIMESTAMP NOT NULL
)';


$retval = mysqli_query($conn, $sql_confirm_payment);
if (!$retval) {
    die('Could not create table confirm_payment: ' . mysqli_error($conn));
}


$sql_admin_table = 'CREATE TABLE IF NOT EXISTS admin_table (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    admin_name VARCHAR(100) NOT NULL,
    admin_email VARCHAR(200) NOT NULL,
    admin_password VARCHAR(255) NOT NULL
)';

$retval = mysqli_query($conn, $sql_admin_table);
if (!$retval) {
    die('Could not create table admin_table: ' . mysqli_error($conn));
}

$sql_contacts = 'CREATE TABLE IF NOT EXISTS contacts (
    contact_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(200) NOT NULL,
    message TEXT NOT NULL
)';
$retval = mysqli_query($conn, $sql_contacts);
if (!$retval) {
    die('Could not create table contacts: ' . mysqli_error($conn));
}

$sql_wishlist = 'CREATE TABLE IF NOT EXISTS wishlist (
    wishlist_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    price DECIMAL(10,2) NOT NULL,
    book_id VARCHAR(10) DEFAULT NULL,
    tool_id VARCHAR(10) DEFAULT NULL

)';

$retval = mysqli_query($conn, $sql_wishlist);
if (!$retval) {
    die('Could not create table wishlist: ' . mysqli_error($conn));
}

$sql_review = 'CREATE TABLE IF NOT EXISTS reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id VARCHAR(10) NOT NULL,  -- Use either book_id or tool_id here
    review_text TEXT NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    review_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)';

$retval = mysqli_query($conn, $sql_review);
if (!$retval) {
    die('Could not create table review: ' . mysqli_error($conn));
}


?>

