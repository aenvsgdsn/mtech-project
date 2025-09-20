-- M-Tech Production & Marketing Website Database Setup
-- Run this script to create the database and tables

-- Create database
CREATE DATABASE IF NOT EXISTS mtech_website CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE mtech_website;

-- Contact submissions table
CREATE TABLE IF NOT EXISTS contact_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    course VARCHAR(50) NOT NULL,
    message TEXT,
    status ENUM('new', 'contacted', 'enrolled', 'closed') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_course (course),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
);

-- Courses table
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    duration VARCHAR(50),
    price DECIMAL(10,2),
    category VARCHAR(50),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_is_active (is_active)
);

-- Services table
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price_range VARCHAR(50),
    category VARCHAR(50),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_is_active (is_active)
);

-- Newsletter subscribers table
CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(100),
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE,
    INDEX idx_email (email),
    INDEX idx_is_active (is_active)
);

-- Testimonials table
CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    position VARCHAR(100),
    company VARCHAR(100),
    content TEXT NOT NULL,
    rating INT DEFAULT 5,
    is_featured BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_is_featured (is_featured),
    INDEX idx_is_active (is_active)
);

-- Blog posts table (for future blog functionality)
CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    content TEXT,
    excerpt TEXT,
    featured_image VARCHAR(255),
    author VARCHAR(100),
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_status (status),
    INDEX idx_published_at (published_at)
);

-- Insert sample courses
INSERT INTO courses (name, description, duration, price, category) VALUES
('Web Development Fundamentals', 'Learn HTML, CSS, JavaScript, PHP, and MySQL to build responsive websites', '3 months', 999.00, 'web-development'),
('Advanced Web Development', 'Master React, Node.js, and full-stack development', '4 months', 1499.00, 'web-development'),
('Mobile App Development', 'Build native and cross-platform mobile applications for iOS and Android using React Native and Flutter', '4 months', 1599.00, 'mobile-development'),
('Graphic Design Mastery', 'Create stunning visual designs using industry-standard tools and techniques for print and digital media', '2 months', 799.00, 'graphic-design'),
('Digital Marketing Strategy', 'Learn comprehensive digital marketing strategies including SEO, social media, and paid advertising', '2 months', 899.00, 'digital-marketing'),
('Video Production & Editing', 'Master video editing, motion graphics, and production techniques for professional video content', '3 months', 1199.00, 'video-production'),
('Data Science & Analytics', 'Learn data analysis, machine learning, and business intelligence using Python, R, and advanced analytics tools', '4 months', 1299.00, 'data-science'),
('UI/UX Design', 'Master user interface and user experience design principles and tools', '2 months', 899.00, 'ui-ux'),
('Cybersecurity Fundamentals', 'Learn essential cybersecurity concepts, ethical hacking, and security best practices', '3 months', 1199.00, 'cybersecurity'),
('Cloud Computing', 'Master AWS, Azure, and Google Cloud platforms for scalable applications', '3 months', 1299.00, 'cloud-computing'),
('DevOps & CI/CD', 'Learn DevOps practices, Docker, Kubernetes, and continuous integration/deployment', '2 months', 1099.00, 'devops'),
('Python Programming', 'Complete Python programming course from basics to advanced applications', '3 months', 899.00, 'programming'),
('Machine Learning', 'Advanced machine learning algorithms and AI applications', '4 months', 1499.00, 'machine-learning'),
('Blockchain Development', 'Learn blockchain technology, smart contracts, and cryptocurrency development', '3 months', 1399.00, 'blockchain'),
('Game Development', 'Create games using Unity, Unreal Engine, and modern game development tools', '4 months', 1299.00, 'game-development');

-- Insert sample services
INSERT INTO services (name, description, price_range, category) VALUES
('Custom Website Development', 'Responsive websites built with modern technologies', '$2,000 - $10,000', 'web-development'),
('E-commerce Solutions', 'Complete online store setup with payment integration', '$3,000 - $15,000', 'web-development'),
('Mobile App Development', 'Native and cross-platform mobile applications', '$5,000 - $25,000', 'mobile-development'),
('Digital Marketing Campaigns', 'SEO, PPC, and social media marketing', '$500 - $5,000/month', 'digital-marketing'),
('Graphic Design Services', 'Logo design, branding, and marketing materials', '$200 - $2,000', 'graphic-design'),
('Video Production', 'Corporate videos, commercials, and promotional content', '$1,000 - $10,000', 'video-production'),
('Data Analytics & Reporting', 'Business intelligence and data visualization solutions', '$1,500 - $8,000', 'data-science'),
('UI/UX Design Services', 'User interface and experience design for web and mobile', '$1,000 - $5,000', 'ui-ux'),
('Cybersecurity Audit', 'Security assessment and vulnerability testing', '$2,000 - $10,000', 'cybersecurity'),
('Cloud Migration', 'Move your applications to cloud platforms', '$3,000 - $15,000', 'cloud-computing'),
('DevOps Implementation', 'CI/CD pipeline setup and infrastructure automation', '$2,500 - $12,000', 'devops'),
('AI/ML Solutions', 'Machine learning models and AI integration', '$5,000 - $20,000', 'machine-learning'),
('Blockchain Development', 'Smart contracts and decentralized applications', '$8,000 - $30,000', 'blockchain'),
('Game Development', 'Custom game development for web and mobile', '$10,000 - $50,000', 'game-development'),
('IT Consulting', 'Technology strategy and digital transformation', '$150 - $300/hour', 'consulting'),
('Maintenance & Support', 'Ongoing technical support and maintenance', '$200 - $1,000/month', 'support');

-- Insert sample testimonials
INSERT INTO testimonials (name, position, company, content, rating, is_featured) VALUES
('Sarah Johnson', 'Web Developer', 'TechCorp', 'The web development course at M-Tech completely transformed my career. The instructors are knowledgeable and the hands-on approach helped me land my dream job.', 5, TRUE),
('Michael Chen', 'Digital Marketing Specialist', 'Digital Solutions Inc.', 'Excellent digital marketing training with practical projects. The job support team helped me secure multiple interview opportunities.', 5, TRUE),
('Emily Rodriguez', 'Creative Director', 'Design Studio Pro', 'The graphic design course exceeded my expectations. I now run my own design agency thanks to the skills I learned here.', 5, TRUE),
('David Kim', 'Full-Stack Developer', 'StartupXYZ', 'Outstanding curriculum and expert instructors. The full-stack development program prepared me perfectly for the job market.', 5, TRUE),
('Lisa Wang', 'Marketing Manager', 'Growth Co.', 'The digital marketing course provided real-world insights and practical skills that I use daily in my career.', 5, TRUE);

-- Create admin user table (for future admin panel)
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    role ENUM('admin', 'moderator') DEFAULT 'admin',
    is_active BOOLEAN DEFAULT TRUE,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_email (email)
);

-- Create course enrollments table
CREATE TABLE IF NOT EXISTS course_enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    student_email VARCHAR(100) NOT NULL,
    student_phone VARCHAR(20),
    course_id INT,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    payment_status ENUM('pending', 'paid', 'refunded') DEFAULT 'pending',
    payment_amount DECIMAL(10,2),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL,
    INDEX idx_student_email (student_email),
    INDEX idx_course_id (course_id),
    INDEX idx_status (status)
);

-- Create job placements table
CREATE TABLE IF NOT EXISTS job_placements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    student_email VARCHAR(100) NOT NULL,
    course_completed VARCHAR(100),
    company_name VARCHAR(100),
    job_title VARCHAR(100),
    salary_range VARCHAR(50),
    placement_date DATE,
    status ENUM('placed', 'interviewing', 'pending') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_student_email (student_email),
    INDEX idx_status (status)
);

-- Create instructors table
CREATE TABLE IF NOT EXISTS instructors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    specialization VARCHAR(100),
    experience_years INT,
    bio TEXT,
    profile_image VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_specialization (specialization)
);

-- Create course schedules table
CREATE TABLE IF NOT EXISTS course_schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    instructor_id INT,
    start_date DATE,
    end_date DATE,
    class_time VARCHAR(50),
    days_of_week VARCHAR(50),
    max_students INT DEFAULT 30,
    current_enrollments INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (instructor_id) REFERENCES instructors(id) ON DELETE SET NULL,
    INDEX idx_course_id (course_id),
    INDEX idx_start_date (start_date)
);

-- Create student projects table
CREATE TABLE IF NOT EXISTS student_projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    student_email VARCHAR(100) NOT NULL,
    project_title VARCHAR(200) NOT NULL,
    project_description TEXT,
    project_url VARCHAR(255),
    github_url VARCHAR(255),
    technologies_used TEXT,
    course_id INT,
    is_featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL,
    INDEX idx_student_email (student_email),
    INDEX idx_is_featured (is_featured)
);

-- Insert default admin user (password: admin123)
INSERT INTO admin_users (username, email, password_hash, full_name, role) VALUES
('admin', 'admin@mtechproduction.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'M-Tech Administrator', 'admin');

-- Insert sample instructors
INSERT INTO instructors (name, email, phone, specialization, experience_years, bio) VALUES
('Dr. Sarah Johnson', 'sarah.johnson@mtechproduction.com', '+1-555-0101', 'Web Development', 8, 'Expert in full-stack development with 8+ years of experience in modern web technologies.'),
('Michael Chen', 'michael.chen@mtechproduction.com', '+1-555-0102', 'Mobile Development', 6, 'Mobile app specialist with expertise in React Native, Flutter, and native iOS/Android development.'),
('Emily Rodriguez', 'emily.rodriguez@mtechproduction.com', '+1-555-0103', 'Graphic Design', 7, 'Creative director with extensive experience in UI/UX design and brand identity development.'),
('David Kim', 'david.kim@mtechproduction.com', '+1-555-0104', 'Data Science', 9, 'Data scientist and machine learning expert with PhD in Computer Science.'),
('Lisa Wang', 'lisa.wang@mtechproduction.com', '+1-555-0105', 'Digital Marketing', 5, 'Digital marketing strategist with proven track record in SEO, SEM, and social media marketing.'),
('James Wilson', 'james.wilson@mtechproduction.com', '+1-555-0106', 'Cybersecurity', 10, 'Cybersecurity expert and ethical hacker with certifications in CISSP and CEH.');

-- Insert sample course schedules
INSERT INTO course_schedules (course_id, instructor_id, start_date, end_date, class_time, days_of_week, max_students) VALUES
(1, 1, '2024-02-01', '2024-05-01', '6:00 PM - 8:00 PM', 'Monday, Wednesday, Friday', 25),
(2, 1, '2024-02-15', '2024-06-15', '7:00 PM - 9:00 PM', 'Tuesday, Thursday', 20),
(3, 2, '2024-03-01', '2024-07-01', '6:30 PM - 8:30 PM', 'Monday, Wednesday, Friday', 22),
(4, 3, '2024-02-10', '2024-04-10', '6:00 PM - 8:00 PM', 'Tuesday, Thursday', 18),
(5, 5, '2024-02-20', '2024-04-20', '7:00 PM - 9:00 PM', 'Monday, Wednesday', 20),
(6, 3, '2024-03-15', '2024-06-15', '6:30 PM - 8:30 PM', 'Tuesday, Thursday, Saturday', 15);

-- Insert sample job placements
INSERT INTO job_placements (student_name, student_email, course_completed, company_name, job_title, salary_range, placement_date, status) VALUES
('Alex Thompson', 'alex.thompson@email.com', 'Web Development', 'TechCorp Inc.', 'Frontend Developer', '$60,000 - $80,000', '2024-01-15', 'placed'),
('Maria Garcia', 'maria.garcia@email.com', 'Digital Marketing', 'Digital Solutions Ltd.', 'Marketing Specialist', '$50,000 - $70,000', '2024-01-20', 'placed'),
('John Smith', 'john.smith@email.com', 'Mobile Development', 'AppTech Co.', 'Mobile Developer', '$70,000 - $90,000', '2024-01-25', 'placed'),
('Sarah Davis', 'sarah.davis@email.com', 'Data Science', 'DataCorp Inc.', 'Data Analyst', '$65,000 - $85,000', '2024-02-01', 'placed'),
('Mike Johnson', 'mike.johnson@email.com', 'Graphic Design', 'Creative Studio', 'UI/UX Designer', '$55,000 - $75,000', '2024-02-05', 'placed');

-- Insert sample student projects
INSERT INTO student_projects (student_name, student_email, project_title, project_description, project_url, github_url, technologies_used, course_id, is_featured) VALUES
('Alex Thompson', 'alex.thompson@email.com', 'E-commerce Website', 'Full-stack e-commerce platform with payment integration', 'https://alex-ecommerce.com', 'https://github.com/alex/ecommerce', 'React, Node.js, MongoDB, Stripe', 1, TRUE),
('Maria Garcia', 'maria.garcia@email.com', 'Social Media Dashboard', 'Analytics dashboard for social media management', 'https://maria-dashboard.com', 'https://github.com/maria/dashboard', 'Vue.js, Python, Chart.js', 5, TRUE),
('John Smith', 'john.smith@email.com', 'Fitness Tracking App', 'Cross-platform mobile app for fitness tracking', 'https://play.google.com/store/apps/details?id=com.john.fitness', 'https://github.com/john/fitness-app', 'React Native, Firebase, Redux', 3, TRUE),
('Sarah Davis', 'sarah.davis@email.com', 'Predictive Analytics Tool', 'Machine learning tool for business predictions', 'https://sarah-analytics.com', 'https://github.com/sarah/analytics', 'Python, TensorFlow, Flask', 7, TRUE),
('Mike Johnson', 'mike.johnson@email.com', 'Portfolio Website', 'Creative portfolio showcasing design work', 'https://mike-portfolio.com', 'https://github.com/mike/portfolio', 'HTML, CSS, JavaScript, GSAP', 4, TRUE);

-- Create indexes for better performance
CREATE INDEX idx_contact_submissions_composite ON contact_submissions (status, created_at);
CREATE INDEX idx_courses_composite ON courses (category, is_active);
CREATE INDEX idx_services_composite ON services (category, is_active);
CREATE INDEX idx_testimonials_composite ON testimonials (is_featured, is_active);

-- Create views for common queries
CREATE VIEW active_courses AS
SELECT id, name, description, duration, price, category
FROM courses 
WHERE is_active = TRUE
ORDER BY name;

CREATE VIEW active_services AS
SELECT id, name, description, price_range, category
FROM services 
WHERE is_active = TRUE
ORDER BY name;

CREATE VIEW featured_testimonials AS
SELECT id, name, position, company, content, rating
FROM testimonials 
WHERE is_featured = TRUE AND is_active = TRUE
ORDER BY created_at DESC;

CREATE VIEW recent_contacts AS
SELECT id, name, email, course, created_at, status
FROM contact_submissions 
ORDER BY created_at DESC
LIMIT 50;

-- Grant permissions (adjust as needed for your setup)
-- GRANT ALL PRIVILEGES ON mtech_website.* TO 'mtech_user'@'localhost' IDENTIFIED BY 'secure_password';
-- FLUSH PRIVILEGES;
