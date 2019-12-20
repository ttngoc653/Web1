
<div class="container">
	<?php 
	if (isset($listStatus)) {
		foreach ($listStatus as $i) {
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
				<?php if (isset($i['anhdinhkem'])): ?>
					<div class="card-footer text-muted">
						<img src="data:image;base64,<?php echo $i['anhdinhkem']; ?>" style="max-height: 100%; max-width: 100%;" alt="">
					</div>
				<?php endif ?>
			</div>
			<?php
		}
	}
	?>
</div>