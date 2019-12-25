
<script>
	function getButtonAdd(idPartner) {
		return '<button id="actWall" value="add" data-partnerid="'+idPartner+'" class="btn btn-info">Kết bạn</button>';
	}
	function getButtonAccept(idPartner) {
		return '<button id="actWall" value="accept" data-partnerid="'+idPartner+'" class="btn btn-primary">Chấp nhận yêu cầu kết bạn</button>';
	}
	function getButtonDelete(idPartner) {
		return '<button id="actWall" value="delete" data-partnerid="'+idPartner+'" class="btn btn-danger">Xóa lời mời</button>';
	}
	function getButtonDestroy(idPartner) {
		return '<button id="actWall" value="destroy" data-partnerid="'+idPartner+'" class="btn btn-danger">Hủy kết bạn</button>';
	}
	function getButtonSent() {
		return '<button class="btn btn-primary" disabled style="margin-right: 5px;">Đã gửi yêu cầu kết bạn</button>';
	}
	function getButtonFriending() {
		return '<button class="btn btn-primary" disabled style="margin-right: 5px;">Bạn bè</button>';
	}

	$("body").on("click","button#actWall",function() {
		var act=$(this).val();
		var idPartner=$(this).data('partnerid');
		var elementChanged=$(this).parent();
		var elementFollow=elementChanged.parent().find('button#actFollow');

		$.ajax({
			url:"<?php echo getCurUrl(); ?>/../ajaxProcess/actionFriend.php",
			method:"POST",
			data:{userid:<?php echo isset($infoUser)?$infoUser['ma']: "0"; ?>,partnerid:idPartner,act:act},
			success:function(data) {
				elementChanged.empty();
				if (act.localeCompare("add")==0) {
					elementChanged.append(getButtonSent());
					elementChanged.append(getButtonDelete(idPartner));

					elementFollow.val("add");
					actionProcessFollow(elementFollow);
				} else if (act.localeCompare("accept")==0) {
					elementChanged.append(getButtonFriending());
					elementChanged.append(getButtonDestroy(idPartner));

					elementFollow.val("add");
					actionProcessFollow(elementFollow);
				} else if (act.localeCompare("delete")==0 || act.localeCompare("destroy")==0) {
					elementChanged.append(getButtonAdd(idPartner));

					elementFollow.val("delete");
					actionProcessFollow(elementFollow);
				} 
			}
		})
	});
</script>