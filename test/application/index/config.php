<?php
//配置文件
use \think\Request;

$basename = Request::instance()->root();
if (pathinfo($basename, PATHINFO_EXTENSION) == 'php') {
    $basename = dirname($basename);
}
return [

'view_replace_str'      => [

	'__ROOT__'   		=> $basename,
    '__assets__'        => $basename . '/assets',
    '__image__'        => $basename . '/assets/images',
    '__style__'         => $basename . '/assets/css',
    '__script__'        => $basename . '/assets/js',
    '__fonts__'         => $basename . '/assets/fonts'
    ],

];