<?php
class Local{ 

    //configuração para o banco
    private $conn;
    private $table_name = "local";
    
    //propriedades do objeto
    public $id;
    public $id_morador;
    public $logo;
    public $nome;
    public $rua;
    public $num;
    public $cidade;
    public $uf;
    public $cnpj;

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
                id_morador,
                logo,
                nome,
                rua,
                num,
                cidade,
                uf,
                cnpj
            ) 
            VALUES (
                :id_morador,
                :logo,
                :nome,
                :rua,
                :num,
                :cidade,
                :uf,
                :cnpj
            )";
    
        //preparando a query
        $stmt = $this->conn->prepare($query);
    
        //Organizando dados
        $this->id_morador=htmlspecialchars(strip_tags($this->id_morador));
        $this->logo=htmlspecialchars(strip_tags($this->logo));
        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->rua=htmlspecialchars(strip_tags($this->rua));
        $this->num=htmlspecialchars(strip_tags($this->num));
        $this->cidade=htmlspecialchars(strip_tags($this->cidade));
        $this->uf=htmlspecialchars(strip_tags($this->uf));
        $this->cnpj=htmlspecialchars(strip_tags($this->cnpj));
    
        //Bind
        $stmt->bindParam(":id_morador", $this->id_morador);
        $stmt->bindParam(":logo", $this->logo);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":rua", $this->rua);
        $stmt->bindParam(":num", $this->num);
        $stmt->bindParam(":cidade", $this->cidade);
        $stmt->bindParam(":uf", $this->uf);
        $stmt->bindParam(":cnpj", $this->cnpj);
    
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
        $this->logo = $row['logo'];
        $this->nome = $row['nome'];
        $this->rua = $row['rua'];
        $this->num = $row['num'];
        $this->cidade = $row['cidade'];
        $this->uf = $row['uf'];
        $this->cnpj = $row['cnpj'];
    }

    //Update
    function update(){
    
        //Querry
        $query = "UPDATE 
                " . $this->table_name . " 
                SET
                    id_morador = :id_morador,
                    logo = :logo,
                    nome = :nome,
                    rua = :rua,
                    num = :num,
                    cidade = :cidade,
                    uf = :uf,
                    cnpj = :cnpj
                WHERE
                    id = :id";
                    
        //Preparando query
        $stmt = $this->conn->prepare($query);
    
        //Organizando dados
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->id_morador=htmlspecialchars(strip_tags($this->id_morador));
        $this->logo=htmlspecialchars(strip_tags($this->logo));
        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->rua=htmlspecialchars(strip_tags($this->rua));
        $this->num=htmlspecialchars(strip_tags($this->num));
        $this->cidade=htmlspecialchars(strip_tags($this->cidade));
        $this->uf=htmlspecialchars(strip_tags($this->uf));
        $this->cnpj=htmlspecialchars(strip_tags($this->cnpj));
    
        // Bind
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':id_morador', $this->id_morador);
        $stmt->bindParam(':logo', $this->logo);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':rua', $this->rua);
        $stmt->bindParam(':num', $this->num);
        $stmt->bindParam(':cidade', $this->cidade);
        $stmt->bindParam(':uf', $this->uf);
        $stmt->bindParam(':cnpj', $this->cnpj);
        
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
                    rua LIKE ? OR
                    num LIKE ? OR
                    cidade LIKE ? OR
                    uf LIKE ?
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
        $stmt->bindParam(3, $chave);
        $stmt->bindParam(4, $chave);
        $stmt->bindParam(5, $chave);
    
        // Executar
        $stmt->execute();
    
        return $stmt;
    }

}
?>