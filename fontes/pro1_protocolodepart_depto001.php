<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
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
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_db_depart_classe.php");
include("classes/db_protocolodepart_classe.php");
include("classes/db_protocolodepartdepartamentos_classe.php");
include("dbforms/db_funcoes.php");

db_postmemory($HTTP_POST_VARS);
//db_postmemory($HTTP_GET_VARS);

$cldb_depart     = new cl_db_depart;
$cl_protocolodepart = new cl_protocolodepart;
$cl_protocolodepart_departamentos = new cl_protocolodepartdepartamentos;

$db_opcao = 1;
$opcao = 1;
$db_botao = true;
$existe=true;

if(isset($incluir)){
  $result_existe=$cl_protocolodepart->sql_record($cl_protocolodepart->sql_query_file(null,"*",null,"coddepto=$coddepto"));
  if ($cl_protocolodepart->numrows>0){
    db_msgbox('Departamento já cadastrado!');
    db_fieldsmemory($result_existe,0);
    $codigo=$sequencial;
    echo "<script>
    parent.iframe_db_almoxdepto.location.href='mat1_matdb_almoxdepto001.php?codalmox=".@$codigo."';\n
    parent.iframe_db_almox.location.href='mat1_matdb_almox001.php?chavepesquisa=".@$codigo."';\n
    parent.mo_camada('db_almoxdepto');
    parent.document.formaba.db_almoxdepto.disabled = false;\n
    </script>";
  }else{
    db_inicio_transacao();
    $sqlerro=false;
    $cl_protocolodepart->incluir(null);
    $erro_msg=$cl_protocolodepart->erro_msg;
    if ($cl_protocolodepart->erro_status==0){
      $sqlerro=true;
    }
    $codigo=$cl_protocolodepart->sequencial;
    if ($sqlerro==false){
      $cl_protocolodepart_departamentos->protocolodepart=$codigo;
      $cl_protocolodepart_departamentos->coddepto=$coddepto;
      $cl_protocolodepart_departamentos->incluir(null);	
      if($cl_protocolodepart_departamentos->erro_status=='0'){
        $sqlerro = true;
        $erro_msg = $cl_protocolodepart_departamentos->erro_msg;
      }
    }
    $existe=false;
    db_fim_transacao($sqlerro);
  }
}else if(isset($chavepesquisa)&&$chavepesquisa!=""){
  $result_cha=$cl_protocolodepart->sql_record($cl_protocolodepart->sql_query($chavepesquisa));
  if ($cl_protocolodepart->numrows>0){
    db_fieldsmemory($result_cha,0);
  }
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
<tr> 
<td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
<center>
<?
include("forms/db_frmprotocolodepart_depto.php");
?>
</center>
</td>
</tr>
</table>
</body>
</html>
<?

if(isset($incluir)&&$existe==false){
  if($cl_protocolodepart->erro_status=="0"){
    $cl_protocolodepart->erro(true,false);
    $db_botao=true;
    //    echo "<script> document.form1.db_opcao.disabled=false;</script>";
    if($cl_protocolodepart->erro_campo!=""){
      echo "<script> document.form1.".$cl_protocolodepart->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cl_protocolodepart->erro_campo.".focus();</script>";
    };
  }else{
    db_msgbox($erro_msg);
    echo "<script>
    parent.iframe_db_protocolodepart_depto.location.href='pro1_protocolodepart_depto002.php?protocolodepart=".@$codigo."';\n
    parent.iframe_db_protocolodepart.location.href='pro1_protocolodepart_depto001.php?chavepesquisa=".@$codigo."';\n
    parent.mo_camada('protocolodepart_depto');
    parent.document.formaba.protocolodepart_depto.disabled = false;\n
    </script>";
  };
};
?>