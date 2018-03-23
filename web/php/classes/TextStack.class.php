<?PHP
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* An ugly hack for to log the consistency check protokol
* The depth starts with 1.
*/
class TextStack {

	private $buffer = array();
	private $maxDepth = 0;


	/**
	* Push text to buffer.
	* Use next depth if not given.
	*/
	public function push($text) {

		$this->maxDepth = $this->setDepth(++$this->maxDepth);
		$this->buffer[$this->maxDepth] .= $text;

		return $this->maxDepth;
	} // eo push text


	/**
	* Append text to buffer.
	* Use current maxdepth if not given
	*/
	public function append($text, $depth = null) {

		if ($depth === null) {
			$depth = $this->maxDepth;
		}

		// validated depth setting
		$depth = $this->setDepth($depth);

		$this->buffer[$depth] .= $text;

		return $depth;
	} // eo append text


	/**
	* Set valid depth.
	* Minimum is 1.
	*/
	private function setDepth($depth) {

		$depth = max($depth, 1);
		$this->maxDepth = max($this->maxDepth, $depth);

		return $depth;
	} // eo set depth



	/**
	* Output buffered text
	*/
	public function flush($appendText = '') {
		for ($i = 1; $i <= $this->maxDepth; $i++) {
			$text .= $this->buffer[$i];
		}
		$this->buffer = array();

		return $text . $appendText;
	}


	/**
	* Pop text from buffer
	*/
	public function pop() {

		// the minimum buffer position is 1
		if ($this->maxDepth < 1) {
			return '';
		}

		$text = $this->buffer[$this->maxDepth];
		$this->buffer[$this->maxDepth] = '';
		$this->maxDepth = max($this->maxDepth - 1, 0);

		return $text;
	} // eo pop text


}  // end of class

?>
