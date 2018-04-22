<?php
/** singleton request handler */
final class RequestHandlerSingleton{

	private static $instance = null; //the single instance
	private $name = 'RequestHandlerSingleton';

	//da singleton -> private contstructor (Es soll nur einen geben)
	private function __construct(){}

	//darf auch nicht gecloned werden
	private function __clone(){}

	/** liefert die eine Instanz des RHs zurueck */
	public static function getInstance(){
		//falls noch keine Instanz existiert zunaechst erzeugen, sonst nur zurueck geben
		if(self::$instance === null)
		{
			self::$instance = new self; //anscheinend egal?
			//self::$instance = new RequestHandler(); 
		}

		return self::$instance;
	}

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