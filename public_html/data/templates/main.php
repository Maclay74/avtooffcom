<?php 
if(isset($_GET['clean']))
{
echo $content;
}
?>
<?php if(!isset($_GET['clean'])):?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>	
		<title>АСТО</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-datepicker/css/datepicker.css" rel="stylesheet">
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.ru.js" charset="UTF-8"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="http://malsup.github.com/jquery.form.js"></script> 
		<script src="http://malsup.github.com/jquery.form.js"></script>

	</head>
	
	<body>
		<div id="main_content" class="container">
			
			<?php require "header_login.php"?>
			<?php echo $content;?>
			
		</div>
			<?php //require "data/modules/window.php"?>
			<?php //require "data/modules/popover.php"?>
			
		
	</body>
	
</html>
	<?php endif?>