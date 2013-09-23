<?php
	/**
	* Analysis Class
	**/

	class Analysis{
		private $raw = null;

		public function __construct($productID = null) {
			if (!is_null($productID)) {
				$this->raw = SingletonDB::multiQuery("SELECT * FROM AnalysisRaw WHERE AnalysisID = '%s';", $productID);
			}
		}

		public function isValid() {
			return !is_null($this->raw);
		}

		public function search($likelihood, $consequence) {
			$arr = array();
			if($this->isValid()) {
				foreach($this->raw as $entry) {
					if($entry['Likelihood'] == $likelihood && $entry['Consequence'] == $consequence)
						array_push($arr, $entry);
				}
			}
			return $arr;
		}
	}