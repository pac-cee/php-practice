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
		$this->Seek('loca');
		$offsets = array();
		if($this->indexToLocFormat==0)
		{
			// Short format
			for($i=0;$i<=$this->numGlyphs;$i++)
				$offsets[] = 2*$this->ReadUShort();
		}
		else
		{
			// Long format
			for($i=0;$i<=$this->numGlyphs;$i++)
				$offsets[] = $this->ReadULong();
		}
		for($i=0;$i<$this->numGlyphs;$i++)
		{
			$this->glyphs[$i]['offset'] = $offsets[$i];
			$this->glyphs[$i]['length'] = $offsets[$i+1] - $offsets[$i];
		}
	}

	function ParseGlyf()
	{
		$tableOffset = $this->tables['glyf']['offset'];
		foreach($this->glyphs as &$glyph)
		{
			if($glyph['length']>0)
			{
				fseek($this->f, $tableOffset+$glyph['offset'], SEEK_SET);
				if($this->ReadShort()<0)
				{
					// Composite glyph
					$this->Skip(4*2); // xMin, yMin, xMax, yMax
					$offset = 5*2;
					$a = array();
					do
					{
						$flags = $this->ReadUShort();
						$index = $this->ReadUShort();
						$a[$offset+2] = $index;
						if($flags & 1) // ARG_1_AND_2_ARE_WORDS
							$skip = 2*2;
						else
							$skip = 2;
						if($flags & 8) // WE_HAVE_A_SCALE
							$skip += 2;
						elseif($flags & 64) // WE_HAVE_AN_X_AND_Y_SCALE
							$skip += 2*2;
						elseif($flags & 128) // WE_HAVE_A_TWO_BY_TWO
							$skip += 4*2;
						$this->Skip($skip);
						$offset += 2*2 + $skip;
					}
					while($flags & 32); // MORE_COMPONENTS
					$glyph['components'] = $a;
				}
			}
		}
	}

	function ParseCmap()
	{
		$this->Seek('cmap');
		$this->Skip(2); // version
		$numTables = $this->ReadUShort();
		$offset31 = 0;
		for($i=0;$i<$numTables;$i++)
		{
			$platformID = $this->ReadUShort();
			$encodingID = $this->ReadUShort();
			$offset = $this->ReadULong();
			if($platformID==3 && $encodingID==1)
				$offset31 = $offset;
		}
		if($offset31==0)
			$this->Error('No Unicode encoding found');

		$startCount = array();
		$endCount = array();
		$idDelta = array();
		$idRangeOffset = array();
		$this->chars = array();
		fseek($this->f, $this->tables['cmap']['offset']+$offset31, SEEK_SET);
		$format = $this->ReadUShort();
		if($format!=4)
			$this->Error('Unexpected subtable format: '.$format);
		$this->Skip(2*2); // length, language
		$segCount = $this->ReadUShort()/2;
		$this->Skip(3*2); // searchRange, entrySelector, rangeShift
		for($i=0;$i<$segCount;$i++)
			$endCount[$i] = $this->ReadUShort();
		$this->Skip(2); // reservedPad
		for($i=0;$i<$segCount;$i++)
			$startCount[$i] = $this->ReadUShort();
		for($i=0;$i<$segCount;$i++)
			$idDelta[$i] = $this->ReadShort();
		$offset = ftell($this->f);
		for($i=0;$i<$segCount;$i++)
			$idRangeOffset[$i] = $this->ReadUShort();

		for($i=0;$i<$segCount;$i++)
		{
			$c1 = $startCount[$i];
			$c2 = $endCount[$i];
			$d = $idDelta[$i];
			$ro = $idRangeOffset[$i];
			if($ro>0)
				fseek($this->f, $offset+2*$i+$ro, SEEK_SET);
			for($c=$c1;$c<=$c2;$c++)
			{
				if($c==0xFFFF)
					break;
				if($ro>0)
				{
					$gid = $this->ReadUShort();
					if($gid>0)
						$gid += $d;
				}
				else
					$gid = $c+$d;
				if($gid>=65536)
					$gid -= 65536;
				if($gid>0)
					$this->chars[$c] = $gid;
			}
		}
	}

	function ParseName()
	{
		$this->Seek('name');
		$tableOffset = $this->tables['name']['offset'];
		$this->postScriptName = '';
