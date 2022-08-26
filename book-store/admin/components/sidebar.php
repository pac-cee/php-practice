<aside class="admin-sidebar">
  <div class="sidebar-header">
    <a href="../admin/index.php" class="admin-logo">
      <span class="logo-text">BookHaven</span>
      <span class="logo-badge">Admin</span>
    </a>
    <button class="sidebar-close-btn">
      <i class="icon-close"></i>
    </button>
  </div>
  
  <nav class="sidebar-nav">
    <ul>
      <li>
        <a href="../admin/index.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>">
          <i class="icon-dashboard"></i> Dashboard
        </a>
      </li>
      <li>
        <a href="../admin/orders.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'orders.php' ? 'active' : ''; ?>">
          <i class="icon-orders"></i> Orders
        </a>
      </li>
      <li>
        <a href="../admin/books.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'books.php' || basename($_SERVER['PHP_SELF']) === 'edit-book.php' || basename($_SERVER['PHP_SELF']) === 'add-book.php' ? 'active' : ''; ?>">
          <i class="icon-books"></i> Books
        </a>
      </li>
      <li>
        <a href="../admin/categories.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'categories.php' ? 'active' : ''; ?>">
          <i class="icon-categories"></i> Categories
        </a>
      </li>
      <li>
        <a href="../admin/users.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'users.php' ? 'active' : ''; ?>">
          <i class="icon-users"></i> Users
        </a>
      </li>
