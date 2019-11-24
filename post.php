<?php include 'header.php'; ?>


<div class="container">
	<h2>Thêm trạng thái mới</h2>
	<form action="index.php" method="post" id="formSubmitted" class="md-form" enctype="multipart/form-data">
		<input type="hidden" name="formName" value="postStatus"/>
		<div class="form-group">
			<textarea class="form-control" rows="3" name="contentStatus" placeholder="Bạn đang nghĩ gì?" required></textarea>
		</div>
		<div class="custom-file">
			<input type="file" name="attach" class="custom-file-input" id="attach" accept="image/*" >
			<label class="custom-file-label" for="attach">Chọn hình ảnh đính kèm</label>
		</div>
		<div class="mt-3">
			<center>
				<button type="submit" class="btn btn-primary">Đăng trạng thái</button>
			</center>
		</div>
	</form>
</div>
<?php include 'footer.php'; ?>