<header class="admin-header">
  <div class="header-left">
    <button class="menu-toggle">
      <i class="icon-menu"></i>
    </button>
  </div>
  
  <div class="header-right">
    <div class="admin-search">
      <form action="search-results.php" method="GET">
        <input type="text" name="query" placeholder="Search...">
        <button type="submit">
          <i class="icon-search"></i>
        </button>
      </form>
    </div>
    
    <div class="header-actions">
      <div class="dropdown">
        <button class="notifications-toggle">
          <i class="icon-bell"></i>
          <span class="badge">3</span>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="dropdown-header">
            <h3>Notifications</h3>
            <a href="#" class="mark-all-read">Mark all as read</a>
          </div>
          <div class="notifications-list">
            <a href="#" class="notification-item unread">
              <div class="notification-icon order-icon"></div>
              <div class="notification-content">
                <p class="notification-text">New order #1234 has been placed</p>
                <p class="notification-time">10 minutes ago</p>
              </div>
            </a>
            <a href="#" class="notification-item unread">
              <div class="notification-icon stock-icon"></div>
              <div class="notification-content">
                <p class="notification-text">"The Great Gatsby" is now out of stock</p>
                <p class="notification-time">1 hour ago</p>
              </div>
            </a>
            <a href="#" class="notification-item unread">
              <div class="notification-icon review-icon"></div>
              <div class="notification-content">
                <p class="notification-text">New review for "1984" (4★)</p>
                <p class="notification-time">3 hours ago</p>
              </div>
            </a>
            <a href="#" class="notification-item">
              <div class="notification-icon user-icon"></div>
              <div class="notification-content">
                <p class="notification-text">New user registration: john.doe@example.com</p>
                <p class="notification-time">Yesterday</p>
              </div>
            </a>
