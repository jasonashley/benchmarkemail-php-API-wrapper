<?php
  /**
  This Example shows how to authenticate a user using XML-RPC.
  Note that we are using the PEAR XML-RPC client and recommend others do as well.
  **/
  require_once 'XML/RPC2/Client.php';
  require_once 'inc/config.php';

  try
  {
    $client = XML_RPC2_Client::create($apiURL);
    $token = $client->login($apiLogin, $apiPassword);

    /**
    Fetch the latest contact list ID, so we can retrieve the target contact list ID.
    **/

    /**
		If you want to create the email for the Segment then use this code:-
		$segmentList=$client->segmentGet($token, "", 1, 100, "");
		$listID=$segmentList[0]['id'];
		$emailDetail['isSegment']=true;
	**/

    $contactList = $client->listGet($token, "", 1, 1, "", "");
    $listID = $contactList[0]['id'];

    $emailDetail['fromEmail'] = 'user1@____.com';
    $emailDetail['fromName'] = 'Steve';
    $emailDetail['emailName'] = 'Sales Promo May 10';
    $emailDetail['replyEmail'] = 'feedback@____.com;
    $emailDetail['subject'] = 'New Products launch at our store';
    $emailDetail['templateContent'] = '<html><body> Hello World </body></html>';
    $emailDetail['toListID'] = intval($listID);
    $emailDetail['scheduleDate'] = '1 May 2010 5:00'; /* In UTC */
    $emailDetail['webpageVersion'] = true;
    $emailDetail['permissionReminderMessage'] = 'You are receiving this email because of your relationship with our company. Unsubscribe is available at the bottom of this email.';
    $newEmailID = $client->emailCreate($token, $emailDetail);
    echo($newEmailID);
  } catch (XML_RPC2_FaultException $e){
    echo "ERROR:" . $e->getFaultString() ."(" . $e->getFaultCode(). ")";
  }
?>