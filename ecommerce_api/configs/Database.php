<?php
class Database {
    // Substitua 'api_db' pelo nome do seu banco de dados
    private $host = "localhost";
    private $db_name = "ecommerce"; 
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection(){
        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        }catch(PDOException $exception){
            echo "Erro de conexão: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>