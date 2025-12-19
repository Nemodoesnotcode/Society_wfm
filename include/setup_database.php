<?php
echo "<h1>Setting up Database for Green Villas Society</h1>";

// Database connection
$servername = "localhost";
$username = "root";
$password = "";

// Create connection without selecting database first
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<p>✓ Connected to MySQL server</p>";

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS society_wfm";
if ($conn->query($sql) === TRUE) {
    echo "<p>✓ Database 'society_wfm' created or already exists</p>";
} else {
    echo "<p>✗ Error creating database: " . $conn->error . "</p>";
}

// Select the database
$conn->select_db("society_wfm");

// Create admins table
$sql = "CREATE TABLE IF NOT EXISTS admins (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    admin_type VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "<p>✓ Table 'admins' created or already exists</p>";
} else {
    echo "<p>✗ Error creating table: " . $conn->error . "</p>";
}

// Create workers table (for future use)
$sql = "CREATE TABLE IF NOT EXISTS workers (
    worker_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    address TEXT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    status VARCHAR(20) DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "<p>✓ Table 'workers' created or already exists</p>";
} else {
    echo "<p>✗ Error creating table: " . $conn->error . "</p>";
}

// Insert admin accounts (with correct email format)
$sql = "INSERT IGNORE INTO admins (name, email, password, admin_type) VALUES 
    ('NAA - Admin One', 'admin.one@greenvillas.pk', ?, 'admin_one'),
    ('NAA - Admin Two', 'admin.two@greenvillas.pk', ?, 'admin_two')";

$stmt = $conn->prepare($sql);

if ($stmt) {
    // Hash passwords
    $password_one = password_hash('admin123', PASSWORD_DEFAULT);
    $password_two = password_hash('admin456', PASSWORD_DEFAULT);
    
    $stmt->bind_param("ss", $password_one, $password_two);
    
    if ($stmt->execute()) {
        echo "<p>✓ Admin accounts created or already exist</p>";
        
        // Show the inserted accounts
        echo "<h3>Admin Accounts Created:</h3>";
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
        echo "<tr><th>Name</th><th>Email</th><th>Admin Type</th><th>Password (Plain)</th></tr>";
        echo "<tr><td>NAA - Admin One</td><td>admin.one@greenvillas.pk</td><td>admin_one</td><td>admin123</td></tr>";
        echo "<tr><td>NAA - Admin Two</td><td>admin.two@greenvillas.pk</td><td>admin_two</td><td>admin456</td></tr>";
        echo "</table>";
    } else {
        echo "<p>✗ Error inserting admin accounts: " . $stmt->error . "</p>";
    }
    
    $stmt->close();
} else {
    echo "<p>✗ Error preparing statement: " . $conn->error . "</p>";
}

echo "<h2>Test Connection</h2>";

// Test selecting from admins table
$sql = "SELECT * FROM admins";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        echo "<p>✓ Found " . $result->num_rows . " admin(s) in the database</p>";
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Admin Type</th></tr>";
        
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['admin_type'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>⚠ No admins found in the table</p>";
    }
} else {
    echo "<p>✗ Error querying admins table: " . $conn->error . "</p>";
}

$conn->close();

echo "<h2 style='color: green;'>✓ Database setup completed!</h2>";
echo "<p><a href='../pages/admin_login.html'>Go to Admin One Login</a></p>";
echo "<p><a href='../pages/admin2_login.html'>Go to Admin Two Login</a></p>";
?>