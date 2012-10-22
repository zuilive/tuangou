<?php

$config["ad"] =  array (
  'howdo' => 
  array (
    'name' => '首页购买帮助',
    'enabled' => false,
    'config' => 
    array (
      'image' => 'templates/html/ad/images/howdo.ad.gif',
      'linker' => 'javascript:;',
      'close_allow' => 'no',
      'auto_hide_time' => '5',
      'auto_hide_allow' => 'on',
      'reshow_delay_time' => '1',
    ),
  ),
  'howdom' => 
  array (
    'name' => '首页多图广告位（购买帮助下方）',
    'enabled' => true,
    'config' => 
    array (
      'list' => 
      array (
        '6j5bok' => 
        array (
          'image' => 'templates/html/ad/images/hm.6j5bok.gif',
          'text' => '',
          'link' => '',
          'target' => '_self',
        ),
      ),
      'dsp' => 
      array (
        'time' => '3',
        'switchPath' => 'left',
        'showText' => 'false',
        'showButtons' => 'true',
      ),
    ),
  ),
);
?>