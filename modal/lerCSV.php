<?php
require_once '../classes/BD/crudPDO.php';
include_once '../admin/modal.php';
$idCurso = $_POST["idCurso"];

$fetch = selecionarWHERE("curso", array("nome"), "id= '$idCurso' LIMIT 1");
foreach ($fetch as $f) {
    $nomeCurso = $f["nome"];
}

$fetch = selecionarWHERE("curso", array('codigo'), "id = $idCurso LIMIT 1");
foreach ($fetch as $f) {
    $codCurso = $f['codigo'];
}
?>


<script>
    function setaDadosModal(valor) {
        document.getElementById('nome').value = valor;
    }
    function mostraAjudaCSV(i){
        if(i === 1){
            $("#ajudaCSV").html("<label class='text-success'>Formato CSV</label>");
        }else{
            
            $("#ajudaCSV").html("<label><br></label>");
        }
        
    }


</script>


<center>
    <form class="text-uppercase" action="upload.php" enctype="multipart/form-data" method="POST">
        <br>
        <label class="text-uppercase">Enviar o arquivo: </label>
        <br>
        <input onmouseover="mostraAjudaCSV(1)" onmouseout="mostraAjudaCSV(0)"  name="arquivo" id="arquivo" class="alert-warning" type="file" />
        <br>
        <div id="ajudaCSV"><label><br></label></div>
        <input type="hidden" name="idCurso" id="idCurso" value="<?php echo $idCurso; ?>"/>
      
        <input onmouseover="mostraAjudaCSV(1)" onmouseout="mostraAjudaCSV(0)"  type="submit" class="bg-success  Athena_button_book_large " value="Enviar" /> 
        
    </form>
    <br>
    <button type="button" class="btn-lg Athena_button_book_large text-uppercase" onclick="window.location.href = 'CSV/modelo/modelo.xlsx'"> Modelo da Planilha</button>
</center>



