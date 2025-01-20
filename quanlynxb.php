<!DOCTYPE html>
<html lang="en">
<?php require_once "config.php"; ?>

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Quản lý thể loại - <?php echo WEB_NAME ?></title>
  <meta content="" name="description" />
  <meta content="" name="keywords" />

  <?php require_once "./includes/linkcss.php"; ?>
  <link rel="stylesheet" href="assets/css/quanlysach.css">
</head>

<body>
  <!-- MODAL -->.
  <div class="modal fade" id="modal-tao" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Thêm Nhà xuất bản</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="ten">Tên Nhà xuất bản</label>
              <input type="text" class="form-control" id="ten" name="ten" required
                oninvalid="this.setCustomValidity('Trường này bắt buộc')">
            </div>
            <div class="mb-3">
              <label for="diachi">Địa chỉ</label>
              <input type="text" class="form-control" id="diachi" name="diaChi" required
                oninvalid="this.setCustomValidity('Trường này bắt buộc')">
            </div>
            <div class="mb-3">
              <label for="ngaythanhlap">Ngày thành lập</label>
              <input type="date" class="form-control" id="ngaythanhlap" name="ngayThanhLap"
                oninvalid="this.setCustomValidity('Trường này bắt buộc')">
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-primary" name="tao">Tạo</button>
          </div>
        </form>
        <?php
        if (isset($_POST['tao'])) {
          $ten = $_POST['ten'];
          $diaChi = $_POST['diaChi'];
          $ngayThanhLap = $_POST['ngayThanhLap'] == '' ? NULL : $_POST['ngayThanhLap'];
          if ($ngayThanhLap == NULL) {
            $sql = "INSERT INTO publisher (ten, dia_chi) VALUES ('$ten', '$diaChi')";

          } else {
            $sql = "INSERT INTO publisher (ten, dia_chi, thanh_lap) VALUES ('$ten', '$diaChi', '$ngayThanhLap')";
          }
          if (transitionSQL($sql)) {
            echo "<script>alert('Thêm Nhà xuất bản thành công')</script>";
          } else {
            echo "<script>alert('Thêm Nhà xuất bản thất bại.')</script>";
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
      <h1>Quản lý Nhà xuất bản</h1>
    </div>
    <!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="card-title">
                <!-- <h3>Quản lý Nhà xuất bản</h3> -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tao">
                  Thêm Nhà xuất bản
                </button>

              </div>
              <!-- Table with stripped rows -->
              <table class="table datatable align-middle">
                <thead>
                  <tr>
                    <th>STT</th>
                    <th>Nhà xuất bản</th>
                    <th>Ngày thành lập</th>
                    <th>Địa chỉ</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $sql = "SELECT * FROM publisher";
                  global $conn;
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $i++ . "</td>";
                      echo "<td>" . $row['ten'] . "</td>";
                      $datecreate = $row['thanh_lap'] == NULL ? '' : date('d/m/Y', strtotime($row['thanh_lap']));
                      echo "<td>" . $datecreate . "</td>";
                      echo "<td>" . $row['dia_chi'] . "</td>";
                      echo "<td></td>";
                      // echo "<td><a href='#' class='btn btn-primary'>Sửa</a> <a href='#' class='btn btn-danger'>Xóa</a></td>";
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