<?php
class Cliente {
    private $conn;
    private $table_name = "Cliente";

    public $idCliente;
    public $nomeCompletoCliente;
    public $emailCliente;
    public $senhaCliente;
    public $CPFCliente;
    public $celularCliente;
    public $telComercialCliente;
    public $telResidencialCliente;
    public $dtNascCliente;

    public function __construct($db){
        $this->conn = $db;
    }


    function create(){
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    nomeCompletoCliente = :nomeCompletoCliente,
                    emailCliente = :emailCliente,
                    senhaCliente = :senhaCliente,
                    CPFCliente = :CPFCliente,
                    celularCliente = :celularCliente,
                    telComercialCliente = :telComercialCliente,
                    telResidencialCliente = :telResidencialCliente,
                    dtNascCliente = :dtNascCliente";

        $stmt = $this->conn->prepare($query);


        $this->nomeCompletoCliente = htmlspecialchars(strip_tags($this->nomeCompletoCliente));
        $this->emailCliente        = htmlspecialchars(strip_tags($this->emailCliente));
        $this->CPFCliente          = htmlspecialchars(strip_tags($this->CPFCliente));
        $this->celularCliente      = htmlspecialchars(strip_tags($this->celularCliente));
        $this->telComercialCliente = htmlspecialchars(strip_tags($this->telComercialCliente));
        $this->telResidencialCliente = htmlspecialchars(strip_tags($this->telResidencialCliente));

        $hashed_password = password_hash($this->senhaCliente, PASSWORD_BCRYPT);
        
        $stmt->bindParam(":nomeCompletoCliente", $this->nomeCompletoCliente);
        $stmt->bindParam(":emailCliente", $this->emailCliente);
        $stmt->bindParam(":senhaCliente", $hashed_password); 
        $stmt->bindParam(":CPFCliente", $this->CPFCliente);
        $stmt->bindParam(":celularCliente", $this->celularCliente);
        $stmt->bindParam(":telComercialCliente", $this->telComercialCliente);
        $stmt->bindParam(":telResidencialCliente", $this->telResidencialCliente);
        

        if (empty($this->dtNascCliente)) {
             $this->dtNascCliente = null;
        }
        $stmt->bindParam(":dtNascCliente", $this->dtNascCliente);


        if($stmt->execute()){
            $this->idCliente = $this->conn->lastInsertId(); 
            return true;
        }

        return false;
    }

    function login($email, $senha) {

        $query = "SELECT * FROM $this->table_name WHERE emailCliente = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $clienteData = $stmt->fetch();

        if (!$clienteData) {
            return [
                'sucesso' => false, 
                'mensagem' => 'E-mail não encontrado.'
            ];
        }
        if (password_verify($senha, $clienteData['senhaCliente'])) {
            $cliente = new Cliente($clienteData);
            $cliente->nomeCompletoCliente = $clienteData['nomeCompletoCliente'];
            $cliente->emailCliente = $clienteData['emailCliente'];
            $cliente->idCliente = $clienteData['idCliente'];
            $cliente->celularCliente = $clienteData['celularCliente'];
            
            unset($cliente->senhaCliente); 
            
            return [
                'cliente' => $cliente 
            ];
        } else {
            return [
                'sucesso' => false, 
                'mensagem' => 'Senha incorreta.'
            ];
        }
    }
}
?>