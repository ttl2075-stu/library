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
            <h5 class='modal-title' id='exampleModalLabel'>Thêm độc giả</h5>
            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
          </div>
          <div class='modal-body'>
            <div class="mb-3">
              <label for="cardType">Loại thẻ</label>
              <select class="form-select" name="cardType" id="cardType" aria-label="Example select with button addon">
                <?php
                global $conn;
                $sql = "SELECT * FROM card_type";
                $card_type = $conn->query($sql);
                while ($row = $card_type->fetch_assoc()) {
                  $id_cd_type = $row['id_cd_type'];
                  $ten = $row['ten'];
                  echo "<option value='$id_cd_type'>$ten</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="kyGui">Ký gửi</label>
              <input type="text" class="form-control" id="kyGui" name="kyGui" required
                oninvalid="this.setCustomValidity('Trường này bắt buộc')">
            </div>
          </div>
          <div class='modal-footer'>
            <button type='reset' class='btn btn-secondary' data-bs-dismiss='modal'>Đóng</button>
            <button type='submit' class='btn btn-primary' name='taoThe'>Tạo</button>
          </div>
        </form>
        <?php
        if (isset($_POST['taoThe'])) {
          $id_cd_type = $_POST['cardType'];
          echo $id_cd_type;
          global $conn;
          $sql = "SELECT * FROM card_type WHERE id_cd_type = '$id_cd_type'";
          $result = $conn->query($sql);
          $result = $result->fetch_assoc();

          $id_reader = $_GET['id'];
          $ngay_dk = date('Y-m-d');
          echo $tg_het_han = $result['tg_het_han'];
          $ngay_hh = date('Y-m-d', strtotime("+$tg_het_han days"));
          $ky_gui = $_POST['kyGui'];
          $sl_con_lai = $result['sl_duoc_muon'];
          $sql = "INSERT INTO reader_card (id_reader, id_cd_type, ngay_dk, ngay_hh, ky_gui, sl_con_lai) VALUES ('$id_reader', '$id_cd_type', '$ngay_dk', '$ngay_hh', '$ky_gui', '$sl_con_lai')";
          // echo $sql;
          if (transitionSQL($sql)) {
            echo "<script>alert('Thêm thẻ độc giả thành công')</script>";
          } else {
            echo "<script>alert('Thêm thẻ độc giả thất bại')</script>";
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
                <h5 class='tone fw-bold'>Thông tin độc giả</h5>
                <?php
                $id_reader = $_GET['id'];
                global $conn;
                $reader = $conn->query("SELECT * FROM reader WHERE id_reader = '$id_reader'");
                $reader = $reader->fetch_assoc();
                ?>
                <div class='row mb-3'>
                  <div class='col-3'>
                    <label for=''>CCCD</label>
                    <input type='text' disabled class='form-control' value='<?php echo $reader['cccd'] ?>'>
                  </div>
                  <div class='col-6'>
                    <label for=''>Tên</label>
                    <input type='text' disabled class='form-control' value='<?php echo $reader['ten'] ?>'>
                  </div>
                  <div class='col-3'>
                    <label for=''>Ngày sinh</label>
                    <input type='text' disabled class='form-control'
                      value='<?php echo date('d/m/Y', strtotime($reader['ngay_sinh'])) ?>'>
                  </div>
                </div>
                <div class='row mb-3'>
                  <div class='col-3'>
                    <label for=''>Chức danh</label>
                    <input type='text' disabled class='form-control' value='<?php echo $reader['chuc_danh'] ?>'>
                  </div>
                  <div class='col-9'>
                    <label for=''>Địa chỉ</label>
                    <input type='text' disabled class='form-control' value='<?php echo $reader['dia_chi'] ?>'>
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
                  Thêm thẻ độc giả
                </button>
              </div>
              <div class='card-info'>
                <h5 class='tone fw-bold'>Thông tin thẻ độc giả</h5>
                <?php
                global $conn;
                $sql = "
                  SELECT 
                    rc.id_rd_card,
                    rc.id_reader,
                    rc.id_cd_type,
                    rc.ngay_dk,
                    rc.ngay_hh,
                    rc.ky_gui,
                    rc.sl_con_lai,
                    ct.ten AS card_type_name,
                    ct.phat AS fine_amount,
                    ct.sl_duoc_muon AS max_books,
                    ct.tg_muon AS borrow_duration
                  FROM 
                    reader_card rc
                  JOIN 
                    card_type ct
                  ON 
                    rc.id_cd_type = ct.id_cd_type
                  WHERE 
                    rc.id_reader = '$id_reader';
                ";
                $card_reader = $conn->query($sql);
                while ($row = $card_reader->fetch_assoc()) {
                  $id_rd_card = $row['id_rd_card'];
                  $ngay_dk = date('d/m/Y', strtotime($row['ngay_dk']));
                  $ngay_hh = date('d/m/Y', strtotime($row['ngay_hh']));
                  $trang_thai = date('d/m/Y') > $ngay_hh ? 'Hết hạn' : 'Còn hạn';
                  $ky_gui = $row['ky_gui'];
                  $sl_con_lai = $row['sl_con_lai'];
                  $card_type_name = $row['card_type_name'];
                  $fine_amount = $row['fine_amount'];
                  $max_books = $row['max_books'];
                  $borrow_duration = $row['borrow_duration'];
                  echo "
                    <div class='row mb-3'>
                      <div class='col-3'>
                        <label for=''>Mã thẻ</label>
                        <input type='text' disabled class='form-control' value='$id_rd_card'>
                      </div>
                      <div class='col-3'>
                        <label for=''>Ngày cấp</label>
                        <input type='text' disabled class='form-control' value='$ngay_dk'>
                      </div>
                      <div class='col-3'>
                        <label for=''>Ngày hết hạn</label>
                        <input type='text' disabled class='form-control' value='$ngay_hh'>
                      </div>
                      <div class='col-3'>
                        <label for=''>Trạng thái</label>
                        <input type='text' disabled class='form-control' value='$trang_thai'>
                      </div>
                      </div>
                      <div class='row mb-3'>
                      <div class='col-3'>
                        <label for=''>Ký gửi</label>
                        <input type='text' disabled class='form-control' value='$ky_gui'>
                      </div>
                      <div class='col-3'>
                        <label for=''>Mức phạt</label>
                        <input type='text' disabled class='form-control' value='$fine_amount%'>
                      </div>
                      <div class='col-3'>
                        <label for=''>Thời gian mượn</label>
                        <input type='text' disabled class='form-control' value='$borrow_duration ngày'>
                      </div>
                      <div class='col-3'>
                        <label for=''>SL còn được mượn</label>
                        <input type='text' disabled class='form-control' value='$sl_con_lai'>
                      </div>
                    </div>
                    <hr class='m-3'>
                  ";
                }
                ?>
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