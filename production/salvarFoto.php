<?php
$con = mysqli_connect("localhost", "root", "", "vistoria") or die("<h1>Falha na comunicação com banco</h1>");
$action = $_POST['action'];
$timestamp = date("dmYHis");

if ($action == "salvar") {
    $url = 'http://10.101.10.100/jpg/1/image.jpg';
    $document = trim($_POST['document']);
    $client = trim($_POST['client']);
    $path = $client."/".$document;

    if(!is_dir($path)){
        mkdir($path, 0777, true);
    }

    $ch = curl_init($url);

    $fp = fopen($client."/".$document."/".date("dmYHis").".jpg", 'wb');

    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    $retCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    fclose($fp);

    if ($retCode == 200) {

       
        $file = $client."/".$document."/" . date("dmYHis") . ".jpg";
        
        $insert = mysqli_query($con, "insert into vistoria.confere_fotos (tb_doc,tb_foto,tb_amostra) values ('". $document."','". $file."','0')") or die("erro no insert ".mysqli_error($con));
        if ($insert) {
            $select1 = mysqli_query($con, "select tb_id from vistoria.confere_fotos where tb_doc = '". $document."' and tb_foto = '".$file."' order by tb_id desc limit 1") or die("erro no select 1 ".mysqli_error($con));
            $result1 = mysqli_fetch_array($select1);
            echo $result1['tb_id'];
        }
    } else {
        echo "Erro ao salvar ". $retCode;
    }
}

if ($action == "buscar") {
    //print_r($_POST);

    $document = $_POST['document'];
    $id = $_POST['id'];
    $date = date('Y-m-d');

    $select2 = mysqli_query($con, "select tb_foto from vistoria.confere_fotos where tb_doc = '". $document."' and date(tb_data) = '".$date."' and tb_id = ".$id."") or die("erro no select 2 ".mysqli_error($con));

    $rows = mysqli_num_rows($select2);

    if ($rows > 0) {
        $result2 = mysqli_fetch_array($select2);
        echo $result2['tb_foto'];
    } else {
        echo "0";
    }
}

if ($action == "load") {
    //print_r($_POST);

    $document = $_POST['document'];
    $date = date('Y-m-d');

    $select3 = mysqli_query($con, "select tb_foto from vistoria.confere_fotos where tb_doc = '". $document. "'") or die("erro no select " . mysqli_error($con));

    $rows = mysqli_num_rows($select3);

    if ($rows > 0) {
        while ($result3 = mysqli_fetch_array($select3)) {
            echo $result3['tb_foto'].";";
        }
    } else {
        echo "0";
    }
}

if ($action == "deletar") {
    print_r($_POST);

    $document = $_POST['document'];
    $file = $_POST['file'];

    $remove = unlink($file);
    if($remove === true){
        $delete = mysqli_query($con, "delete from vistoria.confere_fotos where tb_doc = '". $document."' and tb_foto = '".$file."'")or die("erro no delete: ".mysqli_error($con));
        if($delete){
            echo "Deletado com sucesso";
        }
    }else{
        echo "Erro ao remover";
    }
}
