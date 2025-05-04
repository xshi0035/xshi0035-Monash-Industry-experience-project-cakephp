<?php

/**
 * @var \App\View\AppView $this
 */

$cakeDescription = $this->ContentBlock->text('website-title') . " Contractor Portal";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->Html->charset() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <?= $this->Html->meta('icon') ?>

    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <?= $this->Html->css(['admin.css']) ?>
    <?= $this->Html->css(['bootstrap.min.css']) ?>
    <?= $this->Html->css(['admin_view.css']) ?>

    <!-- skeleton layout  -->
    <script src="https://kit.fontawesome.com/dc286b156c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css">

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <title>
        <?= $cakeDescription . ": ",
        $this->fetch('title') ?>
    </title>
    <style>
        .dt-paging-button {
            font-size: small;
        }
    </style>
</head>

<body class="container-fluid" id="page-top">

    <div class="wrapper">
        <div class="top_navbar">
            <div class="top_menu">
                <!-- Remain empty to align the symbols to the right  -->
                <div class="logo">
                </div>
                <?php if ($this->request->getSession()->read('Auth')): ?>
                    <ul>
                        <li>
                            <span class="username">
                                <?php echo $this->request->getSession()->read('Auth.first_name') . " " . $this->request->getSession()->read('Auth.last_name'); ?>
                            </span>
                        </li>
                        <li>
                            <div class="dropdown">
                                <a class="dropbtn" href="javascript:document.getElementById('myDropdown').classList.toggle('show');">
                                    <i class="fas fa-user"></i>
                                </a>
                                <div id="myDropdown" class="dropdown-content">
                                    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $this->request->getSession()->read('Auth.id')]) ?>">Profile</a>
                                    <a href="#logoutModal" data-toggle="modal">Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                <?php endif ?>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main_container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of top navigation bar -->

    <!-- Sidebar -->
    <div class="sidebar close">
        <div class="logo-details">
            <i class='bx bxs-diamond'></i>
            <span class="logo_name">Pram Spa</span>
        </div>
        <ul class="nav-links">
            <!-- <li>
                <a href="<?= $this->Url->build(['controller' => 'Inquiries', 'action' => 'index']) ?>">
                    <i class='bx bx-message-square-error'></i>
                    <span class="link_name">Inquiries</span>
                </a>
                <ul class="sub-menu blank">
                    <li>
                        <a class="link_name" href="<?= $this->Url->build(['controller' => 'Inquiries', 'action' => 'index']) ?>">List Inquiries</a>
                    </li>
                </ul>
            </li> -->
            <li>
                <div class="iocn-link">
                    <a href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'indexById']) ?>">
                        <i class='bx bxs-package'></i>
                        <span class="link_name" href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'indexById']) ?>">View Jobs</span>
                    </a>
                    <!-- <i class='bx bxs-chevron-down arrow'></i> -->
                </div>
            </li>
            <!-- <li>
                <a href="<?= $this->Url->build(['controller' => 'Orders', 'action' => 'index']) ?>">
                    <i class='bx bx-cart'></i>
                    <span class="link_name" href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'indexById']) ?>"></span>
                </a>
                <ul class="sub-menu blank">
                    <li>
                        <a class="link_name" href="<?= $this->Url->build(['controller' => 'Orders', 'action' => 'index']) ?>">List Orders</a>
                    </li>
                </ul>
            </li> -->
            <!-- <li> -->
                <!-- Profile tab on sidebar  -->
                <!-- <div class="profile-details">
                    <div class="profile-content">
                        <img src="image/profile.jpg" alt="profileImg">
                    </div>
                    <div class="name-job">
                        <div class="profile_name">Prem Shahi</div>
                        <div class="job">Web Desginer</div>
                    </div>
                    <i class='bx bx-log-out' ></i>
                </div> -->
                <!-- End of profile tab on sidebar  -->

            <!-- </li> -->
        </ul>
    </div>
    <!-- End of Sidebar -->

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <!-- <button class="close" type="button" data-dismiss="modal" aria-label="Close"> -->
                    <i class='bx bx-x' data-dismiss="modal"></i>
                    <!-- </button> -->
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="logout-button" id="logout-button" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>">
                        <a href="<?= $this->Url->build(['controller' => 'Auth', 'action' => 'logout']) ?>">Logout</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Logout Modal -->
    </div>
    <!-- End of Body Container -->

    <!-- Footer -->
    <div>
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span><?= $this->ContentBlock->text('copyright-message'); ?></span>
                </div>
            </div>
        </footer>
    </div>
    <!-- End of Footer -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <?= $this->Html->script("/vendor/jquery/jquery.min.js") ?>
    <?= $this->Html->script("/vendor/bootstrap/js/bootstrap.bundle.min.js") ?>
    <!-- Core plugin JavaScript-->
    <?= $this->Html->script("/vendor/jquery-easing/jquery.easing.min.js") ?>

    <!-- Custom JavaScript -->
    <?= $this->Html->script("admin") ?>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <?= $this->Html->script(['contractor-date-picker.js']) ?>
    
    <?= $this->Html->css('//cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css')?>
    <?= $this->Html->script('//cdn.datatables.net/2.1.3/js/dataTables.min.js') ?>

</body>

</html>
