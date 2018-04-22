<?php
/** singleton request handler */
final class RequestHandler{

	//da singleton -> private contstructor (Es soll nur einen geben)
	public function __construct(){}

	/*** Verarbeitet den Input zu einem JSON-Objekt und fuegt einen Timestamp hinzu
	*
	* @param string $givenInput		Der Inputparameter der auch wieder mit zurueck gegeben wird
	* @return						returns a JSON-Object for a given input with a timestamp
	*/
	private function getJSON($givenInput){
		$time = (new DateTime())->format("d.m.Y H:i:s");	//aktuellen Timestamp erzeugen

		$outArr = ['given_param' => $givenInput, 'timestamp' => $time];
		return json_encode($outArr);
	}

	/** Die eigentliche Logik zum handeln des Requests
	*
	* @param mixed $param	optionaler Parameter
	*/
	public function handleRequest($param = null){

		//falls long polling mode
		if(isset($_REQUEST["lp"]) && ($_REQUEST["lp"] == 'true')) {
			//do stuff frequently
			$cnt = 0;

			//condition for output
			//while($cnt < 5){
				//usleep(500000); //wait n microseconds
				sleep(5); //wait n seconds
				echo $this->getJSON($_REQUEST['my_val']);
				$cnt++;
			//}
		}
		else	//do stuff just one time(no long polling mode)
			echo $this->getJSON($_REQUEST['my_val']);

		return;
	}
}
?>