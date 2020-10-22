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
<script type="text/javascript" src="js/zxml.js"></script>
<script type="text/javascript" src="js/pos.js"></script>
<script type="text/javascript" src="js/activeX.js"></script>
<script type="text/javascript" src="js/slider.js"></script>
<script type="text/javascript" src="js/tooltip.js"></script>
<script>
    /* =================================== Continuous move (arrows) =================================== */
    var newContMove = zXmlHttp.createRequest();
    if (newContMove.overrideMimeType)
        newContMove.overrideMimeType('text/plain');

    var mouseUp;

    function continousMove(action, val) {
        //alert('continousMove');
        mouseUp = (val == "0,0" || val == "0");
        var theAction = "continuous";
        if (action == "pan" || action == "tilt") theAction += "pantiltmove=";
        else if (action == "zoom") theAction += "zoommove=";
        else if (action == "focus") theAction += "focusmove=";
        else if (action == "iris") theAction += "irismove=";
        else if (action == "brightness") theAction += "brightnessmove=";

        theAction += val;

        if (imagerotation != "")
            theAction += "&imagerotation=" + imagerotation;

        if (newContMove.readyState > 0 && newContMove.readyState < 4)
            newContMove.abort();

        var now = new Date();
        newContMove.open("GET", "http://10.101.10.100/axis-cgi/com/ptz.cgi?camera=1&" + theAction + "&timestamp=" + now.getTime(), true);
        newContMove.onreadystatechange = newContMove_onchange;
        update_sliders = false;
        newContMove.send("");
    }

    function newContMove_onchange() {
        //alert('newContMove_onchange');
        if (ptzPosInterval)
            window.clearTimeout(ptzPosInterval);

        try {
            if (newContMove.status == 401) {
                return;
            }
        } catch (e) {}

        if (typeof(newContMove) == 'object' && newContMove.readyState == 4) {
            update_sliders = true;
            if (newContMove.responseText.length > 0) {
                if (!mouseUp) {
                    // Don't show the pop-up on the mouse up event.
                    var alertTxt = newContMove.responseText.replace(/<.*>/ig, "").trim();
                    var panEnabled = true;
                    var tiltEnabled = true;
                    if (!((alertTxt.indexOf('pan') != -1 && !panEnabled) || (alertTxt.indexOf('tilt') != -1 && !tiltEnabled)))
                        alert(alertTxt + " teste");
                }
            }
            ptzPosInterval = window.setTimeout(getPtzPositions, position_interval);
        }
    }

    /* =================================== PTZ slider functions =================================== */

    var maxPan = parseInt("180", 10);
    var minPan = parseInt("-180", 10);
    var panPos = Math.round((minPan + maxPan) / 2);
    var maxTilt = parseInt("0", 10);
    var minTilt = parseInt("-90", 10);
    var tiltPos = Math.round((minTilt + maxTilt) / 2);
    var maxZoom = parseInt("10909", 10);
    var minZoom = parseInt("1", 10);
    var zoomPos = Math.round((minZoom + maxZoom) / 2);
    var maxFocus = parseInt("9999", 10);
    var minFocus = maxFocus * (-1);
    var focusPos = Math.round((minFocus + maxFocus) / 2);
    var maxIris = parseInt("9999", 10);
    var minIris = parseInt("1", 10);
    var irisPos = Math.round((minIris + maxIris) / 2);

    var panSlider = null;
    var tiltSlider = null;
    var zoomSlider = null;
    var focusSlider = null;
    var irisSlider = null;

    var theNewSliderValue;

    var ptzPosInterval = null;
    var initiateToolTip = true;

    var ptzValues = zXmlHttp.createRequest();
    if (ptzValues.overrideMimeType)
        ptzValues.overrideMimeType('text/plain');

    var isCtlStarted = false;

    function getPtzPositions() {
        if (ptzValues.readyState > 0 && ptzValues.readyState < 4)
            return;

        var now = new Date();
        var timestamp = now.getTime();
        var url = "/axis-cgi/com/ptz.cgi?query=position,limits&camera=1&html=no";
        if (imagerotation != "")
            url += "&imagerotation=" + imagerotation;
        url += "&timestamp=" + timestamp;
        ptzValues.open("GET", url, true);
        ptzValues.onreadystatechange = showPtzValues;
        try {
            ptzValues.send("");
        } catch (e) {}
    }
</script>

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
            <div class="col-md-9">
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
                                <label>ARM1-01</label>
                                <div class="image view view-first">
                                    <img style="width: 100%; display: block; cursor: pointer;" id="ARM1" onclick="mostrar('ARM1');" src="http://10.101.10.100/axis-cgi/mjpg/video.cgi" alt="image" />
                                </div>
                                <br>
                                <label>ARM2-02</label>
                                <div class="image view view-first">
                                    <img style="width: 100%; display: block; cursor: pointer;" id="ARM2" onclick="mostrar('ARM2');" src="images/pool.jpg" alt="image" />
                                </div>
                                <br>
                                <label>ARM3-03</label>
                                <div class="image view view-first">
                                    <img style="width: 100%; display: block; cursor: pointer;" id="ARM3" onclick="mostrar('ARM3');" src="images/media.jpg" alt="image" />
                                </div>
                                <br>
                                <label>ARM4-04</label>
                                <div class="image view view-first">
                                    <img style="width: 100%; display: block; cursor: pointer;" id="ARM4" onclick="mostrar('ARM4');" src="images/cropper.jpg" alt="image" />
                                </div>
                            </div>
                            <div class="col-md-10" style="text-align: right;">
                                <br>
                                <div class="image view view-first">
                                    <img style="width: 100%; height: 400px; display: block; cursor: pointer;" id="principal" src="images/user.png" alt="image" />
                                </div>

                            </div>
                        </div>


                    </div>
                </div>

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Painel de Controle</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-6">
                                <script language="JavaScript">
                                    var ptzDefMaxDigitalZoomMag = 12;
                                    var ptzDefContSpeedZoom = 100;
                                    var ptzDefContSpeedFocus = 20;
                                    var ptzDefContSpeedIris = Number.NaN;
                                    var ptzDefQueryInterval = 300;
                                    var ptzDefMinFocusList = [
                                        [1250, 10],
                                        [3750, 30],
                                        [6250, 100],
                                        [8750, 150],
                                    ];

                                    var ptzDefMaxZoomList = [
                                        [358, 2],
                                        [715, 3],
                                        [1072, 4],
                                        [1429, 5],
                                        [1786, 6],
                                        [2143, 7],
                                        [2500, 8],
                                        [2857, 9],
                                        [3214, 10],
                                        [3571, 11],
                                        [3928, 12],
                                        [4285, 13],
                                        [4642, 14],
                                        [5000, 15],
                                        [5357, 16],
                                        [5714, 17],
                                        [6071, 18],
                                        [6428, 19],
                                        [6785, 20],
                                        [7142, 21],
                                        [7499, 22],
                                        [7856, 23],
                                        [8213, 24],
                                        [8570, 25],
                                        [8927, 26],
                                        [9284, 27],
                                        [9641, 28],
                                        [9999, 29],
                                        [10909, 58],
                                        [12727, 116],
                                        [14545, 174],
                                        [16363, 232],
                                        [18181, 290],
                                        [19999, 348],
                                    ];

                                    var ptzDefContSpeedPan = 100;
                                    var ptzDefContSpeedTilt = 100;

                                    var ptzDefSpeedList = [
                                        [1, 0.20],
                                        [10, 0.50],
                                        [14, 1.00],
                                        [18, 2.00],
                                        [25, 5.00],
                                        [32, 10.00],
                                        [40, 20.00],
                                        [53, 45.00],
                                        [67, 90.00],
                                        [76, 135.00],
                                        [84, 180.00],
                                        [91, 225.00],
                                        [100, 300.00],
                                    ];

                                    var MoUpBtnStatTxt = "Move up";
                                    var MoDoBtnStatTxt = "Move down";
                                </script>
                                Vertical

                                <span id="tilt-up" style="cursor: pointer;">
                                    <img src="http://10.101.10.100/pics/up_14x13px.gif" width="14" height="13" onmousedown="continousMove('tilt', '0,'+ptzDefContSpeedTilt);this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('tilt', '0,0');this.onmouseout=noAction; return false;">
                                </span>

                                <span id="zoombar1">
                                    <img src="http://10.101.10.100/pics/panbar_abs_268x14px.gif" width="220" height="13" id="zoom-bg" onmousemove="handleBarMove(this.parentNode, event);" onclick="getPtzPositions();">
                                </span>

                                <span id="tilt-down" style="cursor: pointer;">
                                    <img src="http://10.101.10.100/pics/down_14x13px.gif" width="14" height="13" onmousedown="continousMove('tilt', '0,-'+ptzDefContSpeedTilt);this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('tilt', '0,0');this.onmouseout=noAction; return false;">
                                </span>

                            </div>
                            <div class="col-md-6">
                                <script language="JavaScript">
                                    var ptzDefMaxDigitalZoomMag = 12;
                                    var ptzDefContSpeedZoom = 100;
                                    var ptzDefContSpeedFocus = 20;
                                    var ptzDefContSpeedIris = Number.NaN;

                                    var ptzDefQueryInterval = 300;

                                    var ptzDefMinFocusList = [
                                        [1250, 10],
                                        [3750, 30],
                                        [6250, 100],
                                        [8750, 150],
                                    ];

                                    var ptzDefMaxZoomList = [
                                        [358, 2],
                                        [715, 3],
                                        [1072, 4],
                                        [1429, 5],
                                        [1786, 6],
                                        [2143, 7],
                                        [2500, 8],
                                        [2857, 9],
                                        [3214, 10],
                                        [3571, 11],
                                        [3928, 12],
                                        [4285, 13],
                                        [4642, 14],
                                        [5000, 15],
                                        [5357, 16],
                                        [5714, 17],
                                        [6071, 18],
                                        [6428, 19],
                                        [6785, 20],
                                        [7142, 21],
                                        [7499, 22],
                                        [7856, 23],
                                        [8213, 24],
                                        [8570, 25],
                                        [8927, 26],
                                        [9284, 27],
                                        [9641, 28],
                                        [9999, 29],
                                        [10909, 58],
                                        [12727, 116],
                                        [14545, 174],
                                        [16363, 232],
                                        [18181, 290],
                                        [19999, 348],
                                    ];

                                    var ptzDefContSpeedPan = 100;
                                    var ptzDefContSpeedTilt = 100;

                                    var ptzDefSpeedList = [
                                        [1, 0.20],
                                        [10, 0.50],
                                        [14, 1.00],
                                        [18, 2.00],
                                        [25, 5.00],
                                        [32, 10.00],
                                        [40, 20.00],
                                        [53, 45.00],
                                        [67, 90.00],
                                        [76, 135.00],
                                        [84, 180.00],
                                        [91, 225.00],
                                        [100, 300.00],
                                    ];

                                    if (typeof(ptzDefContSpeedZoom) != "number" || isNaN(ptzDefContSpeedZoom))
                                        var ptzDefContSpeedZoom = 70;
                                </script>

                                <label>Zoom
                                    <span id="zoom-left" style="cursor: pointer;">
                                        <img src="http://10.101.10.100/pics/left_15x14px.gif" width="15" height="14" onmousedown="continousMove('zoom', -ptzDefContSpeedZoom);this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('zoom', 0);this.onmouseout=noAction; return false;">
                                    </span>
                                </label>
                                <span id="zoombar1">
                                    <img src="http://10.101.10.100/pics/zoombar_268x14px.gif" width="200" height="14" id="zoom-bg" onmousemove="handleBarMove(this.parentNode, event);" onclick="getPtzPositions();">
                                </span>
                                <span id="zoom-right" style="cursor: pointer;">
                                    <img src="http://10.101.10.100/pics/right_15x14px.gif" width="15" height="14" onmousedown="continousMove('zoom', ptzDefContSpeedZoom);this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('zoom', 0);this.onmouseout=noAction; return false;">
                                </span>
                                <input type="hidden" name="zoomvalue" id="zoom" value="">
                            </div>


                            <div class="col-md-6">
                                <label>Horizontal
                                    <span id="pan-left" style="cursor: pointer;">
                                        <img src="http://10.101.10.100/pics/left_15x14px.gif" width="15" height="14" onmousedown="continousMove('pan', -ptzDefContSpeedPan+',0');this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('pan', '0,0');this.onmouseout=noAction; return false;">
                                    </span>
                                    <span id="panbar1">
                                        <img src="http://10.101.10.100/pics/panbar_abs_268x14px.gif" width="200" height="14" id="pan-bg" onmousemove="handleBarMove(this.parentNode, event);" onclick="getPtzPositions();" style="background-position: 0px 5px;">
                                    </span>
                                    <span id="pan-right" style="cursor: pointer;">
                                        <img src="http://10.101.10.100/pics/right_15x14px.gif" width="15" height="14" onmousedown="continousMove('pan', ptzDefContSpeedPan+',0');this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('pan', '0,0');this.onmouseout=noAction; return false;">
                                    </span>
                                </label>
                                <input type="hidden" name="panvalue" id="pan" value="105">
                            </div>


                            <div class="col-md-6">
                                <label>Foco</label>
                                <span id="focus-left" style="cursor: pointer;">
                                    <img src="http://10.101.10.100/pics/left_15x14px.gif" width="15" height="14" onmousedown="continousMove('focus', -ptzDefContSpeedFocus);this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('focus', 0);this.onmouseout=noAction; return false;">
                                </span>
                                <span id="focusbar1">
                                    <img src="http://10.101.10.100/pics/panbar_rel_nonlin_268x14px.gif" width="210" height="14" id="focus-bg" onmousemove="handleBarMove(this.parentNode, event);" onclick="getPtzPositions();" style="background-position: 0px 5px;">
                                </span>
                                <span id="focus-right" style="cursor: pointer;">
                                    <img src="http://10.101.10.100/pics/right_15x14px.gif" width="15" height="14" onmousedown="continousMove('focus', ptzDefContSpeedFocus);this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('focus', 0);this.onmouseout=noAction; return false;">
                                </span>
                                <input type="hidden" name="focusvalue" id="focus" value="0">
                            </div>
                        </div>


                    </div>
                    <br>
                    <div class="x_content" style="margin-top: 30px;">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <button class="btn btn-app" id="snap" onclick="snapshot();" style="cursor: pointer; margin-top: 5px;">
                                    <i class="fa fa-camera"></i> Fotografar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Ações</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-12">
                            <button class="btn btn-warning">Solicitar Amostra</button>
                            <button class="btn btn-warning">Solicitar Laudo Pericial</button>
                            <button class="btn btn-danger">Responder</button>
                            <!-- modals -->
                            <!-- Large modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Enviar Relatório</button>

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


            </div>

            <div class="col-md-3">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Vistoria</h2>
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
                            <div class="col-md-12" style="text-align: center;">
                                <button onclick="start();" class="btn btn-app" style="cursor: pointer;">
                                    <i class="fa fa-play"></i> Gravar
                                </button>
                                <button class="btn btn-app" onclick="stop();" style="cursor: pointer;">
                                    <i class="fa fa-pause"></i> Pausar
                                </button>
                            </div>
                        </div>

                        <div class="item form-group">
                            <div class="col-md-12" style="text-align: center;">
                                <div class="border">
                                    <div style="background-color: #E0E0E0; padding: 10px; font-weight: bold;">
                                        Tempo Percorrido
                                    </div>
                                    <div style="font-size: 21px;" id="screen">
                                        00 : 00 : 00 : 00
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="item form-group">
                            <div class="col-md-12" style="text-align: center;">
                                <button class="btn btn-app" onclick="reset();" style="cursor: pointer;">
                                    <i class="fa fa-power-off"></i> Limpar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

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
                        <b>Recinto:</b> EADI AURORA TERMINAIS<br>
                        <b>Data Agendada:</b> <?php echo date("d/m/Y H:i:s"); ?><br>
                        <b>Responsável:</b> Deivid Santos<br>
                        <b>Cargo do Designado:</b> Auditor Fiscal<br>
                        <b>Telefone Fixo1:</b> (11) 3245-2039 Ramal1: 4872<br>
                        <b>Celular:</b>
                    </div>
                </div>

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
                        <b>Número:</b> DI 19/2002389-7<br>
                        <b>Canal:</b> <button class="btn btn-round btn-danger btn-sm" style="width:45%; height: 30px;">Canal Vermelho</button><br>
                        <b>Comissária:</b> SAFE TRADE CONSULTORIA LTDA.<br>
                        <b>Cliente:</b> FLEXTRONICS LTDA.<br>
                    </div>
                </div>

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Conhecimento</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li>
                                <a><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <b>Nome:</b> Marcos Lages<br>
                        <b>Telefone Fixo 1:</b> (11) 3940-4049<br>
                        <b>Celular:</b>
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
    <script>
        var undefinedVar; //Workaround for IE5
        var img = undefinedVar; // The video stream image object
        var cross = undefinedVar; // The crosshair image object
        var siPos;
        var thedragbox;
        var thedragarea;
        if (browser != "IE")
            var boxdef = new Box(0, 0, 10, 10);
        var radius;
        var mode = "center";

        var imagerotation = "";
        imagerotation = "180"; //root_Image_I#_Appearance_Rotation
        var update_sliders = true;
        var ptzDefMaxOpticalZoomMag = 29;
        var ptzDefMaxDigitalZoomMag = 12;
        var ptzDefContSpeedZoom = 100;
        var ptzDefContSpeedFocus = 20;
        var ptzDefContSpeedIris = Number.NaN;

        var ptzDefQueryInterval = 300;

        var ptzDefMinFocusList = [
            [1250, 10],
            [3750, 30],
            [6250, 100],
            [8750, 150],
        ];

        var ptzDefMaxZoomList = [
            [358, 2],
            [715, 3],
            [1072, 4],
            [1429, 5],
            [1786, 6],
            [2143, 7],
            [2500, 8],
            [2857, 9],
            [3214, 10],
            [3571, 11],
            [3928, 12],
            [4285, 13],
            [4642, 14],
            [5000, 15],
            [5357, 16],
            [5714, 17],
            [6071, 18],
            [6428, 19],
            [6785, 20],
            [7142, 21],
            [7499, 22],
            [7856, 23],
            [8213, 24],
            [8570, 25],
            [8927, 26],
            [9284, 27],
            [9641, 28],
            [9999, 29],
            [10909, 58],
            [12727, 116],
            [14545, 174],
            [16363, 232],
            [18181, 290],
            [19999, 348],
        ];

        var ptzDefContSpeedPan = 100;
        var ptzDefContSpeedTilt = 100;

        var ptzDefSpeedList = [
            [1, 0.20],
            [10, 0.50],
            [14, 1.00],
            [18, 2.00],
            [25, 5.00],
            [32, 10.00],
            [40, 20.00],
            [53, 45.00],
            [67, 90.00],
            [76, 135.00],
            [84, 180.00],
            [91, 225.00],
            [100, 300.00],
        ];

        var position_interval = ((typeof(ptzDefQueryInterval) != "number" || isNaN(ptzDefQueryInterval)) ? 1000 : ptzDefQueryInterval);

        function noAction(event) {
            return true;
        }

        function init() {
            if ((browser != "IE") && (("".indexOf("/mjpg/") != -1) || (document.URL.indexOf("/view/view.shtml") == -1))) {
                img = document.getElementById("stream");
                cross = document.getElementById("crosshair");
                switchMode();
                // Center crosshair
                var si = document.getElementById("stream");
                var ch = document.getElementById("crosshair");
                siPos = getPos(si);
                ch.style.left = (si.width - ch.width) / 2 + siPos.x;
                ch.style.top = (si.height - ch.height) / 2 + siPos.y;
                thedragbox = document.getElementById("zoombox");
                thedragbox.style.visibility = 'hidden';
                if (mode == "center") {
                    thedragarea = document.getElementById("stream");
                    thedragarea.onmousedown = placeHandler;
                    thedragarea.onmouseup = noAction;
                    thedragarea.onmousemove = noAction;
                    cross.onmousedown = placeHandler;
                }
            }
            getPtzPositions();
        }
    </script>
</body>

</html>