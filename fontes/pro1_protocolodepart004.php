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
include("dbforms/db_funcoes.php");
include("classes/db_protocolodepart_classe.php");
include("classes/db_protocolodepartdepartamentos_classe.php");

$cl_protocolodepart = new cl_protocolodepart;
$cl_protocolodepart_departamentos = new cl_protocolodepartdepartamentos;

db_postmemory($HTTP_POST_VARS);

$db_opcao = 1;
$db_botao = true;

if (isset($coddepto)) {

  // verifica se o departamento já não está cadastrado como uma central
  $cl_protocolodepart->sql_record($cl_protocolodepart->sql_query(null, "coddepto", null, "coddepto = $coddepto"));
  if ($cl_protocolodepart->numrows == 0) {
	
    if (isset($incluir)) {
    	
      $sqlerro=false;
      db_inicio_transacao();
      
      $cl_protocolodepart->coddepto = $coddepto;
      $cl_protocolodepart->incluir(null);

      if ($cl_protocolodepart->erro_status == 0) {
        $sqlerro=true;
        $erro_msg = $cl_protocolodepart->erro_msg;
      } 

      $cl_protocolodepart_departamentos->sequencial = null;
      $cl_protocolodepart_departamentos->protocolodepart = $cl_protocolodepart->sequencial;
      $cl_protocolodepart_departamentos->coddepto   = $coddepto;
      $cl_protocolodepart_departamentos->incluir(null);
      
      if ($cl_protocolodepart_departamentos->erro_status == 0) {
        $sqlerro=true;
        $erro_msg = $cl_protocolodepart_departamentos->erro_msg;
      }        

      if ( $sqlerro==false ) {
        $erro_msg = $cl_protocolodepart->erro_msg;
      }
      db_fim_transacao($sqlerro);
      $sequencial = $cl_protocolodepart->sequencial;
      $db_opcao = 1;
      $db_botao = true;
    }

  } else {    
  	$sqlerro  = true;
    $erro_msg = "Este departamento já é uma Central! Não poderá ser incluído novamente!";
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
<center>
<table border="0" style="padding-top:15px" cellspacing="0" cellpadding="0">
  <tr> 
    <td align="center" bgcolor="#CCCCCC"> 
	  <?
	    include("forms/db_frmprotocolodepart.php");
	  ?>
    </td>
  </tr>
</table>
</center>
</body>
</html>
<?
if(isset($incluir)){
  if($sqlerro==true){
    db_msgbox($erro_msg);
    if($cl_protocolodepart->erro_campo!=""){
      echo "<script> document.form1.".$cl_protocolodepart->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cl_protocolodepart->erro_campo.".focus();</script>";
    }
  }else{
   db_msgbox($erro_msg);
   db_redireciona("pro1_protocolodepart005.php?liberaaba=true&chavepesquisa=$sequencial");
  }
}
/*if (isset($chavepesquisa)) {
  db_redireciona("pro1_protocolodepart005.php?liberaaba=true&chavepesquisa=$chavepesquisa");
}*/
?>