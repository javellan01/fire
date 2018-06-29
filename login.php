
<!DOCTYPE html>
<html>
<head>
	<title>Login | FireSystems.online</title>
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<script src="./assets/js/jquery-3.3.1.min.js"></script>
	<script src="./assets/js/jquery.mask.js"></script>
	<script src="./assets/js/md5.min.js"></script>
	<style type="text/css">
		@import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300);
		* {
		  box-sizing: border-box;
		  margin: 0;
		  padding: 0;
		  font-weight: 400;
		}
		body {
		  font-family: 'Source Sans Pro', sans-serif;
		  color: white;
		  font-weight: 400;
		}
		body ::-webkit-input-placeholder {
		  /* WebKit browsers */
		  font-family: 'Source Sans Pro', sans-serif;
		  color: white;
		  font-weight: 300;
		}
		body :-moz-placeholder {
		  /* Mozilla Firefox 4 to 18 */
		  font-family: 'Source Sans Pro', sans-serif;
		  color: white;
		  opacity: 1;
		  font-weight: 300;
		}
		body ::-moz-placeholder {
		  /* Mozilla Firefox 19+ */
		  font-family: 'Source Sans Pro', sans-serif;
		  color: white;
		  opacity: 1;
		  font-weight: 300;
		}
		body :-ms-input-placeholder {
		  /* Internet Explorer 10+ */
		  font-family: 'Source Sans Pro', sans-serif;
		  color: white;
		  font-weight: 300;
		}
		p{
		  font-family: 'Source Sans Pro', sans-serif;
		  color: white;
		  font-weight: 300;

		  color: white;
		  font-size: 1.3em;
		  margin: 15px 0 10px;
		}
		.wrap {
		  background: #a60117 ;
		  background: linear-gradient(to bottom right, #c95 0%, #a60117 100%);
		  position: absolute;
		  top: 0;
		  left: 0;
		  width: 100%;
		  overflow: hidden;
		}/*
		.wrap.form-success .container h1 {
		  -webkit-transform: translateY(85px);
		          transform: translateY(85px);
		}*/
		.container {
		  max-width: 600px;
		  margin: 0 auto;
		  padding: 25vh 0 0;
		  height: 100vh;
		  text-align: center;
		}
		.container h1 {
		  font-size: 40px;/*
		  transition-duration: 1s;
		  transition-timing-function: ease-in-put;*/
		  font-weight: 400;
		}
		form {
		  padding: 20px 0;
		  position: relative;
		  z-index: 2;
		}
		form .error{color: yellow;}
		form input {
		  -webkit-appearance: none;
		     -moz-appearance: none;
		          appearance: none;
		  outline: 0;
		  border: 1px solid rgba(255, 255, 255, 0.4);
		  background-color: rgba(255, 255, 255, 0.2);
		  width: 250px;
		  border-radius: 3px;
		  padding: 10px 15px;
		  margin: 0 auto 10px auto;
		  display: inline-block;
		  text-align: center;
		  font-size: 18px;
		  color: white;
		  transition-duration: 0.25s;
		  font-weight: 300;
		}
		form input:hover {
		  background-color: rgba(255, 255, 255, 0.4);
		}
		form input:focus {
		  background-color: white;
		  width: 300px;
		  color: #004472;
		}
		form button {
		  -webkit-appearance: none;
		     -moz-appearance: none;
		          appearance: none;
		  outline: 0;
		  background-color: white;
		  border: 0;
		  padding: 10px 15px;
		  color: #004472;
		  border-radius: 3px;
		  width: 250px;
		  cursor: pointer;
		  font-size: 18px;
		  transition-duration: 0.25s;
		}
		form button:hover {
		  background-color: #f5f7f9;
		}
		.bg-bubbles {
		  position: absolute;
		  top: 0;
		  left: 0;
		  width: 100%;
		  height: 100%;
		  z-index: 1;
		}
		.bg-bubbles li {
		  position: absolute;
		  list-style: none;
		  display: block;
		  width: 40px;
		  height: 40px;
		  background-image: url('img/er-sprink.png');
		  background-size: cover;
		  bottom: -160px;
		  -webkit-animation: square 25s infinite;
		  animation: square 25s infinite;
		  transition-timing-function: linear;
		}
		.bg-bubbles li:nth-child(1) {
		  left: 10%;
		}
		.bg-bubbles li:nth-child(2) {
		  left: 20%;
		  width: 80px;
		  height: 80px;
		  -webkit-animation-delay: 2s;
		          animation-delay: 2s;
		  -webkit-animation-duration: 17s;
		          animation-duration: 17s;
		}
		.bg-bubbles li:nth-child(3) {
		  left: 25%;
		  -webkit-animation-delay: 4s;
		          animation-delay: 4s;
		}
		.bg-bubbles li:nth-child(4) {
		  left: 40%;
		  width: 60px;
		  height: 60px;
		  -webkit-animation-duration: 22s;
		          animation-duration: 22s;
		  
		}
		.bg-bubbles li:nth-child(5) {
		  left: 70%;
		}
		.bg-bubbles li:nth-child(6) {
		  left: 80%;
		  width: 120px;
		  height: 120px;
		  -webkit-animation-delay: 3s;
		          animation-delay: 3s;
		  
		}
		.bg-bubbles li:nth-child(7) {
		  left: 32%;
		  width: 160px;
		  height: 160px;
		  -webkit-animation-delay: 7s;
		          animation-delay: 7s;
		}
		.bg-bubbles li:nth-child(8) {
		  left: 55%;
		  width: 20px;
		  height: 20px;
		  -webkit-animation-delay: 15s;
		          animation-delay: 15s;
		  -webkit-animation-duration: 40s;
		          animation-duration: 40s;
		}
		.bg-bubbles li:nth-child(9) {
		  left: 25%;
		  width: 10px;
		  height: 10px;
		  -webkit-animation-delay: 2s;
		          animation-delay: 2s;
		  -webkit-animation-duration: 40s;
		          animation-duration: 40s;
		  
		}
		.bg-bubbles li:nth-child(10) {
		  left: 90%;
		  width: 160px;
		  height: 160px;
		  -webkit-animation-delay: 11s;
		          animation-delay: 11s;
		}
		@-webkit-keyframes square {
		  0% {
		    -webkit-transform: translateY(0);
		            transform: translateY(0);
		  }
		  100% {
		    -webkit-transform: translateY(-700px) rotate(600deg);
		            transform: translateY(-700px) rotate(600deg);
		  }
		}
		@keyframes square {
		  0% {
		    -webkit-transform: translateY(0);
		            transform: translateY(0);
		  }
		  100% {
		    -webkit-transform: translateY(-700px) rotate(600deg);
		            transform: translateY(-700px) rotate(600deg);
		  }
		}
	</style>
</head>
<body>

	<div class="wrap">
		<div class="container">
			<h1>FIRESYSTEMS.online</h1>
			<p>Informe Login e Senha para acessar o sistema</p>
			
			<form class="acessoOnline" autocomplete="off" method="POST" action="agent.php">
				<div>
					<label class="error" id="usuario_erro" for="usuario">!</label>
					<input type="text" name="usuario" id="usuario" placeholder="Identificação de Usuário" autocomplete="nope" />
					<input type="text" name="fakeusernameremembered" style="display:none" />
					<label class="error" id="usuario_erro" for="usuario"/>!</label>
				</div>
				<div>
					<label class="error" id="senha_erro" for="senha">!</label>
					<input type="password" name="senha" id="senha" placeholder="Entrar Senha" autocomplete="new-password" />
					<input type="text" name="fakepasswordremembered" style="display:none" />
					<label class="error" id="senha_erro" for="senha">!</label>
					<br />
<!--
			<input type="text" id="teste" name="usuario" placeholder="eg. 000.000.000-00" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" max-lenght="14" /> 
<!---->
				</div>
				<button type="submit" class="login-button">Entrar</button>
			</form>

		</div>
		
		<ul class="bg-bubbles">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
		    $('#usuario').mask('000.000.000-00');
		

		$('.error').hide();
		$(".login-button").submit(function(event){
//			 event.preventDefault();


			var name = $("input#usuario").val();
			if(name == "") {
				$("label#usuario_erro").show();
			    $("input#usuario").focus().css('border', '2px solid orange');
			    return false;
		    } 

			var passkey = $("input#senha").val();
			if(passkey == "") {
				$("label#senha_erro").show();
			    $("input#senha").focus().css('border', '2px solid orange');
			    return false;
		    } 

//			    var data =  $('form').serialize();alert(data);

			var usuario = $("input#usuario").val();
			var senha = $("input#senha").val();
			
	//		var dataString = 'usuario='+ usuario + '&senha=' + senha;
			
			$.ajax({
				type: "POST",
			    url: "agent.php",
	    		dataType: 'JSON',
			    data: {
					'usuario' : usuario,
					'senha' : senha
					
					  }	,
			    success: function(result) {
//						alert(result.categoria);
						alert('VAI');
			    	if(!result){

			    		alert('algo de errado não está certo');
					} else{
						alert('FOI CERTO!');
						$('form').fadeOut(500);
						$('p').fadeOut(500);
						$('.wrap').addClass('form-success');
			//			$('acessoOnlinve').delay(500).submit();
						$('h1').fadeOut(function() {
							$(this).fadeIn(2000).text("Acesso Permitido !").css('margin-top', '120px');
						});
						setTimeout(function(){ window.location = 'central.php'; }, 5000); 
			    	}

			    /*
				    $('form').html("<div id='message'></div>");
				    $('#message').html("<h2>Contact Form Submitted!</h2>")
				    .append("<p>We will be in touch soon.</p>")
				    .hide()
				    .fadeIn(1500, function() {
				    	$('#message').append("<img id='checkmark' src='images/check.png' />");
		    		});
		    	}  
		    	error: function (jqXHR, exception) {
			        var msg = '';
			        if (jqXHR.status === 0) {
			            msg = 'Not connect.\n Verify Network.';
			        } else if (jqXHR.status == 404) {
			            msg = 'Requested page not found. [404]';
			        } else if (jqXHR.status == 500) {
			            msg = 'Internal Server Error [500].';
			        } else if (exception === 'parsererror') {
			            msg = 'Requested JSON parse failed.';
			        } else if (exception === 'timeout') {
			            msg = 'Time out error.';
			        } else if (exception === 'abort') {
			            msg = 'Ajax request aborted.';
			        } else {
			            msg = 'Uncaught Error.\n' + jqXHR.responseText;
			        }
			        console.log(msg);
/**/			    }
	  		});
			return false;
		});
	});	
	</script>

</body>
</html>