<?php
// Debug script to identify contact form issues
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Contact Form Debug</h2>";

// Test 1: Check if contact.php exists and is readable
echo "<h3>1. File Check</h3>";
if (file_exists('contact.php')) {
    echo "<p style='color: green;'>✓ contact.php exists</p>";
    if (is_readable('contact.php')) {
        echo "<p style='color: green;'>✓ contact.php is readable</p>";
    } else {
        echo "<p style='color: red;'>❌ contact.php is not readable</p>";
    }
} else {
    echo "<p style='color: red;'>❌ contact.php does not exist</p>";
}

// Test 2: Check database connection
echo "<h3>2. Database Connection</h3>";
$host = 'localhost';
$dbname = 'mtech_website';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color: green;'>✓ Database connection successful</p>";
    
    // Check if table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'contact_submissions'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✓ Table 'contact_submissions' exists</p>";
    } else {
        echo "<p style='color: orange;'>⚠ Table 'contact_submissions' does not exist - will use file backup</p>";
    }
} catch(PDOException $e) {
    echo "<p style='color: orange;'>⚠ Database connection failed: " . $e->getMessage() . " - will use file backup</p>";
}

// Test 3: Check directory permissions
echo "<h3>3. Directory Permissions</h3>";
if (is_writable('.')) {
    echo "<p style='color: green;'>✓ Directory is writable</p>";
} else {
    echo "<p style='color: red;'>❌ Directory is not writable - contact form may not work</p>";
}

// Test 4: Test contact.php directly
echo "<h3>4. Direct Contact.php Test</h3>";
echo "<p>Testing contact.php with sample data...</p>";

$test_data = [
    'name' => 'Test User',
    'email' => 'test@example.com',
    'phone' => '123-456-7890',
    'course' => 'web-development',
    'message' => 'This is a test message'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/mtechprojject/contact.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($test_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response) {
    $result = json_decode($response, true);
    if ($result && isset($result['success'])) {
        if ($result['success']) {
            echo "<p style='color: green;'>✓ Contact.php test successful: " . $result['message'] . "</p>";
        } else {
            echo "<p style='color: red;'>❌ Contact.php test failed: " . $result['message'] . "</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Invalid response from contact.php: " . htmlspecialchars($response) . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ No response from contact.php (HTTP Code: $http_code)</p>";
}

// Test 5: Check if contact_submissions.txt was created
echo "<h3>5. File Backup Check</h3>";
if (file_exists('contact_submissions.txt')) {
    echo "<p style='color: green;'>✓ contact_submissions.txt exists</p>";
    $content = file_get_contents('contact_submissions.txt');
    if ($content) {
        echo "<p style='color: green;'>✓ File has content (" . strlen($content) . " bytes)</p>";
        echo "<details><summary>View file content</summary><pre>" . htmlspecialchars($content) . "</pre></details>";
    } else {
        echo "<p style='color: orange;'>⚠ File exists but is empty</p>";
    }
} else {
    echo "<p style='color: orange;'>⚠ contact_submissions.txt does not exist</p>";
}

// Test 6: Simple form test
echo "<h3>6. Simple Form Test</h3>";
echo "<form method='POST' action='contact.php' style='background: white; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
echo "<h4>Test Contact Form (POST method)</h4>";
echo "<p><label>Name: <input type='text' name='name' value='Test User' required></label></p>";
echo "<p><label>Email: <input type='email' name='email' value='test@example.com' required></label></p>";
echo "<p><label>Phone: <input type='tel' name='phone' value='123-456-7890'></label></p>";
echo "<p><label>Course: <select name='course' required>";
echo "<option value='web-development'>Web Development</option>";
echo "<option value='graphic-design'>Graphic Design</option>";
echo "</select></label></p>";
echo "<p><label>Message: <textarea name='message' rows='3'>This is a test message</textarea></label></p>";
echo "<p><button type='submit'>Test Submit (POST)</button></p>";
echo "</form>";

// Test 7: AJAX test
echo "<h3>7. AJAX Test</h3>";
echo "<button onclick='testAjax()' style='background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;'>Test AJAX Submission</button>";
echo "<div id='ajax-result' style='margin-top: 10px; padding: 10px; background: #f8fafc; border-radius: 5px;'></div>";

?>

<script>
function testAjax() {
    const resultDiv = document.getElementById('ajax-result');
    resultDiv.innerHTML = 'Testing AJAX...';
    
    const data = {
        name: 'Test User',
        email: 'test@example.com',
        phone: '123-456-7890',
        course: 'web-development',
        message: 'This is a test AJAX submission'
    };
    
    fetch('contact.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.text();
    })
    .then(text => {
        console.log('Response text:', text);
        try {
            const data = JSON.parse(text);
            if (data.success) {
                resultDiv.innerHTML = '<p style="color: green;">✓ AJAX test successful: ' + data.message + '</p>';
            } else {
                resultDiv.innerHTML = '<p style="color: red;">❌ AJAX test failed: ' + data.message + '</p>';
            }
        } catch (e) {
            resultDiv.innerHTML = '<p style="color: red;">❌ Invalid JSON response: ' + text + '</p>';
        }
    })
    .catch(error => {
        resultDiv.innerHTML = '<p style="color: red;">❌ AJAX error: ' + error.message + '</p>';
    });
}
</script>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 900px;
    margin: 20px auto;
    padding: 20px;
    background: #f8fafc;
}
h2, h3 {
    color: #1e293b;
    border-bottom: 2px solid #3b82f6;
    padding-bottom: 5px;
}
p {
    margin: 10px 0;
    padding: 8px;
    background: white;
    border-radius: 5px;
    border-left: 4px solid #e2e8f0;
}
form {
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
label {
    display: block;
    margin: 10px 0;
    font-weight: bold;
}
input, select, textarea {
    width: 100%;
    padding: 8px;
    margin: 5px 0;
    border: 1px solid #d1d5db;
    border-radius: 5px;
    box-sizing: border-box;
}
button {
    background: #3b82f6;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
button:hover {
    background: #2563eb;
}
details {
    margin: 10px 0;
}
pre {
    background: #f1f5f9;
    padding: 10px;
    border-radius: 5px;
    overflow-x: auto;
}
</style>
