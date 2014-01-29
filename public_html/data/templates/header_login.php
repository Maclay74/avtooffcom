<?php 
$User = User::getInstance();
?>

<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
			<a class="brand" href="/">АСТО</a>
			
			 <?php if (isset($User->login)):?>
				<a class="btn" href="?event=index"><i class="icon-home"></i> Домой</a> 
				
			<?php endif ?>
			<?php

				if (isset($User->login))
				{
					echo "<a href='?event=login&action=logout' class= 'btn pull-right'><i class='icon-off'></i> Выйти</a>";
					echo "<div class='navbar-text pull-right'>Вы вошли как: <b>".$User->login."&nbsp;</b></div>";
				}
				else
				{
					echo "<a href='?event=login' class= 'btn pull-right'><i class='icon-off'></i> Войти</a>";
				}
				
				?>	 
			</div>
			
			
		</div>
		
	</div>