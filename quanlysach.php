<!DOCTYPE html>
<html lang="en">
<?php require_once "config.php"; ?>

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Quản lý sách - <?php echo WEB_NAME ?></title>
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
            <h5 class="modal-title" id="exampleModalLabel">Thêm sách</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- <div class="mb-3">
              <label for="maSach">Mã sách</label>
              <input type="text" class="form-control" id="maSach" name="maSach" required
                oninvalid="this.setCustomValidity('Trường này bắt buộc')">
            </div> -->
            <div class="mb-3">
              <label for="tenSach">Tên sách</label>
              <input type="text" class="form-control" id="tenSach" name="tenSach" required
                oninvalid="this.setCustomValidity('Trường này bắt buộc')">
            </div>
            <div class="mb-3">
              <label for="linhVuc">Lĩnh vực</label>
              <select class="form-select" id="linhVuc" name="linhVuc" required
                oninvalid="this.setCustomValidity('Trường này bắt buộc')">
                <?php
                global $conn;
                $sql = "SELECT * FROM field";
                $tacgiaSQL = $conn->query($sql);
                while ($row = $tacgiaSQL->fetch_assoc()) {
                  echo "<option value='" . $row['id_field'] . "'>" . $row['ten'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="tacGia" class="mb-1">Tác giả</label>
              <div class="choice">
                <?php
                global $conn;
                $sql = "SELECT * FROM author";
                $theloaiSQL = $conn->query($sql);
                while ($row = $theloaiSQL->fetch_assoc()) {
                  echo "<div class='form-check'>";
                  echo "<input class='form-check-input' type='checkbox' name='tacGia[]' id='tacGia-" . $row['id_author'] . "' value='" . $row['id_author'] . "'>";
                  echo "<label class='form-check-label' for='tacGia-" . $row['id_author'] . "'>" . join(' - ', [$row['ten'], $row['chuc_danh'], $row['dia_chi']]) . "</label>";
                  echo "</div>";
                }
                ?>
              </div>
            </div>
            <div class="mb-3">
              <label for="theLoai" class="mb-1">Thể loại</label>
              <div class="choice">
                <?php
                global $conn;
                $sql = "SELECT * FROM category";
                $theloaiSQL = $conn->query($sql);
                while ($row = $theloaiSQL->fetch_assoc()) {
                  echo "<div class='form-check'>";
                  echo "<input class='form-check-input' type='checkbox' name='theLoai[]' id='theloai-" . $row['id_category'] . "' value='" . $row['id_category'] . "'>";
                  echo "<label class='form-check-label' for='theloai-" . $row['id_category'] . "'>" . $row['ten'] . "</label>";
                  echo "</div>";
                }
                ?>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-primary" name="taoTacGia">Tạo</button>
          </div>
        </form>
        <?php
        if (isset($_POST['taoTacGia'])) {
          // $maSach = $_POST['maSach'];
          global $conn;
          $sql = "SELECT MAX(id_sach) as max FROM book";
          $maxid = $conn->query($sql);
          $maSach = $maxid->fetch_assoc()['max'] + 1;
          $maSach = str_pad($maSach, 6, '0', STR_PAD_LEFT);
          $tenSach = $_POST['tenSach'];
          $linhVuc = $_POST['linhVuc'];
          $tacGia = $_POST['tacGia'];
          $theLoai = $_POST['theLoai'];
          try {
            global $conn;
            $conn->begin_transaction();
            $sql = "INSERT INTO book (ma_sach, ten_sach, linh_vuc) VALUES ('$maSach', '$tenSach', '$linhVuc')";
            if ($conn->query($sql)) {
              echo $idSach = $conn->insert_id;
              foreach ($tacGia as $idTacGia) {
                $sql = "INSERT INTO book_author (id_book, id_author) VALUES ('$idSach', '$idTacGia')";
                if (!$conn->query($sql)) {
                  throw new Exception('Lỗi thêm tác giả');
                }
              }
              foreach ($theLoai as $idTheLoai) {
                $sql = "INSERT INTO book_category (id_book, id_category) VALUES ('$idSach', '$idTheLoai')";
                if (!$conn->query($sql)) {
                  throw new Exception('Lỗi thêm thể loại');
                }
              }
              $conn->commit();
              echo "<script>alert('Thêm sách thành công')</script>";
            } else {
              throw new Exception('Lỗi thêm sách');
            }
          } catch (Exception $e) {
            $conn->rollback();
            echo "<script>alert('Thêm sách thất bại')</script>";
            echo "<script>alert('$e')</script>";
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
                    <th>TT</th>
                    <th>Mã</th>
                    <th>Tên sách</th>
                    <th>Lĩnh vực</th>
                    <th>Thể loại</th>
                    <th>Tác giả</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT b.id_sach AS id_sach, b.ma_sach AS ma_sach, b.ten_sach AS ten_sach, f.ten AS linh_vuc, GROUP_CONCAT(DISTINCT c.ten ORDER BY c.ten ASC SEPARATOR ', ') AS the_loai, GROUP_CONCAT(DISTINCT a.ten ORDER BY a.ten ASC SEPARATOR ', ') AS tac_gia FROM book b LEFT JOIN field f ON b.linh_vuc = f.id_field LEFT JOIN book_category bc ON b.id_sach = bc.id_book LEFT JOIN category c ON bc.id_category = c.id_category LEFT JOIN book_author ba ON b.id_sach = ba.id_book LEFT JOIN author a ON ba.id_author = a.id_author GROUP BY b.id_sach, b.ma_sach, b.ten_sach, f.ten;";
                  global $conn;
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $i++ . "</td>";
                      echo "<td>" . $row['ma_sach'] . "</td>";
                      echo "<td>" . $row['ten_sach'] . "</td>";
                      echo "<td>" . $row['linh_vuc'] . "</td>";
                      echo "<td>" . $row['the_loai'] . "</td>";
                      echo "<td>" . $row['tac_gia'] . "</td>";
                      $idbook = $row['id_sach'];
                      echo "<td><a href='sach.php?id=$idbook' class='btn btn-primary'><i class='bi bi-eye-fill'></i></a> </td>";
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