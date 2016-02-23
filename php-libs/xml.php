<?php
	function writeCandidate($c_id, $c_name, $c_img, $xml){
		$xml->startElement('candidate');
		$xml->writeAttribute('id',$c_id);
		$xml->writeElement('name',$c_name);
		$xml->startElement('picture');
		$xml->writeAttribute('src',$c_img);
		$xml->endElement();
		$xml->endElement();
	}
	function startPoll($ballotid, $xml){
		$xml->startElement('poll');
		$xml->writeAttribute('id',$ballotid);
	}
	function endPoll($xml){
		$xml->endElement();
	}
	
	function startPool($presidential, $xml){
		$xml->startElement('pool');
		$xml->writeAttribute('id',$presidential);
	}
	function endPool($xml){
		$xml->endElement();
	}
?>