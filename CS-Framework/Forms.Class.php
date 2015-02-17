<?php

namespace CSF\Modules;

/**
 * Forms Class - Club Systems Framework
 * Do NOT modify
 *
 * Usage: This class relies on Static Method calls:
 * 		  		ie. $obj::MethodName($params);
 * 		  You must choose to use either an id attribute OR the name attribute.
 * 		  
 * 		  echo $obj::CSFormStart($params);
 * 		  echo $obj::CSInput($inputParam);
 * 		  echo $obj::CSSubmit();
 * 		  echo $obj::CSFormEnd();
 * 
 * Copyright Club Systems 2015
 * @author Joseph Kasavage
 */

class Forms
{
	/**
	 * Create FORM tag and add Attributes
	 * Usage: $formAttributes = array(
	 * 		  	"name"=>"addMember",
	 * 		   	"method"=>"POST",
	 * 		   	"action"=>"anotherPage.php",
	 * 		   	"target"=>"_blank"
	 *   	  );
	 *   	  
	 *   	  $obj::CSFormStart($formAttributes);
	 *
	 * 		  Allowed Parameters: name (String),
	 * 		  					  id (String)
	 * 		  					  method (String),
	 * 		  					  action (String),
	 * 		  					  target (String)
	 *
	 * @param Array $form
	 * 
	 * @return String
	 */
	public static function CSFormStart(Array $form)
	{
		$formStart = '<form ';

		if(isset($form["name"])) {
			$formStart .= 'name="' . $form["name"] . '" method="' . $form["method"] . '" action="' . $form["action"] . '" ';
		} else if(isset($form["id"])) {
			$formStart .= 'id="' . $form["id"] . '" method="' . $form["method"] . '" action="' . $form["action"] . '" ';
		}

		if(isset($form["target"])) {
			$formStart .= 'target="' . $form["target"] . '">';
		} else {
			$formStart .= '>';
		}

		return $formStart;
	}

	/**
	 * Create an Input Box with Parameters
	 *
	 * Usage: The only parameter that MUST be passed is the type.
	 *
	 * 		  
	 * 		  $inputParam = array(
	 * 			"type"=>"text",
	 * 			"name"=>"email", // Use either name OR id
	 * 			"maxlength"=>"30",
	 * 			"size"=>"25",
	 * 			"class"=>"magic",
	 * 			"events"=>array(
	 * 					  	"onClick"=>"javascript: functionName();"
	 * 					  	"onBlur"=>"javascript: validate();"
	 * 			          ),
	 * 			"value"=>"yourmail@email.com",
	 * 			"label"=>"E-mail Address"
	 * 		  );
	 *
	 * 	      echo $obj::CSInput($inputParam);
	 *
	 * 		  Allowed Parameters: id (String),
	 * 		     				  name (String),
	 * 		     				  type (String),
	 * 		     				  maxlength (String),
	 * 		     				  size (String),
	 * 		     				  class (String),
	 * 		     				  events (Array),
	 * 		     				  value (String),
	 * 		     				  label (String)
	 * 
	 * @param Array $param 
	 *
	 * @return String
	 */
	public static function CSInput(Array $param)
	{
		$input = '<input type="' . $param["type"] . '" ';

		if(isset($param["name"])) {
			$input .= 'name="' . $param["name"] . '" ';
		} else {
			$input .= 'id="' . $param["id"] . '" ';
		}

		if(isset($param["maxlength"])) {
			$input .= 'maxlength="' . $param["maxlength"] . '" ';
		}

		if(isset($param["size"])) {
			$input .= 'size="' . $param["size"] . '" ';
		}

		if(isset($param["class"])) {
			$input .= 'class="' . $param["class"] . '" ';
		}

		if(isset($param["events"])) {
			foreach($param["events"] as $key=>$value) {
				$input .= $key . '="' . $value . '" ';
			}
		}

		if(isset($param["value"])) {
			$input .= 'value="' . $param["value"] . '" />';
		} else {
			$input .= ' />';
		}

		return '<label style="font-weight: bold;">' . $param["label"] . '</label><br />' . $input;
	}

	/**
	 * Create a Select box with Values and/or Parameters
	 *
	 * Usage: $selectParam = array(
	 * 						 	"id"=>"selectIntegers",
	 * 						 	"size"=>"1",
	 * 						 	"events"=>array(
	 * 						 			  	"onClick"=>"javascript: aFunc();",
	 * 						 			  	"onChange"=>"javascript: alert('Welcome!');"
	 * 						 			  );
	 * 						 	"options"=>array(
	 * 						 				 "option1ID", "Option 1 Value!",
	 * 						 				 "option2ID", "Option 2 Value!"
	 * 						 			   );
	 *                       );
	 *
	 * 		 echo $obj::CSSelect($selectParam);
	 *
	 * 		 Allowed Parameters: label (String),
	 * 		 					 id (String),
	 * 		 					 name (String),
	 * 		 					 size (String),
	 * 		 					 events (Array),
	 * 		 					 class (String),
	 * 		 					 multiple (Boolean),
	 * 		 					 disabled (Boolean),
	 * 		 					 options (Array),
	 * 		 					 label (String)
	 * 
	 * @param Array $param
	 *
	 * @return String
	 */
	public static function CSSelect(Array $param)
	{
		$select = '<select ';

		if(isset($param["id"])) {
			$select .= 'id="' . $param["id"] . '" ';
		} else if(isset($param["name"])) {
			$select .= 'name="' . $param["name"] . '" ';
		}

		if(isset($param["size"])) {
			$select .= 'size="' . $param["size"] . '" ';
		}

		if(isset($param["class"])) {
			$select .= 'class="' . $param["class"] . '"';
		}

		if(isset($param["events"])) {
			foreach($param["events"] as $key=>$value) {
				$select .= $key . '="' . $value . '" ';
			}
		}

		if(isset($param["multiple"])) {
			$select .= 'multiple ';
		}

		if(isset($param["disabled"])) {
			$select .= 'disabled ';
		}

		$select .= '>';

		if(isset($param["options"])) {
			foreach($param["options"] as $key=>$value) {
				$select .= '<option id="' . $key . '">' . $value . '</option>';
			}
		}

		$select .= '</select>';

		return '<label style="font-weight: bold;">' . $param["label"] . '</label><br />' . $select;
	}

	/**
	 * Create a Checkbox with a Name or ID
	 *
	 * Usage: $checkboxParam = array(
	 * 						   	 "id"=>"thisCheckbox",
	 * 						   	 "checked"=>true
	 * 						   );
	 *
	 * 		  echo $obj::CSCheckbox($checkboxParam);
	 *
	 * 		  Allowed Parameters: label (String),
	 * 		  					  id (String),
	 * 		                      name (String),
	 * 		                      class (String),
	 * 		                      events (String),
	 * 		                      checked (Boolean),
	 * 		                      disabled (Boolean),
	 * 		                      label (String)
	 * 
	 * @param Array $param
	 *
	 * @return String
	 */
	public static function CSCheckbox(Array $param)
	{
		$checkbox = '<input type="checkbox" ';

		if(isset($param["id"])) {
			$checkbox .= 'id="' . $param["id"] . '"" ';
		} else if(isset($param["name"])) {
			$checkbox .= 'name="' . $param["name"] . '"" '; 
		}

		if(isset($param["class"])) {
			$checkbox .= 'class="' . $param["class"] . '" ';
		}

		if(isset($param["events"])) {
			foreach($param["events"] as $key=>$value) {
				$checkbox .= $key . '="' . $value . '" ';
			}
		}

		if(!empty($param["checked"])) {
			$checkbox .= 'checked ';
		}

		if(!empty($param["disabled"])) {
			$checkbox .= 'disabled />';
		} else {
			$checkbox .= '/>';
		}

		return $checkbox . '<br />' . '<label style="font-weight: bold;">' . $param["label"] . '</label>';
	}

	/**
	 * Create a Radio Button with Parameters
	 *
	 * Usage: $radioParam = array(
	 * 							"id"=>"gender",
	 * 							"value"=>"male",
	 * 							"label"=>"Male"
	 * 						);
	 *
	 * 		  echo $obj::CSRadio($radioParam);
	 *
	 * 		  Allowed Parameters: id (String),
	 * 		  					  name (String),
	 * 		  					  class (String),
	 * 		  					  events (String),
	 * 		  					  value (String),
	 * 		  					  checked (Boolean),
	 * 		  					  label (String)
	 * 
	 * @param Array $param
	 *
	 * @return String
	 */
	public static function CSRadio(Array $param)
	{
		$radio = '<input type="radio" ';

		if(isset($param["id"])) {
			$radio .= 'id="' . $param["id"] . '" ';
		} else if(isset($param["name"])) {
			$radio .= 'name="' . $param["name"] . '" ';
		}

		if(isset($param["events"])) {
			foreach($param["events"] as $key=>$value) {
				$radio .= $key . '="' . $value . '" ';
			}
		}

		if(isset($param["class"])) {
			$radio .= 'class="' . $param["class"] . '" ';
		}

		if(isset($param["value"])) {
			$radio .= 'value="' . $param["value"] . '" ';
		}

		if(!empty($param["checked"])) {
			$radio .= 'checked />';
		} else {
			$radio .= '/>';
		}

		return $radio . '<br />' . '<label style="font-weight: bold;">' . $param["label"] . '</label>';
	}

	/**
	 * Create a Textarea Box with Parameters
	 *
	 * Usage: $textboxParam = array(
	 * 							"id"=>"textarea1",
	 * 							"value"=>"Value!",
	 * 							"label"=>"Textarea: "
	 * 						);
	 *
	 * 		  echo $obj::CSTextArea($textboxParam);
	 *
	 * 		  Allowed Parameters: id (String),
	 * 		  					  name (String),
	 * 		  					  class (String),
	 * 		  					  events (String),
	 * 		  					  value (String),
	 * 		  					  columns (Integer),
	 * 		  					  rows (Integer),
	 * 		  					  label (String)
	 * 
	 * @param Array $param
	 *
	 * @return String
	 */
	public static function CSTextarea(Array $param)
	{
		$textbox = '<textarea ';

		if(isset($param["id"])) {
			$textbox .= 'id="' . $param["id"] . '" ';
		} else if(isset($param["name"])) {
			$textbox .= 'name="' . $param["name"] . '" ';
		}

		if(isset($param["class"])) {
			$textbox .= 'class="' . $param["class"] . '" ';
		}

		if(isset($param["events"])) {
			foreach($param["events"] as $key=>$value) {
				$textbox .= $key . '="' . $value . '" ';
			}
		}

		if(isset($param["column"])) {
			$textbox .= 'cols="' . $param["columns"] . '" ';
		}

		if(isset($param["rows"])) {
			$textbox .= 'rows="' . $param["rows"] . '" ';
		}

		if(isset($param["value"])) {
			$textbox .= '>' . $param["value"] . '</textarea>';
		} else {
			$textbox .= '></textarea>';
		}

		return '<label style="font-weight: bold;">' . $param["label"] . '</label><br /> ' . $textbox;
	}

	/**
	 * Create a Submit Button with Parameters
	 *
	 * Usage: $submitParam = array(
	 * 							"id"=>"next",
	 * 							"value"=>"Submit!",
	 * 							"class"=>"btn btn-default submit"
	 * 						);
	 *
	 * 		  echo $obj::CSButtonSubmit($submitParam);
	 *
	 * 		  Allowed Parameters: id (String),
	 * 		  					  name (String),
	 * 		  					  class (String),
	 * 		  					  events (String),
	 * 		  					  value (String)
	 * 
	 * @param Array $param
	 *
	 * @return String
	 */
	public static function CSButtonSubmit(Array $param)
	{
		$submit = '<input type="submit" ';

		if(isset($param["id"])) {
			$submit .= 'id="' . $param["id"] . '" ';
		} else if(isset($param["name"])) {
			$submit .= 'name="' . $param["name"] .  '"';
		}

		if(isset($param["class"])) {
			$submit .= 'class="' . $param["class"] . '" ';
		}

		if(isset($param["events"])) {
			foreach($param["events"] as $key=>$value) {
				$submit .= $key . '="' . $value . '" ';
			}
		}

		$submit .= 'value="' . $param["value"] . '" />';

		return $submit;
	}

	/**
	 * Create Form end Tag
	 *
	 * Usage: $obj->CSFormEnd();
	 *
	 * @return String
	 */
	public static function CSFormEnd()
	{
		return '</form>';
	}
}