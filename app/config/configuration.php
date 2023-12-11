<?php 

$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
$protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
$envFile = __DIR__ . './core/.env';
// Load the environment variables from the .env file
if (file_exists($envFile)) {
    $envVariables = parse_ini_file($envFile);
    foreach ($envVariables as $key => $value) {
        putenv("$key=$value");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
	/**
	 * set database variables
	 * And Access environment variables
	 */
	define('DB_TYPE', getenv('DB_TYPE'));
	define('DB_NAME', getenv('DB_NAME')); 
	define('DB_USER', getenv('DB_USER'));
	define('DB_PASS', getenv('DB_PASS'));
	define('DB_HOST', getenv('DB_HOST'));
	define('DB_CHARSET', getenv('DB_CHARSET'));
	/*set Application General Title, Daveloper name and Protocal variables*/
	define('App_Title', getenv('App_Name'));
	// --Optional 
	define('Developer', getenv('Developer'));
	// -- 

	define('PROTOCAL', $protocol); 

	// Define jwt private key 
	define('PRIVATE_KEY', getenv('API_SECURITY_KEY'));

	/*root and asset paths*/
	$path = str_replace("\\", "/",PROTOCAL ."://" . $_SERVER['SERVER_NAME'] . __DIR__  . DIRECTORY_SEPARATOR);
	$path = str_replace($_SERVER['DOCUMENT_ROOT'], "", $path);
	define('ROOT', str_replace("app/config/", "", $path));
	define('ASSETS', str_replace("app/config", "public/assets", $path));
} else {
    die('.env file not found.');
}

/*set to true to allow error reporting
set to false when you upload online to stop error reporting*/

define('DEBUG',true);

if(DEBUG)
{
	ini_set("display_errors",1);
}else{
	ini_set("display_errors",0);
}