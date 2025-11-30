# 🔌 POWP ERP – Backend API (Laravel)

# POWP ERP

This repository contains the official API of the POWP ERP, a modular system designed for freelancers, small businesses, and medium-sized companies seeking organization, efficiency, and productivity in their daily operations.

The API was built using Laravel, providing a secure, scalable, and flexible backend to support all POWP ERP modules.

🔗 Front-end Repository

👉 https://github.com/oPortela/POWP

🌐 Landing Page

👉 https://oportela.github.io/POWP/Powp/index.html

---

## 🚀 About POWP ERP
POWP ERP is a modular system where each user selects only the modules that fit their business needs.
Our goal is to deliver a system that is:

- Simple to use
- Intuitive in its workflow
- Modular and fully customizable
- Secure, scalable, and ready to grow with your company

---

##✨ What This API Does
The Laravel API is responsible for:

- 🔐 User authentication & account management
- 🗂️ Data processing for ERP modules
- 🔄 Communication with Supabase via REST API
- 📦 Structured responses for the front-end
- 🧱 REST architecture with modern best practices
- 📜 Centralized business logic, validation, and logging

---

## 🛠️ Technologies Used
- PHP / Laravel <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-plain.svg" width="35"/> <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-plain.svg" width="35"/>
- Supabase (PostgreSQL via REST API) <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/postgresql/postgresql-original.svg" width="35"/>
- JWT / Sanctum Authentication
- MVC Architecture
- RESTful API Design

---

## 🚀 Installation and Setup

**Requirements**
- PHP 8.1+
- Composer
- Laravel 10+
- Supabase project configured
- Supabase REST API keys

**Steps**
1. Clone the repository:
   ```bash
   git clone https://github.com/oPortela/POWP-laravel.git
   cd POWP-laravel
   ```

2. Install dependencies
   ```bash
   composer install
   ```

3. Configure your .env file
   Create or edit the .env file:
   ```bash
   nAPP_NAME=POWP
   APP_ENV=local
   APP_KEY=base64:xxxxxx
   APP_DEBUG=true
   APP_URL=http://localhost:8000
    
   # Supabase (REST API)
   SUPABASE_URL=https://xxxx.supabase.co
   SUPABASE_KEY=public_key
   SUPABASE_SERVICE_KEY=private_service_key_if_needed
   ```

5. Generate the application key
   ```bash
   php artisan key:generate
   ```

7. Run the server:
   ```bash
   php artisan serve
   ```
- Your API will be available at:

- 👉 http://localhost:8000

---

##📡 Endpoints
Full endpoint documentation will be added soon (Swagger / API Documentation).
If you want, I can generate it automatically for you.

---

## 🤝 Contribution

Contributions are always welcome!  
Feel free to open issues, submit pull requests, or suggest improvements.

1. Fork the project.
2. Create a branch for your feature:
   ```bash
   git checkout -b my-feature
   ```
3. Commit your changes:
   ```bash
   git commit -m 'feat: New update'
   ```
4. Push to your fork:
   ```bash
   git push origin my-feature
   ```
5. Open a Pull Request.

---

## 👨‍💻 Development Team

- Matheus Marques Portela (BackEnd and DBA)
- João Luccas Marques (QA)
- Marcos Paulo Moreira Damascena (FrontEnd)
- Victor Manuel de Moraes (FrontEnd)
- Victo Duarte Madaleno (FrontEnd)
- Pedro Echebarria (Design and PO)

---

## 📄 License

This project is licensed under the MIT License — see the LICENSE file for details.
