<html>
	<link href="<?=LIB?>sweetalert2/sweetalert2.min.css" rel="stylesheet">
	<style>
		.swal2-container{position: fixed;width: 100%;height: 100%;background: #ddd !important;}
		.swal2-popup{width: 25em;box-shadow: 0 0 5px 1px #bbb;}
		.swal2-container .swal2-icon{margin: .5em auto;}
		.swal2-container .swal2-title{margin: 5px 0;font-size: 20px;}
		.swal2-container .swal2-content{margin: 0;}
		.swal2-container .swal2-actions{margin: 0 auto;}
		.swal2-container .back-link{font-size: 15px;color: blue;}
		.swal2-container .swal2-confirm{background:none;padding:0;color:#3085d6;font-size:14px;box-shadow: none !important;}
		.swal2-container .swal2-confirm:hover{background:none!important;text-decoration:underline;}
	</style>
	<header><meta charset="utf-8"></header>
	<body>
		<script src="<?=LIB?>sweetalert2/sweetalert2.min.js"></script>
		<script>
			Swal.fire({
				title: "<?=$val?>",
				text: "",
				icon: "<?=$icon?>",
				timer: 3000,
				timerProgressBar: true,
				showCloseButton: false,
				showCancelButton: false,
				showConfirmButton: true,
				confirmButtonText: "Click vào đây nếu không muốn đợi lâu",
			}).then((result) => {
				location.href = "<?=$page?>";
			});
		</script>
	</body>
</html>