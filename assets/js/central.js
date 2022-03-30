// Central de funções JScript Javell_2018

//Set JQuery DatePicker

	function loadPhp(str) {
		var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
		document.getElementById("main").innerHTML = this.responseText;
		
		$( function() {
		$( ".date" ).datepicker();
		  
		$('.color-picker').spectrum({
			type: "text",
			hideAfterPaletteSelect: true,
			showAlpha: false,
			showButtons: false,
			allowEmpty: false
		  }); 
		} );

		$("#novaCategoria").click(function(e) {
			e.preventDefault();
			
				$.ajax({
				type: "POST",
				url: "catprocess.php",
				data: { 
					removeCategoria: '0',
					updateCategoria: '0',
					novaCategoria: $(this).val(),
					id_categoria: $('input#formCatId').val(),
					tx_color: $('input#formCatColor').val(),
					tx_nome: $('input#formCatName').val(),
						
				},
				
				success: function(result) {
					window.alert(result);
					
					
				},
				error: function(result) {
					window.alert(result);
					
				}
			});
		});

		$(".updateCategoria").click(function(e) {
			e.preventDefault();
			
			var id_categoria = $(this).attr("data-id_categoria");

			$.ajax({
				type: "POST",
				url: "catprocess.php",
				data: { 
					removeCategoria: '0',
					updateCategoria: $(this).val(),
					novaCategoria: '0',
					id_categoria: id_categoria,
					tx_color: $('input#color'+id_categoria).val(),
					tx_nome: $('input#nome'+id_categoria).val(),
						
				},
				
				success: function(result) {
					window.alert(result);
					loadPhp('configurar.php');
					
				},
				error: function(result) {
					window.alert(result);
					loadPhp('configurar.php');
				}
			});
		});

		$(".removeCategoria").click(function(e) {
			e.preventDefault();
			
			var id_categoria = $(this).attr("data-id_categoria");

			$.ajax({
				type: "POST",
				url: "catprocess.php",
				data: { 
					removeCategoria: $(this).val(),
					updateCategoria: '0',
					novaCategoria: '0',
					id_categoria: id_categoria,

						
				},
				
				success: function(result) {
					window.alert(result);
					loadPhp('configurar.php');
					
				},
				error: function(result) {
					window.alert(result);
					loadPhp('configurar.php');
				}
			});
		});	

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
		$( function() {
			$( ".date" ).datepicker();
		  } );
		$('.modal').on('hide.bs.modal', function (){
			atvPhp(str);
		});
		
		function calcular(){
		let soma = 0;
		let total = $('input#pedidoValor').val()*1;

		$( 'input.parcela' ).each(function() {
			soma = soma + $( this ).val()*1;
		  });
		
		let result = (soma / total) *100;
 
		$('span#resultado').text(Number(result).toFixed(1));
		$('span#soma').text(Number(soma).toFixed(2));

		}

		calcular();

		$('input.parcela').on('keyup', function (){
			calcular();
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
		$( function() {
			$( ".date" ).datepicker();
		  } );
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
		
		$( function() {
			$( ".date" ).datepicker();
		  } );

		$('.modal').on('hide.bs.modal', function (){
			loadFData(str);
		});
		
		$("#uploadBtn").click(function(e) {
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: "updoc.php",
				data: { 
					Fid: $('#Fid').val(), 
					uploadBtn: $(this).val(),
					DNome: $('#formDNome').val(),
					Text: $('#formDNome option:selected').text(),
					dataVencimento: $('#formVencimento').val()				

					},
				success: function(result) {
					window.alert(result);
					loadFData(str);						
				},
				error: function(result) {
					window.alert('erro');
					alert('error');
				}
			});
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
		$(document).ready(function(){
			$("#newButton").click(function(e) {
				e.preventDefault();
				$.ajax({
					type: "GET",
					url: "ucprocess.php",
					data: { 
						Cid: $('#Cid').val(), 
						newCuser: $(this).val(),
						Nome: $('#formNome').val(),
						Email: $('#formEmail').val(),
						Tel: $('#formTel').val(),
						processMode: '0'
					},
					success: function(result) {
						$('#modalNCuser').modal('hide');
						
					},
					error: function(result) {
						alert('error');
					}
				});
			});
			$("#updateButton").click(function(e) {
				e.preventDefault();
				$.ajax({
					type: "GET",
					url: "process.php",
					data: { 
						Cid: $('#CId').val(), 
						updateCliente: $(this).val(),
						CNome: $('#formCNome').val(),
						CNPJ: $('#formCNPJ').val(),
						
					},
					success: function(result) {
						loadCData(str);						
					},
					error: function(result) {
						alert('error');
					}
				});
			});
		
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

		$( function() {
			$( ".date" ).datepicker();
		  } );

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
			
			$.ajax({
				type: "GET",
				url: "pprocess.php",
				data: { 
					removePedido: '0',
					updatePedido: $(this).val(),
					updateAtividade: '0',
					removeFuncionario: '0',
					alocaFuncionario:'0',
					excluirAtividade:'0',
					grantAcessoConvidado: '0',
					removerAcessoConvidado: '0',
					grantAcessoUsuario: '0',
					removerAcessoUsuario: '0',
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
					$('#modalUPedido').modal('hide');
					loadCData( $("#Cid").val() );
					
				},
				error: function(result) {
					alert('error');
				}
			});
		});
		
		$(".button-update").click(function(event) {
			event.preventDefault();
			var id_atividade = 	 $(this).attr("data-id_atividade");

			$.ajax({
				type: "GET",
				url: "pprocess.php",
				data: { 
					updatePedido: '0',
					removePedido: '0',
					updateAtividade: $(this).val(),
					removeFuncionario: '0',
					alocaFuncionario:'0',
					excluirAtividade:'0',
					grantAcessoConvidado: '0',
					removerAcessoConvidado: '0',
					grantAcessoUsuario: '0',
					removerAcessoUsuario: '0',
					Descricao: $('#formAtvtx_descricao'+id_atividade).val(),
					Tipo: $('#formAtvtx_tipo'+id_atividade).val(),
					Qtd: $('#formAtvnb_qtd'+id_atividade).val(),
					Valor: $('#formAtvnb_valor'+id_atividade).val(),
					Inicio: $('#formAtvidata'+id_atividade).val(),
					Fim: $('#formAtvfdata'+id_atividade).val(),
					Atividade: $(this).attr("data-id_atividade")
					
				},
				
				success: function(result) {
					window.alert(result);
					loadPData(str,str2);
					//loadCData( $("#Cid").val() );
					
				},
				error: function(result) {
					alert('error');
				}
			});
			
		});

		$(".button-excluir").click(function(event) {
			event.preventDefault();

			$.ajax({
				type: "GET",
				url: "pprocess.php",
				data: { 
					updatePedido: '0',
					removePedido: '0',
					updateAtividade: '0',
					excluirAtividade:  $(this).val(),
					removeFuncionario: '0',
					alocaFuncionario:'0',
					grantAcessoConvidado: '0',
					removerAcessoConvidado: '0',
					grantAcessoUsuario: '0',
					removerAcessoUsuario: '0',
					Atividade: $(this).attr("data-id_atividade")
					
				},
				
				success: function(result) {
					window.alert(result);
					loadPData(str,str2);
					
				},
				error: function(result) {
					window.alert(result);
				}
			});
			
		});

		$(".button-remover").click(function(event) {
			event.preventDefault();

			$.ajax({
				type: "GET",
				url: "pprocess.php",
				data: { 
					updatePedido: '0',
					removePedido: '0',
					updateAtividade: '0',
					excluirAtividade:'0',
					removeFuncionario: $(this).val(),
					alocaFuncionario:'0',
					grantAcessoConvidado: '0',
					removerAcessoConvidado: '0',
					grantAcessoUsuario: '0',
					removerAcessoUsuario: '0',
					Fid: $(this).attr("data-id_funcionario"),
					Pid: $(this).attr("data-id_pedido")
					
				},
				
				success: function(result) {
					window.alert(result);
					loadPData(str,str2);
					
				},
				error: function(result) {
					window.alert(result);
				}
			});
			
		});

		$(".button-removeconvidado").click(function(event) {
			event.preventDefault();

			$.ajax({
				type: "GET",
				url: "pprocess.php",
				data: { 
					updatePedido: '0',
					removePedido: '0',
					updateAtividade: '0',
					excluirAtividade:'0',
					removeFuncionario: '0',
					alocaFuncionario:'0',
					grantAcessoConvidado: '0',
					removerAcessoConvidado: $(this).val(),
					grantAcessoUsuario: '0',
					removerAcessoUsuario: '0',
					CUid: $(this).attr("data-id_cliente_usr"),
					Pid: $(this).attr("data-id_pedido")
					
				},
				
				success: function(result) {
					window.alert(result);
					loadPData(str,str2);
					
				},
				error: function(result) {
					window.alert(result);
				}
			});
			
		});

		$(".button-removeusuario").click(function(event) {
			event.preventDefault();

			$.ajax({
				type: "GET",
				url: "pprocess.php",
				data: { 
					updatePedido: '0',
					removePedido: '0',
					updateAtividade: '0',
					excluirAtividade:'0',
					removeFuncionario: '0',
					alocaFuncionario:'0',
					grantAcessoConvidado: '0',
					removerAcessoConvidado: '0',
					grantAcessoUsuario: '0',
					removerAcessoUsuario: $(this).val(),
					Uid: $(this).attr("data-id_usuario"),
					Pid: $(this).attr("data-id_pedido")
					
				},
				
				success: function(result) {
					window.alert(result);
					loadPData(str,str2);
					
				},
				error: function(result) {
					window.alert(result);
				}
			});
			
		});

		$(".button-acessoconvidado").click(function(event) {
			event.preventDefault();

			$.ajax({
				type: "GET",
				url: "pprocess.php",
				data: { 
					updatePedido: '0',
					removePedido: '0',
					updateAtividade: '0',
					excluirAtividade:'0',
					grantAcessoConvidado: $(this).val(),
					removerAcessoConvidado: '0',
					grantAcessoUsuario: '0',
					removerAcessoUsuario: '0',
					removeFuncionario: '0',
					alocaFuncionario:'0',
					CUid: $('#formAcessoConvidado').val(),
					Pid: $(this).attr("data-id_pedido")
					
				},
				
				success: function(result) {
					window.alert(result);
					loadPData(str,str2);
					
				},
				error: function(result) {
					window.alert(result);
				}
			});
			
		});

		$(".button-acessousuario").click(function(event) {
			event.preventDefault();

			$.ajax({
				type: "GET",
				url: "pprocess.php",
				data: { 
					updatePedido: '0',
					removePedido: '0',
					updateAtividade: '0',
					excluirAtividade:'0',
					grantAcessoConvidado: '0',
					removerAcessoConvidado: '0',
					grantAcessoUsuario: $(this).val(),
					removerAcessoUsuario: '0',
					removeFuncionario: '0',
					alocaFuncionario:'0',
					Uid: $('#formAcessoUsuario').val(),
					Pid: $(this).attr("data-id_pedido")
					
				},
				
				success: function(result) {
					window.alert(result);
					loadPData(str,str2);
					
				},
				error: function(result) {
					window.alert(result);
				}
			});
			
		});
		

		$(".button-alocar").click(function(event) {
			event.preventDefault();

			$.ajax({
				type: "GET",
				url: "pprocess.php",
				data: { 
					updatePedido: '0',
					removePedido: '0',
					updateAtividade: '0',
					removeFuncionario: '0',
					excluirAtividade:'0',
					alocaFuncionario: $(this).val(),
					grantAcessoConvidado: '0',
					removerAcessoConvidado: '0',
					grantAcessoUsuario: '0',
					removerAcessoUsuario: '0',
					Fid: $('#formColaborador').val(),
					Pid: $(this).attr("data-id_pedido")
					
				},
				
				success: function(result) {
					window.alert(result);
					loadPData(str,str2);
					
				},
				error: function(result) {
					window.alert(result);
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
		
		$(document).ready(function(){
			$("#removeButton").click(function(e){
				e.preventDefault();
				$.ajax({
					type: "GET",
					url: "ucprocess.php",
					data:{
						cuid: $('#cuid').val(),
						removeCuser: $(this).val(),
						newCuser: '0',
						updateCuser: '0',
						sendNewLogin : '0'
					},
					success: function(result){
						$('#modalRCuser').modal('hide');
						loadCData($("#Cid").val());

					},
					error: function(result) {
						alert('error');
					}
				});
			});
			$("#updateButton").click(function(e) {
				e.preventDefault();
				$.ajax({
					type: "GET",
					url: "ucprocess.php",
					data: { 
						cuid: $('#cuid').val(), 
						updateCuser: $(this).val(),
						Nome: $('#formNome').val(),
						Email: $('#formEmail').val(),
						Tel: $('#formTel').val(),
						Acesso: $('#formAcesso').val(),
						newCuser: '0',
						removeCuser: '0',
						sendNewLogin : '0'
					},
					success: function(result) {
						window.alert(result);
						loadUCData(str,str2);						
					},
					error: function(result) {
						window.alert(result);
						alert('error');
					}
				});
			});
			$("#sendButton").click(function(e){
				e.preventDefault();
				$.ajax({
					type: "GET",
					url: "ucprocess.php",
					data:{
						cuid: $('#cuid').val(),
						Email: $('#formEmail').val(),
						sendNewLogin: $(this).val(),
						newCuser: '0',
						updateCuser: '0',
						removeCuser : '0'
					},
					success: function(result){
						window.alert(result);
						$('#modalSendConfirm').modal('hide');
						loadUCData(str,str2);

					},
					error: function(result) {
						window.alert(result);
						alert('error');
					}
				});
			});
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