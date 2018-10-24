<?php
class Condominio{ 

    //configuração para o banco
    private $conn;
    private $table_name = "condominio";
    
    //propriedades do objeto
    public $id;
    public $id_morador;
    public $id_banco;
    public $valor;
    public $data_vencimento;
    public $descricao;
    public $data_process;
    public $cod;

    //construtor recebendo o banco
    public function __construct($db){
        $this->conn = $db;
    }

    //leitura
    function read(){
        
        //SELECT ALL
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY data_process ASC";
    
        //Preparando stmt
        $stmt = $this->conn->prepare($query);
    
        // Executando
        $stmt->execute();
    
        return $stmt;
    }

    //criação
    function create(){
    
        // query para inserir os dados
        $query = "INSERT INTO " 
            . $this->table_name . 
            "(
                id_morador,
                id_banco,
                valor,
                data_vencimento,
                descricao,
                data_process,
                cod
            ) 
            VALUES (
                :id_morador,
                :id_banco,
                :valor,
                :data_vencimento,
                :descricao,
                :data_process,
                :cod
            )";
    
        //preparando a query
        $stmt = $this->conn->prepare($query);
    
        //Organizando dados
        $this->id_morador=htmlspecialchars(strip_tags($this->id_morador));
        $this->id_banco=htmlspecialchars(strip_tags($this->id_banco));
        $this->valor=htmlspecialchars(strip_tags($this->valor));
        $this->data_vencimento=htmlspecialchars(strip_tags($this->data_vencimento));
        $this->descricao=htmlspecialchars(strip_tags($this->descricao));
        $this->data_process=htmlspecialchars(strip_tags($this->data_process));
        $this->cod=htmlspecialchars(strip_tags($this->cod));
    
        //Bind
        $stmt->bindParam(":id_morador", $this->id_morador);
        $stmt->bindParam(":id_banco", $this->id_banco);
        $stmt->bindParam(":valor", $this->valor);
        $stmt->bindParam(":data_vencimento", $this->data_vencimento);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":data_process", $this->data_process);
        $stmt->bindParam(":cod", $this->cod);
    
        //Executando
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    //Usado para updates
    function readOne(){
    
        //Query para ler somente 1 dado
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        
        //preparando a query
        $stmt = $this->conn->prepare( $query );
    
        //Bind
        $stmt->bindParam(1, $this->id);
    
        //Executando
        $stmt->execute();
    
        // Obtendo a linha
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Setando valoeres para o objeto
        $this->id_morador = $row['id_morador'];
        $this->id_banco = $row['id_banco'];
        $this->valor = $row['valor'];
        $this->data_vencimento = $row['data_vencimento'];
        $this->descricao = $row['descricao'];
        $this->data_process = $row['data_process'];
        $this->cod = $row['cod'];
    }

    //Update
    function update(){
    
        //Querry
        $query = "UPDATE 
                " . $this->table_name . " 
                SET
                    id_morador = :id_morador,
                    id_banco = :id_banco,
                    valor = :valor,
                    data_vencimento = :data_vencimento,
                    descricao = :descricao,
                    data_process = :data_process,
                    cod = :cod
                WHERE
                    id = :id";
                    
        //Preparando query
        $stmt = $this->conn->prepare($query);
    
        //Organizando dados
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->id_morador=htmlspecialchars(strip_tags($this->id_morador));
        $this->id_banco=htmlspecialchars(strip_tags($this->id_banco));
        $this->valor=htmlspecialchars(strip_tags($this->valor));
        $this->data_vencimento=htmlspecialchars(strip_tags($this->data_vencimento));
        $this->descricao=htmlspecialchars(strip_tags($this->descricao));
        $this->data_process=htmlspecialchars(strip_tags($this->data_process));
        $this->cod=htmlspecialchars(strip_tags($this->cod));
    
        // Bind
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':id_morador', $this->id_morador);
        $stmt->bindParam(':id_banco', $this->id_banco);
        $stmt->bindParam(':valor', $this->valor);
        $stmt->bindParam(':data_vencimento', $this->data_vencimento);
        $stmt->bindParam(':descricao', $this->descricao);
        $stmt->bindParam(':data_process', $this->data_process);
        $stmt->bindParam(':cod', $this->cod);
        
        // Executando
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    //Delete
    function delete(){
    
        // Query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    
        // Preparando
        $stmt = $this->conn->prepare($query);
    
        // Organizando
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // Bind
        $stmt->bindParam(1, $this->id);
    
        // Executando
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // Procura
    function search($chave){
    
        // SELECT
        $query = "SELECT * FROM " . $this->table_name . "
                WHERE
                    valor LIKE ? OR
                    data_vencimento LIKE ? OR
                    descricao LIKE ? OR
                    data_process LIKE ? OR
                    cod LIKE ?
                ORDER BY
                    data_process ASC";
        // Preparar query
        $stmt = $this->conn->prepare($query);
    
        // Organizar dados
        $chave=htmlspecialchars(strip_tags($chave));
        $chave = "%{$chave}%";
    
        // Bind
        $stmt->bindParam(1, $chave);
        $stmt->bindParam(2, $chave);
        $stmt->bindParam(3, $chave);
        $stmt->bindParam(4, $chave);
        $stmt->bindParam(5, $chave);
    
        // Executar
        $stmt->execute();
    
        return $stmt;
    }

}
?>