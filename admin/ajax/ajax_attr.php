<?php
	include ("ajax_config.php");

	@$id = $func->decode($_POST["id"]);
	@$tbl = $func->decode($_POST["tbl"]);
	@$attr = $func->decode($_POST["attr"]);
	@$value = $func->decode($_POST["value"]);
	@$action = $func->decode($_POST["action"]);

	if($id)
	{
		if($action == 'status')
		{
			$status = $d->rawQueryOne("select status from #_$tbl where id=?", array($id));
			$array = !empty($status['status']) ? explode(',', $status['status']) : array();

			if(array_search($attr, $array) !== false)
			{
				$key = array_search($attr, $array);
				unset($array[$key]);
			}
			else
			{
				array_push($array, $attr);
			}
			$status_result = implode(',', $array);
			@$data['status'] = $status_result;
		}
		else
		{
			@$data[$attr] = $value;
		}		
		$d->where('id', $id);
		if($d->update($tbl, $data)) echo "success";
		else echo "failed";	
	}
?>