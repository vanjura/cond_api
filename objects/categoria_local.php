<?php
class Categoria_local{ 

    //configuração para o banco
    private $conn;
    private $table_name = "categoria_local";
    
    //propriedades do objeto
    public $id;
    public $nome;
    public $descricao;
    public $img;

    //construtor recebendo o banco
    public function __construct($db){
        $this->conn = $db;
    }

    //leitura
    function read(){
        
        //SELECT ALL
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nome ASC";
    
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
                nome,
                descricao,
                img
            ) 
            VALUES (
                :nome,
                :descricao,
                :img
            )";
    
        //preparando a query
        $stmt = $this->conn->prepare($query);
    
        //Organizando dados
        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->descricao=htmlspecialchars(strip_tags($this->descricao));
        $this->img=htmlspecialchars(strip_tags($this->img));
    
        //Bind
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":img", $this->img);
    
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
        $this->nome = $row['nome'];
        $this->descricao = $row['descricao'];
        $this->img = $row['img'];
    }

    //Update
    function update(){
    
        //Querry
        $query = "UPDATE 
                " . $this->table_name . " 
                SET
                    nome = :nome,
                    descricao = :descricao,
                    img = :img
                WHERE
                    id = :id";
                    
        //Preparando query
        $stmt = $this->conn->prepare($query);
    
        //Organizando dados
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->descricao=htmlspecialchars(strip_tags($this->descricao));
        $this->img=htmlspecialchars(strip_tags($this->img));
    
        // Bind
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':descricao', $this->descricao);
        $stmt->bindParam(':img', $this->img);

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
                    nome LIKE ? OR
                    descricao LIKE ?
                ORDER BY
                    nome ASC";
        // Preparar query
        $stmt = $this->conn->prepare($query);
    
        // Organizar dados
        $chave=htmlspecialchars(strip_tags($chave));
        $chave = "%{$chave}%";
    
        // Bind
        $stmt->bindParam(1, $chave);
        $stmt->bindParam(2, $chave);
    
        // Executar
        $stmt->execute();
    
        return $stmt;
    }

}
?>