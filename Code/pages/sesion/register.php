<script src="./static/js/register.js"></script>
<div>
	<div class="w3-row-padding">
		<div class="w3-col m12">
			<div class="w3-card w3-round w3-white">
				<div class="w3-container w3-padding">
					<h3 class="w3-opacity w3-padding">Login</h3>
					<form action method="POST" class="w3-container w3-padding" onsubmit="return checkPass()">
						<input type="text" name="username" id="username" placeholder="Username" class="w3-border w3-padding"><br/><br/>
						<input type="password" name="password" id="password" placeholder="Password" class="w3-border w3-padding"><br/><br/>
						<input type="password" name="ConfirmPassword" id="ConfirmPassword" placeholder="ConfirmPassword" class="w3-border w3-padding"><br/><br/>
						<button type="send" class="w3-button w3-theme"><i class="fa fa-pencil"></i> &nbsp;Register</button> 
						<h4 class="w3-opacity w3-padding">Si ya tienes cuenta logeate aqui:</h4>
						<button onclick="window.location.href='./login.php'" type="button" class="w3-button w3-theme"><i class="fa fa-pencil"></i> &nbsp;Login</button> 
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="center quarter">
		<?php
			if (isset($notRegistered)){
		?>
		<h4 class="isa_error">No se ha podido registrar con los datos especificados</h4>
		<?php
			}else{
		?>
	<div class="" id="divCheckPasswordMatch">
		<?php
			}
		?>
	</div>
</div>