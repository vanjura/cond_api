<?php
class Locacao{ 

    //configuração para o banco
    private $conn;
    private $table_name = "locacao";
    
    //propriedades do objeto
    public $id;
    public $id_local;
    public $id_boleto;
    public $id_morador;
    public $data;
    public $inicio;
    public $fim;

    //construtor recebendo o banco
    public function __construct($db){
        $this->conn = $db;
    }

    //leitura
    function read(){
        
        //SELECT ALL
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY data ASC";
    
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
                id_local,
                id_boleto,
                id_morador,
                data,
                inicio,
                fim
            ) 
            VALUES (
                :id_local,
                :id_boleto,
                :id_morador,
                :data,
                :inicio,
                :fim
            )";
    
        //preparando a query
        $stmt = $this->conn->prepare($query);
    
        //Organizando dados
        $this->id_local=htmlspecialchars(strip_tags($this->id_local));
        $this->id_boleto=htmlspecialchars(strip_tags($this->id_boleto));
        $this->id_morador=htmlspecialchars(strip_tags($this->id_morador));
        $this->data=htmlspecialchars(strip_tags($this->data));
        $this->inicio=htmlspecialchars(strip_tags($this->inicio));
        $this->fim=htmlspecialchars(strip_tags($this->fim));
    
        //Bind
        $stmt->bindParam(":id_local", $this->id_local);
        $stmt->bindParam(":id_boleto", $this->id_boleto);
        $stmt->bindParam(":id_morador", $this->id_morador);
        $stmt->bindParam(":data", $this->data);
        $stmt->bindParam(":inicio", $this->inicio);
        $stmt->bindParam(":fim", $this->fim);
    
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
        $this->id_local = $row['id_local'];
        $this->id_boleto = $row['id_boleto'];
        $this->id_morador = $row['id_morador'];
        $this->data = $row['data'];
        $this->inicio = $row['inicio'];
        $this->fim = $row['fim'];
    }

    //Update
    function update(){
    
        //Querry
        $query = "UPDATE 
                " . $this->table_name . " 
                SET
                    id_local = :id_local,
                    id_boleto = :id_boleto,
                    id_morador = :id_morador,
                    data = :data,
                    inicio = :inicio,
                    fim = :fim
                WHERE
                    id = :id";
                    
        //Preparando query
        $stmt = $this->conn->prepare($query);
    
        //Organizando dados
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->id_local=htmlspecialchars(strip_tags($this->id_local));
        $this->id_boleto=htmlspecialchars(strip_tags($this->id_boleto));
        $this->id_morador=htmlspecialchars(strip_tags($this->id_morador));
        $this->data=htmlspecialchars(strip_tags($this->data));
        $this->inicio=htmlspecialchars(strip_tags($this->inicio));
        $this->fim=htmlspecialchars(strip_tags($this->fim));
    
        // Bind
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':id_local', $this->id_local);
        $stmt->bindParam(':id_boleto', $this->id_boleto);
        $stmt->bindParam(':id_morador', $this->id_morador);
        $stmt->bindParam(':data', $this->data);
        $stmt->bindParam(':inicio', $this->inicio);
        $stmt->bindParam(':fim', $this->fim);
        
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
                    data LIKE ? OR
                    inicio LIKE ? OR
                    fim LIKE ?
                ORDER BY
                    data ASC";
        // Preparar query
        $stmt = $this->conn->prepare($query);
    
        // Organizar dados
        $chave=htmlspecialchars(strip_tags($chave));
        $chave = "%{$chave}%";
    
        // Bind
        $stmt->bindParam(1, $chave);
        $stmt->bindParam(2, $chave);
        $stmt->bindParam(3, $chave);
    
        // Executar
        $stmt->execute();
    
        return $stmt;
    }

}
?>