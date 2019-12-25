<?php 
if (empty($infoUser)) {
	include 'header.php';
	$openFooter=0;
}

if (empty($infoUser)) {
	redirectTo("Đăng nhập để sử dụng tính năng.");
} else {
	?>
	<div>
		<h2>Đăng trạng thái</h2>
		<form action="index.php" method="post" id="formSubmitted" class="md-form" enctype="multipart/form-data">
			<input type="hidden" name="formName" value="postStatus"/>
			<div class="form-group">
				<textarea class="form-control" rows="3" name="contentStatus" placeholder="Bạn đang nghĩ gì?" required></textarea>
			</div>
			<div class="form-group">
				<label for="privatePort">Ai được xem bài viết này?</label>
				<select name="privatePort" class="form-control" required>
					<option value="2">Công khai</option>
					<option value="1">Bạn bè</option>
					<option value="0">Chỉ mình tôi</option>
				</select>
			</div>
			<div class="custom-file">
				<input type="file" name="attach[]" style="z-index: 10;" multiple class="custom-file-input" id="gallery-photo-add" accept="image/*" >
				<label class="custom-file-label" for="attach">Chọn hình ảnh đính kèm</label>
			</div>
			<div class="form-group">
				<center>
					<div class="gallery"></div>
				</center>
			</div>
			<div class="mt-3">
				<center>
					<button type="submit" class="btn btn-primary">Đăng trạng thái</button>
				</center>
			</div>
		</form>
	</div>
	<script>
		var imagesPreview = function(input, placeToInsertImagePreview) {

			if (input.files) {
				var filesAmount = input.files.length;
				var limitFileUpload = <?php echo file_upload_max_size(); ?>;
				var limitFileUploadMB=limitFileUpload/1024/1024;
				$(placeToInsertImagePreview).empty();
				for (i = 0; i < filesAmount; i++) {
					var reader = new FileReader();

					reader.onload = function(event) {
						$($.parseHTML('<img>')).attr('src', event.target.result).attr('height','100px').attr('class','rounded').attr('style','margin: 3px;').appendTo(placeToInsertImagePreview);
					}
					reader.readAsDataURL(input.files[i]);

					if (input.files[i].size>limitFileUpload) {
						alert("File "+input.files[i].name+" sẽ không được lưu vì kích thước lớn hơn giới hạn server.\nLưu ý: Chỉ lưu file có kích thước "+limitFileUploadMB+"MB trở xuống.");
					}
				}
			}

		};

		$("body").on("change","input#gallery-photo-add", function() {
			imagesPreview(this, 'div.gallery');
		});
	</script>
	<?php 
}
if (isset($openFooter)) {
	include 'footer.php';
}
?>