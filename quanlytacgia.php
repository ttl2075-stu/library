<!DOCTYPE html>
<html lang="en">
<?php require_once "config.php"; ?>

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Quản lý tác giả - <?php echo WEB_NAME ?></title>
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
            <h5 class="modal-title" id="exampleModalLabel">Thêm tác giả</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="tentacgia">Tên tác giả</label>
              <input type="text" class="form-control" id="tentacgia" name="tenTacGia" required
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
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-primary" name="taoTacGia">Tạo</button>
          </div>
        </form>
        <?php
        if (isset($_POST['taoTacGia'])) {
          $tenTacGia = $_POST['tenTacGia'];
          $chucDanh = $_POST['chucDanh'];
          $diaChi = $_POST['diaChi'];
          $sql = "INSERT INTO author (ten, chuc_danh, dia_chi) VALUES ('$tenTacGia', '$chucDanh', '$diaChi')";
          if (transitionSQL($sql)) {
            echo "<script>alert('Thêm tác giả thành công')</script>";
          } else {
            echo "<script>alert('Thêm tác giả thất bại')</script>";
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
                <!-- <h3>Quản lý tác giả</h3> -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-taotacgia">
                  Thêm tác giả
                </button>

              </div>
              <!-- Table with stripped rows -->
              <table class="table datatable align-middle">
                <thead>
                  <tr>
                    <th>STT</th>
                    <th>Tên tác giả</th>
                    <th>Chức danh</th>
                    <th>Đơn vị</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $sql = "SELECT * FROM author";
                  global $conn;
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $i++ . "</td>";
                      echo "<td>" . $row['ten'] . "</td>";
                      echo "<td>" . $row['chuc_danh'] . "</td>";
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