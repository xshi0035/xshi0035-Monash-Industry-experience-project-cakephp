<?php

/**
 * @var \App\View\AppView $this
 */

$cakeDescription = $this->ContentBlock->text('website-title') . " Manager Portal";

$currentController = $this->request->getParam('controller');
$currentAction = $this->request->getParam('action');
?>
<!DOCTYPE html>
<html lang="en">

<head>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <?= $this->Html->meta('icon') ?>

    <title>
        <?= $cakeDescription . ": ",
        $this->fetch('title') ?>
    </title>

    <!-- Custom fonts for this template -->
    <?= $this->Html->css('/vendor/fontawesome-free/css/all.min.css') ?>
    <script src="https://kit.fontawesome.com/dc286b156c.js" crossorigin="anonymous"></script>

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <?= $this->Html->css('sb-admin-2.min.css') ?>

    <!-- Custom styles for this page -->
    <?= $this->Html->css('/vendor/datatables/dataTables.bootstrap4.min.css') ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon">
                    <i class="fa fa-tint" aria-hidden="true"></i>
                    <!-- <?= $this->Html->image('pram_spa_transparent.png', ['alt' => 'Logo', 'class' => 'img-fluid']) ?> -->
                </div>
                <div class="sidebar-brand-text mx-3">Pram Spa</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item <?= $currentController === 'Bookings' &&  $currentAction !== 'bookingsSummary' && $currentAction !== 'monthlySummary' && $currentAction !== 'executiveSummary' ? 'active' : '' ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBookings"
                    aria-expanded="true" aria-controls="collapseBookings">
                    <i class="fas fa-fw fa-bars"></i>
                    <span>Bookings</span>
                </a>
                <div id="collapseBookings" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'Bookings', 'action' => 'upcomingIndex']) ?>">Upcoming Bookings</a>
                        <a class="collapse-item" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'Bookings', 'action' => 'unassignedIndex']) ?>">Unassigned Bookings</a>
                        <a class="collapse-item" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'Bookings', 'action' => 'indexById']) ?>">All Bookings</a>
                    </div>
                </div>

            </li>

            <li class="nav-item <?= $currentController === 'Customers' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'Customers', 'action' => 'index']) ?>">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Customers</span></a>
            </li>

            <li class="nav-item <?= $currentController === 'Locations' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'Locations', 'action' => 'index']) ?>">
                    <i class="fas fa-fw fa-map-marker"></i>
                    <span>Locations</span></a>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item <?= $currentController === 'Services' || $currentController === 'Products' || $currentController === 'Categories' ? 'active' : '' ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOfferings"
                    aria-expanded="true" aria-controls="collapseOfferings">
                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                    <span>Services</span>
                </a>
                <div id="collapseOfferings" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'Services', 'action' => 'index']) ?>">Services</a>
                        <a class="collapse-item" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'Products', 'action' => 'index']) ?>">Products</a>
                        <a class="collapse-item" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'Categories', 'action' => 'index']) ?>">Categories</a>
                    </div>
                </div>
            </li>

            <!-- Reports -->
            <?php
            if ($this->request->getSession()->read('Auth.role_id') == 1): ?>
                <li class="nav-item <?= $currentAction === 'bookingsSummary' || $currentAction === 'monthlySummary' || $currentAction === 'executiveSummary' ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-bars"></i>
                        <span>Reports</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'Bookings', 'action' => 'bookingsSummary']) ?>">Bookings Summary</a>
                            <a class="collapse-item" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'Bookings', 'action' => 'monthlySummary']) ?>">Monthly Summary</a>
                            <a class="collapse-item" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'Bookings', 'action' => 'executiveSummary']) ?>">Executive Summary</a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Pages Collapse Menu -->

            <li class="nav-item <?= $currentController === 'Users' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'Users', 'action' => 'index']) ?>">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Staff</span></a>
            </li>

            <li class="nav-item <?= $currentController === 'ContentBlocks' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= $this->Url->build(['plugin' => 'ContentBlocks', 'controller' => 'ContentBlocks', 'action' => 'index']) ?>">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Customise Website</span></a>
            </li>

            <!-- Bin  -->
            <li class="nav-item <?= $currentController === 'Photos' && $currentAction === 'moveToBin' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'Photos', 'action' => 'moveToBin']) ?>">
                    <i class="fa-solid fa-trash"></i>
                    <span>Photos Bin</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggle" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 medium"><?php echo $this->request->getSession()->read('Auth.first_name') . " " . $this->request->getSession()->read('Auth.last_name'); ?></span>
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $this->request->getSession()->read('Auth.id')]) ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content') ?>
                </div>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <?= $this->ContentBlock->text('copyright-message') ?>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">
                        <a style="color:black" href="<?= $this->Url->build(['controller' => 'Auth', 'action' => 'logout']) ?>">Logout</a>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <?= $this->Html->script("/vendor/jquery/jquery.min.js") ?>
    <?= $this->Html->script("/vendor/bootstrap/js/bootstrap.bundle.min.js") ?>

    <!-- Core plugin JavaScript-->
    <?= $this->Html->script("/vendor/jquery-easing/jquery.easing.min.js") ?>

    <!-- Custom scripts for all pages-->
    <?= $this->Html->script("/js/sb-admin-2.js") ?>

    <!-- Page level plugins -->
    <?= $this->Html->script("/vendor/datatables/jquery.dataTables.min.js") ?>
    <?= $this->Html->script("/vendor/datatables/dataTables.bootstrap4.min.js") ?>

</body>

</html>