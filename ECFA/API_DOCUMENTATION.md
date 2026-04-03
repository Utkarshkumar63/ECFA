# ECFA Backend API Documentation

## Overview
This is the Laravel backend for the East Champaran Fencing Association website. It provides RESTful APIs for managing players, events, achievements, news, gallery, and registrations.

**Base URL:** `http://localhost:8000/api`

---

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js (for frontend)

### Installation

1. **Clone and navigate to backend:**
   ```bash
   cd ECFA
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Configure environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Update .env file:**
   - Set `DB_DATABASE=ecfa_db`
   - Set `DB_USERNAME=root`
   - Set `DB_PASSWORD=` (if needed)
   - Set `APP_URL=http://localhost:8000`

5. **Create database and migrate:**
   ```bash
   php artisan migrate --seed
   ```

6. **Start the Laravel server:**
   ```bash
   php artisan serve
   ```

Server runs on: `http://localhost:8000`

---

## 🔐 Authentication

### Login (Get Token)
```
POST /api/auth/login
```

**Request Body:**
```json
{
  "email": "admin@ecfa.com",
  "password": "password"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "token": "1|abc123...",
  "user": {
    "id": 1,
    "name": "Admin User",
    "email": "admin@ecfa.com"
  }
}
```

### Default Admin Credentials
- **Email:** `admin@ecfa.com`
- **Password:** `password`

### Using Token for Protected Routes
Add header to all protected requests:
```
Authorization: Bearer {token}
```

---

## 📚 API Endpoints

### Players (खिलाड़ी)

#### Get All Players
```
GET /api/players
```
**Response:** List of all active players with details

#### Get Player by ID
```
GET /api/players/{id}
```
**Response:** Single player with achievements and events

#### Get Players by Category
```
GET /api/players/category/{category}
```
**Categories:** `U-8, U-10, U-12, U-14, U-16, U-18, Senior`

#### Get Players by Event Type
```
GET /api/players/event-type/{eventType}
```
**Event Types:** `Épée, Foil, Sabre`

#### Create Player (Admin Only)
```
POST /api/players
Headers: Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "name": "John Fencer",
  "date_of_birth": "2008-05-15",
  "gender": "Male",
  "email": "john@example.com",
  "phone": "9876543210",
  "address": "123 Main St, East Champaran",
  "category": "U-18",
  "event_type": "Épée",
  "bio": "Talented young fencer",
  "emergency_contact": "Jane Doe",
  "emergency_phone": "9876543220"
}
```

#### Update Player (Admin Only)
```
PUT /api/players/{id}
Headers: Authorization: Bearer {token}
```
*(Same fields as create)*

#### Delete Player (Admin Only)
```
DELETE /api/players/{id}
Headers: Authorization: Bearer {token}
```

---

### Events (समारोह/टूर्नामेंट)

#### Get All Events
```
GET /api/events
```

#### Get Upcoming Events
```
GET /api/events/upcoming
```

#### Get Past/Completed Events
```
GET /api/events/past
```

#### Get Event by ID
```
GET /api/events/{id}
```
**Response:** Event with participants, gallery, and registrations

#### Create Event (Admin Only)
```
POST /api/events
Headers: Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "title": "State Championship 2026",
  "description": "Annual state fencing championship",
  "event_date": "2026-05-15",
  "venue": "Sports Complex, Motihari",
  "venue_address": "Motihari, East Champaran",
  "start_time": "09:00",
  "end_time": "17:00",
  "status": "Upcoming",
  "max_participants": 100,
  "rules": "IFF rules apply",
  "is_registration_open": true,
  "registration_end_date": "2026-05-10"
}
```

#### Update Event (Admin Only)
```
PUT /api/events/{id}
Headers: Authorization: Bearer {token}
```

#### Delete Event (Admin Only)
```
DELETE /api/events/{id}
Headers: Authorization: Bearer {token}
```

**Status Options:** `Upcoming, Ongoing, Completed, Cancelled`

---

### Achievements (उपलब्धियां)

#### Get All Achievements
```
GET /api/achievements
```

#### Get Achievements by Player
```
GET /api/achievements/player/{playerId}
```

#### Get Achievements by Level
```
GET /api/achievements/level/{level}
```
**Levels:** `Local, Regional, State, National, International`

#### Get Achievements by Medal
```
GET /api/achievements/medal/{medal}
```
**Medals:** `Gold, Silver, Bronze, Certificate, Participation`

#### Create Achievement (Admin Only)
```
POST /api/achievements
Headers: Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "player_id": 1,
  "title": "Gold Medal - Épée Individual",
  "description": "Won gold in individual épée",
  "medal": "Gold",
  "level": "National",
  "achievement_date": "2025-11-10",
  "event_name": "National Championship 2025"
}
```

#### Update Achievement (Admin Only)
```
PUT /api/achievements/{id}
Headers: Authorization: Bearer {token}
```

#### Delete Achievement (Admin Only)
```
DELETE /api/achievements/{id}
Headers: Authorization: Bearer {token}
```

---

### News/Announcements (समाचार)

#### Get All Published News
```
GET /api/news
```

#### Get News by Type
```
GET /api/news/type/{type}
```
**Types:** `News, Announcement, Selection, Update`

#### Get News by ID
```
GET /api/news/{id}
```

#### Create News (Admin Only)
```
POST /api/news
Headers: Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "title": "Championship Registration Open",
  "content": "Registration for championship is now open...",
  "excerpt": "Short description",
  "type": "Announcement",
  "published_date": "2026-04-02",
  "is_published": true
}
```

#### Update News (Admin Only)
```
PUT /api/news/{id}
Headers: Authorization: Bearer {token}
```

#### Delete News (Admin Only)
```
DELETE /api/news/{id}
Headers: Authorization: Bearer {token}
```

---

### Gallery (गैलरी)

#### Get All Gallery Items
```
GET /api/gallery
```

#### Get Gallery by Type
```
GET /api/gallery/type/{type}
```
**Types:** `Image, Video`

#### Get Gallery by Event
```
GET /api/gallery/event/{eventId}
```

#### Get Gallery Item by ID
```
GET /api/gallery/{id}
```

#### Create Gallery Item (Admin Only)
```
POST /api/gallery
Headers: Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "title": "Championship Final match",
  "description": "Highlights from final",
  "media_type": "Image",
  "media_url": "https://example.com/image.jpg",
  "thumbnail_url": "https://example.com/thumb.jpg",
  "event_id": 1,
  "caption": "Final match in progress",
  "display_order": 1,
  "is_published": true
}
```

#### Update Gallery Item (Admin Only)
```
PUT /api/gallery/{id}
Headers: Authorization: Bearer {token}
```

#### Delete Gallery Item (Admin Only)
```
DELETE /api/gallery/{id}
Headers: Authorization: Bearer {token}
```

---

### Registrations (पंजीकरण)

#### Submit Registration (Public)
```
POST /api/registrations
```

**Request Body:**
```json
{
  "name": "Applicant Name",
  "date_of_birth": "2008-05-15",
  "gender": "Male",
  "email": "applicant@example.com",
  "phone": "9876543210",
  "address": "123 Main St",
  "category": "U-18",
  "event_type": "Épée",
  "event_id": 1
}
```

**Response:**
```json
{
  "success": true,
  "message": "Registration submitted successfully. Awaiting admin approval.",
  "data": {
    "id": 1,
    "status": "Pending",
    "created_at": "2026-04-02T..."
  }
}
```

#### Get All Registrations (Admin Only)
```
GET /api/registrations
Headers: Authorization: Bearer {token}
```

#### Get Pending Registrations (Admin Only)
```
GET /api/registrations/pending
Headers: Authorization: Bearer {token}
```

#### Get Registration by ID (Admin Only)
```
GET /api/registrations/{id}
Headers: Authorization: Bearer {token}
```

#### Approve Registration (Admin Only)
```
PUT /api/registrations/{id}/approve
Headers: Authorization: Bearer {token}
```

#### Reject Registration (Admin Only)
```
PUT /api/registrations/{id}/reject
Headers: Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "rejection_reason": "Reason for rejection"
}
```

#### Delete Registration (Admin Only)
```
DELETE /api/registrations/{id}
Headers: Authorization: Bearer {token}
```

---

### Dashboard (डैशबोर्ड)

#### Get Dashboard Statistics (Admin Only)
```
GET /api/dashboard/stats
Headers: Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "total_players": 50,
    "active_players": 48,
    "total_events": 10,
    "upcoming_events": 2,
    "completed_events": 8,
    "total_achievements": 25,
    "pending_registrations": 5,
    "approved_registrations": 30,
    "total_news": 20,
    "published_news": 18
  }
}
```

#### Get Pending Approvals (Admin Only)
```
GET /api/dashboard/pending-approvals
Headers: Authorization: Bearer {token}
```

#### Get Recent Activities (Admin Only)
```
GET /api/dashboard/recent-activities
Headers: Authorization: Bearer {token}
```

---

### Authentication

#### Change Password (Admin Only)
```
POST /api/auth/change-password
Headers: Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "old_password": "currentPassword",
  "new_password": "newPassword",
  "new_password_confirmation": "newPassword"
}
```

#### Update Profile (Admin Only)
```
PUT /api/auth/profile
Headers: Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "name": "Updated Name",
  "email": "newemail@example.com",
  "phone": "9876543210"
}
```

#### Get Current User (Admin Only)
```
GET /api/auth/me
Headers: Authorization: Bearer {token}
```

#### Logout (Admin Only)
```
POST /api/auth/logout
Headers: Authorization: Bearer {token}
```

---

## 💾 Database Schema

### Tables
- `users` - Admin users
- `players` - Registered fencers
- `events` - Tournaments and events
- `event_participants` - Player participation in events
- `achievements` - Medals and certificates
- `gallery` - Images and videos
- `news` - News and announcements
- `registrations` - Event registrations (pending approval)

---

## 🔧 Configuration

### CORS (Cross-Origin Requests)
Frontend should be allowed to make requests. Update in `config/cors.php`:
```php
'allowed_origins' => ['http://localhost:3000', 'http://localhost:8080'],
```

### Media Storage
Files are stored in `storage/app/public/`. Create symbolic link:
```bash
php artisan storage:link
```

---

## 🧪 Testing

Run migrations and seeders:
```bash
php artisan migrate:fresh --seed
```

This creates:
- 2 admin users
- 5 sample players
- 4 sample events
- 5 sample achievements
- 5 sample news items
- 4 gallery items

---

## 📋 Response Format

### Success Response
```json
{
  "success": true,
  "message": "Operation successful",
  "data": {}
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error message here"
}
```

---

## 🚨 Error Codes

- **200** - OK
- **201** - Created
- **400** - Bad Request (Validation error)
- **401** - Unauthorized (No token or invalid token)
- **404** - Not Found
- **500** - Server Error

---

## 📞 Contact

For issues or questions about the API, contact the development team.

---

## 📄 License

All rights reserved to East Champaran Fencing Association.
