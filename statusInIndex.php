
<?php 
if (isset($infoUser)) {
	$trangthai = new trangthai;
	$listStatus = $trangthai->getListRelate($infoUser['ma']);
	$infoUserCode = $infoUser['ma'];
	include 'foreachStatus.php';
	include 'funcOfStatus.php';
}
?>

<script>
	$("body").on("click", "button#btnToShowMorePosts", function(){
		var arrayStatus= [];
		$("button#itemLike.btn").each(function(index) {
			arrayStatus.push($(this).data('statuid'));
		});	//alert(arrayStatus);

		var elementAdd=$("div#showMoreStatus");
		$.ajax({
			url:"<?php echo getCurURL(); ?>/../ajaxProcess/actionGetStatusIndex.php",
			method:"POST",
			data:{userid:<?php echo $infoUser['ma'] ?>, arrayLoaded:arrayStatus},
			success:function(data) {//alert(data);
				elementAdd.before(data);
				elementAdd.remove();
			}
		})
	});
</script>