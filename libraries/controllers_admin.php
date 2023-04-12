<?php
    @$com = $func->decode($_GET['com']);
    @$act = $func->decode($_GET['act']);
    @$setting = $d->rawQueryOne("select * from #_setting");
    if(file_exists(SOURCE.$com.'.php')) include SOURCE.$com.".php";
    $source = $com;
    $template = ($com != "") ? RouteAD::template() : 'index';
    $error_404 = (($com && !$source) || @$error_404) ? true : false;

    if($template == 'index') $case = '';
    $arr_actionCache = array('add'.$case,'edit'.$case,'save'.$case,'delete'.$case,'copy'.$case,'save_copy'.$case,'info',);
    if(isset($_POST) && !empty($arr_actionCache)) 
    {
        if(in_array($act, $arr_actionCache) || ($com=='setting' && $act =='man'))
        {
            $cacheFile->clearCache();
        }
    }
?>