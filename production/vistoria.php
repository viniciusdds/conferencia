<?php
$ip = $_SERVER["REMOTE_ADDR"];

//Aqui alterei a conexão para PDO pois oci não estava funcionando para mim no PHP7
$user = "wms_eadi";
$pass = "wms_eadi";

$tns = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=172.20.220.32)(PORT=1522)) (CONNECT_DATA=(SID=ALCISSTB)))";
try {
    $con = new PDO('oci:dbname=' . $tns, $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conectado AG<br>";
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$oracle = $con->query("select 
                        d.nr_di DOCUMENTO, 
                        k.nome_fantasia CLIENTE 
                      from desmembr d, klienten k where d.id_klient = k.id_klient and  d.nr_di = '1519253844'");
$oracle->execute();
$result = $oracle->fetch();
// $document = $result['DOCUMENTO'];
// $clients = explode(" ", $result['CLIENTE']);
$document = '20BR0008145111';
$client = 'MISTRAS';
//$client = $clients[0];
?>
<!DOCTYPE html>
<html lang="en">

<?php include("header.php"); ?>

<body class="nav-md" onload="loadFoto();">
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="row">
            <div class="title_left">
                <h2><a href="index.php">Inicial</a> / Vistórias</h2>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-8">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Câmeras</h2>
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
                            <div class="col-md-2">
                                <label>DOME</label>
                                <div class="image">
                                    <img style="width: 80%; display: block; cursor: pointer;" id="ARM1" onclick="mostrar('ARM1');" src="http://10.101.10.100/axis-cgi/mjpg/video.cgi" alt="image" />
                                </div>
                                <br>
                                <label>ARM2-02</label>
                                <div class="image">
                                    <img style="width: 80%; display: block; cursor: pointer;" id="ARM2" onclick="mostrar('ARM2');" src="http://10.101.2.100:4747/video?640x480/" alt="image" />
                                </div>
                                <br>
                                <label>ARM3-03</label>
                                <div class="image">
                                    <img style="width: 80%; display: block; cursor: pointer;" id="ARM3" onclick="mostrar('ARM3');" src="images/media.jpg" alt="image" />
                                </div>
                                <br>
                                <label>ARM4-04</label>
                                <div class="image">
                                    <img style="width: 80%; display: block; cursor: pointer;" id="ARM4" onclick="mostrar('ARM4');" src="images/media.jpg" alt="image" />
                                </div>
								<br>
								<label>MOBILE</label>
                                <div class="image">
                                    <img style="width: 80%; display: block; cursor: pointer;" id="ARM4" onclick="mostrar('ARM4');" src="images/media.jpg" alt="image" />
                                </div>
                            </div>
                            <div class="col-md-9" style="text-align: center;">
                                <div class="image">
                                    <img style="width: 115%; height: 450px; display: block; cursor: pointer" id="principal" src="images/user.png" alt="image" />
                                </div>
                                <!--<button class="btn btn-app" id="foco" onclick="$.get('http://10.101.10.100/axis-cgi/mjpg/video.cgi');" style="cursor: pointer; margin-top: 10px;color:blue">
                                    <i class="fa fa-arrows"></i> Auto Foco
                                </button>&nbsp;&nbsp;&nbsp;-->
                                <button class="btn btn-danger" id="snap" onclick="snapshot();" style="cursor: pointer; margin-top: 10px; width: 50%;">
                                    <i class="fa fa-camera"></i>&nbsp;&nbsp;&nbsp; Fotografar
                                </button></br></br>
                                <button class="btn btn-warning"  data-toggle="modal" data-target=".bs-amostra-modal-lg">Solicitar Amostra</button>&nbsp;&nbsp;&nbsp; 
                                <!--<button class="btn btn-danger">Responder</button>-->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Finalizar Conferência</button>

                            </div>
                        </div> 
                    </div>
                </div>

                
                    <div class="x_content">
                        <div class="col-md-12">
                           
                            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel"><b>Finalizar Vistoria</b></h4>
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="col-md-12">
                                                <label>Observações:</label>
                                                <textarea id="message" required="required" class="form-control" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                            <button type="button" class="btn btn-primary">Finalizar</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                


            </div>

            <div class="col-md-4">
                <div class="x_panel">
				<div class="x_title" align="center">
						<h2><b>21/30886453-1</b></h2>
						
					<div class="clearfix"></div>
				</div>
				<div class="x_content" style="display: block;">
					<div class=" bg-white progress_summary">
						<div class="row">
							<div class="progress_title">
							  <span class="left"><font color="red"><b>Data Agendada:</b> 07/10/2020 17:30</font></span>
							  <div class="clearfix"></div>
							</div>
							<div class="">
							  <div class="progress progress_sm">
								<div class="progress-bar bg-green" role="progressbar" data-transitiongoal="89" aria-valuenow="89" style="width: 89%;"></div>
							  </div>
							</div>  
						</div>
						<div class="row">
							<div class="progress_title">
							  <span class="left"><b>Responsável:</b> Ademir Barros</span>
							  <div class="clearfix"></div>
							</div>
							<div class="">
							  <div class="progress progress_sm">
								<div class="progress-bar bg-green" role="progressbar" data-transitiongoal="79" aria-valuenow="79" style="width: 79%;"></div>
							  </div>
							</div>    
						</div>
						<div class="row">
							<div class="progress_title">
							  <span class="left"><b>Cargo Designado / Responsável:</b> Auditor Fiscal</span>
							  <div class="clearfix"></div>
							</div>
							<div class="">
							  <div class="progress progress_sm">
								<div class="progress-bar bg-green" role="progressbar" data-transitiongoal="69" aria-valuenow="69" style="width: 69%;"></div>
							  </div>
							</div>
						</div>
					</div>
					<div class="row">
							<div class="progress_title">
							  <span class="left"><b>Telefone Fixo:</b> (15) 3235-4800</span><span class="left"><b>&nbsp; &nbsp;Ramal: 4832</b> </span>
							  <div class="clearfix"></div>
							</div>
							<div class="">
							  <div class="progress progress_sm">
								<div class="progress-bar bg-green" role="progressbar" data-transitiongoal="69" aria-valuenow="69" style="width: 69%;"></div>
							  </div>
							</div>
						</div>
					</div>
					<div class="row">
							<div class="progress_title">
							  <span class="left"><b>Telefone Celular:</b> (15) 98818-1883&nbsp; &nbsp;</span><i class="fa fa-whatsapp" style="font-size:24px;color:green"></i> 
							  <div class="clearfix"></div>
							</div>
							<div class="">
							  <div class="progress progress_sm">
								<div class="progress-bar bg-green" role="progressbar" data-transitiongoal="69" aria-valuenow="69" style="width: 69%;"></div>
							  </div>
							</div>
						</div>
						<div class="row">
							<div class="progress_title">
							  <span class="left"><b>Status do Agendamento:</b><font color="green"> <b>Confirmado</b></font> &nbsp;</span><i class="fa fa-check" style="font-size:24px;color:green"></i> 
							  <div class="clearfix"></div>
							</div>
							<div class="">
							  <div class="progress progress_sm">
								<div class="progress-bar bg-green" role="progressbar" data-transitiongoal="69" aria-valuenow="69" style="width: 69%;"></div>
							  </div>
							</div>
						</div>
						<div class="row">
							<div class="progress_title">
							  <span class="left"><b>Conferente Fisico:</b> Alessandro Rodrigues </span>
							  <div class="clearfix"></div>
							</div>
							<div class="">
							  <div class="progress progress_sm">
								<div class="progress-bar bg-green" role="progressbar" data-transitiongoal="69" aria-valuenow="69" style="width: 69%;"></div>
							  </div>
							</div>
							
						</div>
						
					</div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Fotos</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" name="listaFotos" id="listaFotos">
                    </div>
                </div>
            </div>

            <!-- AQUI EU ADICIONEI O MODAL BUSCANDO AS IMAGENS DO BANCO -->
            <div id="myModal" class="modal">
                <span class="close cursor" style="color: #00FF00; background: #FFFFFF; border-radius: 10px;" onclick="closeModal()">&times;</span>
                <div class="modal-content" style="margin-top: -50px;">
                    <?php
                    $con = mysqli_connect("localhost", "root", "", "testes");
                    $sql = mysqli_query($con, "select tb_id, tb_foto from vistoria.confere_fotos where tb_doc = '" . $document . "'") or die("erro no select lista de fotos slides");
                    $rows = mysqli_num_rows($sql);
                    $id = 0;
                    while ($result = mysqli_fetch_array($sql)) {
                        $id = $id + 1;
                        echo "<div class='mySlides'>";
                        echo "<div class='numbertext' style='font-size: 20px; font-weight: bold; color: #00FF00;'>{$id} / {$rows}</div>";
                        echo "<img src='" . $result['tb_foto'] . "' style='width:100%; height: 560px;' />";
                        echo "</div>";
                    }
                    ?>

                    <a class="prev" style="color: #00FF00; background: #E0E0E0;" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" style="color: #00FF00; background: #E0E0E0;" onclick="plusSlides(1)">&#10095;</a>

                </div>
            </div>
        </div>

<!--
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
                            <textarea id="message" required="required" class="form-control" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
                            <button class="btn btn-info" style="margin-top: 5px;">Enviar</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
-->
    </div>
    <!-- /page content -->

    <?php include("footer.php"); ?>

    <script>
        //Identificação do usuário
        var documento = '<?php echo $document; ?>';
        var client = '<?php echo $client; ?>';

        //Tira a foto e salvar no banco e armazena a foto em uma pasta no servidor
        function snapshot() {
            fetch('salvarFoto.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'action=salvar&document=' + documento + '&client=' + client
            }).then(function(response) {
                response.text()
                    .then(function(result) {
                        //alert(result);
                        buscarFoto(result);
                    });
            });
        }

        //Buscar na base a foto que foi tirada por último e mostra na tela 
        function buscarFoto(id) {
            fetch('salvarFoto.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'action=buscar&document=' + documento + '&client=' + client + '&id=' + id
            }).then(function(response) {
                response.text()
                    .then(function(result) {
                        //alert(result);

                        //Div principal
                        var fotos = document.getElementById('listaFotos');

                        //Div de coluna
                        var col = document.createElement('div');
                        col.setAttribute('class', 'col-md-55');
                        fotos.appendChild(col);

                        //Div de thumbnail
                        var thumb = document.createElement('div');
                        thumb.setAttribute('class', 'thumbnail');
                        col.appendChild(thumb);

                        //Div de View
                        var view = document.createElement('div');
                        view.setAttribute('class', 'image view view-first');
                        thumb.appendChild(view);

                        id = parseInt(id) - 1;
                        nums = id;

                        //Imagens vindas do banco
                        var img = document.createElement("img");
                        img.setAttribute("src", result);
                        img.setAttribute("width", "100%");
                        img.setAttribute("id", "foto_" + id);
                        img.setAttribute("name", "foto_" + id);
                        img.setAttribute("class", "foto_" + id);
                        img.setAttribute("alt", documento);
                        img.setAttribute("style", "border-style: solid; border-color: yellow");
                        view.appendChild(img);

                        //div de Mascara
                        var mask = document.createElement('div');
                        mask.setAttribute('class', 'mask');
                        view.appendChild(mask);

                        //div de ferramentas
                        var tools = document.createElement('div');
                        tools.setAttribute('class', 'tools tools-bottom');
                        mask.appendChild(tools);

                        //Botão de edição
                        var edit = document.createElement('a');
                        edit.setAttribute('href', '#');
                        edit.setAttribute('onclick', 'openModal();currentSlide(1)');
                        tools.appendChild(edit);

                        //Botão de remoção
                        var del = document.createElement('a');
                        del.setAttribute('href', '#');
                        del.setAttribute('onclick', 'remover(' + id + ');');
                        tools.appendChild(del);

                        //Icone de edição
                        var pencil = document.createElement('i');
                        pencil.setAttribute('class', 'fa fa-search-plus');
                        edit.appendChild(pencil);

                        //Icone de remoção
                        var times = document.createElement('i');
                        times.setAttribute('class', 'fa fa-times');
                        del.appendChild(times);

                        //Div de titulo
                        var caption = document.createElement('div');
                        caption.setAttribute('class', 'caption');
                        thumb.appendChild(caption);

                        //Texto no titulo
                        var title = document.createElement('p');
                        var text = document.createTextNode('Passe o mouse por cima da imagem');
                        title.appendChild(text);
                        caption.appendChild(title);
                        location.reload();
                    });
            });
        }

        //Carrega as fotos ao atualizar
        function loadFoto() {
            pantalla = document.getElementById("screen");

            fetch('salvarFoto.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'action=load&document=' + documento + '&client=' + client
            }).then(function(response) {
                response.text()
                    .then(function(result) {

                        var foto = result.split(';');
                        var qtd = result.match(/;/gi).length;

                        for (var i = 0; i < qtd; i++) {
                            var nums = i + 1;

                            //Div principal
                            var fotos = document.getElementById('listaFotos');

                            //Div de coluna
                            var col = document.createElement('div');
                            col.setAttribute('class', 'col-md-55');
                            fotos.appendChild(col);

                            //Div de thumbnail
                            var thumb = document.createElement('div');
                            thumb.setAttribute('class', 'thumbnail');
                            col.appendChild(thumb);

                            //Div de View
                            var view = document.createElement('div');
                            view.setAttribute('class', 'image view view-first');
                            thumb.appendChild(view);

                            //Imagens vindas do banco
                            var img = document.createElement("img");
                            img.setAttribute("src", foto[i]);
                            img.setAttribute("width", "100%");
                            img.setAttribute("alt", documento);
                            img.setAttribute("id", "foto_" + i);
                            img.setAttribute("name", "foto_" + i);
                            img.setAttribute("class", "foto_" + i);
                            img.setAttribute("style", "border-style: solid; border-color: yellow");
                            view.appendChild(img);

                            //div de Mascara
                            var mask = document.createElement('div');
                            mask.setAttribute('class', 'mask');
                            view.appendChild(mask);

                            //div de ferramentas
                            var tools = document.createElement('div');
                            tools.setAttribute('class', 'tools tools-bottom');
                            mask.appendChild(tools);

                            //Botão de edição
                            var edit = document.createElement('a');
                            edit.setAttribute('href', '#');
                            edit.setAttribute('onclick', 'openModal();currentSlide(' + nums + ')');
                            tools.appendChild(edit);

                            //Botão de remoção
                            var del = document.createElement('a');
                            del.setAttribute('href', '#');
                            del.setAttribute('onclick', 'remover(' + i + ');');
                            tools.appendChild(del);

                            //Icone de edição
                            var pencil = document.createElement('i');
                            pencil.setAttribute('class', 'fa fa-search-plus');
                            edit.appendChild(pencil);

                            //Icone de remoção
                            var times = document.createElement('i');
                            times.setAttribute('class', 'fa fa-times');
                            del.appendChild(times);

                            //Div de titulo
                            var caption = document.createElement('div');
                            caption.setAttribute('class', 'caption');
                            thumb.appendChild(caption);

                            //Texto no titulo
                            var title = document.createElement('p');
                            var text = document.createTextNode('Passe o mouse por cima da imagem');
                            title.appendChild(text);
                            caption.appendChild(title);
                        }
                    });
            });
        }

        function mostrar(cam) {
            //alert(cam);
            var camera = document.getElementById(cam);
            var principal = document.getElementById('principal');

            principal.src = camera.src;
        }

        function remover(id) {
            //alert(documento);
            var path = document.getElementById('foto_' + id).src;
            var position = path.indexOf(client);
            var file = path.substr(position);
            var confirmar = confirm("Deseja realmente apagar?");

            if (confirmar == true) {
                fetch('salvarFoto.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'action=deletar&document=' + documento + '&file=' + file
                }).then(function(response) {
                    response.text()
                        .then(function(result) {
                            alert(result);
                            location.reload();
                        });
                });
            } else {
                return false;
            }
        }

        var isMarch = false;
        var acumularTime = 0;

        //Inicia o cronometro
        function start() {
            if (isMarch == false) {
                timeInicial = new Date();
                control = setInterval(cronometro, 10);
                isMarch = true;
            }
        }

        //Executar a cronometro
        function cronometro() {
            timeActual = new Date();
            acumularTime = timeActual - timeInicial;
            acumularTime2 = new Date();
            acumularTime2.setTime(acumularTime);
            cc = Math.round(acumularTime2.getMilliseconds() / 10);
            ss = acumularTime2.getSeconds();
            mm = acumularTime2.getMinutes();
            hh = acumularTime2.getHours() - 21;
            if (cc < 10) {
                cc = "0" + cc;
            }
            if (ss < 10) {
                ss = "0" + ss;
            }
            if (mm < 10) {
                mm = "0" + mm;
            }
            if (hh < 10) {
                hh = "0" + hh;
            }
            pantalla.innerHTML = hh + " : " + mm + " : " + ss + " : " + cc;
        }

        //Para o cronometro
        function stop() {
            if (isMarch == true) {
                clearInterval(control);
                isMarch = false;
            }
        }

        //Limpa o cronometro
        function reset() {
            if (isMarch == true) {
                clearInterval(control);
                isMarch = false;
            }
            acumularTime = 0;
            pantalla.innerHTML = "00 : 00 : 00 : 00";
        }

        /*
            AQUI EU ADICIONEI AS FUNÇÕES DO MODAL E SLIDES
        */
        function openModal() {
            document.getElementById("myModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }

            slides[slideIndex - 1].style.display = "block";
        }
    </script>
</body>

</html>