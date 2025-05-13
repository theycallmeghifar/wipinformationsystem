<!DOCTYPE html>
<html lang="en">
  <?php
    $activePage = basename($_SERVER['PHP_SELF'], ".php");
  ?>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WIP Information System FIM</title>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte3.2/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte3.2/plugins/fontawesome/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte3.2/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte3.2/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url() ?>assets/adminlte3.2/dist/img/FIM_Logo_Circle.png">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte3.2/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte3.2/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    
    <style>
      .modal {
        text-align: center;
        padding: 0!important;
      }
      .hiddenField {
        display: none;
      }
      .modal:before {
        content: '';
        display: inline-block;
        height: 100%;
        vertical-align: middle;
        margin-right: -4px;
      }
      .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
      }
      #confirmationTable td[rowspan] {
        vertical-align: middle !important;
      }
    </style>
  </head>
  <body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
      <!-- Preloader -->
      <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="<?php echo base_url() ?>assets/adminlte3.2/dist/img/FIM_Logo_Circle.png" alt="FIM Logo" height="60" width="60">
      </div>
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
          <!-- Left navbar links -->
          <ul class="navbar-nav">
              <li class="nav-item">
                  <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
              </li>
              <li class="nav-item d-none d-sm-inline-block">
                <?php if ($this->session->userdata('role') == 1) { ?>
                  <a class="nav-link">WIP</a>
                <?php } ?>
                <?php if ($this->session->userdata('role') == 2) { ?>
                  <a class="nav-link">Machining</a>
                <?php } ?>
                <?php if ($this->session->userdata('role') == 3) { ?>
                  <a class="nav-link">Finishing</a>
                <?php } ?>
              </li>
          </ul>
          <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                  <a class="nav-link" href="<?php echo site_url('Login') ?>" role="button">
                      Log Out
                      <i class="fas fa-sign-out-alt"></i>
                  </a>
              </li>
          </ul>
      </nav>
      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="" class="brand-link">
          <img src="<?php echo base_url() ?>assets/adminlte3.2/dist/img/FIM_Logo_Circle.png" alt="FIM Logo" class="brand-image" style="opacity: 1.0">
          <span class="brand-text font-weight-light">W.I.S.</span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
              <li class="nav-header">MENU</li>
              <?php if ($this->session->userdata('role') == 1) { ?>
              <li class="nav-item">
                <a href="<?php echo site_url('Order'); ?>" class="nav-link <?= ($activePage == 'Order') ? 'active':''; ?>">
                  <i class="nav-icon fas ion-clipboard"></i>
                  <p>
                    Order
                    <span class="badge badge-info right"></span>
                  </p>
                </a>
              </li>
              <li class="nav-item
                <?= ($activePage == 'MasterData') ? 'menu-open':''; ?> 
                <?= ($activePage == 'Item') ? 'menu-open':''; ?> 
                <?= ($activePage == 'Box') ? 'menu-open':''; ?>
                <?= ($activePage == 'Location') ? 'menu-open':''; ?>">
                <a href="#" class="nav-link 
                <?= ($activePage == 'MasterData') ? 'active':''; ?> 
                <?= ($activePage == 'Item') ? 'active':''; ?> 
                <?= ($activePage == 'Box') ? 'active':''; ?>
                <?= ($activePage == 'Location') ? 'active':''; ?>">
                  <i class="nav-icon fas fa-clipboard"></i>
                  <p>
                    Master Data
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo site_url('Item'); ?>" class="nav-link <?= ($activePage == 'Item') ? 'active':''; ?>">
                      <i class="nav-icon ion-cube"></i>
                      <p>
                        Item
                        <span class="badge badge-info right"></span>
                      </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo site_url('Box'); ?>" class="nav-link <?= ($activePage == 'Box') ? 'active':''; ?>">
                      <i class="nav-icon fas fa-archive"></i>
                      <p>
                        Box
                      </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo site_url('Location'); ?>" class="nav-link <?= ($activePage == 'Location') ? 'active':''; ?>">
                      <i class="nav-icon fas ion-location"></i>
                      <p>
                        Lokasi
                        <span class="badge badge-info right"></span>
                      </p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('WipBoxHistory'); ?>" class="nav-link <?= ($activePage == 'WipBoxHistory') ? 'active':''; ?>">
                  <i class="nav-icon ion-ios-paper-outline"></i>
                  <p>
                    Wip Box History
                    <span class="badge badge-info right"></span>
                  </p>
                </a>
              </li>
              <?php } ?>
              <?php if ($this->session->userdata('role') == 2) { ?>
              <li class="nav-item">
                <a href="<?php echo site_url('Order'); ?>" class="nav-link <?= ($activePage == 'Order') ? 'active':''; ?>">
                  <i class="nav-icon ion-ios-cart-outline"></i>
                  <p>
                    Order
                    <span class="badge badge-info right"></span>
                  </p>
                </a>
              </li>
              <?php } ?>
              <?php if ($this->session->userdata('role') == 3) { ?>
                <li class="nav-item">
                  <a href="<?php echo site_url('WipBox'); ?>" class="nav-link <?= ($activePage == 'WipBox') ? 'active':''; ?>">
                    <i class="nav-icon ion-ios-box"></i>
                    <p>
                      Wip box
                      <span class="badge badge-info right"></span>
                    </p>
                  </a>
                </li>
                <?php } ?>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>
      
      <?php echo $data;?>
      
      <!-- /.content-wrapper -->
      <footer class="main-footer">
        ‎
        
        <div class="float-right d-none d-sm-inline-block">
        <p>&copy; 2025 Manajemen Informatika, <a target="_blank" href="https://www.polytechnic.astra.ac.id/"> Politeknik Astra.</a> All Rights Reserved.</p>
        </div>
      </footer>
      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- jQuery -->
    <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI -->
    <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url() ?>assets/adminlte3.2/dist/js/adminlte.js"></script>
    
    <!-- DataTables JS -->
    <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/datatables-bs4/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- FontAwesome -->
    <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/fontawesome/js/fontawesome.js"></script>
    <!-- SweetAlert -->
    <script src="<?php echo base_url('assets/sweetalert/sweetalert2.all.min.js') ?>"></script>
    <!-- Select2 JS -->
    <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/select2/js/select2.full.min.js"></script>

    <?php echo $script; ?>
    
    <script>
      $(document).ready(function () {
        if (!$.fn.DataTable) {
          console.error("DataTables is not loaded!");
        } else {
          console.log("DataTables loaded successfully.");
          $('#dataTable').DataTable();
        }

        //datatables bahasa indonesia
        $('#dataTable').DataTable({
            "destroy": true,
            "language": {
                "url": "<?php echo base_url(); ?>assets/adminlte3.2/plugins/datatables-bs4/id.json"
            }
        });
      });
    </script>
  </body>
</html>
