# NextpayBank - A vulnerable banking application for security education

⚠️ WARNING: This project intentionally contains security vulnerabilities for educational purposes. Do NOT deploy on the open internet or in production. Run only in a controlled, isolated environment (local VM, sandbox, or lab network).

##Overview

NextPay Bank is a deliberately vulnerable web application designed for learning, practice, and security research. It intentionally includes common web vulnerabilities so students, security engineers, and penetration testers can safely practice discovery and remediation.

##Purpose

-Security education & awareness
-Penetration testing practice
=Demonstrations in labs / CTFs
-Developer training on secure coding and mitigation

## 🚨Features / Intentional Vulnerabilities
- **SQL Injection** — `login.php` (admin auth)
- **Stored XSS** — `contact.php` (feedback)
- **IDOR** — `invoices.php` (missing authorization)
- **Hardcoded secrets** — `config.php`

##Project layout

nextpay-bank/
├── config.php              # Database configuration & initialization (hardcoded secrets)
├── index.html              # Landing page
├── login.php               # Login page (SQL Injection vulnerability)
├── dashboard.php           # User dashboard
├── invoices.php            # Invoice viewer (IDOR)
├── contact.php             # Contact/feedback form (Stored XSS)
├── logout.php              # Logout handler
├── admin/
│   └── dashboard.php       # Admin panel
├── invoices/               # Invoice files directory
└── css/
    └── style.css           # Stylesheets

