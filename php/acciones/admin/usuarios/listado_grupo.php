<?
//Manejo el MODO del listado

    if ($modo = $this->hilo->obtener_parametro("usu_modo")) {
        $this->hilo->persistir_dato_global("usu_modo",$modo);
    }else{
        if(!($modo = $this->hilo->recuperar_dato_global("usu_modo"))){
            $modo = "grupo_acceso";
        }
    }

    if($modo=="grupo_acceso"){

        //Listado de GRUPO de ACCESO
        $titulo = "USUARIOS por GRUPO de ACCESO";
        $editor = "/admin/usuarios/grupo";
        $editor_img = "grupo";
        $editor_tip = "Grupo de Acceso";
        //Cambio de MODO
        $link="perfil_datos";
        $link_img="perfil";
        $link_tip="Ver listado de PERFILES de DATOS";
        $sql = "
SELECT      ga.proyecto as                      grupo_acceso_proyecto,
            ga.usuario_grupo_acc as             grupo_acceso,
            ga.nombre as                        corte_descripcion,
            ga.nivel_acceso as                  nivel_acceso,
            up.usuario as                       usuario,
            u.nombre as                         usuario_nombre,
            pd.usuario_perfil_datos as          perfil_datos,
            pd.nombre as                        perfil_datos_nombre
FROM        apex_usuario_proyecto up
            INNER JOIN apex_usuario u
                ON up.usuario = u.usuario
            INNER JOIN apex_usuario_perfil_datos pd
                ON  up.proyecto = pd.proyecto
                AND up.usuario_perfil_datos = pd.usuario_perfil_datos
            RIGHT OUTER JOIN apex_usuario_grupo_acc ga
                ON  ga.proyecto = up.proyecto
                AND     ga.usuario_grupo_acc = up.usuario_grupo_acc
WHERE       ga.proyecto = '".$this->hilo->obtener_proyecto()."'
AND         ga.nivel_acceso >= ".$this->hilo->obtener_usuario_nivel_acceso()."
ORDER BY    3,6;";

    }else{
        //Listado de PERFIL de DATOS
        $titulo = "USUARIOS por PERFIL de DATOS";
        $editor = "/admin/usuarios/perfil";
        $editor_img = "perfil";
        $editor_tip = "Perfil de Dato";
        //Cambio de MODO
        $link="grupo_acceso";
        $link_img="grupo";
        $link_tip="Ver listado de GRUPOS de ACCESO";
        $sql = "SELECT  pd.proyecto as              perfil_datos_proyecto,
                        pd.usuario_perfil_datos as  perfil_datos,
                        pd.nombre as                corte_descripcion,
                        u.usuario as                usuario,
                        u.nombre as                 usuario_nombre
                FROM    apex_usuario_proyecto up
                        INNER JOIN apex_usuario u
                            ON u.usuario = up.usuario
                        RIGHT OUTER JOIN apex_usuario_perfil_datos pd
                            ON up.proyecto = pd.proyecto
                            AND up.usuario_perfil_datos = pd.usuario_perfil_datos
                WHERE   pd.proyecto = '".$this->hilo->obtener_proyecto()."'
                ORDER BY    1,3,5;";
    }
?>
<table width="100%"  class='cat-item'>

<tr>
     <td colspan='3'>
         <table class='cat-item'  width="100%">
         <tr><td width="3%">
<?
    $param['tipo'] = "normal";
    $param['texto'] = $link_tip;
    $param['imagen_recurso_origen'] = "apex";
    $param['imagen'] = "usuarios/$link_img.gif";
    echo $this->vinculador->generar_solicitud(null,null,array('usu_modo'=>$link),false,false,$param) ;
?>
    <td width="95%">
    </td>

    <td width="2%">
<?
    $param['tipo'] = "normal";
    $param['texto'] = "Administracion de PERFILES de DATOS en otras fuentes de datos";
    $param['imagen_recurso_origen'] = "apex";
    $param['imagen'] = "tabla.gif";
    $param['frame'] = "frame_centro";
    echo $this->vinculador->generar_solicitud('toba','/admin/usuarios/tabla_perfil',array('usu_modo'=>$link),false,false,$param) ;
?>
    </td>
    <td width="2%">
<?
    $param['tipo'] = "normal";
    $param['texto'] = "Administracion de USUARIOS en otras fuentes de datos";
    $param['imagen_recurso_origen'] = "apex";
    $param['imagen'] = "tabla.gif";
    $param['frame'] = "frame_centro";
    echo $this->vinculador->generar_solicitud('toba','/admin/usuarios/tabla_usuarios',array('usu_modo'=>$link),false,false,$param) ;
?>
    </td>
    </tr>
    </table>
     </td>
</tr>
<table>

<script language='javascript'>
    editor='usuario';
</script>
<table width="100%"  class='listado-base'>
<tr>
     <td width="98%" class="lista-obj-titulo" ><? echo $titulo ?></td>
     <td width="2%"  class='lista-obj-titulo'>
    <a href="<? echo $this->vinculador->generar_solicitud("toba",$editor) ?>"
    class="list-obj" target="<? echo  apex_frame_centro ?>">
    <? echo recurso::imagen_apl("usuarios/{$editor_img}_nuevo.gif",true,null,null,"Crear $editor_tip") ?>
    </a>
    </td>
</tr>
</table>
<table width="100%" class='lista-obj'>
    <tr>
      <td class='lista-obj-titcol' colspan='2'>ID</td>
      <td class='lista-obj-titcol' >NOMBRE</td>
    </tr>
<?
    global $ADODB_FETCH_MODE;
    $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
//  dump_sql($sql);
    $rs =& $db["instancia"][apex_db_con]->Execute($sql);
    if(!$rs)
        $this->observar("error","Lista de dimensiones - [error] " . $db["instancia"][apex_db_con]->ErrorMsg()." - [sql]". $sql ,false,true,true);
    if(!$rs->EOF){
    while(!$rs->EOF)
    {
        $grupo = $rs->fields[$modo];
?>
    <tr>
     <td colspan='3'>

        <table class='tabla-0'>
        <tr>
          <td width="2%" class='cat-item-categ1'>
            <a href="<? echo $this->vinculador->generar_solicitud("toba",$editor,array( apex_hilo_qs_zona => $rs->fields[$modo.'_proyecto'] .apex_qs_separador. $rs->fields[$modo])) ?>" target="<? echo  apex_frame_centro ?>">
                <? echo recurso::imagen_apl("usuarios/$editor_img.gif",true,null,null,"Modificar $editor_tip") ?>
            </a>
      </td>
          <td align="center" class="cat-item-categ1"><? echo $rs->fields["corte_descripcion"] ?></td>
         <td width="2%"  class='cat-item-categ1'>
            <a href="<? echo $this->vinculador->generar_solicitud("toba","/admin/usuarios/propiedades",array($modo=>$rs->fields[$modo])) ?>" target="<? echo  apex_frame_centro ?>" class="list-obj">
            <? echo recurso::imagen_apl("usuarios/usuario_nuevo.gif",true,null,null,"Crear Usuario") ?>
            </a>
        </td>
        </tr>
        </table>

    </td>
<?
        while((!$rs->EOF) && ($rs->fields[$modo]==$grupo))
        {
            if(trim($rs->fields["usuario"])!=""){
?>
        <tr>
          <td width="2%" class='lista-obj-botones'>
            <a href="<? echo $this->vinculador->generar_solicitud("toba","/admin/usuarios/propiedades",array(apex_hilo_qs_zona => $rs->fields["usuario"])) ?>" target="<? echo  apex_frame_centro ?>">
                <img src="<? echo recurso::imagen_apl("usuarios/usuario.gif") ?>" alt="Modificar USUARIO" border="0">
            </a>
      </td>
<?
    if( $rs->fields["usuario"] == $this->hilo->obtener_usuario() ){
?>
          <td width="30%" class='lista-obj-dato4'>&nbsp;<b><? echo $rs->fields["usuario"] ?></b></td>
          <td width="70%" class='lista-obj-dato4'>&nbsp;<b><? echo $rs->fields["usuario_nombre"] ?></b></td>
<?
    }else{
?>
          <td width="30%" class='lista-obj-dato1'>&nbsp;<? echo $rs->fields["usuario"] ?></td>
          <td width="70%" class='lista-obj-dato1'>&nbsp;<? echo $rs->fields["usuario_nombre"] ?></td>
<?
    }
?>
        </tr>
<?
            }
            $rs->movenext();
        }
    }
?>
</table>
<?}
//*******************************************************************************************
//***************************  Usuarios no asociados al proyecto  ***************************
//*******************************************************************************************
?>
<table width="100%"  class='cat-item'>
<tr>
     <td width="98%" class="lista-obj-titulo" >Usuarios externos al PROYECTO</td>
</tr>
</table>
<script language='javascript'>
    editor='usuario';
</script>
<table width="100%" class='lista-obj'>
<?
    global $ADODB_FETCH_MODE;
    $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
    $sql = "
SELECT  u.usuario,
        u.nombre
FROM        apex_usuario u
WHERE       NOT EXISTS (
                        SELECT 1 FROM apex_usuario_proyecto p
                        WHERE p.usuario = u.usuario
                        AND p.proyecto = '".$this->hilo->obtener_proyecto()."' )
            ORDER BY 2";
    //dump_sql($sql);
    $rs =& $db["instancia"][apex_db_con]->Execute($sql);
    if(!$rs)
        $this->observar("error","Lista de USUARIOS - [error] " . $db["instancia"][apex_db_con]->ErrorMsg()." - [sql]". $sql ,false,true,true);
    if(!$rs->EOF){
    while(!$rs->EOF)
    {
?>
        <tr>
          <td width="2%" class='lista-obj-botones'>
            <a href="<? echo $this->vinculador->generar_solicitud("toba","/admin/usuarios/propiedades",array(apex_hilo_qs_zona => $rs->fields['usuario'])) ?>" target="<? echo  apex_frame_centro ?>">
                <? echo recurso::imagen_apl("usuarios/usuario.gif",true,null,null,"Modificar USUARIO") ?>
            </a>
      </td>
          <td width="30%" class='lista-obj-dato1'>&nbsp;<? echo $rs->fields["usuario"] ?></td>
          <td width="70%" class='lista-obj-dato1'>&nbsp;<? echo $rs->fields["nombre"] ?></td></tr>
<?
    $rs->movenext();
    }
    }else{
?>
        <tr>
            <td width="2%" class='lista-obj-dato1'>&nbsp;&nbsp;No existen usuarios NO asociados!</td>
        </tr>
<?
    }
?>
</table>
