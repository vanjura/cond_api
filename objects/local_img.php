<?php
class Local_img{ 

    //configuração para o banco
    private $conn;
    private $table_name = "local_img";
    
    //propriedades do objeto
    public $id;
    public $id_local;
    public $link;

    //construtor recebendo o banco
    public function __construct($db){
        $this->conn = $db;
    }

    //leitura
    function read(){
        
        //SELECT ALL
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id ASC";
    
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
                link
            ) 
            VALUES (
                :id_local,
                :link
            )";
    
        //preparando a query
        $stmt = $this->conn->prepare($query);
    
        //Organizando dados
        $this->id_local=htmlspecialchars(strip_tags($this->id_local));
        $this->link=htmlspecialchars(strip_tags($this->link));
    
        //Bind
        $stmt->bindParam(":id_local", $this->id_local);
        $stmt->bindParam(":link", $this->link);
    
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
        $this->link = $row['link'];
    }

    //Update
    function update(){
    
        //Querry
        $query = "UPDATE 
                " . $this->table_name . " 
                SET
                    id_local = :id_local,
                    link = :link
                WHERE
                    id = :id";
                    
        //Preparando query
        $stmt = $this->conn->prepare($query);
    
        //Organizando dados
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->id_local=htmlspecialchars(strip_tags($this->id_local));
        $this->link=htmlspecialchars(strip_tags($this->link));
    
        // Bind
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':id_local', $this->id_local);
        $stmt->bindParam(':link', $this->link);
        
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

    // // Procura
    // function search($chave){
    
    //     // SELECT
    //     $query = "SELECT * FROM " . $this->table_name . "
    //             WHERE
    //                 nome LIKE ?
    //             ORDER BY
    //                 nome ASC";
    //     // Preparar query
    //     $stmt = $this->conn->prepare($query);
    
    //     // Organizar dados
    //     $chave=htmlspecialchars(strip_tags($chave));
    //     $chave = "%{$chave}%";
    
    //     // Bind
    //     $stmt->bindParam(1, $chave);
    
    //     // Executar
    //     $stmt->execute();
    
    //     return $stmt;
    // }

}
?>