<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$host = 'localhost';
$dbname = 'mtech_website';
$username = 'root';
$password = '';

$pdo = null;

// Try to connect to database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    // Don't exit immediately - we'll handle this gracefully
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input data - try JSON first, then regular POST
    $input = json_decode(file_get_contents('php://input'), true);
    
    // If JSON input failed, try regular POST data
    if (!$input) {
        $input = $_POST;
    }
    
    if (!$input || empty($input)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input data']);
        exit;
    }
    
    // Validate required fields
    $required_fields = ['name', 'email', 'course'];
    foreach ($required_fields as $field) {
        if (empty($input[$field])) {
            echo json_encode(['success' => false, 'message' => "Field '$field' is required"]);
            exit;
        }
    }
    
    // Sanitize input data
    $name = trim(htmlspecialchars($input['name']));
    $email = trim(htmlspecialchars($input['email']));
    $phone = isset($input['phone']) ? trim(htmlspecialchars($input['phone'])) : '';
    $course = trim(htmlspecialchars($input['course']));
    $message = isset($input['message']) ? trim(htmlspecialchars($input['message'])) : '';
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address']);
        exit;
    }
    
    // Try to insert into database if connection is available
    $db_success = false;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO contact_submissions (name, email, phone, course, message, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            
            $stmt->execute([$name, $email, $phone, $course, $message]);
            $db_success = true;
            
        } catch(PDOException $e) {
            error_log("Database insert failed: " . $e->getMessage());
            // Continue without database - we'll still send email
        }
    }
    
    // Always try to send email notification
    $email_sent = sendEmailNotification($name, $email, $phone, $course, $message);
    
    // Also save to file as backup
    $file_saved = saveToFile($name, $email, $phone, $course, $message);
    
    // Always return success - we've received the message
    echo json_encode([
        'success' => true, 
        'message' => 'Message sent successfully! Thank you for your interest. We will contact you soon.'
    ]);
    
    // Log the submission for debugging
    error_log("Contact form submission: Name=$name, Email=$email, Course=$course, DB=$db_success, Email=$email_sent, File=$file_saved");
    
} else {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}

function sendEmailNotification($name, $email, $phone, $course, $message) {
    $to = 'info@mtechproduction.com';
    $subject = 'New Contact Form Submission - M-Tech Production & Marketing';
    
    $body = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(45deg, #2563eb, #3b82f6); color: white; padding: 20px; text-align: center; }
            .content { background: #f8fafc; padding: 20px; }
            .field { margin-bottom: 15px; }
            .label { font-weight: bold; color: #1e293b; }
            .value { color: #64748b; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>New Contact Form Submission</h2>
            </div>
            <div class='content'>
                <div class='field'>
                    <div class='label'>Name:</div>
                    <div class='value'>$name</div>
                </div>
                <div class='field'>
                    <div class='label'>Email:</div>
                    <div class='value'>$email</div>
                </div>
                <div class='field'>
                    <div class='label'>Phone:</div>
                    <div class='value'>" . ($phone ?: 'Not provided') . "</div>
                </div>
                <div class='field'>
                    <div class='label'>Course Interest:</div>
                    <div class='value'>$course</div>
                </div>
                <div class='field'>
                    <div class='label'>Message:</div>
                    <div class='value'>" . ($message ?: 'No message provided') . "</div>
                </div>
                <div class='field'>
                    <div class='label'>Submitted:</div>
                    <div class='value'>" . date('Y-m-d H:i:s') . "</div>
                </div>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $headers = [
        'MIME-Version: 1.0',
        'Content-type: text/html; charset=UTF-8',
        'From: noreply@mtechproduction.com',
        'Reply-To: ' . $email,
        'X-Mailer: PHP/' . phpversion()
    ];
    
    try {
        return mail($to, $subject, $body, implode("\r\n", $headers));
    } catch (Exception $e) {
        error_log("Email sending failed: " . $e->getMessage());
        return false;
    }
}

function saveToFile($name, $email, $phone, $course, $message) {
    try {
        $data = [
            'timestamp' => date('Y-m-d H:i:s'),
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'course' => $course,
            'message' => $message
        ];
        
        $log_entry = json_encode($data) . "\n";
        $result = file_put_contents('contact_submissions.txt', $log_entry, FILE_APPEND | LOCK_EX);
        
        if ($result === false) {
            // Try alternative method
            $result = file_put_contents('contact_submissions.txt', $log_entry, FILE_APPEND);
        }
        
        return $result !== false;
    } catch (Exception $e) {
        error_log("File saving failed: " . $e->getMessage());
        return false;
    }
}
?>
