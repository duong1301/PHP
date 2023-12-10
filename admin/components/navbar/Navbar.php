<div class="navbar-wrapper">
    <!-- user router -->
    <a href="?page=user" class="navbar-item <?php echo ($page === 'user') ? 'active' : ''; ?>" onclick="highlightNavItem(this)">
        <div class="nav-item">
        <i class="fa-solid fa-users"></i>&emsp;User
        </div>
    </a>

    <a href="?page=subject" class="navbar-item <?php echo ($page === 'subject') ? 'active' : ''; ?>" onclick="highlightNavItem(this)">
        <div class="nav-item">
        <i class="fa-solid fa-book-open"></i>&emsp;Subject
        </div>
    </a>

    <a href="?page=teacher" class="navbar-item <?php echo ($page === 'teacher') ? 'active' : ''; ?>" onclick="highlightNavItem(this)">
        <div class="nav-item">
        <i class="fas fa-chalkboard-teacher"></i>&emsp;Teacher
        </div>
    </a>

    <a href="?page=class" class="navbar-item <?php echo ($page === 'class') ? 'active' : ''; ?>" onclick="highlightNavItem(this)">
        <div class="nav-item">
        <i class="fa-solid fa-school"></i>&emsp;Class
        </div>
    </a>

    <a href="?page=score" class="navbar-item <?php echo ($page === 'score') ? 'active' : ''; ?>" onclick="highlightNavItem(this)">
        <div class="nav-item">
        <i class="fa-solid fa-star"></i>&emsp;Score
        </div>
    </a>
  <a href="?page=about">
        <div class="nav-item">
            About
        </div>
    </a>

</div>
<script>
    function highlightNavItem(element) {
        // Xóa lớp CSS 'active' khỏi tất cả các mục
        var navItems = document.getElementsByClassName('navbar-item');
        for (var i = 0; i < navItems.length; i++) {
            navItems[i].classList.remove('active');
        }

        // Thêm lớp CSS 'active' cho mục được click
        element.classList.add('active');
    }
</script>

