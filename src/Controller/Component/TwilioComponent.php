<?php 

App::import('Vendor','Twilio',array('file'=>'twilio/twilio.php'));


class TwilioComponent extends Component
{
    var $controller;
 		// Twilio REST API version 
	var	$ApiVersion = "";
	var	$client = '';
	var	$AccountSid = '';
	var	$AuthToken = '';
	
	function __construct(){
		$this->getObject();
	}
    function startup(Controller$controller ) {
        $this->controller = $controller;
	
    }	
	
	
	function getObject(){		

			// Set our AccountSid and AuthToken 

			$this->AccountSid = $this->AccountSid;
            $this->AuthToken   = $this->AccountToken;

			$this->ApiVersion = "2010-04-01";

			// Instantiate a new Twilio Rest Client 

			$this->client = new TwilioRestClient($this->AccountSid, $this->AuthToken);

	}

	function sendsms($to,$from,$body){
		$this->getObject();
		$vars['From']=$from;
		$vars['To']=$to;
		$vars['Body']=$body;	
				
		$response =  $this->client->request("/".$this->ApiVersion."/Accounts/".$this->AccountSid."/SMS/Messages", "POST",$vars);
				
		if(isset($response->HttpStatus) && ($response->HttpStatus == 200)) {
			$result['status'] = 1;		
		}else if(isset($response->IsError) && ($response->IsError == 1)) {
			$result['status'] = 0;				
			$result['message'] = $response->ErrorMessage;				
		}else{
			$result['status'] = 1;	
		}	
		
	   return $result;
	}
	
	
	
	function listNumbers($type,$code){
	
	
	$this->getObject();	
	
	//if($type == 'areacode'){
	
	$SearchParams1['AreaCode'] = $code;
	
	//}else if($type == 'zip'){
	
	//$SearchParams1['InPostalCode'] = $code;
	
	//}	
	
	        $country = "US";
		/* 
			if($SearchParams1['AreaCode']=='' && $country!='' && $SearchParams1['InPostalCode']!=''){
			
			$SearchParams['InPostalCode'] = $code;
		
			$response = $this->client->request("/".$this->ApiVersion."/Accounts/".$this->AccountSid."/AvailablePhoneNumbers/".$country,
						 "GET", 
						  $SearchParams);
						  
						  return $response;
						
						  
			}else */ 
			
			if($SearchParams1['AreaCode']!='' && $country!=''){
			
			$SearchParams['AreaCode'] = $code;
							
			$response = $this->client->request("/".$this->ApiVersion."/Accounts/".$this->AccountSid."/AvailablePhoneNumbers/".$country."/Local",
						 "GET",$SearchParams);
				 return $response;					
			}
	  }
	  
	  function assignthisnumber($numbertoassign,$siteurl){
	$this->getObject();
		$PhoneNumber = $numbertoassign;	
					
			$vars['PhoneNumber']=$PhoneNumber;	
			$vars['VoiceUrl']=$url.'twilios/incomingcall';
            $vars['SmsUrl']= $url.'twilios/incomingsms'; 

		/* Purchase the selected PhoneNumber */
		$response = $this->client->request("/".$this->ApiVersion."/Accounts/".$this->AccountSid."/IncomingPhoneNumbers",
									"POST", 
									$vars);
		
		if($response->IsError) {
			//echo "Error purchasing number: $response->ErrorMessage";
			return;
		}
	
	}
	
	function buythenumber($type,$areacode,$url){
		
		$this->getObject();
		
			//if($type == 'zip'){
			
			//$vars['InPostalCode']=$zip; 
			
			//}else if($type == 'areacode'){	
			
			$vars['AreaCode']=$areacode;  
			
			//}
     

            $vars['VoiceUrl']=$url.'twilios/incomingcall';

            $vars['SmsUrl']= $url.'twilios/incomingsms'; 
		
		
		/* Purchase the selected PhoneNumber */

			$response = $this->client->request("/".$this->ApiVersion."/Accounts/".$this->AccountSid."/IncomingPhoneNumbers","POST",$vars);

      
            $arrReturn['PhoneNumber']=    $response->ResponseXml->IncomingPhoneNumber->PhoneNumber;

            $arrReturn['Sid']		=     $response->ResponseXml->IncomingPhoneNumber->Sid;

            return $arrReturn;
      

    }
	
	}
?>