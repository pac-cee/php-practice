<?php
/*******************************************************************************
* Utility to generate font definition files                                    *
*                                                                              *
* Version: 1.31                                                                *
* Date:    2019-12-07                                                          *
* Author:  Olivier PLATHEY                                                     *
*******************************************************************************/

require('ttfparser.php');

function Message($txt, $severity='')
{
	if(PHP_SAPI=='cli')
	{
		if($severity)
			echo "$severity: ";
		echo "$txt\n";
	}
	else
	{
		if($severity)
			echo "<b>$severity</b>: ";
		echo "$txt<br>";
	}
}

function Notice($txt)
{
	Message($txt, 'Notice');
}

function Warning($txt)
{
	Message($txt, 'Warning');
}

function Error($txt)
{
	Message($txt, 'Error');
	exit;
}

function LoadMap($enc)
{
	$file = dirname(__FILE__).'/'.strtolower($enc).'.map';
	$a = file($file);
	if(empty($a))
		Error('Encoding not found: '.$enc);
	$map = array_fill(0, 256, array('uv'=>-1, 'name'=>'.notdef'));
	foreach($a as $line)
	{
		$e = explode(' ', rtrim($line));
		$c = hexdec(substr($e[0],1));
		$uv = hexdec(substr($e[1],2));
		$name = $e[2];
		$map[$c] = array('uv'=>$uv, 'name'=>$name);
	}
	return $map;
}

function GetInfoFromTrueType($file, $embed, $subset, $map)
{
	// Return information from a TrueType font
	try
	{
		$ttf = new TTFParser($file);
		$ttf->Parse();
	}
	catch(Exception $e)
	{
		Error($e->getMessage());
	}
	if($embed)
	{
		if(!$ttf->embeddable)
			Error('Font license does not allow embedding');
		if($subset)
		{
			$chars = array();
			foreach($map as $v)
			{
				if($v['name']!='.notdef')
					$chars[] = $v['uv'];
			}
			$ttf->Subset($chars);
			$info['Data'] = $ttf->Build();
		}
		else
			$info['Data'] = file_get_contents($file);
		$info['OriginalSize'] = strlen($info['Data']);
	}
	$k = 1000/$ttf->unitsPerEm;
	$info['FontName'] = $ttf->postScriptName;
	$info['Bold'] = $ttf->bold;
