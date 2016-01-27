<?php

class MICS_SMS
{
	private $Username;
	private $Password;

	public function MICS_SMS($Username, $Password)
	{
		$this->Username = $Username;
		$this->Password = $Password;
	}
	
	public function SendSMS($MsgSender, $DestinationAddress, $Message)
	{
		// Build URL request for sending SMS.
		$url = "http://msdgweb.mgov.gov.in/esms/sendsmsrequest?username=%s&password=%s&smsservicetype=singlemsg&content=%s&mobileno=%s&senderid=%s";
		$url = sprintf($url, urlencode($this->Username), urlencode($this->Password), urlencode($Message), urlencode($DestinationAddress), urlencode($MsgSender));
		
		// Check if MsgSender is numeric or alphanumeric.
//		if (is_numeric($MsgSender))
//			$url .= "&sourceAddr=" . $MsgSender;
//		else
//			$url .= "&fromAlpha=" . $MsgSender;
			
		// Get response as xml.
		$XMLResponse = $this->GetResponseAsXML($url);
		// Parse XML.
		$Result = $this->ParseXMLResponse($XMLResponse);
		// Return the result object.
		return $Result;
	}
	
	/*
	 * Gets the respone from the given URL, and return the response as xml.
	 * @param string $url
	 * @return object Response as xml
	 */
	private function Response($url)
	{
		var_dump(libxml_use_internal_errors(true));
		// load the document
		$doc = new DOMDocument;
		
		if (!$doc->load($url)) {
			foreach (libxml_get_errors() as $error) {
				// handle errors here
			}
			//return ;
			libxml_clear_errors();		 
		}
	}
	private function GetResponseAsXML($url)
	{		
		try {
			var_dump(libxml_use_internal_errors(true));
			libxml_clear_errors();
			// Download webpage and return response as xml.
			return simplexml_load_file($url);
		} catch (Exception $e) {
			// Failed to connect to server. Throw an exception with a customized message.
			throw new Exception('Error occured while connecting to server: ' . $e->getMessage());
		}
	}
	
	/*
	 * Parses the XML response
	 * @param objec $XMLResponse
	 * @return Result $Result
	 */
	private function ParseXMLResponse($XMLResponse)
	{
		$Result = new Result;
		$Result->ErrorCode = $XMLResponse[0]["errorcode"];
		$Result->ErrorMessage = $XMLResponse[0];
		$Result->Success = ($XMLResponse[0]["errorcode"] == 0);
		
		return $Result;
	}
}


class Result
{
	public $Success;
	public $ErrorCode;
	public $ErrorMessage;
}
	
?>