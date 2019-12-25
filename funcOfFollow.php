
<script>
	function getButtonFollow(idPartner) {
		return '<button id="actFollow" value="add" data-partnerid="'+idPartner+'" class="btn btn-info">Theo dõi</button>';
	}
	function getButtonUnfollow(idPartner) {
		return '<button id="actFollow" value="delete" data-partnerid="'+idPartner+'" class="btn btn-danger">Bỏ theo dõi</button>';
	}
	function getButtonFollowing() {
		return '<button class="btn btn-primary" disabled style="margin-right: 5px;">Đang theo dõi</button>';
	}

	function actionProcessFollow(buttonActFollow) {
		var act=buttonActFollow.val();
		var idPartner=buttonActFollow.data('partnerid');
		var elementChanged=buttonActFollow.parent();

		$.ajax({
			url:"<?php echo getCurUrl(); ?>/../ajaxProcess/actionFollow.php",
			method:"POST",
			data:{userid:<?php echo isset($infoUser)?$infoUser['ma']: "0"; ?>,partnerid:idPartner,act:act},
			success:function(data) {
				elementChanged.empty();
				if (act.localeCompare("add")==0) {
					elementChanged.append(getButtonFollowing());
					elementChanged.append(getButtonUnfollow(idPartner));
				} else if (act.localeCompare("delete")==0) {
					elementChanged.append(getButtonFollow(idPartner));
				} 
			}
		})
	}

	$("body").on("click","button#actFollow",function() {
		actionProcessFollow($(this));
	});
</script>