<?php
require('../fpdf.php');

class PDF extends FPDF
{
function Header()
{
	global $title;

	// Arial bold 15
	$this->SetFont('Arial','B',15);
	// Calculate width of title and position
	$w = $this->GetStringWidth($title)+6;
	$this->SetX((210-$w)/2);
	// Colors of frame, background and text
	$this->SetDrawColor(0,80,180);
	$this->SetFillColor(230,230,0);
	$this->SetTextColor(220,50,50);
	// Thickness of frame (1 mm)
