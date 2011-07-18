<?php

class rex_xform_datestamp extends rex_xform_abstract
{

	function enterObject()
	{
		$format = "Y-m-d";
		if ($this->getElement(2) != "")
		{
			$format = $this->getElement(2);
		}
  
		 // 0 = immer setzen, 1 = nur wenn leer / create
		if($this->getElement(4) != 1) {
			$set = 0;
		}else {
		  $set = 1;
		}

		if($this->getValue() == "" || $set == 0)
		{
			$this->setValue(date($format));
		}

		$this->params["form_output"][$this->getId()] = '
	      <p class="formhidden '.$this->getHTMLClass().'" style="display:hidden;" id="'.$this->getHTMLId().'">
	        <input type="hidden" name="'.$this->getFieldName().'" id="'.$this->getFieldId().'" value="'.htmlspecialchars(stripslashes($this->getValue())).'" />
	      </p>';

		$this->params["value_pool"]["email"][$this->getName()] = $this->getValue();
		if (!($this->getElement(3) == "no_db"))
		{
			$this->params["value_pool"]["sql"][$this->getName()] = $this->getValue();
		}
	}

	function getDescription()
	{
		return "datestamp -> Beispiel: datestamp|label|[Y-m-d]|[no_db]|[0-wird immer neu gesetzt,1-nur wenn leer]";
	}

	function getDefinitions()
	{

		return array(
            'type' => 'value',
            'name' => 'datestamp',
            'values' => array(
				array( 'type' => 'name',   'label' => 'Name' ),
				array( 'type' => 'text',    'label' => 'Format [YmdHis]'),
				array( 'type' => 'no_db',   'label' => 'Datenbank',  'default' => 1),
				array( 'type' => 'select',  'label' => 'Wann soll Wert gesetzt werden', 'default' => '0', 'definition' => 'immer=0;nur wenn leer=1' ),
				),
            'description' => 'Ein Selectfeld mit festen Definitionen.',
            'dbtype' => 'varchar(255)'
            );


	}


}