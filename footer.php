<?php 
//var_dump($_POST);
//var_dump($_FILES); 
//var_dump($infoUser);
?>
</div>
<script>
	$(document).ready(function () {

		if ($('#selectYear').length) {
			// create option to select year of birth
			var year = 1900;
			var till = new Date().getFullYear();
			var options = "";
			var yearOld = 0;
			<?php 
			if (isset($infoUser)) {
				echo "yearOld= ".$infoUser['namsinh'].";
				";
			}
			?>
			for(var y=till; year<=y; y--){
				options += "<option "+((yearOld==y) ? "selected" : "") + ">"+ y +"</option>";
			}
			document.getElementById("selectYear").innerHTML = options;
		    // end: create option...

		    $("#formSubmitted").submit(function (e) {

		    	$(".btn").attr("disabled", true);
		    	return true;

		    });
		}

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