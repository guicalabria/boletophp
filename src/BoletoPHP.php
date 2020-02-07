<?php
namespace BoletoPHP;

/**
 *  Class responsible for creating and communicating with web services for boletos in Brazil 
 *
 * @category  library
 * @package   BoletoWebService
 * @license   https://opensource.org/licenses/MIT MIT
 * @author    Guilherme Calabria Filho < guiga86 at gmail dot com >
 * @link      https://github.com/guicalabria/boletophp.git for the canonical source repository
 */


class BoletoPHP {
 
    private $bancoDisponivel  = array('bancodobrasil');
    
    private $banco;
    private $bancoWebService;
    /**
     * Mapa das classes dos Bancos e seus códigos
     *
     * @var array
     */
    protected static $classMap = array(
        '001' => 'BancoDoBrasil',
    );


    public $erro = false;
    public $mensagem = '';
    
   /**
     * Constructor
     * @param string $codigobanco
     */
   public function __construct($codigobanco)
   {
      if (! isset(static::$classMap[$codBanco])) 
      {
          $this->erro = true;
          $this->mensagem .= '<span class="formok">Banco não disponível para uso da classe</span>';
          return false;
      }
      
      $this->banco = $banco;
   }
   
   /**
    * Cria a instância do determinado banco
    *
    * @param array $params Parâmetros iniciais para construção do objeto
    * @return boolean
    */
   public function loadBank(array $params = array())
   {
      if (! isset(static::$classMap[$codBanco])) 
      {
         $this->erro = true;
         $this->mensagem .= '<span class="formok">Banco não disponível para uso da classe</span>';
         return false;
      }
      
      $class = __NAMESPACE__ . '\\Webservice\\' .static::$classMap[$this->banco].'Web';

      $this->bancoWebService = new $class($params);
      
      return true;
   }
   /**
    * Retorna a instância de um Banco através do código
    *
    * @param array $params Parâmetros iniciais para construção do objeto
    * @return boolean
    */
   public function loadSetup(array $params = array())
   {
      $this->loadBank($params);
      
      if ( $this->erro )
      {
         $this->mensagem .= '<span class="formok">Erro ao carregar configuração</span>';
         return false;
      }
      $this->bancoWebService->obterToken();
      if ( $this->bancoWebService->erro )
      {
         $this->erro = true;
         $this->mensagem .= '<span class="formok">Erro ao carregar token</span>' $this->bancoWebService->mensagem;
         return false;
      }
      return true;
   }
}
