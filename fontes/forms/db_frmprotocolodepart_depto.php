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
//MODULO: protocolo
$clrotulo = new rotulocampo;
$clrotulo->label("descrdepto");
$clrotulo->label("coddepto");
  ?>
  <form name="form1" method="post" action="">
  <center>
  <table border="0">
  <br>
  <br>
  <tr>
    <td nowrap title="<?=@$Tcoddepto?>">
       <?
       db_ancora(@$Lcoddepto,"js_pesquisacoddepto(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('coddepto',6,$Icoddepto,true,'text',$db_opcao," onchange='js_pesquisacoddepto(false);'")
?>
       <?
db_input('descrdepto',40,$Idescrdepto,true,'text',3,'')
       ?>
    </td>
  </tr>
  </tr>
  </table>
  </center>
  <br>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisacoddepto(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_db_depart','func_db_depart.php?funcao_js=parent.js_mostradb_depart1|coddepto|descrdepto','Pesquisa',true);
  }else{
     if(document.form1.coddepto.value != ''){ 
        js_OpenJanelaIframe('','db_iframe_db_depart','func_db_depart.php?pesquisa_chave='+document.form1.coddepto.value+'&funcao_js=parent.js_mostradb_depart','Pesquisa',false);
     }else{
       document.form1.descrdepto.value = ''; 
     }
  }
}
function js_mostradb_depart(chave,erro){
  document.form1.descrdepto.value = chave; 
  if(erro==true){ 
    document.form1.coddepto.focus(); 
    document.form1.coddepto.value = ''; 
  }
}
function js_mostradb_depart1(chave1,chave2){
  document.form1.coddepto.value = chave1;
  document.form1.descrdepto.value = chave2;
  db_iframe_db_depart.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('','db_iframe_protocolodepart','func_protocolodepart.php?funcao_js=parent.js_preenchepesquisa|sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave1,chave2){

  document.form1.coddepto.value = chave1;
  //document.form1.descrdepto.value = chave2;
  db_iframe_protocolodepart.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave;\n";
  }
  ?>
}
</script>