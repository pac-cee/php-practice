<header class="site-header">
  <div class="header-container">
    <div class="logo">
      <a href="./index.php">
        <span class="logo-text">BookHaven</span>
      </a>
    </div>
    
    <div class="header-search">
      <form action="./catalog.php" method="GET">
        <input type="text" name="search" placeholder="Search for books, authors, or ISBN..." aria-label="Search">
        <button type="submit" aria-label="Search">
          <i class="icon-search"></i>
        </button>
      </form>
    </div>
    
    <nav class="header-nav">
      <ul>
        <li><a href="./catalog.php">Browse</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle">Categories</a>
          <div class="dropdown-menu">
            <a href="./catalog.php?category=fiction">Fiction</a>
            <a href="./catalog.php?category=non-fiction">Non-Fiction</a>
            <a href="./catalog.php?category=mystery">Mystery</a>
            <a href="./catalog.php?category=science-fiction">Science Fiction</a>
            <a href="./catalog.php?category=biography">Biography</a>
            <a href="./catalog.php?category=history">History</a>
            <a href="./catalog.php" class="view-all">View All Categories</a>
          </div>
        </li>
        <li><a href="./new-releases.php">New Releases</a></li>
        <li><a href="./bestsellers.php">Bestsellers</a></li>
      </ul>
    </nav>
    
    <div class="header-actions">
