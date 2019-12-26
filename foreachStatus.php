	<?php 
	if (isset($listStatus) && isset($infoUserCode)) {
		$thich= new thich;
		
		if (!isset($SESSION['listdisplayed'])) {
			$SESSION['listdisplayed'] = array();
		}

		foreach ($listStatus as $i) {
			array_push($SESSION['listdisplayed'], $i['ma']);
			$listImage = $trangthai->getListImageAttach($i['ma']);
			?>
			<div style="margin-top: 5px; margin-bottom: 5px;" class="card">
				<div class="card-header">
					<table>
						<tr>
							<td><img style="float: left; margin-right: 10px;" height="55" src="data:image;base64,<?php echo $i['avatar']; ?>" alt=""/></td>
							<td>
								<b><a href="wall.php?id=<?php echo $i['nguoidang']; ?>"><h3><?php echo $i['hoten']; ?></h3></a></b>
								Đăng lúc: <?php echo $i['thoigiandang']; ?>
								<?php if ($infoUserCode==$i['nguoidang']) { ?>
									<select name="privatePort" id="privatePort" data-statuid="<?php echo $i['ma']; ?>" class="form-control" required>
										<option value="2" <?php if ($i['riengtu']==2): ?>selected<?php endif ?>>Công khai</option>
										<option value="1" <?php if ($i['riengtu']==1): ?>selected<?php endif ?>>Bạn bè</option>
										<option value="0" <?php if ($i['riengtu']==0): ?>selected<?php endif ?>>Chỉ mình tôi</option>
									</select>
								<?php } else {
									echo '<a href="/chat.php?id='.$i['nguoidang'].'">(Nhắn tin)</a>';
								} ?>
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

				$checkLiked=$thich->check($infoUserCode,$i['ma']); 
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
		elseif (count($listStatus)<10) {
			echo "<div class='alert alert-light' role='alert'>Đã hiển thị hết tình trạng.</div>";
		} else {
			echo "<div id='showMoreStatus'><button type='button' id='btnToShowMorePosts' class='btn btn-primary btn-lg btn-block'>Nhấp để hiển thị thêm...</button></div>";
		}
	}
	?>
