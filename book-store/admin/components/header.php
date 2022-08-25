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
