<div class="row">
	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="background-color: rgba(22,22,22,0.5);">
		<div class="modal-dialog modal-lg" style="max-width: 100vw;">
			<center>
				<img class="popup-image" src="" style=" max-width:100vw;" alt="" />
			</center>
		</div>
	</div>
</div>

<script>

$("body").on("click", "img.rounded", function() { //	$("img.rounded").click(function () {
	var src = $(this).attr("src");
	$("img.popup-image").attr("src", src);
});

$("body").on("click", "button#itemLike.btn", function() { //$("button#itemLike.btn").click(function () {
		var $statuId=$(this).data('statuid');
		var numberLiked=0;
		var elementSelected=$(this);
		if ($(this).hasClass("btn-light")) {
			$(this).removeClass('btn-light').addClass('btn-secondary');

			$.ajax({
				url:"<?php echo getCurURL(); ?>/../ajaxProcess/actionLike.php",
				method:"POST",
				data:{idStatu:$statuId, idUser:<?php echo $infoUser['ma']; ?>},
				success:function(data) {
					elementSelected.find('.badge.badge-light').text(data);
				}
			})
		} else {
			$(this).removeClass('btn-secondary').addClass('btn-light');

			$.ajax({
				url:"<?php echo getCurURL(); ?>/../ajaxProcess/actionUnlike.php",
				method:"POST",
				data:{idStatu:$statuId, idUser:<?php echo $infoUser['ma']; ?>},
				success:function(data) {
					elementSelected.find('.badge.badge-light').text(data);
				}
			})
		}
	});

	$("body").on("click", "button#showCmt", function() { // $("button#showCmt").click(function () {
		$(this).parent().find("div.itemsCmt").toggle();
	});

	$("body").on("submit", "form#formComment", function() { //$("form#formComment").submit(function(event) {
		var formData = {
			"content"	:$(this).find('textarea[name=content]').val(),
			"portid"	:$(this).find('input[name=postId').val(),
			"userid"	:<?php echo $infoUser['ma']; ?>

		};

		var itemsComment=$(this).parent().parent().find('div#itemsCmt');

		$.ajax({
			type:'POST',
			url: '<?php echo getCurURL(); ?>/../ajaxProcess/actionComment.php',
			data: formData,
			success:function(data) {
				itemsComment.html(data);
			}
		})

		$(this).find('textarea[name=content]').val('');
		event.preventDefault();
	});

	$("body").on("change", "select#privatePort", function() { //$("select#privatePort").change(function() {
		var formData = {
			"valueprivate"	:$(this).children("option:selected").val(),
			"statuid"	:$(this).data('statuid'),
			"userid"	:<?php echo $infoUser['ma']; ?>

		};

		$.ajax({
			type:'POST',
			url: '<?php echo getCurURL(); ?>/../ajaxProcess/actionChangePrivate.php',
			data:formData,
			success:function(data) {
				if (data!=1) {
					//alert(data);
				}
			}
		})
	});

</script>