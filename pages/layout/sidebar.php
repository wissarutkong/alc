<!-- Navbar -->
<!-- Preloader -->
<!-- <div id="loading_page" class="preloader flex-column justify-content-center align-items-center">
  <div class="spinner-border" style="width: 6rem; height: 6rem;" role="status">
    <span class="sr-only">Loading...</span>
  </div> 
  <img class="animation__shake" src="../../assets/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
</div> -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light bg-info">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/index.php" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-info elevation-1">
    <!-- Brand Logo -->
    <a href="/index.php" class="brand-link bg-info">
      <img src="../../assets/img/logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8" width="50%" height="50%">
      <span class="brand-text font-weight-light">ST Design</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../assets/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['AD_NAME']; ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="../dashboard/" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../graph/" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                GraphAnalytics
              </p>
            </a>
          </li>
          <li class="nav-header">ตั้งค่า</li>
          <li class="nav-item">
            <a href="../devicecustomer/" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                ตั้งค่าอุปกรณ์
              </p>
            </a>
          </li>
          <?php if($_SESSION['AD_PERMISSION'] == 1){  ?>
          
          <?php } ?>
          <li class="nav-item">
            <a href="../site/" class="nav-link">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>
                ตั้งค่า Site
              </p>
            </a>
          </li>
          <?php if($_SESSION['AD_PERMISSION'] == 1){  ?>
            <li class="nav-header">ตั้งค่าสำหรับ Admin</li>
            <li class="nav-item">
            <a href="../device/" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                เพิ่ม/แก้ไข/ลบอุปกรณ์
              </p>
            </a>
          </li>
            <li class="nav-item">
              <a href="../company/" class="nav-link">
                <i class="nav-icon fas fa-building"></i>
                <p>
                  ตั้งค่าบริษัท
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../users/" class="nav-link">
                <i class="nav-icon far fa-user"></i>
                <p>
                  ตั้งค่าผู้ใช้งานระบบ
                </p>
              </a>
            </li>
          <?php } ?>

          <li class="nav-header">บัญชีของเรา</li>
                <li class="nav-item">
                    <a href="../logout.php" id="logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>ออกจากระบบ </p>
                    </a>
                </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>