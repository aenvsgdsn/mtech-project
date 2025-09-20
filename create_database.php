<?php
// Simple database creation script
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Creating Database and Tables</h2>";

$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Connect to MySQL server
    $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS mtech_website CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<p style='color: green;'>✓ Database created</p>";
    
    // Use database
    $pdo->exec("USE mtech_website");
    
    // Create contact_submissions table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS contact_submissions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            phone VARCHAR(20),
            course VARCHAR(50) NOT NULL,
            message TEXT,
            status ENUM('new', 'contacted', 'enrolled', 'closed') DEFAULT 'new',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ");
    echo "<p style='color: green;'>✓ Table created</p>";
    
    echo "<h3 style='color: green;'>Database setup complete!</h3>";
    echo "<p><a href='debug_contact.php'>Test contact form now</a></p>";
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; background: #f8fafc; }
h2 { color: #1e293b; }
p { padding: 10px; background: white; border-radius: 5px; margin: 10px 0; }
a { color: #3b82f6; text-decoration: none; }
a:hover { text-decoration: underline; }
</style>
