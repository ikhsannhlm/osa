<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link">
    <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">OSA</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="index.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="student_data.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'student_data.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-table"></i>
            <p>Student Data</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="scan_rfid.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'scan_rfid.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-book"></i>
            <p>Scan RFID</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="pages/forms/general.html" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'general.html') ? 'active' : ''; ?>">
            <i class="nav-icon far fa-image"></i>
            <p>Scan YOLO</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="attendance.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'attendance.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-file"></i>
            <p>Attendance R&V</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="pages/examples/profile.html" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'profile.html') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>Profile</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
