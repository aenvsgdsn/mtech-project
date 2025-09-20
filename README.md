# M-Tech Production & Marketing Website

A modern, responsive website for an IT training and digital services institute. Built with HTML5, CSS3, JavaScript, PHP, and MySQL.

## Features

### Frontend
- **Modern Design**: Clean, professional layout with gradient backgrounds and smooth animations
- **Responsive**: Fully responsive design that works on all devices
- **Interactive Elements**: Smooth scrolling, hover effects, and animated counters
- **Contact Form**: Functional contact form with validation
- **Mobile Navigation**: Hamburger menu for mobile devices

### Backend
- **PHP Contact Handler**: Processes form submissions and stores in database
- **MySQL Database**: Stores contact submissions, courses, services, and testimonials
- **Admin Dashboard**: Complete admin panel for managing website content
- **Email Notifications**: Automatic email alerts for new contact submissions

### Key Sections
1. **Hero Section**: Eye-catching introduction with call-to-action buttons
2. **Statistics**: Animated counters showing achievements
3. **Courses**: Web development, graphic design, digital marketing, video production
4. **Services**: Website development, mobile apps, e-commerce, SEO, etc.
5. **About**: Institute strengths and technical expertise
6. **Testimonials**: Student success stories
7. **Contact**: Contact form and company information

## Technical Stack

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Libraries**: Font Awesome icons, Google Fonts
- **Features**: Responsive design, animations, form validation

## Installation

### Prerequisites
- XAMPP, WAMP, or similar local server environment
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web browser

### Setup Instructions

1. **Clone/Download** the project files to your web server directory
   ```
   C:\xampp\htdocs\mtechprojject\
   ```

2. **Database Setup**
   - Open phpMyAdmin or MySQL command line
   - Import the `database_setup.sql` file to create the database and tables
   - Or run the SQL commands manually

3. **Configuration**
   - Update `config.php` with your database credentials if needed
   - Default settings work with XAMPP default configuration

4. **Access the Website**
   - Open your browser and navigate to: `http://localhost/mtechprojject/`
   - For admin access: `http://localhost/mtechprojject/admin_login.php`

## File Structure

```
mtechprojject/
├── index.html              # Main website page
├── styles.css              # CSS styles and responsive design
├── script.js               # JavaScript functionality and animations
├── contact.php             # Contact form handler
├── config.php              # Database configuration
├── database_setup.sql      # Database schema and sample data
├── admin_dashboard.php     # Admin panel dashboard
├── admin_login.php         # Admin login page
├── admin_logout.php        # Admin logout handler
└── README.md               # This file
```

## Admin Panel

### Access
- URL: `http://localhost/mtechprojject/admin_login.php`
- Username: `admin`
- Password: `admin123`

### Features
- View contact submissions
- Course interest statistics
- Website overview dashboard
- Manage content (future enhancement)

## Customization

### Colors and Branding
- Update CSS variables in `styles.css` for color scheme
- Modify logo and company information in `index.html`
- Update contact information in footer and contact section

### Content Management
- Edit course information in the database
- Update testimonials through the database
- Modify services and pricing information

### Email Configuration
- Update email settings in `config.php`
- Configure SMTP settings for production use
- Customize email templates in `contact.php`

## Database Schema

### Tables
- `contact_submissions`: Stores form submissions
- `courses`: Course information and pricing
- `services`: Service offerings and details
- `testimonials`: Student testimonials
- `newsletter_subscribers`: Email subscribers
- `admin_users`: Admin user accounts
- `blog_posts`: Blog functionality (future)

## Browser Support

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+
- Mobile browsers (iOS Safari, Chrome Mobile)

## Performance Features

- Optimized images and assets
- Minified CSS and JavaScript (for production)
- Efficient database queries
- Responsive image loading
- Smooth animations and transitions

## Security Features

- Input validation and sanitization
- SQL injection prevention with prepared statements
- XSS protection
- CSRF token implementation
- Secure password hashing

## Future Enhancements

- Blog system
- Course enrollment system
- Payment integration
- Student portal
- Advanced admin features
- Multi-language support
- SEO optimization tools

## Support

For technical support or questions about this website, please contact:
- Email: info@mtechproduction.com
- Phone: +1 (555) 123-4567

## License

This project is created for M-Tech Production & Marketing. All rights reserved.

---

**M-Tech Production & Marketing** - Empowering careers through quality IT education and digital services.
