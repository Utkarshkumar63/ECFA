Frontend Setup Guide
====================

OVERVIEW
--------
The ECFA website is now fully integrated with the Laravel backend API. All pages dynamically fetch data from the backend instead of using static content.

FRONTEND FILE STRUCTURE
-----------------------
Frontend/
├── css/
│   └── style.css          - Main stylesheet with responsive design
├── js/
│   ├── api-client.js      - API client wrapper (50+ methods)
│   ├── script.js          - Common utilities and helpers
│   └── form-validation.js - Registration form validation
├── index.html             - Home page with dashboard
├── members-players.html   - Player directory with filters
├── events.html            - Event listing (upcoming/past)
├── achivements.html       - Achievements/medals showcase
├── gallery.html           - Image gallery
├── news.html              - News and announcements
├── registration.html      - Player registration form
├── about-us.html          - About ECFA
├── contact-us.html        - Contact page
├── admin-login.html       - Admin authentication
└── admin-dashboard.html   - Admin control panel

KEY FEATURES
------------

1. RESPONSIVE DESIGN
   - Mobile-first approach
   - Flexbox and CSS Grid layouts
   - Mobile menu hamburger for small screens
   - Touch-friendly interface

2. API INTEGRATION
   - All data fetched dynamically from backend
   - Automatic token management (localStorage)
   - Bearer token authentication
   - Error handling and user feedback

3. DYNAMIC CONTENT
   - Auto-loading data from API
   - Real-time filtering and search
   - Lightbox for gallery images
   - Modal dialogs for additional info

4. ADMIN PANEL
   - Secure login with JWT tokens
   - Dashboard with statistics
   - Registration approval workflow
   - Content management links

API CONFIGURATION
-----------------
Backend URL: http://localhost:8000/api

The API client automatically includes:
- Authorization: Bearer {token} header
- Content-Type: application/json
- Error handling and retry logic
- Token refresh on 401 responses

If you need to change the API URL, edit:
  js/api-client.js → Line 1: const API_BASE_URL = ...

PAGES OVERVIEW
--------------

PUBLIC PAGES:
1. index.html
   - Shows dashboard with latest news, events, achievements, gallery
   - Dynamic stat cards for players, events, achievements
   - API calls: getNews(), getEvents(), getAchievements(), getGallery()

2. members-players.html
   - Lists all registered players
   - Filters by name, event type, category
   - API calls: getPlayers()

3. events.html
   - Shows upcoming and past events
   - Filters by date
   - Tab navigation between upcoming/past
   - API calls: getEvents()

4. achivements.html
   - Medal showcase with stats
   - Filter by level and medal type
   - Dynamic medal counters
   - API calls: getAchievements()

5. gallery.html
   - Image gallery with lightbox
   - Click images to open in full screen
   - API calls: getGallery()

6. news.html
   - News and announcements list
   - Search and filter by type
   - API calls: getNews()

7. registration.html
   - Player registration form
   - Client-side validation
   - API submission: submitRegistration()
   - Success/error messages

8. about-us.html (Static)
   - Association information
   - Vision, mission, objectives
   - Committee members
   - No API calls needed

9. contact-us.html (Static)
   - Contact information
   - Location map
   - Contact form
   - No API calls needed (form can be submitted if backend has endpoint)

ADMIN PAGES:
1. admin-login.html
   - Email and password authentication
   - Calls: ApiClient.login(email, password)
   - Stores token in localStorage
   - Redirects to dashboard on success

2. admin-dashboard.html
   - Dashboard with statistics
   - Quick action cards
   - Pending registrations list
   - Approve/reject registrations
   - Calls: getDashboardStats(), pendingRegistrations()

JAVASCRIPT UTILITIES (script.js)
--------------------------------
Helper Functions:
- showLoading(element) - Display loading spinner
- showError(element, msg) - Show error message
- emptyStateMessage(element, msg) - Show empty state
- showAlert(msg, type) - Toast notification
- formatDate(dateString) - Format dates
- debounce(func, delay) - Debounce function calls
- openLightbox(imageSrc) - Open image lightbox
- closeLightbox() - Close lightbox
- logout() - Admin logout
- getFormData(form) - Get form data as object
- validateEmail(email) - Email validation
- validatePhone(phone) - Phone validation
- And more...

API CLIENT (api-client.js)
--------------------------
50+ Methods Available:

// Authentication
- login(email, password)
- logout()
- getCurrentUser()
- changePassword(oldPassword, newPassword)

// Players
- getPlayers()
- getPlayer(id)
- createPlayer(data)
- updatePlayer(id, data)
- deletePlayer(id)

// Events
- getEvents()
- getUpcomingEvents()
- getPastEvents()
- createEvent(data)
- updateEvent(id, data)
- deleteEvent(id)

// Achievements
- getAchievements()
- createAchievement(data)
- updateAchievement(id, data)
- deleteAchievement(id)

// News
- getNews()
- createNews(data)
- updateNews(id, data)
- deleteNews(id)

// Gallery
- getGallery()
- uploadGallery(formData)
- deleteGallery(id)

// Registrations
- submitRegistration(data)
- pendingRegistrations()
- approveRegistration(id)
- rejectRegistration(id)

// Dashboard
- getDashboardStats()
- getPendingApprovals()

FORM VALIDATION (form-validation.js)
------------------------------------
Registration Form Validation:
- Name: minimum 3 characters
- Date of Birth: calculates age (minimum 8 years)
- Email: valid email format
- Phone: 10 digits
- Address: required
- Category: required (Épée/Foil/Sabre)
- Age Group: required

API Integration:
- On submit, calls ApiClient.submitRegistration()
- Displays success/error message
- Form resets on successful submission
- Handles validation errors from backend

STYLING & CUSTOMIZATION
-----------------------
CSS Variables (style.css):
--primary-color: #006B9E (ECFA Blue)
--secondary-color: #FF6B35 (Orange)
--success-color: #28a745
--danger-color: #dc3545
--light-color: #f8f9fa
--dark-color: #343a40

To customize:
1. Edit :root section in style.css
2. Responsive breakpoints: 768px, 480px
3. All colors, fonts, spacing can be modified

RESPONSIVE DESIGN
-----------------
Mobile First Approach:
- Default: Mobile layout
- 768px+: Desktop layout with multi-column grids
- 480px: Extra-small devices adjustments

Key Classes:
- .container: Max-width 1200px, centered
- .nav-menu: Hamburger menu on mobile
- .hero-banner: Full-width hero section
- .card: Reusable card component
- .btn: Button styling

TROUBLESHOOTING
---------------

1. API Not Responding
   - Check backend is running: http://localhost:8000
   - Verify CORS is enabled in backend
   - Check network tab in browser dev tools

2. Login Not Working
   - Verify credentials: admin@ecfa.com / password
   - Check localStorage for token storage
   - Clear browser cache and try again

3. Form Submission Fails
   - Check console for validation errors
   - Ensure all required fields are filled
   - Verify backend validation rules

4. Images Not Loading
   - Check gallery API returns valid URLs
   - Ensure images are accessible
   - Check browser console for 404 errors

5. Navigation Not Working
   - Clear browser cache
   - Ensure JavaScript files are loaded
   - Check file paths in links

DEPLOYMENT
----------

Before deploying to production:
1. Update API_BASE_URL in api-client.js
2. Update all mailto and tel links
3. Optimize images for web
4. Minify CSS and JavaScript
5. Test all API endpoints
6. Enable HTTPS for secure admin panel
7. Set up proper CORS headers

TESTING CREDENTIALS
-------------------
Admin Login:
Email: admin@ecfa.com
Password: password

Default Endpoint:
http://localhost:8000/api

BROWSER SUPPORT
---------------
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers (iOS Safari, Chrome Mobile)

PERFORMANCE TIPS
----------------
1. Images are lazy-loaded in galleries
2. Debounced search/filter functions
3. CSS is organized for fast loading
4. JavaScript is split for different pages
5. Use browser cache for static assets

ACCESSIBILITY
--------------
- Semantic HTML structure
- ARIA labels where needed
- Keyboard navigation support
- Sufficient color contrast
- Form labels clearly associated with inputs
- Hero banner has alt text

FUTURE ENHANCEMENTS
-------------------
1. Create admin CRUD pages (admin-players.html, admin-events.html, etc.)
2. Add PWA functionality for offline support
3. Implement real-time notifications
4. Add export to CSV/PDF features
5. Implement user profiles and settings
6. Add email notifications
7. Mobile app development

SUPPORT
-------
For issues or questions, contact:
Email: support@ecfa.org
Phone: +91-XXXXXXXXXX

Last Updated: 2026
Version: 1.0
