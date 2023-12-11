<?php 

Class Database{
	private $HOST = DB_HOST;
	private $USER = DB_USER;
	private $PASSWORD = DB_PASS;
	private $DbNAME = DB_NAME;
	private $charset = DB_CHARSET; 
	private $statement;
	private $dbHandler;
	private $error;

	public function __construct(){
		$conn = 'mysql:host=' .$this->HOST . ';dbname=' .$this->DbNAME . ';charset=' .$this->charset;
		$options = array(
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		);
		try{
			$this->dbHandler = new PDO($conn, $this->USER, $this->PASSWORD, $options);
		}catch  (PDOException $e) {
			$this->error = $e->getMessage();
			echo $this->error;
		}
	}
	//Allows us to write queries
	public function query($sql){
		$this->statement = $this->dbHandler->prepare($sql);
	}
	//Bind values
	public function bind($parameter, $value, $type = null){
		switch (is_null($type)) {
			case is_int($value):
			$type = PDO::PARAM_INT;
				break;
			case is_bool($value):
			$type = PDO::PARAM_BOOL;
				break;
			case is_null($value):
			$type = PDO::PARAM_NULL;
				break;
			default:
				$type = PDO::PARAM_STR;
		}
		$this->statement->bindValue($parameter, $value, $type);
	}
	//Execute the prepare statement
	public function execute(){
		return $this->statement->execute();
	}
	//Return an array
	public function fetch_assoc(){
		$this->execute();
		return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Fetch method returns each row as an object with property names that correspond to the column names returned in the result.
     * @return void
     */  
 
	
	public function PDOFETCHOBJ(){
        $this->execute();
		return $this->statement->fetchAll(PDO::FETCH_OBJ);
	}
	
	public function PDOARRAYFETCH(){
        $this->execute();
		return $this->statement->fetch(PDO::FETCH_ARRAY);
    }
	/**
     * Fetch method returns each row as an object with property names that correspond to the column names returned in the result.
     * @return void
     */
	public function single(){
		$this->execute();
		return $this->statement->fetch(PDO::FETCH_OBJ);
	}
	/**
	 * Specifies that the fetch method shall return TRUE and assign the values of the columns in the result set to the PHP variables to which they were bound with the PDOStatement::bindParam() or PDOStatement::bindColumn() methods.
	 *
	 * @return void
	 */ 
	public function BinderBond(){
		$this->execute();
		return $this->statement->fetchall(PDO::FETCH_BOUND);
	}

	/**
	 * Allows completely customize the way data is treated on the fly (only valid inside PDOStatement::fetchAll()).
	 * @return void
	 */ 
	public function FETCHFUN (){
		$this->execute();
		return $this->statement->fetchall(PDO::FETCH_FUNC);
	}
     
    /**
     * GET A ROW COUNT 
     * @return void
     */
	public function rowCount(){
		$this->execute();
		return $this->statement->rowCount();
	}
}