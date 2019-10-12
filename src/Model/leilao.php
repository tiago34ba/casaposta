<?php



class Leilao
{
    private $descricao;
    private $lances;
	private $maiorLance=0;
    
    function __construct($descricao)
    {
        $this->descricao = $descricao;
        $this->lances = array();
    }
    
    public function propoe(Lance $lance)
    {
        $this->checkUsuarioUltimoLance($lance);
        $this->checkMaiorQue5($lance);
        //print_r($lance);die();
        $this->lances[] = $lance;
		
		
		///so basta isso
		if ($lance>$this->maiorLance){
		   $this->$maiorLance = $lance;
		
		}		
		
    }
    public function dobraLance(Usuario $usuario)
    {
        $lances = array_reverse($this->getLances());
        foreach ($lances as $lance) {
            if ($usuario->getNome() == $lance->getUsuario()->getNome()) {
                $dobro = $lance->getValor() * 2;
                $this->propoe(new Lance($usuario, $dobro));
                return;
            }
        }
    }
    public function checkMaiorQue5(Lance $lanceAtual)
    {
        $lances = $this->getLances();
        $lancesDoUsuarioAtual = 0;
        foreach ($lances as $lance) {
            if ($lanceAtual->getUsuario()->getNome() == $lance->getUsuario()->getNome()) {
                $lancesDoUsuarioAtual++;
            }
        }
        if ($lancesDoUsuarioAtual > 5) {
            throw new Exception("O {$lanceAtual->getUsuario()->getNome()} deu mais que 5 lances R$ {$lanceAtual->getValor()}");
        }
    }
    public function checkUsuarioUltimoLance(Lance $lance)
    {
        $ultimoLance = $this->getUltimoLance();
        if ($ultimoLance) {
            if ($lance->getUsuario()->getNome() == $ultimoLance->getUsuario()->getNome()) {
                throw new Exception("O mesmo usuario é proibido de dar lance seguidos");
            }
        }
    }
    public function getUltimoLance()
    {
        $qntLances = count($this->lances);
        if ($qntLances != 0) {
            $qntLances = $qntLances - 1;
            return $this->lances[$qntLances];
        }
        return false;
    }
    public function getDescricao()
    {
        return $this->descricao;
    }
    public function getLances()
    {
        return $this->lances;
    }
	
	//e isso
	
	 public function getMaiorLance()
    {
        return $this->MaiorLance;
    }
}