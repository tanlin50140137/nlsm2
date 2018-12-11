<?php defined('SPOT')?'':exit('Can not be opened, not the only entrance.');
class This_single_case
{
	private function This_single_case(){}
	private function __clone(){}
	public static function getConcetBase()
	{
		static $m = null;
		if($m == null)
		{
			$m = new This_base_concet();
		}
		return $m;
	}
}