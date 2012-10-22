<?php

/**
 * 界面支持：产品展示
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package UserInterface
 * @name igos.ui.php
 * @version 1.0
 */

class iGOSUI
{

	public function load($product,$flag)
	{
		$style = ini('ui.igos.style');
		$style || $style = 'default';
		if ($style == 'm1selse' && get('page', 'int') > 1)
		{
			$style = 'meituan';
		}
		//如果是秒杀分类，这使用秒杀的模板
		if($flag=='miaosha_jinrimiaosha')$style='miaosha';

		include handler('template')->file('@html/igos/'.$style.'/index');
	}
}

?>