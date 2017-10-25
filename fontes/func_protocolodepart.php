<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2013  DBselller Servicos de Informatica             
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

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$oPost = db_utils::postmemory($_POST,0);
$oGet  = db_utils::postmemory($_GET,0);

$cl_protocolodepart = new cl_protocolodepart;
$cl_protocolodepart->rotulo->label("sequencial");
$cl_protocolodepart->rotulo->label("coddepto");
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td height="63" align="center" valign="top">
        <table width="35%" border="0" align="center" cellspacing="0">
	     <form name="form2" method="post" action="" >
          <tr>
            <td width="4%" align="right" nowrap title="<?=$Tsequencial?>">
              <?=$Lsequencial?>
            </td>
            <td width="96%" align="left" nowrap>
              <?
		        db_input("sequencial",6,$Isequencial,true,"text",4,"","sequencial");
		      ?>
            </td>
          </tr>
          <tr>
            <td width="4%" align="right" nowrap title="<?=$Tcoddepto?>">
              <?=$Lcoddepto?>
            </td>
            <td width="96%" align="left" nowrap>
              <?
		        db_input("coddepto",6,$Icoddepto,true,"text",4,"","coddepto");
		      ?>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_protocolodepart.hide();">
             </td>
          </tr>
        </form>
        </table>
      </td>
  </tr>
  <tr>
    <td align="center" valign="top">
      <?

      if(!isset($pesquisa_chave)) {

      	if(isset($campos) == false ) {
          if(file_exists("funcoes/db_func_protocolodepart.php") == true) {
            include("funcoes/db_func_protocolodepart.php");
          } else {
            $campos = "sequencial, coddepto";
          }
        }

        //parametros da consulta da classe ( $sequencial=null,$campos="*",$ordem=null,$dbwhere="")
        
        // se apenas o campo sequencial foi preenchido no formulário
        if (isset($sequencial) && (trim($sequencial) != "") && trim($coddepto) == null) {
          $sql = $cl_protocolodepart->sql_query("",$campos,"sequencial"," sequencial = $sequencial");
        }

        // se apenas o campo coddepto foi preenchido como parametro para busca
        else if (isset($coddepto) && (trim($coddepto) != "") && trim($sequencial) == null) {
          $sql = $cl_protocolodepart->sql_query("",$campos,"sequencial","coddepto = $coddepto");
        }

        // se os dois campos de busca foram preenchidos
        else if (isset($sequencial) && (trim($sequencial) != "") && (trim($coddepto) != "")) {
          $sql = $cl_protocolodepart->sql_query("",$campos,"sequencial","sequencial = $sequencial and coddepto = $coddepto");
        }

        // se nenhum parametro foi preenchido
        if(!isset($sql)) {
          $sql = $cl_protocolodepart->sql_query("",$campos,"sequencial", "");
        }
        db_lovrot($sql,15,"()","",$funcao_js);

      } else {

      	if ($pesquisa_chave != null && $pesquisa_chave != "") {

      		if (isset($coddepto) && $coddepto == true) {
      			$result = $cl_protocolodepart->sql_record($cl_protocolodepart->sql_query(null,"*",null,"coddepto = {$pesquisa_chave}"));
          } else {
            $result = $cl_protocolodepart->sql_record($cl_protocolodepart->sql_query($pesquisa_chave,"*",null,""));
      		}

          if ($cl_protocolodepart->numrows != 0) {
            db_fieldsmemory($result,0);
            if (isset($coddepto) && $coddepto == true || !empty($sDescricaoDepartamento)) {
            	echo "<script>".$funcao_js."('$descrdepto',false);</script>";
            } else {
              echo "<script>".$funcao_js."('$sequencial',false);</script>";
            }
          } else {
	         echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
          }
        } else {
	       echo "<script>".$funcao_js."('',false);</script>";
        }
      }

      ?>
     </td>
   </tr>
</table>
</body>
</html>
<?
if(!isset($pesquisa_chave)){
  ?>
  <script>
  </script>
  <?
}
?>