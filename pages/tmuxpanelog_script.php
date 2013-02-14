<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>

	var $alreadyDoneFetch = false;

	function fetchTMUXLog(){
	
		var url;
		
		if ( $alreadyDoneFetch )
		{
			$url = './tmuxbridge/fetch.php';
		}else{
			$url = './tmuxbridge/fetch.php?options=limit';
		}
	
		$.ajax({
			url: $url,
			success: function(data) {
				$("#list").prepend(data);
				if($("#list table").length > 200){
					$('#list table:gt(199)').remove();
				}
				$("#list p").fadeIn();
				setTimeout("fetchTMUXLog()", 1000);
			}
		});
	}
	
	$(function () {
		fetchTMUXLog();
	});
</script>