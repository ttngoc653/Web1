
<div class="container">
	<?php 
	if (isset($listStatus)) {
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
					echo "<div class='card-footer text-muted'><center>";
				foreach ($listImage as $j) {
					?>
						<img src="data:image;base64,<?php echo $j['anhdinhkem']; ?>" data-toggle="modal" data-target=".bd-example-modal-lg" height="100px" class="rounded" style="margin: 3px;" alt="">
					<?php
				}
				echo "</center></div>";
				} ?>
			</div>
			<?php
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
	    
	});

</script>