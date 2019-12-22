<div>
	<?php 
	if (isset($listStatus)) {
		$thich= new thich;
		
		foreach ($listStatus as $i) {
			$listImage = $trangthai->getListImageAttach($i['ma']);
			?>
			<div style="margin-top: 10px" class="card">
				<div class="card-header">
					<table>
						<tr>
							<td><img style="float: left;" height="55" src="data:image;base64,<?php echo $i['avatar']; ?>" alt=""/></td>
							<td>
								<b><a href="wall.php?id=<?php echo $i['nguoidang']; ?>"><h3><?php echo $i['hoten']; ?></h3></a></b>
								Đăng lúc: <?php echo $i['thoigiandang']; ?>
								<?php if ($infoUser['ma']==$i['nguoidang']) { ?>
									<select name="privatePort" id="privatePort" data-statuid="<?php echo $i['ma']; ?>" class="form-control" required>
										<option value="2" <?php if ($i['riengtu']==2): ?>selected<?php endif ?>>Công khai</option>
										<option value="1" <?php if ($i['riengtu']==1): ?>selected<?php endif ?>>Bạn bè</option>
										<option value="0" <?php if ($i['riengtu']==0): ?>selected<?php endif ?>>Chỉ mình tôi</option>
									</select>
								<?php } ?>
							</td>
						</tr>
					</table>
				</div>
				<div class="card-body">
					<p class="card-text"><?php echo htmlspecialchars($i['noidung'], ENT_QUOTES); ?></p>
				</div>		
				<?php
				if (count($listImage)>0) {
					echo "<div class='card-body'><center>";
					foreach ($listImage as $j) {
						?>
						<img src="data:image;base64,<?php echo $j['anhdinhkem']; ?>" data-toggle="modal" data-target=".bd-example-modal-lg" height="100px" class="rounded" style="margin: 3px;" alt="">
						<?php
					}
					echo "</center></div>";
				}

				$checkLiked=$thich->check($infoUser['ma'],$i['ma']); 
				?>
				<div class="card-footer text-muted">
					<button type="button" id="itemLike" class="btn btn-<?php if($checkLiked){ echo 'secondary'; } else { echo 'light'; }?>"  data-statuid="<?php echo $i['ma']; ?>"><i class="fas fa-american-sign-language-interpreting" style="font-size: 20px;"></i><span class="badge badge-light"><?php echo $thich->countLiked($i['ma']); ?></span></button>
					<button type="button" id="showCmt" class="btn btn-light">Bình luận</i></button>
					<div class="itemsCmt" style="display: none; margin-top: 5px;">
						<div id="itemsCmt">
							<?php 
							$statuKey = $i['ma'];

							include 'foreachComments.php';
							?>
						</div>
						<div id="formCmt">
							<form method="POST" id="formComment">
								<input type="hidden" name="postId" value="<?php echo $i['ma']; ?>">
								<div class="form-group row">
									<div class="col-11"><textarea class="form-control" name="content" placeholder="Viết bình luận..." rows="1" required></textarea></div>
									<div class="col-1"><input type="submit" class="btn btn-light float-right" value="Bình luận"></div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		if (count($listStatus)==0) {
			echo "<div class='alert alert-light' role='alert'>Không còn tình trạng để hiển thị.</div>";
		}
	}
	?>
	<div class="row">
		<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="background-color: rgba(22,22,22,0.5);">
			<div class="modal-dialog modal-lg" style="max-width: 100vw;">
				<center>
					<img class="popup-image" src="" style=" max-width:100vw;" alt="" />
				</center>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		$("img.rounded").click(function () {
			var $src = $(this).attr("src");
			$("img.popup-image").attr("src", $src);
		});

		$("button#itemLike.btn").click(function () {
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

		$("button#showCmt").click(function () {
			$(this).parent().find("div.itemsCmt").toggle();
		});

		$("form#formComment").submit(function(event) {
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

		$("select#privatePort").change(function() {
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
						alert(data);
					}
				}
			})
		});
	});

</script>