<!DOCTYPE html>
<html lang="en">
<?php require_once "config.php"; ?>

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Báo cáo phiếu mượn quá hạn - <?php echo WEB_NAME ?></title>
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
            <h5 class="modal-title" id="exampleModalLabel">Tạo phiếu mượn sách</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="nguoiMuon">Người mượn</label>
              <select class="form-control" id="nguoiMuon" name="nguoiMuon" required
                oninvalid="this.setCustomValidity('Trường này bắt buộc')">
                <?php
                global $conn;
                $sql = "SELECT rc.id_rd_card AS Ma_the_muon, r.ten AS Ten_doc_gia FROM reader_card rc LEFT JOIN reader r ON rc.id_reader = r.id_reader;";
                $doc_gia = $conn->query($sql);
                while ($row = $doc_gia->fetch_assoc()) {
                  echo "<option value='" . $row['Ma_the_muon'] . "'>" . $row['Ma_the_muon']. ' - '. $row['Ten_doc_gia'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="banIn">Sách (bản in)</label>
              <select class="form-control" id="banIn" name="banIn" required
                oninvalid="this.setCustomValidity('Trường này bắt buộc')">
                <?php
                global $conn;
                $sql = "SELECT bp.ma_print AS Ma_ban_in_sach, b.ten_sach AS Ten_sach, bp.id_print AS ID_ban_in, IF(p.ngay_tra IS NULL, 'Đang mượn', 'Đã trả') AS Trang_thai_muon FROM book_print bp LEFT JOIN book b ON bp.id_book = b.id_sach LEFT JOIN phieu p ON bp.ma_print = p.id_print;";
                $ban_in = $conn->query($sql);
                while ($row = $ban_in->fetch_assoc()) {
                  $flag = $row['Trang_thai_muon'] == 'Đang mượn' ? 'disabled' : '';
                  echo "<option value='" . $row['ID_ban_in'] . "' $flag>" . $row['Ma_ban_in_sach']. ' - '. $row['Ten_sach'] . "</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-primary" name="taoPhieu">Tạo</button>
          </div>
        </form>
        <?php
        if (isset($_POST['taoPhieu'])) {
          global $conn;
          $nguoiMuon = $_POST['nguoiMuon'];
          $sql ="SELECT rc.id_rd_card, DATE_ADD(CURDATE(), INTERVAL ct.tg_muon DAY) AS ngay_het_han, ct.phat AS phi_phat FROM reader_card AS rc JOIN card_type AS ct ON rc.id_cd_type = ct.id_cd_type 
            WHERE rc.id_rd_card = $nguoiMuon;";
          $the = $conn->query($sql);
          $the = $the->fetch_assoc();
          $banIn = $_POST['banIn'];
          $ngayMuon = date('Y-m-d');
          $ngayHetHan = $the['ngay_het_han'];
          $mucPhat = $the['phi_phat'];
          $tinhTrangTra = 'Chưa trả';

          $sql = "INSERT INTO phieu (id_rd_card, id_print, ngay_muon, ngay_het_han, muc_phat, tinh_trang_tra) 
            VALUES ('$nguoiMuon', '$banIn', '$ngayMuon', '$ngayHetHan', '$mucPhat', '$tinhTrangTra')";
          echo $sql;
          if (transitionSQL($sql)) {
            echo "<script>alert('Thêm phiếu thành công')</script>";
          } else {
            echo "<script>alert('Thêm phiếu thất bại')</script>";
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
      <h1>Báo cáo phiếu mượn quá hạn</h1>
    </div>
    <!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="card-title">
                <!-- <h3>Quản lý tác giả</h3> -->
                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-taotacgia">
                  Tạo phiếu
                </button> -->

              </div>
              <!-- Table with stripped rows -->
              <table class="table datatable align-middle">
                <thead>
                  <tr>
                    <th>STT</th>
                    <th>Mã thẻ</th>
                    <th>Độc giả</th>
                    <th>Sách</th>
                    <th>Ngày mượn</th>
                    <th>Ngày hết hạn</th>
                    <th>Ngày trả</th>
                    <th>Tình trạng</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  global $conn;
                  $sql = "SELECT p.id_phieu AS Ma_phieu, p.id_rd_card AS Ma_the_muon, b.ten_sach AS Sach, p.ngay_muon AS Ngay_muon, p.ngay_het_han AS Ngay_het_han, p.ngay_tra AS Ngay_tra, p.tinh_trang_tra AS Tinh_trang, r.ten AS Ten_doc_gia FROM phieu p LEFT JOIN book_print bp ON p.id_print = bp.id_print LEFT JOIN book b ON bp.id_book = b.id_sach LEFT JOIN reader_card rc ON p.id_rd_card = rc.id_rd_card LEFT JOIN reader r ON rc.id_reader = r.id_reader WHERE p.ngay_het_han < CURDATE();";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $i++ . "</td>";
                      echo "<td>" . $row['Ma_the_muon'] . "</td>";
                      echo "<td>" . $row['Ten_doc_gia'] . "</td>";
                      echo "<td>" . $row['Sach'] . "</td>";
                      echo "<td>" . date('d/m/Y', strtotime($row['Ngay_muon'])) . "</td>";
                      echo "<td>" . date('d/m/Y', strtotime($row['Ngay_het_han'])) . "</td>";
                      echo "<td>" . ($row['Ngay_tra'] ? date('d/m/Y', strtotime($row['Ngay_tra'])) : '') . "</td>";
                      echo "<td>" . $row['Tinh_trang'] . "</td>";
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