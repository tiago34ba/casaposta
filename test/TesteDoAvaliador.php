<?php
class TesteDoAvaliador extends Teste
{
   
    private $leiloeiro;
    
    public function SetUp()
    {
        $this->leiloeiro = new Avaliador();
    }
    
    /*
	public static function setUpBeforeClass() {
	  var_dump("before class");
	}
	public static function tearDownAfterClass() {
	  var_dump("after class");
	}
	*/
    
    public function testValorMedio()
    {
        
        $leilao = new Leilao('Playstation 4');
        $renam  = new Usuario('Renam');
        $caio   = new Usuario('Caio');
        $felipe = new Usuario('Felipe');
    
		$construtor = new ConstrutorDeLeilao();
        $leilao = $construtor->para('Playstation 4')
            ->lance($renam, 5)
            ->lance($caio, 5)
            ->lance($felipe, 5)
            ->constroi()
        ;
        $this->leiloeiro->avalia($leilao);
        $valorMedio = 5;
        $this->assertEquals($this->leiloeiro->valorMedio($leilao), $valorMedio);
    }
    
    
    public function testAceitaApenasUmLance()
    {
        
        $renam  = new Usuario('Renam');
        $construtor = new ConstrutorDeLeilao();
        $leilao = $construtor->para('Playstation 4')
            ->lance($renam, 200)
            ->constroi()
        ;
        
		$this->leiloeiro->avalia($leilao);
        
        $maiorEsperado = 200;
        $menorEsperado = 200;
        $this->assertEquals($this->leiloeiro->getMaiorLance(), $maiorEsperado);
        $this->assertEquals($this->leiloeiro->getMenorLance(), $menorEsperado);
    }
    
    public function testUltimoLance()
    {
        $leilao = new Leilao('Nintendo Switch');
        $renam  = new Usuario('Renam');
        $caio   = new Usuario('Caio');
        $leilao->propoe(new Lance($caio, 10));
        $leilao->propoe(new Lance($renam, 200));
        $ultimoLance = $leilao->getUltimoLance();
        $this->assertEquals($ultimoLance->getValor(), 200);
    }
    public function testMaioresLances()
    {
        $renam  = new Usuario('Renam');
        $felipe = new Usuario('Felipe');
        $construtor = new ConstrutorDeLeilao();
        
        $leilao = $construtor->para('Playstation 4')
            ->lance($renam, 200)
            ->lance($felipe, 240)
            ->lance($renam, 300)
            ->lance($felipe, 500)
            ->lance($renam, 2000)
            ->constroi()
        ;
        
        $qntLances = 3;
        $tresUltimosMaioresLances = $this->leiloeiro->pegarMaioresLances($leilao, $qntLances);
        $this->assertEquals(count($tresUltimosMaioresLances), $qntLances);
        $this->assertEquals($tresUltimosMaioresLances[0]->getValor(), 2000);
        $this->assertEquals($tresUltimosMaioresLances[1]->getValor(), 500);
        $this->assertEquals($tresUltimosMaioresLances[2]->getValor(), 300);
    }
    public function testLanceDuplicado()
    {
        try {
            $leilao = new Leilao('Arvore de Natal');
            $renam  = new Usuario('Renam');
            $felipe = new Usuario('Felipe');
            $caio   = new Usuario('Caio');
        
            $leilao->propoe(new Lance($renam, 500));
            $leilao->propoe(new Lance($felipe, 200));
            
			//A Anta do Caio apertou errado o botão e lançõu 1x um lance de 10 e logo em seguida 1.000 hehe
            $leilao->propoe(new Lance($caio, 10));
            $leilao->propoe(new Lance($caio, 1000));
            
			//Então deveria estourar o Exception
        } catch (Exception $exception) {
            $this->assertInstanceOf('Exception', $exception);
        }
    }
   public function testDobro()
    {
        try {
            $leilao = new Leilao('TV 90 Polegada');
            $renam  = new Usuario('Renam');
            $felipe = new Usuario('Felipe');
            
            //Competição (Renam x Felipe) hehe
            $leilao->propoe(new Lance($renam, 50));
            $leilao->propoe(new Lance($felipe, 100));
            $leilao->propoe(new Lance($renam, 150));
            $leilao->propoe(new Lance($felipe, 500));
            $leilao->propoe(new Lance($renam, 800));
            //EITAAA CUZÃO
            $leilao->propoe(new Lance($felipe, 1000));
            $leilao->propoe(new Lance($renam, 2000));
            $leilao->propoe(new Lance($felipe, 2500));
            $leilao->propoe(new Lance($renam, 3000));
            $leilao->propoe(new Lance($felipe, 3050));
            $leilao->propoe(new Lance($renam, 3750));
            //Take DOUBLE KILL, TRIPLE KILL DO MicaO,
            //QUADRA NÃO, QUADRA NÃO?! É TETRA!!! TETRAAAAAA KILL!!
            $leilao->dobraLance($felipe);
            
            $lances = $this->leiloeiro->pegarMaioresLances($leilao, 1);
            $this->assertEquals($lances[0]->getValor(), 3050 * 2);
        } catch (Exception $exception) {
            //$this->assertInstanceOf('Exception', $exception);
            print $exception->getMessage();
        }
    }
    public function testDobroVoid()
    {
        try {
            $leilao = new Leilao('TV 90 Polegada');
            $renam  = new Usuario('Renam');
            $felipe = new Usuario('Felipe');
            
            $leilao->propoe(new Lance($renam, 50));
            //$leilao->propoe(new Lance($felipe, 100));
            $leilao->dobraLance($felipe);
            
            $lances = $this->leiloeiro->pegarMaioresLances($leilao, 1);
            //Deve ignorar a entrada o dobro do $felipe afinalo dobro de void é void² ^^
            $this->assertEquals($lances[0]->getValor(), 50);
        } catch (Exception $exception) {
            //$this->assertInstanceOf('Exception', $exception);
            print $exception->getMessage();
        }
    }
    
    
    /**
    * @expectedException InvalidArgumentException
    */
    public function testDeveRecusarLeilaoSemLances()
    {
                
        $construtor = new ConstrutorDeLeilao();
    
        $leilao = $construtor->para('Playstation 4')
            //->lance($renam, 200)
            ->constroi()
        ;
        $this->leiloeiro->avalia($leilao);
        
        $this->assertTrue(false);
    }
} 