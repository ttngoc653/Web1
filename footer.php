<?php 
//var_dump($_POST);
//var_dump($_FILES); 
//var_dump($infoUser);
?>
</div>
<script>
	$(document).ready(function () {

		$("#formSubmitted").submit(function (e) {

			$(".btn").attr("disabled", true);
			return true;

		});

		$(".custom-file-input").on("change", function() {
			var fileName = $(this).val().split("\\").pop();
			$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
		});
	});

</script>
</body>
</html>
<?php 
//var_dump($_POST);
//var_dump($_FILES); 
?>