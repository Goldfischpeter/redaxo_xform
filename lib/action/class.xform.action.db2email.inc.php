<?php

/**
 * XForm
 *
 * @author jan.kristinus[at]redaxo[dot]de Jan Kristinus
 * @author <a href="http://www.yakamara.de">www.yakamara.de</a>
 *
 * @package redaxo4
 * @version svn:$Id$
 */

class rex_xform_action_db2email extends rex_xform_action_abstract
{
  
  function execute()
  {

    global $REX;

    $template_name = $this->getElement(2);

    if($etpl = rex_xform_emailtemplate::getTemplate($template_name))
    {

      // ----- find mailto
      $mail_to = $REX['ERROR_EMAIL']; // default

      // finde email label in list
      if ($this->getElement(3) != FALSE && $this->getElement(3) != "")
      {
        foreach($this->params["value_pool"]["email"] as $key => $value)
          if ($this->getElement(3)==$key)
          {
            $mail_to = $value;
            break;
          }
      }
      
      // ---- fix mailto from definition
      if ($this->getElement(4) != FALSE && $this->getElement(4) != "")
        $mail_to = $this->getElement(4);
    
      $etpl = rex_xform_emailtemplate::replaceVars($etpl,$this->params["value_pool"]["email"]);
    
      $etpl['mail_to'] = $mail_to;
      $etpl['mail_to_name'] = $mail_to;
      
      if($etpl['attachments'] != "")
      {
        $f = explode(",",$etpl['attachments']);
        $etpl['attachments'] = array();
        foreach($f as $v)
        {
          $etpl['attachments'][] = array("name"=>$v,"path"=>$REX["INCLUDE_PATH"].'/../../files/'.$v);
        }
        
      }else
      {
        $etpl['attachments'] = array();
      }
      
      if ($this->params["debug"])
      {			
        echo "<hr /><pre>"; var_dump($etpl); echo "</pre><hr />"; 
      }
      
      if(!rex_xform_emailtemplate::sendMail($etpl))
      {
        echo "Fehler beim E-Mail Versand";
        return FALSE;
      }

      return TRUE;
    
    }

    return FALSE;

  }

  function getDescription()
  {

    return "action|db2email|emailtemplate|emaillabel|[email@domain.de]";

  }

}
