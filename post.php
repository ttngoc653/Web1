<?php/* include 'header.php';*/ ?>


<div>
	<h2>Đăng trạng thái</h2>
	<form action="index.php" method="post" id="formSubmitted" class="md-form" enctype="multipart/form-data">
		<input type="hidden" name="formName" value="postStatus"/>
		<div class="form-group">
			<textarea class="form-control" rows="3" name="contentStatus" placeholder="Bạn đang nghĩ gì?" required></textarea>
		</div>
		<div class="custom-file">
			<input type="file" name="attach[]" multiple class="custom-file-input" id="gallery-photo-add" accept="image/*" >
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
$(document).ready(function(){
  $(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

			$("div.gallery").empty();
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).attr('height','100px').attr('class','rounded').attr('style','margin: 3px;').appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#gallery-photo-add').on('change', function() {
        imagesPreview(this, 'div.gallery');
    });
});
});
</script>

<?php /*include 'footer.php';*/ ?>