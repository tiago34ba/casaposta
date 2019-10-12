<?php
namespace Tiago\Test;
 
 use Teste\Src\Model\usurio;
 use PHPUnit\framework\testcase;


 class UsuarioTest  extends testcase{
 public function teteValidarNome(){
 
 $usuario = new $nome;
$usuario->setNome('Tiago');
$nome = $usuario->getNome();
$this->assertEquals('Tiago', $nome);
 }
}