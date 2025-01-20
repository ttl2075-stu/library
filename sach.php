<!DOCTYPE html>
<html lang='en'>
<?php require_once 'config.php'; ?>

<head>
  <meta charset='utf-8' />
  <meta content='width=device-width, initial-scale=1.0' name='viewport' />

  <title>Quản lý độc giả - <?php echo WEB_NAME ?></title>
  <meta content='' name='description' />
  <meta content='' name='keywords' />

  <?php require_once './includes/linkcss.php'; ?>
  <link rel='stylesheet' href='assets/css/quanlysach.css'>
</head>

<body>
  <!-- MODAL -->.
  <div class='modal fade' id='modal-taotacgia' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
      <div class='modal-content'>
        <form action='' method='post'>
          <div class='modal-header'>
            <h5 class='modal-title' id='exampleModalLabel'>Thêm bản in</h5>
            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
          </div>
          <div class='modal-body'>
            <div class="mb-3">
              <?php
              global $conn;
              $idbook = $_GET['id'];
              $sql = "SELECT COALESCE(MAX(id_print), 0) AS max_id_print FROM `book_print` WHERE id_book = '$idbook';";
              $max_id_print = $conn->query($sql);
              $max_id_print = $max_id_print->fetch_assoc();
              $max_id_print = $max_id_print['max_id_print'] + 1;
              $ma_sach = $conn->query("SELECT ma_sach FROM book WHERE id_sach = '$idbook'")->fetch_assoc()['ma_sach'];
              ?>
              <label for="maPrint">Mã bản in</label>
              <input type="text" class="form-control" id="maPrint" name="maPrint" value="<?php echo $ma_sach.'-'.$max_id_print ?>">
            </div>
            <div class="mb-3">
              <label for="NXB">Nhà xuất bản</label>
              <select class="form-select" name="NXB" id="NXB" required >
                <?php
                $sql = "SELECT * FROM publisher";
                $nha_xb = $conn->query($sql);
                while ($row = $nha_xb->fetch_assoc()) {
                  echo "<option value='" . $row['id_nxb'] . "'>" . $row['ten'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="namXB">Năm xuất bản</label>
              <input type="number" class="form-control" id="namXB" name="namXB" required>
            </div>
            <div class="mb-3">
              <label for="soTrang">Số trang</label>
              <input type="number" class="form-control" id="soTrang" name="soTrang" required>
            </div>
            <div class="mb-3">
              <label for="khoGiay">Khổ giấy</label>
              <input type="text" class="form-control" id="khoGiay" name="khoGiay" required>
            </div>
            <div class="mb-3">
              <label for="giaTien">Giá</label>
              <input type="text" class="form-control" id="giaTien" name="giaTien" required>
            </div>
          </div>
          <div class='modal-footer'>
            <button type='reset' class='btn btn-secondary' data-bs-dismiss='modal'>Đóng</button>
            <button type='submit' class='btn btn-primary' name='taoBanin'>Tạo</button>
          </div>
        </form>
        <?php
        if (isset($_POST['taoBanin'])) {
          $maPrint = $_POST['maPrint'];
          $NXB = $_POST['NXB'];
          $namXB = $_POST['namXB'];
          $soTrang = $_POST['soTrang'];
          $khoGiay = $_POST['khoGiay'];
          $giaTien = $_POST['giaTien'];
          $sql = "INSERT INTO `book_print`(`ma_print`, `id_book`, `id_nxb`, `nam_xuat_ban`, `so_trang`, `kho_sach`, `gia`) VALUES ('$maPrint', '$idbook', '$NXB', '$namXB', '$soTrang', '$khoGiay', '$giaTien')";
          echo $sql;
          if (transitionSQL($sql)) {
            echo "<script>alert('Thêm thành công')</script>";
          } else {
            echo "<script>alert('Thêm thất bại')</script>";
          }
        }
        ?>
      </div>
    </div>
  </div>
  <!-- ======= Header ======= -->
  <?php require_once './includes/navbar.php'; ?>
  <!-- End Header -->
  <!-- ======= Sidebar ======= -->
  <?php require_once './includes/sidebar.php'; ?>
  <!-- End Sidebar-->

  <main id='main' class='main'>
    <div class='pagetitle'>
      <h1>Độc giả</h1>
    </div>
    <!-- End Page Title -->

    <section class='section'>
      <div class='row'>
        <div class='col-lg-12'>
          <div class='card'>
            <div class='card-body'>
              <div class='card-title'>
                <!-- <h3>Quản lý độc giả</h3> -->
              </div>
              <div class='docgia-info'>
                <h5 class='tone fw-bold'>Thông tin sách</h5>
                <?php
                $idbook = $_GET['id'];
                global $conn;
                $sql = "SELECT b.id_sach AS id_sach, b.ma_sach AS ma_sach, b.ten_sach AS ten_sach, f.ten AS linh_vuc, GROUP_CONCAT(DISTINCT c.ten ORDER BY c.ten ASC SEPARATOR ', ') AS the_loai, GROUP_CONCAT(DISTINCT a.ten ORDER BY a.ten ASC SEPARATOR ', ') AS tac_gia FROM book b LEFT JOIN field f ON b.linh_vuc = f.id_field LEFT JOIN book_category bc ON b.id_sach = bc.id_book LEFT JOIN category c ON bc.id_category = c.id_category LEFT JOIN book_author ba ON b.id_sach = ba.id_book LEFT JOIN author a ON ba.id_author = a.id_author 
                  WHERE b.id_sach = $idbook GROUP BY b.id_sach, b.ma_sach, b.ten_sach, f.ten;";
                $book = $conn->query($sql);
                $book = $book->fetch_assoc();
                $ma_sach = $book['ma_sach'];
                ?>
                <div class='row mb-3'>
                  <div class='col-3'>
                    <label for=''>Mã sách</label>
                    <input type='text' disabled class='form-control' value='<?php echo $book['ma_sach'] ?>'>
                  </div>
                  <div class='col-9'>
                    <label for=''>Tên</label>
                    <input type='text' disabled class='form-control' value='<?php echo $book['ten_sach'] ?>'>
                  </div>
                </div>
                <div class='row mb-3'>
                  <div class='col-6'>
                    <label for=''>Tác giả</label>
                    <input type='text' disabled class='form-control' value='<?php echo $book['tac_gia'] ?>'>
                  </div>
                  <div class='col-3'>
                    <label for=''>Lĩnh vực</label>
                    <input type='text' disabled class='form-control' value='<?php echo $book['linh_vuc'] ?>'>
                  </div>
                  <div class='col-3'>
                    <label for=''>Thể loại</label>
                    <input type='text' disabled class='form-control' value='<?php echo $book['the_loai'] ?>'>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="card-title">
                <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modal-taotacgia'>
                  Thêm bản in sách
                </button>
              </div>
              <div class='card-info'>
                <h5 class='tone fw-bold'>Thông tin các bản in</h5>
                <table class="table datatable align-middle">
                  <thead>
                    <th>Mã bản in</th>
                    <th>Nhà xuất bản</th>
                    <th>Năm XB</th>
                    <th>Số trang</th>
                    <th>Khổ</th>
                    <th>Tình trạng</th>
                    <th>#</th>
                  </thead>
                  <tbody>
                    <?php 
                    global $conn;
                    $sql = "SELECT bp.id_print AS id_print, bp.ma_print AS Ma_ban_in, p.ten AS Nha_xuat_ban, bp.nam_xuat_ban AS Nam_XB, bp.so_trang AS So_trang, bp.kho_sach AS Kho FROM book_print bp LEFT JOIN publisher p ON bp.id_nxb = p.id_nxb 
                    WHERE bp.id_book = $idbook";
                    $bookPrintSQL = $conn->query($sql);
                    while ($bookPrint = $bookPrintSQL->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $bookPrint['Ma_ban_in'] . "</td>";
                      echo "<td>" . $bookPrint['Nha_xuat_ban'] . "</td>";
                      echo "<td>" . $bookPrint['Nam_XB'] . "</td>";
                      echo "<td>" . $bookPrint['So_trang'] . "</td>";
                      echo "<td>" . $bookPrint['Kho'] . "</td>";
                      echo "<td></td>";
                      echo "<td></td>";
                      // echo "<td><a href='banin.php?id=" . $bookPrint['id_print'] . "' class='btn btn-primary'><i class='bi bi-eye-fill'></i></a> </td>";
                      echo "</tr>";
                    }
                    ?>
                  </tbody>
                </table>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id='footer' class='footer'>
    <div class='copyright'>
      &copy; Copyright <strong><span><?php echo WEB_NAME ?></span></strong>. All Rights Reserved
    </div>
  </footer>
  <!-- End Footer -->

  <a href='#' class='back-to-top d-flex align-items-center justify-content-center'><i
      class='bi bi-arrow-up-short'></i></a>

  <?php require_once './includes/linkscript.php'; ?>
</body>

</html>