
</div>
<footer style="margin: 10px;">
	<!-- <?=ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');?>
	 <?=ini_get('upload_max_filesize')?>

	-->
</footer>
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
	});

	$("body").on("change", ".custom-file-input", function() { //$(".custom-file-input").on("change", function() {
		var fileName = $(this).val().split("\\").pop();
		$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
</script>
</body>
</html>
<?php 
ob_end_flush();
//var_dump($_POST);
/*
	$(document).ready(function(){
	  var contentHtml= document.documentElement.innerHTML;
	  alert(contentHtml);
	  contentHtml=contentHtml.replace('﻿','');
	  document.write(contentHtml);
	});

*/
//var_dump($_FILES); 
	?>