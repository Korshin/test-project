<?php
namespace classes;
use \Exception;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
ini_set('error_log',  realpath(__DIR__) . DIRECTORY_SEPARATOR . 'php_errors.log');

class CProducts{
	public $dataProducts = null, $error = null, $currentPage = 1, $pagination = null, $allPages = null;
	private $connect = null;
	
	public function __construct(){
		try{
			if(!$this->connectDB()){
				throw new Exception();
			}
			if(isset($_POST['id']) && isset($_POST['type'])){
				$this->setProductQuantity();
			}elseif(isset($_POST['hide'])){
				$this->hideProduct();
			}else{
				$this->showTableProducts();
			}
		}catch(Exception $e){
			error_log('Error connect: ' . $e->getMessage(), 0);
			$this->error = 'Ошибка соединения с Базой Данных';
		}
	}
	
	private function connectDB(){
		try{
			$this->connect = mysqli_connect('localhost', 'root', '', 'testproject');
			return true;
		}catch(mysqli_sql_exception $e){
			error_log('Error connect Data Base testproject: ' . mysqli_connect_error(), 0);
			return false;
		}
	}
	
	private function closeDB(){
		if($this->connect){
			mysqli_close($this->connect);
		}
	}
	
	private function showTableProducts(int $limit = 10){
		if(isset($_GET['page'])){
			$this->currentPage = trim($_GET['page']);
			if(!settype($this->currentPage, 'int')){
				$this->currentPage = 1;
			}
		}
		if(isset($_GET['limit'])){
			$limit = trim($_GET['limit']);
			if(!settype($limit, 'int')){
				$limit = 10;
			}
		}
		$offset = $limit * ($this->currentPage - 1);
		$sql = "SELECT COUNT(*) FROM products";
		$result = mysqli_query($this->connect, $sql);
		$count = mysqli_fetch_row($result);
		mysqli_free_result($result);
		$this->allPages = ceil($count[0] / $limit);
		$this->pagination = [$this->currentPage - 1, $this->currentPage, $this->currentPage + 1];
		foreach($this->pagination as $key => $value){
			if($value <= 0 || $value > $this->allPages){
				unset($this->pagination[$key]);
			}
		}
		try{
			$sql = mysqli_prepare($this->connect, "SELECT product_id, product_name, product_price, product_article, product_quantity, date_create FROM products WHERE product_show = 1 ORDER BY date_create DESC LIMIT ?, ?");
			mysqli_stmt_bind_param($sql, "ii", $offset, $limit);
			mysqli_stmt_execute($sql);
			$result = mysqli_stmt_get_result($sql);
			$this->dataProducts = mysqli_fetch_all($result, MYSQLI_ASSOC);
			mysqli_free_result($result);
			mysqli_stmt_close($sql);
		}catch(mysqli_sql_exception $e){
			error_log('Error prepare request SELECT products data: ' . mysqli_stmt_error($sql), 0);
			$this->error = 'Ошибка запроса к Базе Данных';
		}
		$this->closeDB();
	}
	
	private function setProductQuantity(){
		$idProduct = trim($_POST['id']);
		$typeButton = trim($_POST['type']);
		try{
			$sql = mysqli_prepare($this->connect, "SELECT product_quantity FROM products WHERE product_id = ? LIMIT 1");
			mysqli_stmt_bind_param($sql, "i", $idProduct);
			mysqli_stmt_execute($sql);
			$result = mysqli_stmt_get_result($sql);
			$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
			mysqli_free_result($result);
			mysqli_stmt_close($sql);
			if(!empty($row)){
				switch($typeButton){
					case 'plus':
						$sql = mysqli_prepare($this->connect, "UPDATE products SET product_quantity = product_quantity + 1 WHERE product_id = ? LIMIT 1");
						break;
					case 'minus':
						if($row[0]['product_quantity'] > 0){
							$sql = mysqli_prepare($this->connect, "UPDATE products SET product_quantity = product_quantity - 1 WHERE product_id = ? LIMIT 1");
						}else{
							$this->closeDB();
							exit();
						}
						break;
					default:
						error_log('Unknown operator [' . $typeButton . '] in request UPDATE product_quantity', 0);
						$this->closeDB();
						header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
						exit('Неизвестный оператор в запросе');
				}
				mysqli_stmt_bind_param($sql, "i", $idProduct);
				mysqli_stmt_execute($sql);
				mysqli_stmt_close($sql);
				$this->closeDB();
				exit();
			}else{
				error_log('Unknown id [' . $idProduct . '] in request UPDATE product_quantity', 0);
				$this->closeDB();
				header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
				exit('Неизвестный id продукта');
			}
		}catch(mysqli_sql_exception $e){
			error_log('Error prepare request UPDATE product_quantity: ' . mysqli_stmt_error($sql), 0);
			mysqli_free_result($result);
			mysqli_stmt_close($sql);
			$this->closeDB();
			header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
			exit('Ошибка в работе с Базой Данных');
		}
	}
	
	private function hideProduct(){
		$idProduct = trim($_POST['hide']);
		try{
			$sql = mysqli_prepare($this->connect, "SELECT product_id FROM products WHERE product_id = ? LIMIT 1");
			mysqli_stmt_bind_param($sql, "i", $idProduct);
			mysqli_stmt_execute($sql);
			$result = mysqli_stmt_get_result($sql);
			$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
			mysqli_free_result($result);
			mysqli_stmt_close($sql);
			if(!empty($row)){
				$sql = mysqli_prepare($this->connect, "UPDATE products SET product_show = 0 WHERE product_id = ? LIMIT 1");
				mysqli_stmt_bind_param($sql, "i", $idProduct);
				mysqli_stmt_execute($sql);
				mysqli_stmt_close($sql);
				$this->closeDB();
				exit();
			}else{
				error_log('Unknown id [' . $idProduct . '] in request UPDATE product_show', 0);
				$this->closeDB();
				header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
				exit('Неизвестный id продукта');
			}
		}catch(mysqli_sql_exception $e){
			error_log('Error prepare request UPDATE product_show: ' . mysqli_stmt_error($sql), 0);
			mysqli_free_result($result);
			mysqli_stmt_close($sql);
			$this->closeDB();
			header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
			exit('Ошибка в работе с Базой Данных');
		}
	}
}
?>