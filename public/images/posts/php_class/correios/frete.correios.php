<?php

/**
 * Create a link by joining the given URL and the parameters given as the second argument.
 * Arguments :  $url - The base url.
 *                $params - An array containing all the parameters and their values.
 *                $use_existing_arguments - Use the parameters that are present in the current page
 * Return : The new url.
 * Example : 
 *            getLink("http://www.google.com/search",array("q"=>"binny","hello"=>"world","results"=>10));
 *                    will return
 *            http://www.google.com/search?q=binny&amp;hello=world&amp;results=10
 */
function getLink($url,$params=array(),$use_existing_arguments=false) {
    if($use_existing_arguments) $params = $params + $_GET;
    if(!$params) return $url;
    $link = $url;
    if(strpos($link,'?') === false) $link .= '?'; //If there is no '?' add one at the end
    elseif(!preg_match('/(\?|\&(amp;)?)$/',$link)) $link .= '&amp;'; //If there is no '&' at the END, add one.
    
    $params_arr = array();
    foreach($params as $key=>$value) {
        if(gettype($value) == 'array') { //Handle array data properly
            foreach($value as $val) {
                $params_arr[] = $key . '[]=' . urlencode($val);
            }
        } else {
            $params_arr[] = $key . '=' . urlencode($value);
        }
    }
    $link .= implode('&',$params_arr);
    
    return $link;
} 

class Correios {

	/**
	 * Contem as informa��es retornadas ap�s a consulta ao correio.
	 **/
	private $info = array();

	/**
	 * URL do webservice do correio
	 **/
	private $correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx";

	/**
	 * C�digo dos servi�os do correio, seguindo a tabela:
	 * 41106	PAC sem contrato
	 * 40010	SEDEX sem contrato
	 * 40045	SEDEX a Cobrar, sem contrato
	 * 40215	SEDEX 10, sem contrato
	 * 40290	SEDEX Hoje, sem contrato
	 * 40096	SEDEX com contrato
	 * 40436	SEDEX com contrato
	 * 40444	SEDEX com contrato
	 * 81019	e-SEDEX, com contrato
	 * 41068	PAC com contrato
	 **/
	private $servicos = array(41106, 40010, 40045, 40215, 40290, 40096, 40436, 81019, 41068, 40444);

	/**
	 * Par�metros de configura��o que ser�o enviados para os correios.
	 **/
	private $params = array(
		"nCdEmpresa" => "",
		"sDsSenha" => "",
		
		# C�digo do servi�o.
		# Deve estar presente no array $servicos
		"nCdServico" => 41106,
		
		# CEP de origem
		"sCepOrigem" => "",

		# CEP de destino
		"sCepDestino" => "",
		
		# Peso da encomenda, incluindo sua embalagem.
		# O peso deve ser informado em quilogramas.
		"nVlPeso" => 0.0,
		
		# Formato da encomenda
		# 1 - Formato caixa/pacote
		# 2 - Formato rolo/prisma
		"nCdFormato" => 1,

		# Comprimento da encomenda (incluindo embalagem), em cent�metros.
		# Se o servi�o n�o exigir as medidas informar zero.
		"nVlComprimento" => 0.0,

		# Altura da encomenda (incluindo embalagem), em cent�metros.
		# Se o servi�o n�o exigir medidas informar zero.
		"nVlAltura" => 0.0,

		# Largura da encomenda (incluindo embalagem), em cent�metros.
		# Se o servi�o n�o exigir medidas informar zero.
		"nVlLargura" => 0.0,

		# Di�metro da encomenda (incluindo embalagem), em cent�metros.
		# Se o servi�o n�o exigir medidas informar zero.
		"nVlDiametro" => 0.0,

		# Indica se a encomenda ser� entregue com o servi�o adicional m�o pr�pria.
		# S - Sim
		# N - N�o
		"sCdMaoPropria" => "N",

		# Indica se a encomenda ser� entregue com o servi�o adicional valor declarado.
		# Deve ser apresentado o valor declarado desejado, em Reais.
		"nVlValorDeclarado" => 0.0,

		# Indica se a encomenda ser� entregue com o servi�o adicional aviso de recebimento.
		# S - Sim
		# N - N�o
		"sCdAvisoRecebimento" => "N",

		# Indica a forma de retorno da consulta
		"StrRetorno" => "XML"
	);

	/**
	 * Envia uma requisi��o para o site dos correios.
	 *
	 * @return String XML retornado pelos correios
	 **/
	private function send() {
		$ch  = curl_init(getLink($this->correios, $this->params));

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_VERBOSE, TRUE);

		$return = curl_exec($ch);
		curl_close($ch);

		return $return;
	}


	/**
	 * Faz a defini��o de um par�metro de configura��o.
	 *
	 * As op��es s�o:
	 *
	 * Int servico: Tipo de servi�o para calcular o frete (Array $servicos)
	 * String origem: CEP de origem
	 * String destino: CEP de destino
	 * Float peso: Peso do pacote
	 * Int formato: Formato da encomenda (vide nCdFormato)
	 * Float comprimento: Comprimento da encomenda, em cm
	 * Float largura: Largura da encomenda, em cm
	 * Float altura: Altura da encomenda, em cm
	 * Float diametro: Diametro da encomenda, em cm
	 * Boolean maopropria: Se ir� utilizar o servi�o de m�o pr�pria
	 * Boolean avisorecebimento: Se ir� utilizar o servi�o de aviso de recebimento
	 **/
	public function set($tipo, $valor) {
		switch($tipo) {
			case "servico":
				if(!in_array($valor, $this->servicos)) {
					return false;
				}

				$this->params["nCdServico"] = (string)$valor;
			break;
		
			case "origem":
				$this->params["sCepOrigem"] = $valor;
			break;

			case "destino":
				$this->params["sCepDestino"] = $valor;
			break;

			case "peso":
				$this->params["nVlPeso"] = $valor;
			break;

			case "formato":
				$this->params["nCdFormato"] = (int)$valor;
			break;

			case "comprimento":
				$this->params["nVlComprimento"] = $valor;
			break;

			case "largura":
				$this->params["nVlLargura"] = $valor;
			break;

			case "altura":
				$this->params["nVlAltura"] = $valor;
			break;

			case "diametro":
				$this->params["nVlDiametro"] = $valor;
			break;

			case "maopropria":
				$this->params["sCdMaoPropria"] = $valor ? "S" : "N";
			break;

			case "avisorecebimento":
				$this->params["sCdAvisoRecebimento"] = $valor ? "S" : "N";
			break;

			case "valordeclarado":
				$this->params["nVlValorDeclarado"] = $valor;
			break;
		}

		return true;
	}

	/**
	 * Faz a requisi��o das informa��es para o site dos correios
	 * e trata o XML retornado. Armazena as informa��es em um array.
	 *
	 * @return Boolean
	 **/
	public function get() {
		$xml = $this->send();

		preg_match('/<Erro>(?P<codigo_erro>.+)<\/Erro>(.*<MsgErro>(?P<msg_erro>.+)<\/MsgErro>)?/i', $xml, $xml_erro);

		// Se n�o encontrar erro
		if((int)$xml_erro['codigo_erro'] === 0) {
			preg_match('/<Valor>(?P<valor>.+)<\/Valor>/i', $xml, $valor);
			preg_match('/<PrazoEntrega>(?P<valor>.+)<\/PrazoEntrega>/i', $xml, $prazo);
			preg_match('/<ValorMaoPropria>(?P<valor>.+)<\/ValorMaoPropria>/i', $xml, $maopropria);
			preg_match('/<ValorAvisoRecebimento>(?P<valor>.+)<\/ValorAvisoRecebimento>/i', $xml, $avisorecebimento);
			preg_match('/<ValorValorDeclarado>(?P<valor>.+)<\/ValorValorDeclarado>/i', $xml, $valordeclarado);
			preg_match('/<EntregaDomiciliar>(?P<valor>.+)<\/EntregaDomiciliar>/i', $xml, $entregadomiciliar);
			preg_match('/<EntregaSabado>(?P<valor>.+)<\/EntregaSabado>/i', $xml, $entregasabado);

			$this->info = array(
				"erro"                  => null,
				"valor"                 => (float)$valor['valor'],
				"prazo"                 => (int)$prazo['valor'],
				"maopropria"            => (float)$maopropria['valor'],
				"avisorecebimento" => (float)$avisorecebimento['valor'],
				"valordeclarado"        => (float)$valordeclarado['valor'],
				"entregadomiciliar"     => $entregadomiciliar['valor'] == "S" ? true : false,
				"entregasabado"         => $entregasabado['valor'] == "S" ? true : false
			);
		}
		else {
			$this->info = array(
				"erro" => sprintf("[%s] %s", $xml_erro['codigo_erro'], $xml_erro['msg_erro'])
			);
		}

		return !$this->info["erro"] ? true : false;
	}

	/**
	 * Retorna o conte�do do par�metro solicitado.
	 * @param String Par�metros dispon�ves
	 *   erro: Mensagem de erro, caso tenha ocorrido
	 *   valor: Valor do frete
	 *   prazo: Prazo, em dias, para entrega
	 *   maopropria: Valor do servi�o de m�o pr�pria
	 *   avisorecebimento: Valor do servi�o de aviso de recebimento
	 *   valordeclarado: Valor declarado do produto
	 *   entregadomiciliar: Se h� entrega domiciliar para o CEP destino
	 *   entregasabado: Se h� entrega nos s�bados par ao CEP destino
	 **/
	public function read($val) {
		return $this->info[$val];
	}
}


$frete = new Correios();
$frete->set("servico", 41106);
$frete->set("origem", "01257090");
$frete->set("destino", "17017340");
$frete->set("valordeclarado", 9.580);
$frete->set("avisorecebimento", true);
$frete->set("altura", 3);
$frete->set("largura", 5);
$frete->set("comprimento", 25);
$frete->set("peso", 0.5);

if(!$frete->get()) {
	die($frete->read("erro"));
}

echo "Tipo de entrega: PAC";

echo "<br>";
echo "Total: R$ " . $frete->read("valor");

echo "<br>";
echo "Prazo de entrega: " . $frete->read("prazo") . " dia(s)";
?>



