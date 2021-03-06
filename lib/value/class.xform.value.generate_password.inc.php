<?php

class rex_xform_value_generate_password extends rex_xform_value_abstract
{

	function enterObject()
	{
		$this->setValue(substr(md5(microtime().rand(1000)), 0, 10));
		
		$this->params["value_pool"]["email"][$this->getElement(1)] = stripslashes($this->getValue());
		if ($this->getElement(2) != "no_db") $this->params["value_pool"]["sql"][$this->getElement(1)] = $this->getValue();
	}
	
	function getDescription()
	{
		return "generate_passwort -> Beispiel: generate_password|label|[no_db]";
	}
}

?>