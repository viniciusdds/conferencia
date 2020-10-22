<!DOCTYPE html>
<html lang="en">
  
	<?php include("header.php"); ?>
	<body class="nav-md">
    

	<!-- page content -->
	<div class="right_col" role="main">
		<div class="row">	
			<div class="title_left">
				<h2><a href="index.php">Inicial</a> / Agendamentos</h2>
			</div>
		</div>
		<br>

		<div class="col-md-12">

            <ul class="nav nav-tabs bar_tabs justify-content-center" id="myTab" role="tablist">
                <li class="nav-item" style="width: 25%; text-align: center;">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">SELEÇÃO DE DOCUMENTOS</a>
                </li>
                <li class="nav-item" style="width: 25%; text-align: center;">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">AGENDAMENTOS</a>
                </li>
            </ul>
            
				<div class="tab-content" id="myTabContent">
					<!-- Aba de Seleção de documentos -->
					<div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                        
						  
					    <div class="row">
							<div class="col-md-6">
								<div class="x_panel">
									<div class="x_title">
										<h2>Documento</h2>
										<ul class="nav navbar-right panel_toolbox">
											<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
											</li>
											<li><a><i class="fa fa-close"></i></a>
											</li>
										</ul>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										
										<div class="item form-group">	
											<div class="col-md-7" >
												<label>Documento</label>
												<input disabled type="text" required="required" class="form-control" placeholder="19/2002389-7">
											</div>
											<div class="col-md-5" >
												<label>Canal</label>	
												<button type="button" class="btn btn-round btn-danger">Canal Vermelho</button>
											</div>
										</div>
										
										<div class="item form-group">	
											<div class="col-md-6" >
												<label>Cliente</label>
												<input disabled type="text" required="required" class="form-control" placeholder="FLEXTRONIC LTDA.">
											</div>
											<div class="col-md-6" >
												<label>Comissária / Representante:</label>	
												<input disabled type="text" required="required" class="form-control" placeholder="SAFE TRADE CONSULTORIA">
											</div>
										</div>
										
										<div class="item form-group">	
											<div class="col-md-6" >
												<label>Responsável</label>
												<input disabled type="text" required="required" class="form-control" placeholder="Cleber Ferreira">
											</div>
											<div class="col-md-6" >
												<label>Designado / Responsável</label>	
												<input disabled type="text" required="required" class="form-control" placeholder="Cleber Ferreira">
											</div>
										</div>
										
										<div class="item form-group">	
											<div class="col-md-6" >
												<label>Conferente</label>
												<input disabled type="text" required="required" class="form-control" placeholder="Marcos Lages">
											</div>
										</div>
										
										<div class="item form-group">	
											<div class="col-md-6 offset-md-9" >
												<button class="btn btn-primary">Designar</button>
											</div>
										</div>
										
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="x_panel">
									<div class="x_title">
										<h2>Análise</h2>
										<ul class="nav navbar-right panel_toolbox">
											<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
											</li>
											<li><a><i class="fa fa-close"></i></a>
											</li>
										</ul>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										<div class="item form-group">	
											<div class="col-md-6">
												<label>Data Sugerida</label>
												<input disabled type="text" required="required" class="form-control" placeholder="01/06/2020 14:00">
											</div>
											<div class="col-md-6">
												<label>Vistoria</label>
												<div class="radio">
													<label style="margin-left: 20px;">
														<input type="radio" class="flat" checked name="iCheck"> In Loco
													</label>
													<label style="margin-left: 25px;" >
														<input type="radio" class="flat" checked name="iCheck"> Remota
													</label>
												</div>
											</div>
										</div>
										
										<div class="item form-group">	
											<div class="col-md-12">
												<label>Convidados</label>
												<input id="tags_1" type="text" class="form-control" value="JOSÉ VIRACI, MARCELO ROCHA, FERNANDO SANCHES" />
											</div>
										</div>
										
										<div class="item form-group">	
											<div class="col-md-8">
												<div class="checkbox">
													<label>
														<input type="checkbox" class="flat" checked="checked"> Comprometer a Agenda
													</label>
												</div>
											</div>
										</div>
										
										<div class="item form-group">	
											<label>Início: </label>
											<div class="col-md-5">
												<input id="birthday" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" required="required" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
													<script>
														function timeFunctionLong(input) {
															setTimeout(function() {
																input.type = 'text';
															}, 60000);
														}
													</script>
											</div>
											<label>Fim: </label>
											<div class="col-md-5">
												<input id="birthday" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" required="required" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
													<script>
														function timeFunctionLong(input) {
															setTimeout(function() {
																input.type = 'text';
															}, 60000);
														}
													</script>
											</div>
										</div>
										
										
										<div class="item form-group">	
											<div class="col-md-6 offset-md-7" style="margin-top: 6px;">
												<button class="btn btn-danger">Recusar</button>
												<button class="btn btn-primary">Aceitar</button>
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12 col-sm-12 ">
								<div class="x_panel">
									<div class="x_title">
										<h2>Mensagens</h2>
										<ul class="nav navbar-right panel_toolbox">
											<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
											</li>
											<li><a><i class="fa fa-close"></i></a>
											</li>
										</ul>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										<div class="col-md-6">
											<label>Histórico de Mensagens</label>
											<a href="#">
												<div class="mail_list border rounded-lg" style="padding: 10px;">
													<div class="left">
													  <i class="fa fa-circle"></i> <i class="fa fa-edit"></i>
													</div>
													<div class="right">
													  <h3>Dennis Mugo <small><?php echo date("d/m/Y H:i:s"); ?></small></h3>
													  <p>Ut enim ad minim veniam, quis nostrud exercitation enim ad minim veniam, quis nostrud exercitation...</p>
													</div>
												</div>
											</a>
										</div>
										<label>Nova Mensagem</label>
										<div class="col-md-6" style="text-align: right;">
											<textarea id="message" required="required" class="form-control"  name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
											<button class="btn btn-info" style="margin-top: 5px;">Enviar</button>
										</div>

									</div>
								</div>
							</div>
						</div>
                    </div>
					<!-- Aba de agendamento -->
					<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
						
						
						<div class="row">
							<div class="col-md-12 col-sm-12 ">
								<div class="x_panel">
									<div class="x_title">
										<h2>Agendamento</h2>
										<ul class="nav navbar-right panel_toolbox">
											<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
											</li>
											<li><a><i class="fa fa-close"></i></a>
											</li>
										</ul>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										<br />
										<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

											<div class="item form-group">
												<label class="col-form-label label-align" for="first-name">Documento:
												</label>
												<div class="col-md-10" style="margin-left: 2px;">
													<input disabled type="text" id="first-name" required="required" class="form-control" placeholder="19/2002389-7">
												</div>
											</div>
											<div class="item form-group">
												<label class="col-form-label label-align" for="last-name">Designado à 
												</label>
												<div class="col-md-10">
													<select class="form-control">
														<option>Choose option</option>
														<option>Option one</option>
														<option>Option two</option>
														<option>Option three</option>
														<option>Option four</option>
													</select>
												</div>
											</div>
											<div class="item form-group">
												<label for="middle-name" class="col-form-label label-align">Auditor:</label>
												<div class="col-md-4" style="margin-left: 29px;">
													<select class="form-control">
														<option>Auditor 1</option>
														<option>Auditor 2</option>
														<option>Auditor 3</option>
														<option>Auditor 4</option>
													</select>
												</div>
												<label for="middle-name" class="col-form-label col-md-2 label-align">Conferente:</label>
												<div class="col-md-4">
													<select class="form-control">
														<option>Conferente 1</option>
														<option>Conferente 2</option>
														<option>Conferente 3</option>
														<option>Conferente 4</option>
													</select>
												</div>
											</div>
											<div class="item form-group">
												<label for="middle-name" class="col-form-label label-align">Câmeras:</label>
												<div class="col-md-4" style="margin-left: 19px;">
													<select class="form-control">
														<option>Câmera 1</option>
														<option>Câmera 2</option>
														<option>Câmera 3</option>
														<option>Câmera 4</option>
													</select>
												</div>
												<label for="middle-name" class="col-form-label label-align">Data Sugerida:</label>
												<div class="col-md-2">
													<input id="birthday" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" required="required" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
													<script>
														function timeFunctionLong(input) {
															setTimeout(function() {
																input.type = 'text';
															}, 60000);
														}
													</script>
												</div>
												<label for="middle-name" class="col-form-label col-md-1 label-align">Hora:</label>
												<div class="col-md-2" style="margin-left: -2px;">
													<input class="form-control" class='time' type="time" name="time" required='required'>
												</div>
											</div>
											<br>
											<div class="item form-group">
												<label for="message">Mensagem (20 chars min, 100 max) :</label>
												<div class="col-md-8">	
													<textarea id="message" required="required" class="form-control" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
												</div>
											</div>
											<div class="ln_solid"></div>
											<div class="item form-group">
												<div class="col-md-6 col-sm-6 offset-md-5">
													<button class="btn btn-danger" type="button">Cancelar</button>
													<button type="submit" class="btn btn-success">Salvar</button>
												</div>
											</div>

										</form>
									</div>
								</div>
							</div>
						</div>
							
					</div>
                </div>

        </div>

	</div>
	<!-- /page content -->

	<?php include("footer.php"); ?>

  </body>
</html>
