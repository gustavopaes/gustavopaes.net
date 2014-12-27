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
	 * Contem as informações retornadas após a consulta ao correio.
	 **/
	private $info = array();

	/**
	 * URL do webservice do correio
	 **/
	private $correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx";

	/**
	 * Código dos serviços do correio, seguindo a tabela:
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
	 * Parâmetros de configuração que serão enviados para os correios.
	 **/
	private $params = array(
		"nCdEmpresa" => "",
		"sDsSenha" => "",
		
		# Código do serviço.
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

		# Comprimento da encomenda (incluindo embalagem), em centímetros.
		# Se o serviço não exigir as medidas informar zero.
		"nVlComprimento" => 0.0,

		# Altura da encomenda (incluindo embalagem), em centímetros.
		# Se o serviço não exigir medidas informar zero.
		"nVlAltura" => 0.0,

		# Largura da encomenda (incluindo embalagem), em centímetros.
		# Se o serviço não exigir medidas informar zero.
		"nVlLargura" => 0.0,

		# Diâmetro da encomenda (incluindo embalagem), em centímetros.
		# Se o serviço não exigir medidas informar zero.
		"nVlDiametro" => 0.0,

		# Indica se a encomenda será entregue com o serviço adicional mão própria.
		# S - Sim
		# N - Não
		"sCdMaoPropria" => "N",

		# Indica se a encomenda será entregue com o serviço adicional valor declarado.
		# Deve ser apresentado o valor declarado desejado, em Reais.
		"nVlValorDeclarado" => 0.0,

		# Indica se a encomenda será entregue com o serviço adicional aviso de recebimento.
		# S - Sim
		# N - Não
		"sCdAvisoRecebimento" => "N",

		# Indica a forma de retorno da consulta
		"StrRetorno" => "XML"
	);

	/**
	 * Envia uma requisição para o site dos correios.
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
	 * Faz a definição de um parâmetro de configuração.
	 *
	 * As opções são:
	 *
	 * Int servico: Tipo de serviço para calcular o frete (Array $servicos)
	 * String origem: CEP de origem
	 * String destino: CEP de destino
	 * Float peso: Peso do pacote
	 * Int formato: Formato da encomenda (vide nCdFormato)
	 * Float comprimento: Comprimento da encomenda, em cm
	 * Float largura: Largura da encomenda, em cm
	 * Float altura: Altura da encomenda, em cm
	 * Float diametro: Diametro da encomenda, em cm
	 * Boolean maopropria: Se irá utilizar o serviço de mão própria
	 * Boolean avisorecebimento: Se irá utilizar o serviço de aviso de recebimento
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
	 * Faz a requisição das informações para o site dos correios
	 * e trata o XML retornado. Armazena as informações em um array.
	 *
	 * @return Boolean
	 **/
	public function get() {
		$xml = $this->send();

		preg_match('/<Erro>(?P<codigo_erro>.+)<\/Erro>(.*<MsgErro>(?P<msg_erro>.+)<\/MsgErro>)?/i', $xml, $xml_erro);

		// Se não encontrar erro
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
	 * Retorna o conteúdo do parâmetro solicitado.
	 * @param String Parâmetros disponíves
	 *   erro: Mensagem de erro, caso tenha ocorrido
	 *   valor: Valor do frete
	 *   prazo: Prazo, em dias, para entrega
	 *   maopropria: Valor do serviço de mão própria
	 *   avisorecebimento: Valor do serviço de aviso de recebimento
	 *   valordeclarado: Valor declarado do produto
	 *   entregadomiciliar: Se há entrega domiciliar para o CEP destino
	 *   entregasabado: Se há entrega nos sábados par ao CEP destino
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



