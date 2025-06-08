# Ivox Car Rental

**Ivox Car Rental** is a single-page, mobile-friendly car rental web application developed as a course project for *Introduction to Web Programming*. The app enables users to register, browse and book cars, while administrators can manage cars, users, and bookings. The project follows a modern web development architecture using a PHP, JavaScript, and MySQL tech stack, with strict separation between frontend and backend.

## 🌐 Live Demo

> Will be added [Issue with renewing GitHub Student Develepor Pack]

---

## 🧰 Technologies Used

- **Frontend**: HTML, CSS, JavaScript, Bootstrap, jQuery
- **Backend**: PHP (FlightPHP framework)
- **Database**: MySQL (with PHP PDO)
- **API Docs**: OpenAPI/Swagger
- **Authentication**: JWT (JSON Web Tokens)
- **Communication**: AJAX requests (using jQuery)

---

## 📦 Project Features

- ✅ Single Page Application (SPA)
- ✅ Mobile-friendly design using Bootstrap
- ✅ Clean separation of backend and frontend logic
- ✅ REST API implemented using FlightPHP
- ✅ CRUD operations for 5 entities
- ✅ Secure authentication with JWT
- ✅ AJAX-based dynamic data loading
- ✅ API documented using OpenAPI
- ✅ Two user roles: Admin and Customer
- ✅ Responsive design with HTML templates

---

## 🗃️ Main Entities and CRUD Support

The system manages five main entities with full CRUD functionality:

1. **Users** – Registration, login, update profile, role-based access
2. **Cars** – Admin adds, edits, deletes; users view and book
3. **Bookings** – Bookings are handled and associated with users
4. **Forms** – Contact forms submitted and stored
5. **Payments** – Implemented at structure level but not fully connected with bookings

---

## ⚠ Known Limitation

While the core functionality was successfully implemented, the **integration between booking and payment** was not finalized due to unforeseen complexity in logic and time constraints. The database schema and partial code for payments exist, and the application is designed for future integration of this feature.

---

## 🛠️ How to Run the Project Locally

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/najtms/introductionToWeb.git
   cd ivox-car-rental
---

## 👨‍💻 Author

Muhamad Assaad
International Burch University
GitHub: https://github.com/najtms