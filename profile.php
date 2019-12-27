<?php 
include 'header.php';
?>
<div>
  <?php 
  if (empty($infoUser)) {
    header('Location: index.php');
  } else {
    $nguoidung = new nguoidung;
    if (isset($_POST['act'])) {
      if (empty($_POST['showname']) || empty($_POST['phone']) || empty($_POST['birthyear'])) {
        echo '<script type="text/javascript" charset="utf-8">alert("Không thay đổi được do thiếu thông tin.");</script>';
      } elseif ($_FILES['avatar']['error'] != 0 &&
        $nguoidung->changeInfo($infoUser['ma'], $_POST['showname'], $_POST['phone'], $_POST['birthyear'])){
        echo '<script type="text/javascript" charset="utf-8">alert("Thông tin đã được cập nhật.");</script>';
      } else {
        $image=addslashes($_FILES['avatar']['tmp_name']);
        $name=addslashes($_FILES['avatar']['name']);
        $image=file_get_contents($image);
        $image=base64_encode($image);
        if ($nguoidung->changeInfoHasAvatar($infoUser['ma'], $_POST['showname'], $_POST['phone'], $image, $_POST['birthyear'])) {
         echo '<script type="text/javascript" charset="utf-8">alert("Thông tin đã được cập nhật cả ảnh đại diện.");</script>';		
       } else {
         echo '<script type="text/javascript" charset="utf-8">alert("Cập nhật thông tin thất bại.");</script>';
       }

     }      
   }
   $infoUser=$nguoidung->getFromId($infoUser['ma']);
   ?>
   <div class="container">
    <h2>Quản lý thông tin cá nhân</h2>
    <form  action="profile.php" method="POST" id="formSubmitted" enctype="multipart/form-data">
      <input type="hidden" name="act" value="update"/>
      <div class="form-group">
        <label for="name">Họ và tên</label>
        <input type="text" name="showname" class="form-control" id="name" aria-describedby="nameHelp" placeholder="Điền họ và tên vào đây" required value="<?php echo $infoUser['hoten']; ?>" />
      </div>
        <div class="form-group">
          <label class="form-check-label" for="selectYear">
            Chọn năm sinh
          </label>
          <select name="birthyear" id="selectYear" class="form-control" placeholder="Nhập năm sinh" required></select>
        </div>
      <div class="form-group">
        <label for="phone">Số điện thoại</label>
        <input type="phone" name="phone" class="form-control" id="phone" placeholder="Điền số điện thoại vào đây" required value="<?php echo $infoUser['sdt']; ?>" />
      </div>
      <div class="form-group">
        <label for="phone">Email</label>
        <input type="mail" name="email" class="form-control" id="mail" placeholder="Điền mail vào đây" required value="<?php echo $infoUser['email']; ?>" disabled />
      </div>
      <div class="custom-file">
        <input type="file" name="avatar" class="custom-file-input" id="avatar" accept="image/*" />
        <label class="custom-file-label" for="avatar">Chọn ảnh đại diện...</label>
        <div class="invalid-feedback"></div>
      </div>
      <div class="form-group">
        <center>
        <div class="gallery"></div>
        </center>
      </div>
      <div class="row mt-3">
        <div class="col" style="text-align: left;">
          <button type="submit" class="btn btn-primary">Cập nhật</button>
          <img style="float: right;" src="data:image;base64,<?php echo $infoUser['avatar']; ?>" height="200" alt="">
        </div>
      </div>
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
            input.empty();
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

    $("body").on("change","input#avatar", function() {
      if(!imagesPreview(this, 'div.gallery')){

      }
    });
    </script>
  </div>
  <?php 
}
?>
</div>
<?php include 'footer.php'; ?>