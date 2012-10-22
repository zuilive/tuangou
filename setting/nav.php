<?php 
 /*********************************************
 *[tttuangou] (C)2005 - 2010 Cenwor Inc.
 *
 * tttuangou nav配置
 *
 * @author www.tttuangou.net
 *
 * @time 2012-09-07 10:58
 *********************************************/
 
  
$config['nav']=array (
  0 => 
  array (
    'order' => '1',
    'name' => '限时秒杀',
    'url' => '?mod=catalog&code=miaosha_jinrimiaosha',
    'title' => '今日秒杀',
    'target' => '_self',
  ),
  1 => 
  array (
    'order' => '2',
    'name' => '今日团购',
    'url' => '',
    'title' => '查看本期团购',
    'target' => '_self',
  ),
  2 => 
  array (
    'order' => '3',
    'name' => '往期热点',
    'url' => '?mod=list&code=deals',
    'title' => '',
    'target' => '_self',
  ),
  3 => 
  array (
    'order' => '4',
    'name' => '常见问题',
    'url' => '?mod=html&code=faq',
    'title' => '有问题了，先来这里看看吧',
    'target' => '_self',
  ),
);
?>