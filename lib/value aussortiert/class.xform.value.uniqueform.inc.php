<?php

class rex_xform_value_uniqueform extends rex_xform_abstract
{

	function enterObject()
	{	
	
		$table = $this->getElement(2);
	
		if (!$this->params["send"])
		{
			$this->setValue(md5($_SERVER["REMOTE_ADDR"].time()));

		}else
		{
			$sql = 'select '.$this->getName().' from '.$table.' WHERE '.$this->getName().'="'.$this->getValue().'" LIMIT 1';
			$cd = rex_sql::factory();
			if ($this->params["debug"]) $cd->debugsql = true;
			$cd->setQuery($sql);
			if ($cd->getRows()==1)
			{
				$this->params["warning"][] = $this->getElement(3);
				$this->params["warning_messages"][] = $this->getElement(3);
			}
	
		}
	
		$this->params["form_output"][$this->getId()] = '<input type="hidden" name="FORM['.$this->params["form_name"].'][el_'.$this->getId().']" value="'.htmlspecialchars(stripslashes($this->getValue())).'" />';
		$this->params["value_pool"]["email"][$this->getName()] = stripslashes($this->getValue());
		$this->params["value_pool"]["sql"][$this->getName()] = stripslashes($this->getValue());
	
		return;
	
	}
	
	function getDescription()
	{
		return "uniqueform -> Beispiel: uniqueform|label|table|Fehlermeldung";
	}
}

?>