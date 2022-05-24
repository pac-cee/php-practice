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
