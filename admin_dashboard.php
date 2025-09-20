<?php
require_once 'config.php';

// Start session
session_start();

// Check if user is logged in (basic authentication)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

$pdo = getDBConnection();
if (!$pdo) {
    die('Database connection failed');
}

// Get statistics
$stats = [];

// Total contacts
$stmt = $pdo->query("SELECT COUNT(*) as total FROM contact_submissions");
$stats['total_contacts'] = $stmt->fetch()['total'];

// New contacts (last 30 days)
$stmt = $pdo->query("SELECT COUNT(*) as new FROM contact_submissions WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
$stats['new_contacts'] = $stmt->fetch()['new'];

// Total courses
$stmt = $pdo->query("SELECT COUNT(*) as total FROM courses WHERE is_active = 1");
$stats['total_courses'] = $stmt->fetch()['total'];

// Total services
$stmt = $pdo->query("SELECT COUNT(*) as total FROM services WHERE is_active = 1");
$stats['total_services'] = $stmt->fetch()['total'];

// Recent contacts
$stmt = $pdo->query("SELECT * FROM contact_submissions ORDER BY created_at DESC LIMIT 10");
$recent_contacts = $stmt->fetchAll();

// Course statistics
$stmt = $pdo->query("SELECT course, COUNT(*) as count FROM contact_submissions GROUP BY course ORDER BY count DESC");
$course_stats = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - M-Tech Production & Marketing</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #333;
        }
        
        .dashboard {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 250px;
            background: #1e293b;
            color: white;
            padding: 2rem 0;
        }
        
        .sidebar h2 {
            padding: 0 2rem;
            margin-bottom: 2rem;
            color: #3b82f6;
        }
        
        .sidebar ul {
            list-style: none;
        }
        
        .sidebar li {
            margin-bottom: 0.5rem;
        }
        
        .sidebar a {
            display: block;
            padding: 1rem 2rem;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .sidebar a:hover,
        .sidebar a.active {
            background: #3b82f6;
            color: white;
        }
        
        .main-content {
            flex: 1;
            padding: 2rem;
        }
        
        .header {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #3b82f6;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: #64748b;
            font-size: 1.1rem;
        }
        
        .content-section {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .content-section h3 {
            margin-bottom: 1.5rem;
            color: #1e293b;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th,
        .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .table th {
            background: #f8fafc;
            font-weight: 600;
            color: #1e293b;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .status-new {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .status-contacted {
            background: #dcfce7;
            color: #166534;
        }
        
        .status-enrolled {
            background: #fef3c7;
            color: #92400e;
        }
        
        .status-closed {
            background: #f3f4f6;
            color: #374151;
        }
        
        .chart-container {
            height: 300px;
            margin-top: 1rem;
        }
        
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.875rem;
            transition: background 0.3s ease;
        }
        
        .btn:hover {
            background: #2563eb;
        }
        
        .btn-danger {
            background: #ef4444;
        }
        
        .btn-danger:hover {
            background: #dc2626;
        }
        
        .logout {
            position: absolute;
            bottom: 2rem;
            left: 2rem;
            right: 2rem;
        }
        
        .logout a {
            display: block;
            text-align: center;
            background: #ef4444;
            color: white;
            padding: 0.75rem;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        
        .logout a:hover {
            background: #dc2626;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <h2><i class="fas fa-graduation-cap"></i> M-Tech Admin</h2>
            <ul>
                <li><a href="#dashboard" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="#contacts"><i class="fas fa-envelope"></i> Contacts</a></li>
                <li><a href="#courses"><i class="fas fa-book"></i> Courses</a></li>
                <li><a href="#services"><i class="fas fa-cogs"></i> Services</a></li>
                <li><a href="#testimonials"><i class="fas fa-quote-left"></i> Testimonials</a></li>
                <li><a href="#settings"><i class="fas fa-cog"></i> Settings</a></li>
            </ul>
            <div class="logout">
                <a href="admin_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
        
        <div class="main-content">
            <div class="header">
                <h1>Dashboard Overview</h1>
                <p>Welcome back! Here's what's happening with your website.</p>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['total_contacts']; ?></div>
                    <div class="stat-label">Total Contacts</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['new_contacts']; ?></div>
                    <div class="stat-label">New This Month</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['total_courses']; ?></div>
                    <div class="stat-label">Active Courses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['total_services']; ?></div>
                    <div class="stat-label">Active Services</div>
                </div>
            </div>
            
            <div class="content-section">
                <h3>Recent Contact Submissions</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_contacts as $contact): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($contact['name']); ?></td>
                            <td><?php echo htmlspecialchars($contact['email']); ?></td>
                            <td><?php echo htmlspecialchars($contact['course']); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $contact['status']; ?>">
                                    <?php echo ucfirst($contact['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('M j, Y', strtotime($contact['created_at'])); ?></td>
                            <td>
                                <a href="view_contact.php?id=<?php echo $contact['id']; ?>" class="btn">View</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="content-section">
                <h3>Course Interest Statistics</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Interest Count</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_interests = array_sum(array_column($course_stats, 'count'));
                        foreach ($course_stats as $stat): 
                            $percentage = $total_interests > 0 ? round(($stat['count'] / $total_interests) * 100, 1) : 0;
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars(ucwords(str_replace('-', ' ', $stat['course']))); ?></td>
                            <td><?php echo $stat['count']; ?></td>
                            <td><?php echo $percentage; ?>%</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
