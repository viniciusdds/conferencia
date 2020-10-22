<!DOCTYPE html>
<html lang="en">
<link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
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
        /* text-align: center; */
        border-style: solid;
        border-width: 1px !important;
    }

    .titulo {
        font-size: 20px;
        color: black;
        font-weight: bold;
        padding: 20px;
        text-align: center;
        border-style: solid;
        border-width: 1px !important;
    }

    .aviso {
        font-size: 14px;
        padding: 15px;
        text-align: center;
    }

    .nota {
        text-align: left;
        font-size: 12px;
    }

    .pdf {
        margin-left: -10px;
    }
</style>

<body onload="CriaPDF();fechar();">

    <!-- page content -->
    <div class="container">
        <div id="conteudo">
            <div class="row">
                <div class="col-md-12 border titulo">
                    Relatório de Verificação Física
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 border lista">
                    Data: 14/10/2020
                </div>
                <div class="col-md-6 border lista">
                    Recinto: Aurora Terminais
                </div>
            </div>

            <div class="row">
                <div class="col-md-6  border lista">
                    Fiscal: Leonardo Moura
                </div>
                <div class="col-md-6 border lista">
                    Vistoriador: Clayton Souza
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 border-top border lista">
                    Hora Inicial: 14/10/2020 09:23
                </div>
                <div class="col-md-6 border lista">
                    Hora Final: 14/10/2020 10:34
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 nota">
                    Declaro sob a pena da lei, que a conferência aduaneira remota no documento DUIMP - 12344567891 foi <b>Aprovada</b> conforme as anotações abaixo descritas:
                    <br>
                    Portaria 36/2020
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 nota">
                    Para demais comprovações, segue abaixo as imagens capturadas pela câmera do recinto:
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 aviso">
                    <img class="imagem" src="images/media.jpg" alt="media" width="900" height="500">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 aviso">
                    <img class="imagem" src="images/picture.jpg" alt="media" width="900" height="500">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 aviso">
                    <img class="imagem" src="images/pool.jpg" alt="media" width="900" height="500">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 aviso">
                    <img class="imagem" src="images/prod-1.jpg" alt="media" width="900" height="500">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 aviso">
                    <img class="imagem" src="images/img.jpg" alt="media" width="900" height="500">
                </div>
            </div>
        </div>
    </div>


    <script>
        function CriaPDF() {
            var minhaTabela = document.getElementById('conteudo').innerHTML;
            var style = "<style>";
            style = style + "* {font-family: sans-serif;}";
            style = style + ".lista {font-size: 18px; padding: 10px; color: black; text-align: center; border-style: solid; border-width: 1px;}";
            style = style + ".titulo {font-size: 20px; color: black; font-weight: bold; padding: 20px; text-align: center; border-style: solid; border-width: 1px;}";
            style = style + ".aviso {text-align: center;}";
            style = style + ".nota {text-align: left; font-size: 12px;}";
        style = style + "</style>";
        // CRIA UM OBJETO WINDOW
        var win = window.open('', '', 'height=700,width=1200');
        win.document.write('<html><head>');
        //win.document.write('<title>Empregados</title>');   // <title> CABEÇALHO DO PDF.
        win.document.write('<link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">'); // <title> CABEÇALHO DO PDF.
        win.document.write(style); // INCLUI UM ESTILO NA TAB HEAD
        win.document.write('</head>');
        win.document.write('<body>');
        win.document.write(minhaTabela); // O CONTEUDO DA TABELA DENTRO DA TAG BODY
        win.document.write('</body></html>');
        win.document.close(); // FECHA A JANELA
        win.print(); // IMPRIME O CONTEUDO
        win.close();
        }

        function fechar() {
            window.close();
        }
    </script>