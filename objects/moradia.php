<?php
class Moradia{ 

    //configuração para o banco
    private $conn;
    private $table_name = "moradia";
    
    //propriedades do objeto
    public $id;
    public $id_condominio;
    public $id_morador;
    public $num;
    public $tipo;
    public $bloco;

    //construtor recebendo o banco
    public function __construct($db){
        $this->conn = $db;
    }

    //leitura
    function read(){
        
        //SELECT ALL
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY bloco ASC";
    
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
                id_condominio,
                id_morador,
                num,
                tipo,
                bloco
            ) 
            VALUES (
                :id_condominio,
                :id_morador,
                :num,
                :tipo,
                :bloco
            )";
    
        //preparando a query
        $stmt = $this->conn->prepare($query);
    
        //Organizando dados
        $this->id_condominio=htmlspecialchars(strip_tags($this->id_condominio));
        $this->id_morador=htmlspecialchars(strip_tags($this->id_morador));
        $this->num=htmlspecialchars(strip_tags($this->num));
        $this->tipo=htmlspecialchars(strip_tags($this->tipo));
        $this->bloco=htmlspecialchars(strip_tags($this->bloco));
    
        //Bind
        $stmt->bindParam(":id_condominio", $this->id_condominio);
        $stmt->bindParam(":id_morador", $this->id_morador);
        $stmt->bindParam(":num", $this->num);
        $stmt->bindParam(":tipo", $this->tipo);
        $stmt->bindParam(":bloco", $this->bloco);
    
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
        $this->id_condominio = $row['id_condominio'];
        $this->id_morador = $row['id_morador'];
        $this->num = $row['num'];
        $this->tipo = $row['tipo'];
        $this->bloco = $row['bloco'];
    }

    //Update
    function update(){
    
        //Querry
        $query = "UPDATE 
                " . $this->table_name . " 
                SET
                    id_condominio = :id_condominio,
                    id_morador = :id_morador,
                    num = :num,
                    tipo = :tipo,
                    bloco = :bloco
                WHERE
                    id = :id";
                    
        //Preparando query
        $stmt = $this->conn->prepare($query);
    
        //Organizando dados
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->id_condominio=htmlspecialchars(strip_tags($this->id_condominio));
        $this->id_morador=htmlspecialchars(strip_tags($this->id_morador));
        $this->num=htmlspecialchars(strip_tags($this->num));
        $this->tipo=htmlspecialchars(strip_tags($this->tipo));
        $this->bloco=htmlspecialchars(strip_tags($this->bloco));
    
        // Bind
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':id_condominio', $this->id_condominio);
        $stmt->bindParam(':id_morador', $this->id_morador);
        $stmt->bindParam(':num', $this->num);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':bloco', $this->bloco);
        
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
                    num LIKE ? OR
                    tipo LIKE ? OR
                    bloco LIKE ?
                ORDER BY
                    bloco ASC";
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