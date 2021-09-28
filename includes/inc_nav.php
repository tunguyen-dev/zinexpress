<?php 
    if(!is_object($adminuser)) {
        header("Location: ".Commons_WebConst::HTACCESS_LOGIN);
    }
?>
<ul class="navbar-nav bg-gradient-primary sidebar toggled sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3"><?= $adminuser->phone?></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="<?= Commons_WebConst::HTACCESS_INDEX ?>"><i class="fas fa-fw fa-tachometer-alt"></i><span>Thống kê</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrders"
            aria-expanded="true" aria-controls="collapseOrders">
            <i class="fas fa-box-open"></i>
            <span>Tạo đơn</span>
        </a>
        <div id="collapseOrders" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= Commons_WebConst::HTACCESS_CREATE_ORDER?>">Tạo đơn lẻ</a>
                <a class="collapse-item" href="<?= Commons_WebConst::HTACCESS_CREATE_ORDER_BY_EXCEL?>">Tải lên Excel</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseManageOrdes"
            aria-expanded="true" aria-controls="collapseManageOrdes">
            <i class="fas fa-clipboard-list"></i>
            <span>Quản lý đơn hàng</span>
        </a>
        <div id="collapseManageOrdes" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= Commons_WebConst::HTACCESS_ORDER_MANAGERMENT?>">Quản lý đơn hàng</a>
                <a class="collapse-item" href="utilities-color.html">Danh sách file excel</a>
                <a class="collapse-item" href="utilities-border.html">Phản hồi đơn hàng</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMoney"
            aria-expanded="true" aria-controls="collapseMoney">
            <i class="fas fa-dollar-sign"></i>
            <span>Quản lý dòng tiền</span>
        </a>
        <div id="collapseMoney" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="404.html">Thống kê doanh thu</a>
                <a class="collapse-item" href="blank.html">Thống kê tiền hàng</a>
                <a class="collapse-item" href="login.html">Phiếu đối soát</a>
                <a class="collapse-item" href="register.html">Lịch sử chuyển tiền</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser"
            aria-expanded="true" aria-controls="collapseUser">
            <i class="fas fa-user"></i>
            <span>Tài khoản</span>
        </a>
        <div id="collapseUser" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= Commons_WebConst::HTACCESS_PROFILE?>">Quản lý tài khoản</a>
                <a class="collapse-item" href="<?= Commons_WebConst::HTACCESS_WARE?>">Kho hàng</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>