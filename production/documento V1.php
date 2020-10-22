<!DOCTYPE html>
<html lang="en">

<?php include("header.php"); ?>

<body class="nav-md">
  <!-- page content -->
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="row">
      <div class="title_left">
        <h2><a href="index.php">Incial</a> </h2>
      </div>
    </div>
    <br>

    <?php
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
    ?>
    <div class="col-md-12 col-sm-12 ">
      <div class="x_panel">
        <div class="x_title">

          <h2 class="btn btn-success btn-lg btn-block active">Documentos Disponíveis para Agendamento</h2>
          <ul class="nav navbar-center panel_toolbox">

            <form id="form1" name="form1" method="post" action="#" class="form-inline">
              <input type="text" name="docpsc" id="docpsc" class="form-control" />&nbsp;&nbsp;
              <input type="submit" name="buscar" id="buscar" class="btn btn-primary" value="Pesquisar" />
            </form>
            <a href="documento.php" id="buscar" class="btn btn-danger" value="Limpar">Limpar</a>
          </ul>

          <div class="clearfix"></div>
        </div>

      <?php
			  if(isset($_POST['buscar'])) {
      ?>
        <div class="x_content">
          <div class="row">
            <div class="col-sm-12">
              <div class="card-box table-responsive">

                <table class="table table-striped table-bordered center" style="width:100%">
                  <!--<table id="datatable-buttons" class="table table-striped table-bordered center" style="width:100%">-->
                  <thead bgcolor="#c9c7c7">
                    <tr>
                      <th>
                        <font color="black">TIPO</font>
                      </th>
                      <th>
                        <font color="black">DOCUMENTO</font>
                      </th>
                      <th>
                        <font color="black">LOTE</font>
                      </th>
                      <th>
                        <font color="black">CLIENTE</font>
                      </th>
                      <th>
                        <font color="black">CNPJ</font>
                      </th>
                       <th>
                        <font color="black">FOTOS</font>
                      </th>
                      <th>
                        <font color="black"></font>
                      </th>
                    </tr>
                  </thead>


                  <tbody>
                    <?php
                    $docdsc = $_POST['docpsc'];

                    $stmt2 = $con->query("SELECT WE.NR_LIEFERSCHEIN, K.NAME
                              FROM WE, KLIENTEN K
                          WHERE (WE.NR_LIEFERSCHEIN = '$docdsc' OR WE.NR_DOC = '$docdsc' OR
                              WE.NR_DI = '$docdsc' OR WE.COD_CONHEC = '$docdsc')
                              AND K.ID_KLIENT = WE.ID_KLIENT");

                    $stmt2->execute();

                    while ($row = $stmt2->fetch()) {
                      $lote = $row['NR_LIEFERSCHEIN'];
                    }

                    

                    $stmt1 = $con->query("SELECT 
                                            WE.NR_LIEFERSCHEIN LOTE, 
                                            K.NAME CLIENTE,
                                            K.SUCHBEGRIFF CNPJ,
                                            we.typ_doc TIPO,
                                            we.nr_doc DOCUMENTO
                                            FROM WE, KLIENTEN K, WERTE W
                                          WHERE (WE.NR_LIEFERSCHEIN = '".$docdsc."' OR WE.NR_DOC = '" . $docdsc ."' OR
                                                WE.NR_DI = '" . $docdsc . "' OR WE.COD_CONHEC = '" . $docdsc ."')
                                            AND K.ID_KLIENT = WE.ID_KLIENT
                                            and w.werte_ber = 'MOD'
                                          UNION
                                          SELECT DE.LOTE_AD, K.NAME, K.SUCHBEGRIFF, de.typ_doc, de.nr_da
                                            FROM DESMEMBR DE, KLIENTEN K
                                          WHERE DE.NR_DA = '" . $docdsc ."'
                                            AND DE.TYP_PROCESS = 'DAENTR'
                                            AND K.ID_KLIENT = DE.ID_KLIENT
                                            UNION
                                          SELECT DE.LOTE_AD, K.NAME, K.SUCHBEGRIFF, de.typ_doc, de.nr_da
                                            FROM DESMEMBR DE, KLIENTEN K
                                          WHERE DE.NR_DI = '" . $docdsc . "'
                                            AND DE.TYP_PROCESS = 'DINACI'
                                            AND K.ID_KLIENT = DE.ID_KLIENT
                                          UNION
                                          SELECT IV.CHARGE, K.NAME, K.SUCHBEGRIFF, DD.Typ_Doc, dd.nr_dde 
                                            FROM INVOICE IV, DDE_REG DD, KLIENTEN K
                                          WHERE IV.NR_DDE = DD.NR_DDE
                                            AND DD.NR_DDE = '" . $docdsc . "'
                                            AND K.ID_KLIENT = DD.ID_KLIENT");

                    $stmt1->execute();
                     $count = 0;
                    while ($row = $stmt1->fetch()) {
                      $count = $count + 1;
                      $cliente = $row['CLIENTE'];
                      $documento = $row['DOCUMENTO'];
                      $lote = $row['LOTE'];
                      $tipo = $row['TIPO'];
                      $cnpj = $row['CNPJ'];
                    ?>
                      <tr>
                        <td><?= $tipo ?></td>
                        <td><?= $documento ?></td>
                        <td><?= $lote ?></td>
                        <td><?= $cliente ?></td>
                        <td><?= $cnpj ?></td>
                        <!-- AQUI CHAMO A FUNÇÃO PARA ABRIR O MODAL -->
                        <?php
                        $con = mysqli_connect("localhost", "root", "", "vistoria");
                        $sql = mysqli_query($con, "select tb_id, tb_foto from vistoria.confere_fotos where tb_doc = '" . $documento . "'") or die("erro no select lista de fotos slides");
                        $rows = mysqli_num_rows($sql);
                        if ($rows > 0) {
                        ?>
                          <td align="center"><button class="btn btn-primary btn-sm" onclick="openModal(<?php echo $count; ?>);currentSlide(1)"><i class="fa fa-camera"></i></button></td>
                        <?php
                        } else {
                          echo "<td></td>";
                        }
                        ?>
                        <td align="center"><a href="agendar.php?doc=<?= $documento; ?>" class="btn btn-success btn-sm">Agendar</a></td>
                      </tr>
                      <!-- AQUI EU ADICIONEI O MODAL RETORNANDO AS IMAGENS CADASTRADAS NO BANCO -->
                      <div id="myModal_<?php echo $count; ?>" class="modal">
                        <span class="close cursor" style="color: #00FF00; background: #FFFFFF; border-radius: 10px;" onclick="closeModal(<?php echo $count; ?>)">&times;</span>
                        <div class="modal-content" style="margin-top: -50px;">
                          <?php



                          if ($rows > 0) {

                            $id = 0;
                            while ($result = mysqli_fetch_array($sql)) {
                              $id = $id + 1;


                              echo "<div class='mySlides_" . $count . "'>";
                              echo "<div class='numbertext' style='font-size: 20px; font-weight: bold; color: #00FF00;'>{$id} / {$rows}</div>";
                              echo "<img src='" . $result['tb_foto'] . "' style='width:100%; height: 560px;' />";
                              echo "</div>";
                            }
                          } else {

                            echo "<img src='images/transferir.png' style='width:100%; height: 560px;' />";
                          }
                          ?>
                          <!-- AQUI CHAMO A FUNÇÃO PARA PASSAR AS FOTOS APOS ABRIR O MODAL -->
                          <a class="prev" style="color: #00FF00; background: #E0E0E0;" onclick="plusSlides(-1)">&#10094;</a>
                          <a class="next" style="color: #00FF00; background: #E0E0E0;" onclick="plusSlides(1)">&#10095;</a>
                        </div>
                      </div>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <?  } else { ?>
        <div class="x_content">
          <div class="row">
            <div class="col-sm-12">
              <div class="card-box table-responsive">

                <table class="table table-striped table-bordered center" style="width:100%">
                  <!--<table id="datatable-buttons" class="table table-striped table-bordered center" style="width:100%">-->
                  <thead bgcolor="#c9c7c7">
                    <tr>
                      <th>
                        <font color="black">TIPO</font>
                      </th>
                      <th>
                        <font color="black">DOCUMENTO</font>
                      </th>
                      <th>
                        <font color="black">REGISTRO</font>
                      </th>
                      <th>
                        <font color="black">CLIENTE</font>
                      </th>
                      <th>
                        <font color="black">CANAL</font>
                      </th>
                      <th>
                        <font color="black">FOTOS</font>
                      </th>
                      <th>
                        <font color="black"></font>
                      </th>
                    </tr>
                  </thead>


                  <tbody>
                    <?php

                    $stmt = $con->query("SELECT *
  FROM (SELECT 'DI' TIPO,
                D.NR_DI DOCUMENTO,
                D.TIME_INVOICE REGISTRO,
                D.VALOR_NF VALOR,
                K.NAME || ' (' || K.SUCHBEGRIFF || ')' CLIENTE,
                W.BEZ CANAL,
                T.BEZ || ' (' || T.SUCHBEGRIFF || ')' DESPACHANTE,
                D.TIME_DESEMB DESEMBARACO,
                D.TIME_LIBER_DI LIBERACAO,
                D.NR_DA DA,
                K.ID_KLIENT
           FROM DESMEMBR D, WERTE W, KLIENTEN K, DISPATCHER T
          WHERE 
          D.TYP_PROCESS = 'DINACI'
       AND W.WERTE_BER(+) = 'DUCT'
       AND W.WERT(+) = D.DUCT
       AND D.STAT_NAC NOT IN ('80', '90')
       AND D.LAGER = K.LAGER
       AND D.ID_KLIENT = K.ID_KLIENT
       AND D.LAGER = T.LAGER(+)
       AND D.ID_DISPATCHER = T.ID_DISPATCHER(+)
         UNION
         SELECT 'DA' TIPO,
                D.NR_DA DOCUMENTO,
                D.TIME_INVOICE REGISTRO,
                D.VALOR_NF VALOR,
                K.NAME || ' (' || K.SUCHBEGRIFF || ')' CLIENTE,
                W.BEZ CANAL,
                T.BEZ || ' (' || T.SUCHBEGRIFF || ')' DESPACHANTE,
                D.TIME_DESEMB DESEMBARACO,
                D.TIME_LIBER_DI LIBERACAO,
                D.NR_DA DA,
                K.ID_KLIENT
           FROM DESMEMBR D, WERTE W, KLIENTEN K, DISPATCHER T
          WHERE 
          D.TYP_PROCESS = 'DAENTR'
       AND W.WERTE_BER(+) = 'DUCT'
       AND W.WERT(+) = D.DUCT
       AND D.STAT_NAC NOT IN ('80', '90')
       AND D.LAGER = K.LAGER
       AND D.ID_KLIENT = K.ID_KLIENT
       AND D.LAGER = T.LAGER(+)
       AND D.ID_DISPATCHER = T.ID_DISPATCHER(+)
         UNION
         SELECT 'DUE' TIPO,
                DDE.NR_DDE DOCUMENTO,
                DDE.TIME_NEU REGISTRO,
                DDE.PREIS VALOR,
                K.NAME || ' (' || K.SUCHBEGRIFF || ')' CLIENTE,
                W.BEZ CANAL,
                T.BEZ || ' (' || T.SUCHBEGRIFF || ')' DESPACHANTE,
                DDE.DATE_RELEASE DESEMBARACO,
                DDE.DATE_RELEASE LIBERACAO,
                '' DA,
                K.ID_KLIENT
           FROM INVOICE I, DDE_REG DDE, WERTE W, KLIENTEN K, DISPATCHER T
          WHERE 
          I.LAGER = DDE.LAGER
       AND I.NR_DDE = DDE.NR_DDE
       AND I.ID_KLIENT_DDE = DDE.ID_KLIENT -- AJUSTE CHAMADO 33570      
       AND W.WERTE_BER = 'DUCT'
       AND W.WERT = DDE.DUCT
       AND DDE.LAGER = K.LAGER
       AND DDE.STAT = '00'
       AND DDE.ID_KLIENT = K.ID_KLIENT
       AND DDE.LAGER = T.LAGER(+)
       AND DDE.DESPACHANTE = T.ID_DISPATCHER(+)) CAN
 WHERE CAN.LIBERACAO IS NULL
   AND CAN.CANAL IS NOT NULL ORDER BY CAN.REGISTRO ASC");

                    $stmt->execute();
                    $count = 0;

                    while ($row = $stmt->fetch()) {
                      $count = $count + 1;
                      $tipo = $row['TIPO'];
                      $documento = $row['DOCUMENTO'];
                      $registro = $row['REGISTRO'];
                      $valor = $row['VALOR'];
                      $cliente = $row['CLIENTE'];
                      $canal = $row['DESPACHANTE'];
                      $despachante = $row['DESEMBARACO'];
                      $desembaraco = $row['LIBERACAO'];
                      $liberacao = $row['DA'];
                      $cod_cliente = $row['ID_KLIENT'];
                    ?>

                      <tr>
                        <td><?= $tipo ?></td>
                        <td><?= $documento ?></td>
                        <td><?= $registro ?></td>
                        <td><?= $cliente ?></td>
                        <td><?= $canal ?></td>
                        <!-- AQUI CHAMO A FUNÇÃO PARA ABRIR O MODAL -->
                        <?php
                        $con = mysqli_connect("localhost", "root", "", "vistoria");
                        $sql = mysqli_query($con, "select tb_id, tb_foto from vistoria.confere_fotos where tb_doc = '" . $documento . "'") or die("erro no select lista de fotos slides");
                        $rows = mysqli_num_rows($sql);
                        if ($rows > 0) {
                        ?>
                          <td align="center"><button class="btn btn-primary btn-sm" onclick="openModal(<?php echo $count; ?>);currentSlide(1)"><i class="fa fa-camera"></i></button></td>
                        <?php
                        } else {
                          echo "<td></td>";
                        }
                        ?>
                        <td align="center"><a href="agendar.php?doc=<?php echo $documento; ?>" class="btn btn-success btn-sm">Agendar</a></td>
                      </tr>
                      <!-- AQUI EU ADICIONEI O MODAL RETORNANDO AS IMAGENS CADASTRADAS NO BANCO -->
                      <div id="myModal_<?php echo $count; ?>" class="modal">
                        <span class="close cursor" style="color: #00FF00; background: #FFFFFF; border-radius: 10px;" onclick="closeModal(<?php echo $count; ?>)">&times;</span>
                        <div class="modal-content" style="margin-top: -50px;">
                          <?php



                          if ($rows > 0) {

                            $id = 0;
                            while ($result = mysqli_fetch_array($sql)) {
                              $id = $id + 1;


                              echo "<div class='mySlides_" . $count . "'>";
                              echo "<div class='numbertext' style='font-size: 20px; font-weight: bold; color: #00FF00;'>{$id} / {$rows}</div>";
                              echo "<img src='" . $result['tb_foto'] . "' style='width:100%; height: 560px;' />";
                              echo "</div>";
                            }
                          } else {

                            echo "<img src='images/transferir.png' style='width:100%; height: 560px;' />";
                          }
                          ?>
                          <!-- AQUI CHAMO A FUNÇÃO PARA PASSAR AS FOTOS APOS ABRIR O MODAL -->
                          <a class="prev" style="color: #00FF00; background: #E0E0E0;" onclick="plusSlides(-1)">&#10094;</a>
                          <a class="next" style="color: #00FF00; background: #E0E0E0;" onclick="plusSlides(1)">&#10095;</a>
                        </div>
                      </div>
                      <?  } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      </div>
    </div>

  </div>
  <!-- /page content -->
  <?php include("footer.php"); ?>

  <!-- AQUI ADICIONEI O JAVASCRIPT COM AS FUNÇÕES DO MODAL E SLIDE -->
  <script>
    function openModal(id) {
      index = id;
      document.getElementById("myModal_" + id).style.display = "block";

    }

    function closeModal(id) {
      document.getElementById("myModal_" + id).style.display = "none";
    }

    var slideIndex = 1;
    showSlides(slideIndex);

    var teste = 0;

    function plusSlides(n) {

      showSlides(slideIndex += n);
    }

    function currentSlide(n) {
      showSlides(slideIndex = n);
    }


    function showSlides(n) {
      var i;
      var slides = document.getElementsByClassName("mySlides_" + index);

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