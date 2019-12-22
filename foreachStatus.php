
<div class="container">
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
								<h3><?php echo $i['hoten']; ?></h3>
								Đăng lúc: <?php echo $i['thoigiandang']; ?>
							</td>
						</tr>
					</table>
				</div>
				<div class="card-body">
					<p class="card-text"><?php echo $i['noidung']; ?></p>
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
					<button type="button" id="itemLike" class="btn btn-<?php if($checkLiked){ echo 'secondary'; } else { echo 'light'; }?>"  data-statuid="<?php echo $i['ma']; ?>"><i class="fas fa-american-sign-language-interpreting" style="font-size: 20px;"></i></button>
					<button type="button" class="btn btn-light">Bình luận</i></button>
					<div class="list-group">
					  <!-- <button type="button" class="list-group-item list-group-item-action">Porta ac consectetur ac</button> -->
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

<div id="checkAjax"></div>
<script>
	$(document).ready(function () {
		$("img.rounded").click(function () {
	        var $src = $(this).attr("src");
	        $("img.popup-image").attr("src", $src);
	    });
	    
	    $("button.btn.btn-light#itemLike").click(function () {
	    	var $statuId=$(this).data('statuid');
	    	//alert($statuId);

	    	$.ajax({
	    		url:"<?php echo getCurURL(); ?>/ajaxProcess/actionLike.php",
	    		method:"POST",
	    		data:{idStatu:$statuId, idUser:<?php echo $infoUser['ma']; ?>},
	    		success:function(data) {
	    		}
	    	});

			$(this).removeClass('btn-light').addClass('btn-secondary');
	    });

	    $("button.btn.btn-secondary#itemLike").click(function () {
	    	var $statuId=$(this).data('statuid');
	    	//alert($statuId);

	    	$.ajax({
	    		url:"<?php echo getCurURL(); ?>/ajaxProcess/actionUnlike.php",
	    		method:"POST",
	    		data:{idStatu:$statuId, idUser:<?php echo $infoUser['ma']; ?>},
	    		success:function(data) {
	    		}
	    	});

			$(this).removeClass('btn-secondary').addClass('btn-light');
	    });
	});

</script>