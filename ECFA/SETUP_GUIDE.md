# Backend Setup Guide - ECFA

## ✅ What's Been Created

A complete **Laravel backend** with all necessary components:

✅ **8 Database Migrations** for tables:
- users, players, events, achievements, gallery, news, registrations, event_participants

✅ **7 Eloquent Models** with relationships:
- User, Player, Event, Achievement, Gallery, News, Registration

✅ **7 API Controllers** with full CRUD:
- PlayerController, EventController, AchievementController, NewsController, GalleryController, RegistrationController, AuthController, DashboardController

✅ **Comprehensive Routing** with 40+ API endpoints:
- Public endpoints for browsing content
- Protected admin endpoints with Sanctum authentication

✅ **Database Seeders** with sample data:
- 2 admin users, 5 players, 4 events, 5 achievements, 5 news items, 4 gallery items

✅ **Complete API Documentation** - See `API_DOCUMENTATION.md`

---

## 🚀 Quick Setup Steps

### 1. Navigate to Backend
```bash
cd /Users/anshikakumari/Desktop/ECFA/ECFA
```

### 2. Create MySQL Database
```sql
CREATE DATABASE ecfa_db;
```

### 3. Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```

Update `.env`:
```
APP_URL=http://localhost:8000
DB_DATABASE=ecfa_db
DB_USERNAME=root
DB_PASSWORD=  # (leave blank if no password)
```

### 4. Run Migrations & Seeders
```bash
php artisan migrate --seed
```

This creates all tables with sample data.

### 5. Start Laravel Server
```bash
php artisan serve
```

Server runs on: **http://localhost:8000**

---

## 🔐 Default Admin Accounts

| Email | Password |
|-------|----------|
| admin@ecfa.com | password |
| manager@ecfa.com | password |

---

## 🎯 API Base URL

```
http://localhost:8000/api
```

All API endpoints use this base URL.

---

## 📱 Frontend Integration

When building your frontend, configure API calls to:

```javascript
const API_BASE_URL = 'http://localhost:8000/api';

// Example: Get all players
fetch(`${API_BASE_URL}/players`)
  .then(res => res.json())
  .then(data => console.log(data));

// Example: Login
fetch(`${API_BASE_URL}/auth/login`, {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    email: 'admin@ecfa.com',
    password: 'password'
  })
})
.then(res => res.json())
.then(data => {
  // Save token: localStorage.setItem('token', data.token);
});

// Example: Protected endpoint (with token)
fetch(`${API_BASE_URL}/dashboard/stats`, {
  headers: {
    'Authorization': `Bearer ${token}`
  }
})
.then(res => res.json())
.then(data => console.log(data));
```

---

## 📚 Key Endpoints

### Public (No Auth Required)
- `GET /api/players` - All players
- `GET /api/events` - All events
- `GET /api/events/upcoming` - Upcoming events
- `GET /api/news` - All news
- `GET /api/achievements` - All achievements
- `GET /api/gallery` - All gallery items
- `POST /api/registrations` - Submit registration

### Admin (Auth Required)
- `POST /api/auth/login` - Get token
- `POST /api/players` - Create player
- `PUT /api/players/{id}` - Update player
- `PUT /api/registrations/{id}/approve` - Approve registration
- `GET /api/dashboard/stats` - Dashboard statistics

**See [API_DOCUMENTATION.md](API_DOCUMENTATION.md) for complete endpoint list**

---

## 🎨 Frontend Structure

Your frontend should be in `/Users/anshikakumari/Desktop/ECFA/Frontend/` with:

```
Frontend/
├── index.html
├── about-us.html
├── members-players.html
├── events.html
├── achievements.html
├── gallery.html
├── registration.html
├── news.html
├── contact-us.html
├── admin-login.html
├── admin-dashboard.html
├── css/
│   ├── style.css
│   └── responsive.css
├── js/
│   ├── script.js
│   ├── form-validation.js
│   └── api-client.js
└── assets/
    ├── images/
    ├── videos/
    └── icons/
```

---

## 🔗 API Structure

### Authentication Flow
1. User submits login form
2. Frontend sends `POST /api/auth/login`
3. Backend returns token
4. Frontend stores token in localStorage
5. All future requests include: `Authorization: Bearer {token}`

### Registration Approval Flow
1. User submits registration via `POST /api/registrations`
2. Status set to "Pending"
3. Admin views pending in dashboard
4. Admin clicks "Approve" → `PUT /api/registrations/{id}/approve`
5. Status changes to "Approved"

---

## 📦 Create Storage Link

Make uploaded files accessible:
```bash
php artisan storage:link
```

---

## 🧹 Database Reset (if needed)

```bash
php artisan migrate:refresh --seed
```

This resets and reseeds the database.

---

## ✨ Next Steps

1. **Update Frontend** to use these API endpoints
2. **Create API client** in frontend JavaScript for cleaner API calls
3. **Implement authentication** flow in admin pages
4. **Add image upload** functionality for events, news, gallery
5. **Test all endpoints** with Postman or similar tool

---

## 📞 Quick Reference

| Task | Command |
|------|---------|
| Start server | `php artisan serve` |
| Run migrations | `php artisan migrate` |
| Add seed data | `php artisan migrate --seed` |
| Create model | `php artisan make:model ModelName` |
| Create controller | `php artisan make:controller Api/ControllerName` |
| Reset DB | `php artisan migrate:refresh --seed` |

---

**Backend is ready! Now build the amazing frontend! 🚀**
