<!DOCTYPE html>
<html lang="en">
<?php require_once "config.php"; ?>

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Quản lý độc giả - <?php echo WEB_NAME ?></title>
  <meta content="" name="description" />
  <meta content="" name="keywords" />

  <?php require_once "./includes/linkcss.php"; ?>
  <link rel="stylesheet" href="assets/css/quanlysach.css">
</head>

<body>
  <!-- MODAL -->.
  <div class="modal fade" id="modal-taotacgia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Thêm độc giả</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="CCCD">CCCD</label>
              <input type="text" class="form-control" id="CCCD" name="CCCD" required
                oninvalid="this.setCustomValidity('Trường này bắt buộc')">
            </div>
            <div class="mb-3">
              <label for="tenDocGia">Họ và tên</label>
              <input type="text" class="form-control" id="tenDocGia" name="tenDocGia" required
                oninvalid="this.setCustomValidity('Trường này bắt buộc')">
            </div>
            <div class="mb-3">
              <label for="ngaySinh">Ngày sinh</label>
              <input type="date" class="form-control" id="ngaySinh" name="ngaySinh" required
                oninvalid="this.setCustomValidity('Trường này bắt buộc')">
            </div>
            <div class="mb-3">
              <label for="chucDanh">Chức danh</label>
              <input type="text" class="form-control" id="chucDanh" name="chucDanh" required
                oninvalid="this.setCustomValidity('Trường này bắt buộc')">
            </div>
            <div class="mb-3">
              <label for="diaChi">Địa chỉ</label>
              <input type="text" class="form-control" id="diaChi" name="diaChi" required
                oninvalid="this.setCustomValidity('Trường này bắt buộc')">
            </div>
            <div class="mb-3">
              <label for="SDT">SĐT</label>
              <input type="text" class="form-control" id="SDT" name="SDT" required
                oninvalid="this.setCustomValidity('Trường này bắt buộc')">
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-primary" name="taoTacGia">Tạo</button>
          </div>
        </form>
        <?php
        if (isset($_POST['taoTacGia'])) {
          $CCCD = $_POST['CCCD'];
          $tenDocGia = $_POST['tenDocGia'];
          $ngaySinh = $_POST['ngaySinh'];
          $chucDanh = $_POST['chucDanh'];
          $diaChi = $_POST['diaChi'];
          $SDT = $_POST['SDT'];
          $sql = "INSERT INTO reader (cccd, ten, ngay_sinh, chuc_danh, dia_chi, sdt) VALUES ('$CCCD', '$tenDocGia', '$ngaySinh', '$chucDanh', '$diaChi', '$SDT')";
          if (transitionSQL($sql)) {
            echo "<script>alert('Thêm độc giả thành công')</script>";
          } else {
            echo "<script>alert('Thêm độc giả thất bại')</script>";
          }
        }
        ?>
      </div>
    </div>
  </div>
  <!-- ======= Header ======= -->
  <?php require_once "./includes/navbar.php"; ?>
  <!-- End Header -->
  <!-- ======= Sidebar ======= -->
  <?php require_once "./includes/sidebar.php"; ?>
  <!-- End Sidebar-->

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Quản lý tác giả</h1>
    </div>
    <!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="card-title">
                <!-- <h3>Quản lý độc giả</h3> -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-taotacgia">
                  Thêm độc giả
                </button>

              </div>
              <!-- Table with stripped rows -->
              <table class="table datatable align-middle">
                <thead>
                  <tr>
                    <th>STT</th>
                    <th>CCCD</th>
                    <th>Tên</th>
                    <th>Ngày sinh</th>
                    <th>Chức danh</th>
                    <th>Địa chỉ</th>
                    <th>SĐT</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $sql = "SELECT * FROM reader";
                  global $conn;
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $i++ . "</td>";
                      echo "<td>" . $row['cccd'] . "</td>";
                      echo "<td>" . $row['ten'] . "</td>";
                      echo "<td>" . date('d/m/Y', strtotime($row['ngay_sinh'])) . "</td>";
                      echo "<td>" . $row['chuc_danh'] . "</td>";
                      echo "<td>" . $row['dia_chi'] . "</td>";
                      echo "<td>" . $row['sdt'] . "</td>";
                      $idreader = $row['id_reader'];
                      echo "<td><a href='docgia.php?id=$idreader' class='btn btn-primary'><i class='bi bi-eye-fill'></i></a> </td>";
                      echo "</tr>";
                    }
                  }
                  ?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span><?php echo WEB_NAME ?></span></strong>. All Rights Reserved
    </div>
  </footer>
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <?php require_once './includes/linkscript.php'; ?>
</body>

</html>