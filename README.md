# 🌱 EcoVault  

![Laravel](https://img.shields.io/badge/Laravel-10.x-red?logo=laravel)  
![PHP](https://img.shields.io/badge/PHP-^8.1-blue?logo=php)  
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange?logo=mysql)  
![License](https://img.shields.io/badge/License-DENR-green)  

EcoVault is a **web-based document archiving system** for the **Department of Environment and Natural Resources (DENR)**.  
It helps in organizing, storing, and retrieving documents efficiently in a secure and accessible way.  

---

## ✨ Features
- 📂 Archive and manage DENR-related documents  
- 🔍 Search and filter documents by metadata  
- 👥 Role-based access for secure document handling  
- 📊 Simple dashboard for quick insights  
- ☁️ Deployable on both **Hostinger** and other Laravel-supported hosting platforms  

---

## 🛠️ Tech Stack
- **Backend:** Laravel (PHP Framework)  
- **Database:** MySQL  
- **Hosting:** Hostinger / Generic Laravel-supported servers  

---

## 🚀 Getting Started

### Prerequisites
Make sure you have installed:
- PHP >= 8.1  
- Composer  
- MySQL >= 5.7  
- Node.js & NPM 

### Installation

1. Clone the repository  
   git clone https://github.com/penromarinduque/ecovault.git  
   cd ecovault  

2. Install dependencies  
   composer install  
   npm install && npm run dev  

3. Environment setup  
   Copy `.env.example` to `.env` and update your database credentials:  
   cp .env.example .env  
   php artisan key:generate  

4. Run migrations  
   php artisan migrate --seed  

5. Start the server  
   php artisan serve  
   Visit: http://localhost:8000  

---

## 📦 Deployment
EcoVault can be deployed on:  
- **Hostinger** → Upload the project, configure `.env`, and point the domain to `public/`.  
- **Generic Laravel-supported host** → Same steps apply, ensure correct PHP & MySQL versions.  

---

## 👩‍💻 Developers
This project was created by Jastine Siena et. al. and later utilized by DENR - PENRO Marinduque
---

## 🤝 Contributing
We welcome contributions!  
1. Fork the repository  
2. Create your feature branch (git checkout -b feature/amazing-feature)  
3. Commit your changes (git commit -m 'Add amazing feature')  
4. Push to the branch (git push origin feature/amazing-feature)  
5. Open a Pull Request  

---

## 📄 License
This project is intended for DENR use.  
For other usage, please contact the maintainers.  
