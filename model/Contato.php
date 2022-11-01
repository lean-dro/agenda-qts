<?php 
require_once 'conexao.php';
class Contato
{
    private $id;
    private $nome;
    private $email;
    private $celular;
    private $telefone;

	public function getNome() {
		return $this->nome;
	}

    public function setNome($nome) {
		$this->nome = $nome;
	}

    public function getId() {
		return $this->id;
	}


    public function setId($id) {
		$this->id = $id;
	}

    public function getEmail() {
		return $this->email;
	}


    public function setEmail($email) {
		$this->email = $email;
	}


    public function getCelular() {
		return $this->celular;
	}


    public function setCelular($celular) {
		$this->celular = $celular;
		
	}
	public function getTelefone() {
		return $this->telefone;
	}
	

	public function setTelefone($telefone) {
		$this->telefone = $telefone;
	}

    public function listar(){
        $con = Conexao::conexao();

        $query = "SELECT id, nome, email, telefone, celular FROM tbcontato";
        $resultado = $con->query($query);
        $lista = $resultado->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }
    public function listarContato($id)
    {
        $con = Conexao::conexao();

        $query = "SELECT id, nome, email, telefone, celular FROM tbcontato WHERE id = $id";
        $resultado = $con->query($query);
        $lista = $resultado->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }
    public function inserir($contato){
        $con = Conexao::conexao();
        $data = [
            'nome' => $contato->getNome(),
            'telefone' => $contato->getTelefone(),
            'celular' => $contato->getCelular(),
            'email' => $contato->getEmail()
        ];
        $stmt = $con->prepare("INSERT INTO tbcontato (nome, telefone, email, celular) VALUES (:nome, :telefone, :celular, :email)");
        
        $stmt->execute($data);
        $query = "SELECT MAX(id) as id FROM tbcontato";
        $resultado = $con->query($query);
        $lista = $resultado->fetchAll();
        foreach ($lista as $linha) {
            $id = $linha['id'];
        }
        return $id;
    }
    public function update($contato)
    {
        $con = Conexao::conexao();
        $data = [
            'id' => $contato->getId(),
            'nome' => $contato->getNome(),
            'telefone' => $contato->getTelefone(),
            'celular' => $contato->getCelular(),
            'email' => $contato->getEmail()
        ];
        $stmt = $con->prepare("UPDATE tbcontato SET nome = :nome, telefone = :telefone, email = :email, celular = :celular WHERE id = :id");

        $stmt->execute($data);

        $id = $data['id'];
        return $id;
    }

    public function delete($contato)
    {
        $con = Conexao::conexao();
        $data = [
            'id' => $contato->getId()
        ];
        $stmt = $con->prepare("DELETE FROM tbcontato WHERE id = :id");

        $stmt->execute($data);
    }
}
