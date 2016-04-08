<?php
   $dbhost = '162.44.168.214';
   $dbuser = 'actionAdmin';
   $dbpass = 'ims';
   
   $conn = mysql_connect($dbhost, $dbuser, $dbpass);
   
   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }
   
   $sql = 'SELECT action_name, action_label, action_group, numeric_value FROM owa_action_fact';
   mysql_select_db('owa');
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   $doc = new DOMDocument('1.0','UTF-8');
   $doc->preserveWhiteSpace = false;
   $doc->formatOutput = true;
   $root = $doc->createElement('actions');
   $root = $doc->appendChild($root);
   while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
	    // add node for each row
		$occ = $doc->createElement('action');
		$occ = $root->appendChild($occ);
		
		$child = $doc->createElement('Name');
        $child = $occ->appendChild($child);
		$value = $doc->createTextNode($row['action_name']);
        $value = $child->appendChild($value);
		
		$child = $doc->createElement('Label');
        $child = $occ->appendChild($child);
		$value = $doc->createTextNode($row['action_label']);
        $value = $child->appendChild($value);
		
		$child = $doc->createElement('Group');
        $child = $occ->appendChild($child);
		$value = $doc->createTextNode($row['action_group']);
        $value = $child->appendChild($value);
		
		$child = $doc->createElement('Value');
        $child = $occ->appendChild($child);
		$value = $doc->createTextNode($row['numeric_value']);
        $value = $child->appendChild($value);		          
   }   
   $fullData = $doc->saveXML();
   //echo $fullData;
   
    $xml = simplexml_load_string($fullData);
	$json = json_encode($xml);
	echo $json;
   mysql_close($conn);
?>