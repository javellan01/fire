// Bagunça Central de funções JScript Javell_2018-2022

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
		
		var formatter = new Intl.NumberFormat('pt-BR', {
			style: 'currency',
			currency: 'BRL',
		  });

		function calcular(){
		let soma = 0;
		let total = $('input#pedidoValor').val()*1;

		$('input.parcela').each(function() {
			soma = soma + $( this ).val()*1;
		  });
		
		let result = (soma / total) *100;

		$('span#resultado').text(Number(result).toFixed(2));
		$('span#soma').text(formatter.format(soma));

		}

		calcular();

		$('input.parcela').on('keyup', function (){
			calcular();
			let indice = $(this).attr("data-aid");
			let nb_valor = $(this).attr("data-nb_valor")*1;
			let limit = $(this).attr("data-limit")*1;
			let current = $(this).val()*1;
			limit = limit - current;
			let result = (current / nb_valor) * 100;
			$('span#percent'+indice).text(Number(result).toFixed(2));
			$('span#limit'+indice).text(formatter.format(limit));

		});

		$('#modalAtividadeCalendario').on('show.bs.modal', function(event){ 
			let button = $(event.relatedTarget);
			$(this).find('#descricao').text(button.data('descricao'));
			//let events = geteventChart(button.val());
			var calendarEl = document.getElementById('calendario');
			
			var calendar = new FullCalendar.Calendar(calendarEl, {
				locale: 'pt-br',
				headerToolbar: {
				  left: 'prevYear,prev,next,nextYear today',
				  center: 'title',
				  right: 'dayGridMonth,dayGridWeek'
				},
				weekNumbers: true,
				weekNumberTitle: 'W',
				weekNumberCalculation: 'ISO',
				editable: false,
				height: 480,
				dayMaxEvents: true, // allow "more" link when too many events
				events: {
					url: 'loadEventsAtividade.php',
					method: 'POST',
					extraParams: {
						id_atividade: button.val(),
						
					  }
				},
				eventDidMount: function(info){
					if(info.event.extendedProps.quantidade){
					 $(info.el).popover({
					  title: info.event.title,
					  content: 'Cadastrado: '+info.event.extendedProps.quantidade+', por: '+info.event.extendedProps.usuario+'.',
					  placement: 'top',
					  trigger: 'hover',
					  container: 'body'
					});
					}else{
						$(info.el).popover({
						title: info.event.title,
						content: 'Medição '+info.event.extendedProps.medicao+', avanço: '+info.event.extendedProps.medidos+' %.',
						placement: 'top',
						trigger: 'hover',
						container: 'body'
						  });
					}

				  },
			  });

			calendar.render();
			
		});

		$('#modalFinalizarMedicao').on('show.bs.modal', function(event){ 
			let button = $(event.relatedTarget);
			let id_medicao = button.val();
			let nb_ordem = button.data('ordem');
			$(this).find('#ordemMedicao').text(nb_ordem);
			$(this).find('#finalizarMedicao').attr("data-id_medicao", id_medicao);
		});

		$('#modalUpdate').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var atividade = button.data('atividade');
			var id_atividade = button.data('id_atividade');
			var modal = $(this);
			modal.find('.modal-title').text(atividade);
			modal.find('#formAid.form-control').val(id_atividade);
		});

		$('#modalNotificar').on('show.bs.modal', function (event) {
			
			$(this).find('#ordemMedicao').text($(event.relatedTarget).val());
			$(this).find('#sendNotificacao').attr("data-id_medicao", $(event.relatedTarget).data('id_medicao'));
		});

		$('#modalExcMedicao').on('show.bs.modal', function (event) {
			
			$(this).find('#excluirMedicao').val($(event.relatedTarget).val());
			
		});

		$('button#excluirMedicao').on('click', function (event){
			
			$.ajax({
				type: "POST",
				url: "updateMedicao.php",
				data: {
					updateMedicao: '',
					finalizarMedicao: '',
					excluirMedicao: $(this).val()
					
				},
				
				success: function(result) {
					window.alert(result);
					$('#modalExcMedicao').modal('hide');
					atvPhp(str);
					
				}
			});
		});

		$('button#sendNotificacao').on('click', function (event){
			event.preventDefault();
			let contatos = 0;
			let indice = 0;
			let contato = [];

			$( 'input#checkUser:checked' ).each(function() {
				contatos = contatos + 1 * 1;
				indice = $(this).val();
				contato.push($('input#formUser'+indice).val());
			});

			$.ajax({
				type: "POST",
				url: "enviaNotificacao.php",
				data: {
					sendNotificacao: $(this).val(),
					id_medicao: $(this).attr('data-id_medicao'),
					contatos: contatos,
					contato: contato
				},
				
				success: function(result) {
					window.alert(result);
					$('#modalNotificar').modal('hide');
					atvPhp(str);
					
				},
				error: function(result) {
					window.alert(result);
					
				}
			});
		});

		$('button#registraAtividade').on('click', function (){

			$.ajax({
				type: "POST",
				url: "registraAtividade.php",
				data: {
					registraAtividade: $(this).val(),
					id_atividade: $('#formAid').val(),
					nb_qtd: $('#formUqtd').val(),
					dt_date : $('#formUdata').val()
				},
				
				success: function(result) {
					toastr.success(result);
					toastr.options.progressBar = true;
					//window.alert(result);
					
					
				},
				error: function() {
					toastr.error('Atividade já cadastrada nesta data!');
					toastr.options.progressBar = true;
					
				}
			});
		});

		$('button#revisarMedicao').on('click', function (){
			let pid = $(this).attr("data-id_medicao");
			let mid = $(this).val();

			loadMData(pid,mid,'');
		});

		$('button#finalizarMedicao').on('click', function (){
	
			let pid = $(this).attr("data-id_medicao");
			let mid = $(this).val();

			$.ajax({
				type: "POST",
				url: "updateMedicao.php",
				data: {
					updateMedicao: '',
					excluirMedicao: '',
					finalizarMedicao: $(this).val(),
					id_medicao: $(this).attr("data-id_medicao"),
					DadoNota: $("#formDadoNota").val(),
					EmData: $("#formEmData").val(),
					VeData: $("#formVeData").val()
					
				},
				
				success: function(result) {
					window.alert(result);
					$('#modalFinalizarMedicao').modal('hide');
					atvPhp(str);
					
				},
				error: function(result) {
					window.alert(result);
					
				}
			});
			
		});
		

		$('#formiData').mask('00/00/0000', {reverse: false});
		$('#formfData').mask('00/00/0000', {reverse: false});

		Chart.register(ChartDataLabels);
		Chart.defaults.set('plugins.datalabels', {
			align: 'end',
			offset: '5',
			anchor: 'end',
			font: {weight: 'bold'},
			borderColor: 'grey',
			borderWidth: 1,
			
		});

		function getdataChart(id_pedido){
			let portable;
			$.ajax({
				type: "POST",
				url: "barCodes.php",
				async: false,
				data: {
					id_pedido: id_pedido,	
				},
				success: function(result) {
					portable = result;
					
				}
				
			});
			return portable;
		}

		const myChart = new Chart($('#myChart'), {
			type: 'bar',
			data: {
				plugins: [ChartDataLabels],
				
				labels: ['Total', 'Concluído', '99% Progresso', '75% Progresso', '50% Progresso', '25% Progresso','0% Progresso'],
				datasets: [{
					label: 'Dados',
					fill: false,
					data: JSON.parse(getdataChart($('input#formMPed').val())),
					barPercentage: 0.5,
					backgroundColor: [
						'rgba(11, 83, 148, 0.75)',
						'rgba(106, 168, 79, 0.75)',
						'rgba(143, 206, 0, 0.75)',
						'rgba(53, 162, 240, 0.75)',
						'rgba(241, 194, 50, 0.75)',
						'rgba(230, 145, 56, 0.75)',
						'rgba(204, 30, 0, 0.75)'
					],
					borderColor: [
						'rgba(11, 83, 148, 1)',
						'rgba(106, 168, 79, 1)',
						'rgba(143, 206, 0, 1)',
						'rgba(53, 162, 240, 1)',
						'rgba(241, 194, 50, 1)',
						'rgba(230, 145, 56, 1)',
						'rgba(204, 30, 0, 1)'
					],
					borderWidth: 2
				}]
			},
			options: {
				indexAxis: 'y',
				scales: {
					y: {
						beginAtZero: true
					},
					x: {
						beginAtZero: true,
						title: {
							font: {weight: 'bold'},
							display: true,
							text: 'Dados Gerais do Pedido'
						  }
					}
				}
			}

		});
		

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
			$( ".date" ).datepicker({
				maxDate: 0,

			});

		});
		
		function getdataChart(id_pedido){
			let portable;
			$.ajax({
				type: "POST",
				url: "barCodes.php",
				async: false,
				data: {
					id_pedido: id_pedido,	
				},
				success: function(result) {
					portable = result;
					
				}
				
			});
			return portable;
		}

		const myChart = new Chart($('#myChart'), {
			type: 'bar',
			data: {
				plugins: [ChartDataLabels],
				
				labels: ['Total', 'Concluído', '99% Progresso', '75% Progresso', '50% Progresso', '25% Progresso','0% Progresso'],
				datasets: [{
					label: 'Dados',
					fill: false,
					data: JSON.parse(getdataChart($('input#formMPed').val())),
					barPercentage: 0.5,
					backgroundColor: [
						'rgba(11, 83, 148, 0.75)',
						'rgba(106, 168, 79, 0.75)',
						'rgba(143, 206, 0, 0.75)',
						'rgba(53, 162, 240, 0.75)',
						'rgba(241, 194, 50, 0.75)',
						'rgba(230, 145, 56, 0.75)',
						'rgba(204, 30, 0, 0.75)'
					],
					borderColor: [
						'rgba(11, 83, 148, 1)',
						'rgba(106, 168, 79, 1)',
						'rgba(143, 206, 0, 1)',
						'rgba(53, 162, 240, 1)',
						'rgba(241, 194, 50, 1)',
						'rgba(230, 145, 56, 1)',
						'rgba(204, 30, 0, 1)'
					],
					borderWidth: 2
				}]
			},
			options: {
				indexAxis: 'y',
				scales: {
					y: {
						beginAtZero: true
					},
					x: {
						beginAtZero: true,
						title: {
							font: {weight: 'bold'},
							display: true,
							text: 'Dados Gerais do Pedido'
						  }
					}
				}
			}

		});
		
		$('#modalUpdate').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var atividade = button.data('atividade');
			var id_atividade = button.data('id_atividade');
			var modal = $(this);
			modal.find('.modal-title').text(atividade);
			modal.find('#formAid').val(id_atividade);
		});
		
		$('#modalAtividadeCalendario').on('show.bs.modal', function(event){ 
			let button = $(event.relatedTarget);
			$(this).find('#descricao').text(button.data('descricao'));
			//let events = geteventChart(button.val());
			var calendarEl = document.getElementById('calendario');
			
			var calendar = new FullCalendar.Calendar(calendarEl, {
				locale: 'pt-br',
				headerToolbar: {
				  left: 'prevYear,prev,next,nextYear today',
				  center: 'title',
				  right: 'dayGridMonth,dayGridWeek'
				},
				weekNumbers: true,
				weekNumberTitle: 'W',
				weekNumberCalculation: 'ISO',
				editable: false,
				height: 480,
				dayMaxEvents: true, // allow "more" link when too many events
				events: {
					url: 'loadEventsAtividade.php',
					method: 'POST',
					extraParams: {
						id_atividade: button.val(),
						
					  }
				},
				eventDidMount: function(info){
					if(info.event.extendedProps.quantidade){
					 $(info.el).popover({
					  title: info.event.title,
					  content: 'Cadastrado: '+info.event.extendedProps.quantidade+', por: '+info.event.extendedProps.usuario+'.',
					  placement: 'top',
					  trigger: 'hover',
					  container: 'body'
					});
					}else{
						$(info.el).popover({
						title: info.event.title,
						content: 'Medição '+info.event.extendedProps.medicao+', avanço: '+info.event.extendedProps.medidos+' %.',
						placement: 'top',
						trigger: 'hover',
						container: 'body'
						  });
					}

				  },
			  });

			calendar.render();
			
		});

		$('button#registraAtividade').on('click', function (){

			$.ajax({
				type: "POST",
				url: "registraAtividade.php",
				data: {
					registraAtividade: $(this).val(),
					id_atividade: $('#formAid').val(),
					nb_qtd: $('#formUqtd').val(),
					dt_date : $('#formUdata').val()
				},
				
				success: function(result) {
					toastr.success(result);
					toastr.options.progressBar = true;
					//window.alert(result);
					
					
				},
				error: function() {
					toastr.error('Atividade já cadastrada nesta data!');
					toastr.options.progressBar = true;
					
				}
			});
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
					window.alert('Erro: '+result);
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

	function loadMData(str,str2,str3) {
		var xhttp = new XMLHttpRequest();

		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
		document.getElementById("main").innerHTML = this.responseText;
		
		const formatter = new Intl.NumberFormat('pt-BR', {
			style: 'currency',
			currency: 'BRL',
		  });

		function calcular(){
		let soma = 0;
		let total = $('input#pedidoValor').val()*1;
		let sbalance = $('input#medidoSaldo').val()*1;

		$( 'input.parcela' ).each(function() {
			soma = soma + $(this).val()*1;
		  });
		
		let result = (soma / total) *100;
		let saldo = total - sbalance - soma;
		$('span#resultado').text(Number(result).toFixed(2)+' %');
		$('span#soma').text(formatter.format(soma));
		$('span#saldo').text(formatter.format(saldo));

		}

		calcular();

		$('input.parcela').on('keyup', function (){
			calcular();
			let indice = $(this).attr("data-aid");
			let nb_valor = $(this).attr("data-nb_valor")*1;
			let nb_sum = $(this).attr("data-nb_sum")*1;
			let limit = $(this).attr("data-limit")*1;
			let current = $(this).val()*1;
			limit = limit + nb_valor - current;
			let result = (current / nb_sum) * 100;
			$('span#percent'+indice).text(Number(result).toFixed(2));
			$('span#limit'+indice).text(formatter.format(limit));

		});

		$('button#updateMedicao').on('click', function (){
			$(this).prop({disabled: true});
			let update = $(this).val();
			let nb_ordem = [];
			let id_pedido = [];
			let valor = [];
			let atividade = [];

			$( 'input.parcela' ).each(function() {

				atividade.push($(this).attr("data-aid"));
				nb_ordem.push($(this).attr("data-nb_ordem"));
				id_pedido.push($(this).attr("data-id_pedido"));
				valor.push($(this).val());;
				
			});

			$.ajax({
				type: "POST",
				url: "updateMedicao.php",
				data: {
					excluirMedicao: '',
					finalizarMedicao:'',
					updateMedicao: update,
					Nb_ordem: nb_ordem,
					Id_pedido: id_pedido,
					Valor: valor,
					Atividade: atividade
				},
				
				success: function(result) {
					window.alert(result);
					loadMData(str,str2,str3);
					}	
			});
		});
	}

};

xhttp.open("GET", "revmedicao.php?pid="+str+"&mid="+str2+"&controlid="+str3, true);
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

		const formatter = new Intl.NumberFormat('pt-BR', {
			style: 'currency',
			currency: 'BRL',
		  });

		function calcular(){	
			let reference = $('#formValor').val()*1;
			let total_global = 0;

			$( '.categoria-sub' ).each(function() {
				let soma = 0;
				$(this).find('.valores').each(function(){
					soma = soma + $(this).val()*1;
				});
				$(this).find('#subtotal').text(formatter.format(soma));
				total_global = total_global + soma;
			  });
			
			$('#totalfinal').text(formatter.format(total_global));
			if(total_global > reference){
				$('#totalfinal').addClass('text-danger');
			}else{
				$('#totalfinal').removeClass('text-danger');
			}

			}
	
			$('.valores').on('keyup', function (){
				calcular();	
			});

		$("#removeButton").click(function(e) {
			e.preventDefault();
			$.ajax({
				type: "GET",
				url: "pprocess.php",
				data: { 
					Pid: $("#Pid").val(), 
					removePedido: $(this).val()
				},
				success: function(result) {
					$('#modalRPedido').modal('hide');
					loadCData( $("#Cid").val() );
					
				}
			});
		});

		$('button#revisarMedicao').on('click', function (){
			let pid = $(this).attr("data-id_medicao");
			let mid = $(this).val();

			loadMData(pid,mid,'1');
		});

		$('button#updateAllAtividade').on('click', function (event){
			$(this).prop({disabled: true});
			let indice = [];
			let status = [];
			let categoria = [];
			let descricao = [];
			let tipo = [];
			let qtd = [];
			let valor = [];
			let inicio = [];
			let fim = [];
			let atividade = [];
			let json_data = [];
			$( 'tr.atividades' ).each(function() {
				var id_atividade = 	 $(this).find('.button-update').attr("data-id_atividade");
				atividade.push(id_atividade);
				indice.push(($(this).find('#formAtvid_idx'+id_atividade).val().replace(/\s/g,'')));	
				status.push($(this).find('#formAtvStatus'+id_atividade).val());	
				categoria.push($(this).find('#formAtvCat'+id_atividade).val());
				descricao.push($(this).find('#formAtvtx_descricao'+id_atividade).val());
				tipo.push($(this).find('#formAtvtx_tipo'+id_atividade).val());
				qtd.push($(this).find('#formAtvnb_qtd'+id_atividade).val());
				valor.push($(this).find('#formAtvnb_valor'+id_atividade).val());;
				inicio.push($(this).find('#formAtvidata'+id_atividade).val());
				fim.push($(this).find('#formAtvfdata'+id_atividade).val());	
			});
			json_data.push(indice);
			json_data.push(status);
			json_data.push(categoria);
			json_data.push(descricao);
			json_data.push(tipo);
			json_data.push(qtd);
			json_data.push(valor);
			json_data.push(inicio);
			json_data.push(fim);
			json_data.push(atividade);
			json_data = JSON.stringify(json_data);
			$.ajax({
				type: "POST",
				url: "updateAllAtividade.php",
				data: {
					updateAllAtividade: $(this).val(),
					json_data: json_data,
				},
				
				success: function(result) {
					window.alert(result);
					loadPData(str,str2);
					
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
				
				success: function() {
					$('#modalUPedido').modal('hide');
					loadCData( $("#Cid").val() );
					
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
					Indice: $('#formAtvid_idx'+id_atividade).val().replace(/\s/g,''),
					Status: $('#formAtvStatus'+id_atividade).val(),
					Categoria: $('#formAtvCat'+id_atividade).val(),
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
					
				}
			});
			
		});

		$("#excluirAtividade").click(function() {
			
			$.ajax({
				type: "GET",
				url: "pprocess.php",
				data: { 
					updatePedido: '0',
					removePedido: '0',
					updateAtividade: '0',
					removeFuncionario: '0',
					alocaFuncionario:'0',
					excluirAtividade: $(this).val(),
					grantAcessoConvidado: '0',
					removerAcessoConvidado: '0',
					grantAcessoUsuario: '0',
					removerAcessoUsuario: '0',
					Atividade: $('#modalExAtividade').find('#id_atividade').val()
					
				},
				
				success: function(result) {
					window.alert(result);
					$('#modalExAtividade').modal('hide');
					loadPData(str,str2);
					
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
					
				}
			});
			
		});

		
		$('#modalExAtividade').on('show.bs.modal', function(event){
			let id_atividade = $(event.relatedTarget).val();
			let atividade = $('#formAtvtx_descricao'+id_atividade).val();
			$(this).find('#nomeAtividade').text(atividade);
			$(this).find('#id_atividade').val(id_atividade);
		});

		$('button#generateButton').on('click', function (event){
			event.preventDefault();
			$.ajax({
				type: "POST",
				url: "newAtividade.php",
				data: {
					generateButton: $(this).val(),
					id_pedido: $('#formPid').val(),
					nb_loops: $('#formMultiple').val(),
					id_categoria : $('#formCategoria').val()
				},
				
				success: function(result) {
					window.alert(result);
					$('#modalGenerate').modal('hide');
					loadPData(str,str2);
					
				}
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
		
		xhttp.open("GET", "ucprocess.php?"+formData, true);
		xhttp.send();
	}