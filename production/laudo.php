<!DOCTYPE html>
<html lang="en">

<?php include("header.php"); ?>
<style>
    @media print {

        .no-print,
        .no-print * {
            display: none !important;
        }
    }

    #conteudo {
        background: white;
    }

    .lista {
        font-size: 18px;
        padding: 10px;
        color: black;
        border-style: solid;
        border-width: 3px !important;
    }

    .titulo {
        font-size: 20px;
        color: black;
        font-weight: bold;
        padding: 20px;
        text-align: center;
        border-style: solid;
        border-width: 3px !important;
    }

    .aviso {
        font-size: 14px;
        padding: 15px;
    }

    .pdf {
        margin-left: -10px;
    }
</style>


<body class="nav-md">

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="row">
            <div class="title_left no-print">
                <h2><a href="index.php">Inicial</a> / Relatório</h2>
            </div>
        </div>
        <br>

        <div class="row">
            <div id="editor"></div>
            <div class="col-md-12 ">
                <button class="btn btn-danger no-print" id="btGerarPDF" onclick="generatePdf();"><i class="fa fa-file-pdf-o"></i> &nbsp;PDF</button>
            </div>
        </div>

        <div id="conteudo">
            <div class="row">
                <div class="col-md-12  border-light border titulo">
                    Relatório de Verificação Física
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 border-top border-bottom border-light border-right lista">
                    Data: 14/10/2020
                </div>
                <div class="col-md-6 border-top border-bottom border-light  lista">
                    Recinto: Aurora Terminais
                </div>
            </div>

            <div class="row">
                <div class="col-md-6  border-light border-right border-top  border-bottom lista">
                    Fiscal: Leonardo Moura
                </div>
                <div class="col-md-6 border-top border-bottom border-light lista">
                    Vistoriador: Clayton Souza
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 border-top border-bottom border-light border-right lista">
                    Hora Inicial: 14/10/2020 09:23
                </div>
                <div class="col-md-6 border-top border-bottom border-light lista">
                    Hora Final: 14/10/2020 10:34
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 aviso">
                    Declaro sob a pena da lei, que a conferÇencia aduaneira remota no documento DUIMP - 12344567891 foi <b>Aprovada</b> conforme as anotações abaixo descritas:
                    <br>
                    Portaria 36/2020
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 aviso">
                    Para demais comprovações, segue abaixo as imagens capturadas pela câmera do recinto:
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 aviso">
                    <img class="imagem" src="images/media.jpg" alt="media" width="500" height="300">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 aviso">
                    <img class="imagem" src="images/picture.jpg" alt="media" width="500" height="300">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 aviso">
                    <img class="imagem" src="images/pool.jpg" alt="media" width="500" height="300">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 aviso">
                    <img class="imagem" src="images/prod-1.jpg" alt="media" width="500" height="300">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 aviso">
                    <img class="imagem" src="images/img.jpg" alt="media" width="500" height="300">
                </div>
            </div>
        </div>
    </div>

    <script src="js/jspdf.js"></script>
    <script src="js/autotablepdf.js"></script>
    <script>
        var div = document.getElementById("conteudo");

        function generatePdf() {
            data = new Date();

            window.open("pdf.php", "", "width=1000,height=900,top=0, left=200");
        }
    </script>

    <?php include("footer.php"); ?>
</body>

</html>