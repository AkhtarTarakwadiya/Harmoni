<?php if(isset($_SESSION['success_message'])) { ?>
	<script type="text/javascript">
    	swal({
			title: "Success!",
			icon: "success",
			text: "<?php echo $_SESSION['success_message']; ?>",
			// type: "success",
			timer: 3000
	    });
	  </script>
<?php
	unset($_SESSION['success_message']); 
} elseif (isset($_SESSION['error_message'])) { ?>
	<script type="text/javascript">
    	swal({
			title: "Error!",
			icon: "error",
			text: "<?php echo $_SESSION['error_message']; ?>",
			// type: "error",
			timer: 4000
	    });
	</script>
<?php 
	unset($_SESSION['error_message']); 
} ?>