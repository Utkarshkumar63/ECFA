/**
 * ECFA API Client
 * Handles all API communication with Laravel backend
 * 
 * Usage:
 * import ApiClient from './api-client.js';
 * await ApiClient.getPlayers();
 */

const API_BASE_URL = 'http://localhost:8001/api';

class ApiClient {
  /**
   * Get token from localStorage
   */
  static getToken() {
    return localStorage.getItem('ecfa_token');
  }

  /**
   * Set token in localStorage
   */
  static setToken(token) {
    localStorage.setItem('ecfa_token', token);
  }

  /**
   * Remove token from localStorage
   */
  static clearToken() {
    localStorage.removeItem('ecfa_token');
  }

  /**
   * Get authorization headers
   */
  static getHeaders(needsAuth = false) {
    const headers = {
      'Content-Type': 'application/json',
    };

    if (needsAuth) {
      const token = this.getToken();
      if (token) {
        headers['Authorization'] = `Bearer ${token}`;
      }
    }

    return headers;
  }

  /**
   * Make API request
   */
  static async request(endpoint, method = 'GET', data = null, needsAuth = false) {
    try {
      const url = `${API_BASE_URL}${endpoint}`;
      const options = {
        method,
        headers: this.getHeaders(needsAuth),
      };

      if (data) {
        options.body = JSON.stringify(data);
      }

      const response = await fetch(url, options);
      const result = await response.json();

      if (!response.ok) {
        throw new Error(result.message || `Error: ${response.status}`);
      }

      return result;
    } catch (error) {
      console.error('API Error:', error);
      throw error;
    }
  }

  // ==================== AUTHENTICATION ====================

  /**
   * Login - Get authentication token
   */
  static async login(email, password) {
    const result = await this.request('/auth/login', 'POST', {
      email,
      password,
    });
    if (result.success) {
      this.setToken(result.token);
    }
    return result;
  }

  /**
   * Logout
   */
  static async logout() {
    const result = await this.request('/auth/logout', 'POST', null, true);
    this.clearToken();
    return result;
  }

  /**
   * Get current user
   */
  static async getCurrentUser() {
    return this.request('/auth/me', 'GET', null, true);
  }

  // ==================== PLAYERS ====================

  /**
   * Get all players
   */
  static async getPlayers() {
    return this.request('/players');
  }

  /**
   * Get player by ID
   */
  static async getPlayer(id) {
    return this.request(`/players/${id}`);
  }

  /**
   * Get players by category
   */
  static async getPlayersByCategory(category) {
    return this.request(`/players/category/${category}`);
  }

  /**
   * Get players by event type
   */
  static async getPlayersByEventType(eventType) {
    return this.request(`/players/event-type/${eventType}`);
  }

  /**
   * Create player (Admin)
   */
  static async createPlayer(playerData) {
    return this.request('/players', 'POST', playerData, true);
  }

  /**
   * Update player (Admin)
   */
  static async updatePlayer(id, playerData) {
    return this.request(`/players/${id}`, 'PUT', playerData, true);
  }

  /**
   * Delete player (Admin)
   */
  static async deletePlayer(id) {
    return this.request(`/players/${id}`, 'DELETE', null, true);
  }

  // ==================== EVENTS ====================

  /**
   * Get all events
   */
  static async getEvents() {
    return this.request('/events');
  }

  /**
   * Get upcoming events
   */
  static async getUpcomingEvents() {
    return this.request('/events/upcoming');
  }

  /**
   * Get past events
   */
  static async getPastEvents() {
    return this.request('/events/past');
  }

  /**
   * Get event by ID
   */
  static async getEvent(id) {
    return this.request(`/events/${id}`);
  }

  /**
   * Create event (Admin)
   */
  static async createEvent(eventData) {
    return this.request('/events', 'POST', eventData, true);
  }

  /**
   * Update event (Admin)
   */
  static async updateEvent(id, eventData) {
    return this.request(`/events/${id}`, 'PUT', eventData, true);
  }

  /**
   * Delete event (Admin)
   */
  static async deleteEvent(id) {
    return this.request(`/events/${id}`, 'DELETE', null, true);
  }

  // ==================== ACHIEVEMENTS ====================

  /**
   * Get all achievements
   */
  static async getAchievements() {
    return this.request('/achievements');
  }

  /**
   * Get achievements by player
   */
  static async getPlayerAchievements(playerId) {
    return this.request(`/achievements/player/${playerId}`);
  }

  /**
   * Get achievements by level
   */
  static async getAchievementsByLevel(level) {
    return this.request(`/achievements/level/${level}`);
  }

  /**
   * Get achievements by medal
   */
  static async getAchievementsByMedal(medal) {
    return this.request(`/achievements/medal/${medal}`);
  }

  /**
   * Create achievement (Admin)
   */
  static async createAchievement(achievementData) {
    return this.request('/achievements', 'POST', achievementData, true);
  }

  /**
   * Update achievement (Admin)
   */
  static async updateAchievement(id, achievementData) {
    return this.request(`/achievements/${id}`, 'PUT', achievementData, true);
  }

  /**
   * Delete achievement (Admin)
   */
  static async deleteAchievement(id) {
    return this.request(`/achievements/${id}`, 'DELETE', null, true);
  }

  // ==================== NEWS ====================

  /**
   * Get all news
   */
  static async getNews() {
    return this.request('/news');
  }

  /**
   * Get news by type
   */
  static async getNewsByType(type) {
    return this.request(`/news/type/${type}`);
  }

  /**
   * Get news by ID
   */
  static async getNewsItem(id) {
    return this.request(`/news/${id}`);
  }

  /**
   * Create news (Admin)
   */
  static async createNews(newsData) {
    return this.request('/news', 'POST', newsData, true);
  }

  /**
   * Update news (Admin)
   */
  static async updateNews(id, newsData) {
    return this.request(`/news/${id}`, 'PUT', newsData, true);
  }

  /**
   * Delete news (Admin)
   */
  static async deleteNews(id) {
    return this.request(`/news/${id}`, 'DELETE', null, true);
  }

  // ==================== GALLERY ====================

  /**
   * Get all gallery items
   */
  static async getGallery() {
    return this.request('/gallery');
  }

  /**
   * Get gallery by type
   */
  static async getGalleryByType(type) {
    return this.request(`/gallery/type/${type}`);
  }

  /**
   * Get gallery by event
   */
  static async getGalleryByEvent(eventId) {
    return this.request(`/gallery/event/${eventId}`);
  }

  /**
   * Get gallery item by ID
   */
  static async getGalleryItem(id) {
    return this.request(`/gallery/${id}`);
  }

  /**
   * Create gallery item (Admin)
   */
  static async createGalleryItem(galleryData) {
    return this.request('/gallery', 'POST', galleryData, true);
  }

  /**
   * Update gallery item (Admin)
   */
  static async updateGalleryItem(id, galleryData) {
    return this.request(`/gallery/${id}`, 'PUT', galleryData, true);
  }

  /**
   * Delete gallery item (Admin)
   */
  static async deleteGalleryItem(id) {
    return this.request(`/gallery/${id}`, 'DELETE', null, true);
  }

  // ==================== REGISTRATIONS ====================

  /**
   * Submit registration (Public)
   */
  static async submitRegistration(registrationData) {
    return this.request('/registrations', 'POST', registrationData);
  }

  /**
   * Get all registrations (Admin)
   */
  static async getRegistrations() {
    return this.request('/registrations', 'GET', null, true);
  }

  /**
   * Get pending registrations (Admin)
   */
  static async getPendingRegistrations() {
    return this.request('/registrations/pending', 'GET', null, true);
  }

  /**
   * Get registration by ID (Admin)
   */
  static async getRegistration(id) {
    return this.request(`/registrations/${id}`, 'GET', null, true);
  }

  /**
   * Get registrations by event (Admin)
   */
  static async getRegistrationsByEvent(eventId) {
    return this.request(`/registrations/event/${eventId}`, 'GET', null, true);
  }

  /**
   * Approve registration (Admin)
   */
  static async approveRegistration(id) {
    return this.request(`/registrations/${id}/approve`, 'PUT', {}, true);
  }

  /**
   * Reject registration (Admin)
   */
  static async rejectRegistration(id, rejectionReason) {
    return this.request(`/registrations/${id}/reject`, 'PUT', {
      rejection_reason: rejectionReason,
    }, true);
  }

  /**
   * Delete registration (Admin)
   */
  static async deleteRegistration(id) {
    return this.request(`/registrations/${id}`, 'DELETE', null, true);
  }

  // ==================== DASHBOARD ====================

  /**
   * Get dashboard statistics (Admin)
   */
  static async getDashboardStats() {
    return this.request('/dashboard/stats', 'GET', null, true);
  }

  /**
   * Get pending approvals (Admin)
   */
  static async getPendingApprovals() {
    return this.request('/dashboard/pending-approvals', 'GET', null, true);
  }

  /**
   * Get recent activities (Admin)
   */
  static async getRecentActivities() {
    return this.request('/dashboard/recent-activities', 'GET', null, true);
  }
}

export default ApiClient;
