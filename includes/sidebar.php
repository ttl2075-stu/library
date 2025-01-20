<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed" href="index.php">
                <i class="bi bi-grid"></i>
                <span>Trang chủ</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#sach-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i>
                <span>Quản lý sách</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="sach-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="quanlysach.php"> <i class="bi bi-circle"></i><span>Quản lý sách</span> </a>
                </li>
                <li>
                    <a href="quanlytacgia.php"> <i class="bi bi-circle"></i><span>Quản lý tác giả</span> </a>
                </li>
                <li>
                    <a href="quanlytheloai.php"> <i class="bi bi-circle"></i><span>Quản lý thể loại</span> </a>
                </li>
                <li>
                    <a href="quanlylinhvuc.php"> <i class="bi bi-circle"></i><span>Quản lý lĩnh vực</span> </a>
                </li>
                <li>
                    <a href="quanlynxb.php"> <i class="bi bi-circle"></i><span>Quản lý nhà xuất bản</span> </a>
                </li>
            </ul>

        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="" data-bs-target="#docgia-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i>
                <span>Quản lý độc giả</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="docgia-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="quanlydocgia.php"> <i class="bi bi-circle"></i><span>Quản lý độc giả</span> </a>
                </li>
                <li>
                    <a href=""> <i class="bi bi-circle"></i><span>Quản lý thẻ độc giả</span> </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="phieumuonsach.php">
                <i class="bi bi-menu-button-wide"></i>
                <span>Phiếu mượn sách</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="" data-bs-target="#baocao-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i>
                <span>Báo cáo</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="baocao-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="baocaoquahan.php"> <i class="bi bi-circle"></i><span>Báo cáo quá hạn</span> </a>
                </li>
                <li>
                    <a href="baocaotansuat.php"> <i class="bi bi-circle"></i><span>Báo cáo tần suất mượn</span> </a>
                </li>
            </ul>
        </li>

    </ul>
</aside>