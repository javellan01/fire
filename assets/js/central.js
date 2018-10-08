// Central de funções JScript Javell_2018

	function loadPhp(str) {
		var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
		document.getElementById("main").innerHTML = this.responseText;
		
		$('#modalPedido').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var cliente = button.data('cliente');
			var id_cliente = button.data('id_cliente');
			var modal = $(this);
			modal.find('#formSCliente.form-control').val(cliente);
			modal.find('#formidCliente.form-control').val(id_cliente);
		});
		
		$('#modalEdUsr').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var id_usuario = button.data('uid');
			var catuser = button.data('catuser');
			var uid = document.getElementById('uid'+id_usuario);
			
			var nome = uid.getElementsByClassName('uname');
			var tel = uid.getElementsByClassName('utel');
			var mail = uid.getElementsByClassName('umail');
			var cpf = uid.getElementsByClassName('ucpf');

			var modal = $(this);
			
			modal.find('#formUser.form-control').val(nome[0].innerHTML);
			modal.find('#formUserid.form-control').val(id_usuario);
			modal.find('#formCPF.form-control').val(cpf[0].innerHTML);
			modal.find('#formEmail.form-control').val(mail[0].innerHTML);
			modal.find('#formTel.form-control').val(tel[0].innerHTML);
			document.getElementById('formECatuser').options.selectIndex = catuser;
			console.log(catuser);
			console.log(document.getElementById('formECatuser').options.selectIndex);
			
		});
		
		$('#formCNPJ').mask('00.000.000/0000-00', {reverse: false});
		$('#formCPF').mask('000.000.000-00', {reverse: false});
		$('#formTel').mask('(00) #0000-0000', {reverse: false});
		$('#formData').mask('00/00/0000', {reverse: false});
		$('#formDataA').mask('00/00/0000', {reverse: false});
		$('#formDataB').mask('00/00/0000', {reverse: false});
		
		$('.modal').on('hide.bs.modal', function (){
			loadPhp(str);
		});
		
		}		
			
		
		};
	
	xhttp.open("GET", str, true);
	xhttp.send();
		}
		
	function atvPhp(str) {
		var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
		document.getElementById("main").innerHTML = this.responseText;
		
		$('#formData').mask('00/00/0000', {reverse: false});
		$('#formQtdin').mask('###0', {reverse: false});
		
		$('.modal').on('hide.bs.modal', function (){
			atvPhp(str);
		});
		
		$('#modalUpdate').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var atividade = button.data('atividade');
			var id_atividade = button.data('id_atividade');
			var modal = $(this);
			modal.find('.modal-title').text(atividade);
			modal.find('#formAid.form-control').val(id_atividade);
		});
		
		$('#formiData').mask('00/00/0000', {reverse: false});
		$('#formfData').mask('00/00/0000', {reverse: false});

		}
		
		};
		xhttp.open("GET", "atividades.php?pid="+str, true);
		xhttp.send();
		}
		
	function atv_uPhp(str) {
		var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
		document.getElementById("main").innerHTML = this.responseText;
		
		$('#formData').mask('00/00/0000', {reverse: false});
		$('#formQtdin').mask('###0', {reverse: false});
		
		$('#modalUpdate').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var atividade = button.data('atividade');
			var id_atividade = button.data('id_atividade');
			var modal = $(this);
			modal.find('.modal-title').text(atividade);
			modal.find('#formAid.form-control').val(id_atividade);
		});
		
		$('.modal').on('hide.bs.modal', function (){
			atv_uPhp(str);
		});
		
			}
			
		};
		xhttp.open("GET", "atividades_usr.php?pid="+str, true);
		xhttp.send();
		}
	//Processa Medicao
	function formMProc() {
		var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
		document.getElementById("process").innerHTML = this.responseText;
		}
		};
		
		var formData = $('form.medicao').serialize();
		
		toastr.info(formData);
		toastr.options.progressBar = true;
		
		xhttp.open("GET", "mprocess.php?"+formData, true);
		xhttp.send();
		}
	//Processo Base do Sistema	
	function formProc() {
		var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
		document.getElementById("process").innerHTML = this.responseText;
		}
		};
		
		var formData = $('form').serialize();

		toastr.info(formData);
		toastr.options.progressBar = true;
		
		xhttp.open("GET", "process.php?"+formData, true);
		xhttp.send();
	}

	function formFProc() {
			var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
			document.getElementById("process").innerHTML = this.responseText;
			}
			};

			var formData = $('form').serialize();
			
			toastr.info(formData);
			toastr.options.progressBar = true;
			
			xhttp.open("GET", "fprocess.php?"+formData, true);
			xhttp.send();
		}

	function loadFData(str) {
		var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
		document.getElementById("main").innerHTML = this.responseText;
		
		$('#formData').mask('00/00/0000', {reverse: false});
		$('#formQtdin').mask('###0', {reverse: false});
		$('#formCPF').mask('000.000.000-00', {reverse: false});

		$('.modal').on('hide.bs.modal', function (){
			loadFData(str);
		});
		
		}
			
		};
		
		xhttp.open("GET", "detfuncionario.php?fid="+str, true);
		xhttp.send();
	}	
	
	function loadCData(str) {
		var xhttp = new XMLHttpRequest();

		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
		document.getElementById("main").innerHTML = this.responseText;
		
		$('#formData').mask('00/00/0000', {reverse: false});
		$('#formQtdin').mask('###0', {reverse: false});
		$('#formCNPJ').mask('00.000.000/0000-00', {reverse: false});

		$('.modal').on('hide.bs.modal', function (){
			loadCData(str);
		});
		
		}
			
		};
		
		xhttp.open("GET", "detcliente.php?cid="+str, true);
		xhttp.send();
	}	

	function loadPData(str,str2) {
		var xhttp = new XMLHttpRequest();

		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
		document.getElementById("main").innerHTML = this.responseText;
		
		$('#formData').mask('00/00/0000', {reverse: false});
		$('#formQtdin').mask('###0', {reverse: false});
		$('#formCNPJ').mask('00.000.000/0000-00', {reverse: false});
				
		$('.modal').on('hide.bs.modal', function (){	loadPData(str,str2);	});
		$(document).ready(function(){
		$("#removeButton").click(function(e) {
			e.preventDefault();
			$.ajax({
				type: "GET",
				url: "pprocess.php",
				data: { 
					Pid: $("#Pid").val(), // < note use of 'this' here
					removePedido: $(this).val()
				},
				success: function(result) {
					$('#modalRPedido').modal('hide');
					loadCData( $("#Cid").val() );
					
				},
				error: function(result) {
					alert('error');
				}
			});
		});
		$("#updateButton").click(function(e) {
			e.preventDefault();
			
				
			console.log($(this).val());
			console.log($('#formCodigo').val());
			console.log($('#Pid').val());
			console.log($('#formiData').val());
			console.log($('#formtData').val());
			console.log($('#formStatus').val());
			console.log($('#formLocal').val());
			console.log($('#formValor').val());
			console.log($('#formRetencao').val());
			console.log($('#formCUser').val());
			console.log($('#formUser').val());	
			console.log($('#formControlTextarea').val());
			
			$.ajax({
				type: "GET",
				url: "pprocess.php",
				data: { 
					removePedido: '0',
					updatePedido: $(this).val(),
					Codigo: $('#formCodigo').val(),
					pid: $('#Pid').val(),
					idata: $('#formiData').val(),
					tdata: $('#formtData').val(),
					Status: $('#formStatus').val(),
					Local: $('#formLocal').val(),
					Valor: $('#formValor').val(),
					Retencao: $('#formRetencao').val(),
					Cuser: $('#formCUser').val(),
					User: $('#formUser').val(),
					pdDescricao: $('#formControlTextarea').val()
				},
				
				success: function(data) {
					console.log(data);
					$('#modalUPedido').modal('hide');
					loadCData( $("#Cid").val() );
					
				},
				error: function(result) {
					alert('error');
				}
			});
		});

		});
		
		}

		};
		
		xhttp.open("GET", "detpedido.php?pid="+str+"&cid="+str2, true);
		xhttp.send();
	}	

	function formPProc() {
		var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
		document.getElementById("process").innerHTML = this.responseText;
		}
		};

		var formData = $('form').serialize();
		
		toastr.info(formData);
		toastr.options.progressBar = true;
		
		xhttp.open("GET", "pprocess.php?"+formData, true);
		xhttp.send();
	}

	function loadUCData(str,str2) {
		var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
		document.getElementById("main").innerHTML = this.responseText;
		
		$('#formData').mask('00/00/0000', {reverse: false});
		$('#formQtdin').mask('###0', {reverse: false});
		$('#formCPF').mask('000.000.000-00', {reverse: false});

		$('.modal').on('hide.bs.modal', function (){
			loadUCData(str,str2);
		});
		
		}
			
		};
		
		xhttp.open("GET", "detucliente.php?cuid="+str+"&cid="+str2, true);
		xhttp.send();
	}	

	function formCProc() {
		var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
		document.getElementById("process").innerHTML = this.responseText;
		}
		};

		var formData = $('form').serialize();
		
		toastr.info(formData);
		toastr.options.progressBar = true;
		
		xhttp.open("GET", "ucprocess.php?"+formData, true);
		xhttp.send();
	}