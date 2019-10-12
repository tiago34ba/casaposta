<?php
class usuario {
	
	private $email;
	private $senha;
	private $nome;
	
	public function __construct(){
		$this->setEmail("");
		$this->setSenha("");
		$this->setNome("");
		}
	
	
	
	//Email
	function getEmail() {
        	return $this->email;
	}
	function setEmail($novo_email)
	{
 		$this->email = $novo_email;
		return true;
	}
	//Senha
	function getSenha() {
        	return $this->senha;
	}
	function setSenha($nova_senha)
	{
 		$this->senha = $nova_senha;
		return true;
	}
	//Nome
	function getNome() {
        	return $this->nome;
	}
	function setNome($novo_nome)
	{
 		$this->nome = $novo_nome;
		return true;
	}
}
