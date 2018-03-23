<?php
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/

require_once(__DIR__ . "/../init.inc.php");




/**
* Print proto to pdf
*/
if ($_REQUEST['_action'] == "exportPdf") {

// inline tmp pdf class
class TmpPdf extends OgerPdf {

	public function header() {

		$this->setFont("helvetica", "B", 12);
		$this->setMargins(20,20);
		$this->setTopMargin(20);

		$margins = $this->getMargins();

		// page header
		$this->write(0, "{$this->headerFooterVals['title']}");
		$fontSize = $this->getFontSize();
		$this->setY($this->getY() + $fontSize + 2);
		$this->line($margins['left'], $this->getY(), $this->getPageWidth() - $margins['right'], $this->getY());
		$this->setY($this->getY() + 5);

		$this->ln();
		$this->setTopMargin($this->getY());

	}  // eo head

	public function footer() {

		$margins = $this->getMargins();
		$this->line($margins['left'], $this->getPageHeight() - $margins['bottom'] + 5,
								$this->getPageWidth() - $margins['right'], $this->getPageHeight() - $margins['bottom'] + 5);

		$this->setY($this->getPageHeight() - $margins['bottom'] + 5);
		$this->setFont("helvetica", "", 6);
		$this->ln(1);

		$textW = $this->getPageWidth() - $margins['left'] - $margins['right'];
		$this->cell($textW / 3, 0, "", "", "", "L");  // company
		$pageInfo = "Seite " . $this->getAliasNumPage() . " von " . $this->getAliasNbPages();
		$this->cell($textW / 3, 0, $pageInfo, "", "", "C");
		$this->cell($textW / 3, 0, $this->headerFooterVals['time'], "", "", "R");
	}  // eo footer

}  // eo inline Opdf class


	$pdf = new TmpPdf();


	// body settings
	$pdf->setMargins(20, 70);
	$pdf->SetAutoPageBreak(true, 30);


	// prepare vals for header and footer
	$hfVals = array(
		"title" => $_REQUEST['title'],
		"time" => date("d.m.Y"),
	);
	$pdf->headerFooterVals = $hfVals;


	// output proto

	$pdf->addPage();
	$pdf->multiCell(0, 0, $_REQUEST['protoText'], 0, "L");

	// write footer for last page and send pdf output
	$pdf->endPage();
	$pdf->Output(Oger::_('Protokoll'), 'I');

}  // eo pdf output





echo Extjs::errorMsg("Invalid request action '" . $_REQUEST['_action'] . "' in " . __FILE__);
exit;


