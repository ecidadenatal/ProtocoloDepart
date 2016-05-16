<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBSeller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */
require("libs/db_stdlib.php");
require("libs/db_conecta_plugin.php");
include("libs/db_sql.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_protocolodepart_classe.php");
include("classes/db_protocolodepartdepartamentos_classe.php");
include("classes/db_db_depart_classe.php");
include("dbforms/db_funcoes.php");

$cl_protocolodepart = new cl_protocolodepart;
$cl_protocolodepart_departamentos = new cl_protocolodepartdepartamentos;
$cldb_depart = new cl_db_depart;

$clrotulo = new rotulocampo;
$clrotulo->label('coddepto');
$clrotulo->label('descrdepto');
$clrotulo->label('protocolodepart');
db_postmemory($HTTP_POST_VARS);

if (isset($atualizar)){
  
  db_inicio_transacao();
  $sqlerro = false;
  
  $vt = $HTTP_POST_VARS;
  $ta = sizeof($vt);
  reset($vt);
 
  for($i = 0; $i < $ta; $i++){
 
    $chave = key($vt);
 
    if(substr($chave,0,5) == "CHECK"){
      $dados = split("_",$chave); 

      $cl_protocolodepart_departamentos->sequencial      = null;
      $cl_protocolodepart_departamentos->protocolodepart = $protocolodepart;
      $cl_protocolodepart_departamentos->coddepto        = $dados[1];
      $cl_protocolodepart_departamentos->incluir(null);

      $erro_msg = $cl_protocolodepart_departamentos->erro_msg;
      if ($cl_protocolodepart_departamentos->erro_status == 0){
        $sqlerro=true;
      }
    }

    $proximo = next($vt);
  }  
  db_fim_transacao($sqlerro);
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script>
function js_marca(obj){ 
  var OBJ = document.form1;
  for(i=0;i<OBJ.length;i++){
    if(OBJ.elements[i].type == 'checkbox'){
      OBJ.elements[i].checked = !(OBJ.elements[i].checked == true);            
    }
  }
  return false;
}
</script>  
<style>
.cabec {
  text-align: center;
  color: darkblue;
  background-color:#aacccc;       
  border-color: darkblue;
}
.corpo {
  text-align: center;
  color: black;
  background-color:#ccddcc;       
}
</style>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
</table>
<center>
<form name="form1" method='post'>
<table border='0'>
<tr>
<td ></td>
<td ></td>
</tr>
<tr> 
<td align="left" nowrap title="<?=$Tprotocolodepart?>">Central: </td>
<td align="left" nowrap>
<? 
$result_descr = $cl_protocolodepart->sql_record($cl_protocolodepart->sql_query($protocolodepart,"sequencial as protocolodepart"));

if ($cl_protocolodepart->numrows>0) {
  
  db_fieldsmemory($result_descr,0);
}

db_input("protocolodepart",6,$Iprotocolodepart,true,"hidden",3,"");

$protocolodepart=@$protocolodepart;
db_input("protocolodepart",6,$Iprotocolodepart,true,"text",3,"");

?>
</td>
</tr>
<tr>
<td colspan="2" align="center">
<br>

<? 
//desativa botao atualizar caso seja exclusão
if( isset($db_opcao) == 33){
  $read = "disabled";
} else {
  $read = null;		
}
echo "<input $read name=\"atualizar\" type=\"submit\" value=\"Atualizar\">";
?>

<br>
</td>
</tr>
<?

if (isset($protocolodepart) && $protocolodepart != ""){

$dtAtual      = date("Y-m-d", db_getsession('DB_datausu'));
$iInstituicao = db_getsession("DB_instit");

  $sSqlDepartamentos = $cldb_depart->sql_query_file(null,"coddepto as departamento, descrdepto","coddepto"," instit = {$iInstituicao} and (limite >=  '$dtAtual' or  limite is null)");
  
  $result01  = $cldb_depart->sql_record($sSqlDepartamentos);
  $numrows01 = $cldb_depart->numrows;
  if($numrows01>0){ 
    echo "<table>
    <tr>
    <td class='cabec'  title='Inverte marcação' align='center'><a  title='Inverte Marcação' href='' onclick='return js_marca(this);return false;'>M</a></td>
    <td class='cabec' align='center'  title='$Tcoddepto'>".str_replace(":","",$Lcoddepto)."</td>
    <td class='cabec' align='center'  title='$Tdescrdepto'>".str_replace(":","",$Ldescrdepto)."</td>
    </tr>";      
  } 
  $result02  = $cl_protocolodepart_departamentos->sql_record($cl_protocolodepart_departamentos->sql_query_file(null,"*",null,"protocolodepart=$protocolodepart",null));
  $numrows02 = $cl_protocolodepart_departamentos->numrows;
  $read="";
  
  for($i=0; $i<$numrows01; $i++){
    db_fieldsmemory($result01,$i);
    $che="";
    $read="";
    if (@$coddepto==$departamento){
      $che="checked";
    }
    for($h=0; $h<$numrows02; $h++){
      db_fieldsmemory($result02,$h);        
      if($coddepto==$departamento){
        $che="checked";
        $read="disabled";
      } 
    }

    if (isset($m90_deptalmox)&&$m90_deptalmox=='t'){
    }else{
      $result_naumostra  = $cl_protocolodepart_departamentos->sql_record($cl_protocolodepart_departamentos->sql_query_file(null,null,"*","","coddepto = $departamento and protocolodepart <> $protocolodepart"));
      $numrows_naumostra = $cl_protocolodepart_departamentos->numrows;
      if ($numrows_naumostra!=0){
        continue;    
      }
    }
    //desativa checkbox caso seja exclusão
    if( isset($db_opcao) == "33"){
      $read = "disabled";
    }
    
    echo "<tr>
    <td  class='corpo' title='Inverte a marcação' align='center'><input $read  $che type='checkbox' name='CHECK_$departamento' id='CHECK_".$departamento."'></td>
    <td  class='corpo'  align='center' title='$Tcoddepto'><label for='CHECK_".$departamento."' style=\"cursor: hand\"><small>$departamento</small></label></td>
    <td  class='corpo'  align='center' title='$Tdescrdepto'><label for='CHECK_".$departamento."' style=\"cursor: hand\"><small>$descrdepto</small></label></td>
    </tr>";
  }
  echo "</table>";	        
  ?>
  <tr >
  <td ></td>
  <td ></td>
  </tr>
  <?
}
?>
</table>
</form>
</center>
<? 
if (isset($atualizar)){
  db_msgbox($erro_msg);
  if($cl_protocolodepart_departamentos->erro_campo!=""){
    echo "<script> document.form1.".$cl_protocolodepart_departamentos->erro_campo.".style.backgroundColor='#99A9AE';</script>";
    echo "<script> document.form1.".$cl_protocolodepart_departamentos->erro_campo.".focus();</script>";
  }
}
?>
</body>
</html>