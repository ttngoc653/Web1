<?php include 'header.php'; ?>
<div class="container">
  <?php 
  if (!(empty($_SESSION['user']) && empty($_COOKIE['user']))) {
    redirectTo("Đã đăng nhập rồi nên không thể thực hiện chức năng.");
  } else {
    ?>
    <h1>Đăng ký tài khoản</h1>

    <?php 
    if (isset($_POST['formName']) && "register" == $_POST['formName']) {
      $nguoidung=new nguoidung;
      echo '<div class="alert alert-warning" role="alert">';
      if (empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['showname']) || empty($_POST['birthyear']) || $_FILES['avatar']['error'] != 0) {
        echo 'THIẾU THÔNG TIN ĐỂ ĐĂNG KÝ. <a href="javascript:history.go(-1)">Nhấp nếu nuốn sửa lại thông tin trước.</a>';
      } else {
        $image=addslashes($_FILES['avatar']['tmp_name']);
        $name=addslashes($_FILES['avatar']['name']);
        $image=file_get_contents($image);
        $image=base64_encode($image);

        $keyCode=bin2hex(random_bytes(16));

        if ($nguoidung->sameMail($_POST['email']) || $nguoidung->samePhone($_POST['phone'])) {
          echo 'EMAIL HOẶC SỐ ĐIỆN THOẠI ĐÃ CÓ NGƯỜI ĐĂNG KÝ. <a href="javascript:history.go(-1)">Nhấp vào đây nếu muốn sửa lại thông tin đã nhập.</a>';
        } elseif ($nguoidung->addUser($_POST['email'], $_POST['phone'], $_POST['password'], $_POST['showname'], $_POST['birthyear'], $image, $keyCode) > 0) {
          $banbe=new banbe;
          $info=$nguoidung->getFromKey($_POST['email']);
          $banbe->addFriend($info['ma'], $info['ma']);
          $banbe->accept($info['ma'], $info['ma']);
          $nguoidung->setCode($_POST['email'], $keyCode);
          echo 'ĐÃ ĐĂNG KÝ THÀNH CÔNG. '.relatedemail::sendActiveAccount($_POST['email'], $keyCode).' Vui lòng kiểm tra email để kích hoạt tài khoản.';
          $daDangKyThanhCong=true;
        } else {
          echo 'ĐĂNG KÝ THẤT BẠI. <a href="javascript:history.go(-1)">Nhấp vào đây nếu muốn sửa lại thông tin đã nhập.</a>';
        }

      }
      echo '</div>';
    } 
    ?>
    <?php if (!isset($daDangKyThanhCong)): ?>
      <form action="register.php" method="POST" enctype="multipart/form-data" id="formSubmitted">
        <input type="hidden" name="formName" value="register">
        <div class="form-group">
          <input type="email" name="email" class="form-control" placeholder="Nhập email" required>
        </div>
        <div class="form-group">
          <input type="text" name="showname" class="form-control" placeholder="Nhập tên hiển thị" required>
        </div>
        <div class="form-group">
          <label class="form-check-label" for="selectYear">
            Chọn năm sinh
          </label>
          <select name="birthyear" id="selectYear" class="form-control" placeholder="Nhập năm sinh" required></select>
        </div>
        <div class="form-group">
          <input type="number" name="phone" class="form-control" placeholder="Nhập số điện thoại" required>
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
        </div>
        <div class="custom-file">
          <input type="file" accept="image/*" name="avatar" class="custom-file-input" id="avatarFile" required>
          <label class="custom-file-label" for="avatarFile" id="avatarFileName">Chọn hình đại diện</label>
        </div>
        <div class="form-group">
          <center>
            <div class="gallery"></div>
          </center>
        </div>
        <center>
          <button type="submit" class="btn btn-primary mt-3">Đăng ký</button>
        </center>
      </form>
      
      <script>
        var imagesPreview = function(input, placeToInsertImagePreview) {

          if (input.files) {
            var filesAmount = input.files.length;
            var limitFileUpload = <?php echo file_upload_max_size(); ?>;
            var limitFileUploadMB=limitFileUpload/1024/1024;
            $(placeToInsertImagePreview).empty();
            for (i = 0; i < filesAmount; i++) {
              if (input.files[i].size>limitFileUpload) {
                alert("File "+input.files[i].name+" sẽ không được lưu vì kích thước lớn hơn giới hạn server.\nLưu ý: Chỉ lưu file có kích thước "+limitFileUploadMB+"MB trở xuống.");
                return false;
              } else {
                var reader = new FileReader();

                reader.onload = function(event) {
                  $($.parseHTML('<img>')).attr('src', event.target.result).attr('height','100px').attr('class','rounded').attr('style','margin: 3px;').appendTo(placeToInsertImagePreview);
                }
                reader.readAsDataURL(input.files[i]);
              }
            }
          }
          return true;
        };

        $("body").on("change","input#avatarFile", function() {
          if(!imagesPreview(this, 'div.gallery'))
            $("label#avatarFileName").val("");;
        });
      </script>
    <?php endif ?>
    <?php 
  }
  ?>
</div>
<?php include 'footer.php'; ?>