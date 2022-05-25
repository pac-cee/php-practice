<?php
/*******************************************************************************
* Class to parse and subset TrueType fonts                                     *
*                                                                              *
* Version: 1.11                                                                *
* Date:    2021-04-18                                                          *
* Author:  Olivier PLATHEY                                                     *
*******************************************************************************/

class TTFParser
{
	protected $f;
	protected $tables;
	protected $numberOfHMetrics;
	protected $numGlyphs;
	protected $glyphNames;
	protected $indexToLocFormat;
	protected $subsettedChars;
	protected $subsettedGlyphs;
	public $chars;
	public $glyphs;
	public $unitsPerEm;
	public $xMin, $yMin, $xMax, $yMax;
	public $postScriptName;
	public $embeddable;
	public $bold;
	public $typoAscender;
	public $typoDescender;
	public $capHeight;
	public $italicAngle;
	public $underlinePosition;
	public $underlineThickness;
	public $isFixedPitch;

	function __construct($file)
	{
		$this->f = fopen($file, 'rb');
		if(!$this->f)
			$this->Error('Can\'t open file: '.$file);
	}

	function __destruct()
	{
		if(is_resource($this->f))
			fclose($this->f);
	}

	function Parse()
	{
		$this->ParseOffsetTable();
		$this->ParseHead();
		$this->ParseHhea();
		$this->ParseMaxp();
		$this->ParseHmtx();
		$this->ParseLoca();
		$this->ParseGlyf();
		$this->ParseCmap();
		$this->ParseName();
		$this->ParseOS2();
		$this->ParsePost();
	}

	function ParseOffsetTable()
	{
		$version = $this->Read(4);
		if($version=='OTTO')
			$this->Error('OpenType fonts based on PostScript outlines are not supported');
		if($version!="\x00\x01\x00\x00")
			$this->Error('Unrecognized file format');
		$numTables = $this->ReadUShort();
		$this->Skip(3*2); // searchRange, entrySelector, rangeShift
		$this->tables = array();
		for($i=0;$i<$numTables;$i++)
		{
			$tag = $this->Read(4);
			$checkSum = $this->Read(4);
