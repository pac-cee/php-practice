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
			$offset = $this->ReadULong();
			$length = $this->ReadULong();
			$this->tables[$tag] = array('offset'=>$offset, 'length'=>$length, 'checkSum'=>$checkSum);
		}
	}	

	function ParseHead()
	{
		$this->Seek('head');
		$this->Skip(3*4); // version, fontRevision, checkSumAdjustment
		$magicNumber = $this->ReadULong();
		if($magicNumber!=0x5F0F3CF5)
			$this->Error('Incorrect magic number');
		$this->Skip(2); // flags
		$this->unitsPerEm = $this->ReadUShort();
		$this->Skip(2*8); // created, modified
		$this->xMin = $this->ReadShort();
		$this->yMin = $this->ReadShort();
		$this->xMax = $this->ReadShort();
		$this->yMax = $this->ReadShort();
		$this->Skip(3*2); // macStyle, lowestRecPPEM, fontDirectionHint
		$this->indexToLocFormat = $this->ReadShort();
	}

	function ParseHhea()
	{
		$this->Seek('hhea');
		$this->Skip(4+15*2);
		$this->numberOfHMetrics = $this->ReadUShort();
	}

	function ParseMaxp()
	{
		$this->Seek('maxp');
		$this->Skip(4);
		$this->numGlyphs = $this->ReadUShort();
	}

	function ParseHmtx()
	{
		$this->Seek('hmtx');
		$this->glyphs = array();
		for($i=0;$i<$this->numberOfHMetrics;$i++)
		{
			$advanceWidth = $this->ReadUShort();
			$lsb = $this->ReadShort();
			$this->glyphs[$i] = array('w'=>$advanceWidth, 'lsb'=>$lsb);
		}
		for($i=$this->numberOfHMetrics;$i<$this->numGlyphs;$i++)
		{
			$lsb = $this->ReadShort();
			$this->glyphs[$i] = array('w'=>$advanceWidth, 'lsb'=>$lsb);
		}
	}

	function ParseLoca()
	{
