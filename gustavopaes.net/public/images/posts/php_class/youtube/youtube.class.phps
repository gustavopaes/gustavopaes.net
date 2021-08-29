<?php
/**
 * Classe que trabalha com a API do YouTube.
 * Consegue:
 *  - obter listagem de vídeos de um determinado usuário
 *  - montar, através do resultado obtido, HTML da listagem
 *  - montar, através do resultado obtido, HTML embed do último
 *    vídeo cadastrado.
 *
 * @author Gustavo Paes <gustavopaes.net>
 * @copyright (c) 2011, Gustavo Paes
 * @version 1.3
 */

class Youtube {
	
	/**
	 * Usuário da listagem de vídeos
	 * @access private
	 * @var String
	 */
	private $user        = "";

	/**
	 * Máximo de resultados por request (resultados por página)
	 * @access private
	 * @var Int
	 */
	private $max_results = 10;

	/**
	 * Página atual.
	 * @access private
	 * @var Int
	 */
	private $page = 1;

	/**
	 * Obtém o retorno da API do YouTube
	 * @access private
	 * @var Mixed JSON Object
	 */
	private $response = null;

	/**
	 * Recebe os parâmetros de configuração para realizar o request
	 * na API do YouTube.
	 *
	 * @param Array $config user | max-results | page
	 */
	function __construct($config = array()) {
		if(isset($config['user'])) {
			$this->user = $config['user'];
		}

		if(isset($config['max-results'])) {
			$this->max_results = $config['max-results'];
		}

		if(isset($config['page'])) {
			$this->page = $config['page'];
		}
	}

	/**
	 * Realiza o request para a API do YouTube usando os parâmetros
	 * recebidos no __contruct do objeto.
	 *
	 * @return Object this
	 */
	public function request() {
		$start_index = $this->page == 1 ? 1 : (($this->page - 1) * $this->max_results) + 1;
		$url = 'http://gdata.youtube.com/feeds/api/users/' . $this->user . '/uploads?alt=json&max-results=' . $this->max_results . '&start-index=' . $start_index;

		$request = curl_init($url);
		curl_setopt($request, CURLOPT_RETURNTRANSFER, TRUE);
		$this->response = json_decode(curl_exec($request));
		curl_close($request);

		return $this;
	}


	/**
	 * Usando o retorno do método request(), monta o markup
	 * HTML da listagem de vídeos.
	 *
	 * @param String $template Nome do template que deverá ser usado
	 * @return String Markup HTML
	 */
	public function templateList($template = "list.tpl") {
		if(!file_exists($template) || !$this->response)
			return false;

		$template = file_get_contents($template);
		$output   = '';

		foreach($this->response->{"feed"}->{"entry"} as $video) {
			$infos = $this->getVideoInfos($video);
			
			$video_output = $template;
			$video_output = str_replace("{link}", $infos['link'], $video_output);
			$video_output = str_replace("{id}", $infos['id'], $video_output);
			$video_output = str_replace("{title}", $infos['title'], $video_output);
			$video_output = str_replace("{duration}", $infos['duration'], $video_output);
			
			$output .= $video_output;
		}
		
		return $output;
	}

	/**
	 * Monta o código embed do player usando as informações do vídeo
	 * passada no parâmetro $video.
	 *
	 * @param String $template Nome do template que deverá ser usado
	 * @param Mixed JSON Object $video Objeto com as informações do vídeo para montar o embed
	 * @return String Markup HTML
	 */
	public function playerEmbed($template = 'embed.tpl', $video = array()) {
		if(!file_exists($template) || !count($video))
			return false;
		
		$infos = $this->getVideoInfos($video);
		
		$template = file_get_contents($template);
		$template = str_replace("{id}", $infos['id'], $template);
		
		return $template;
	}

	/**
	 * Recebe um Mixed Json com as informações do vídeo e transforma
	 * em um array mais simples e com dados já tratados.
	 *
	 * @param Mixed JSON Object $video Informações do vídeo
	 * @return Array
	 */
	public function getVideoInfos($video) {
		$infos = array(
			"title" => $video->{'title'}->{'$t'}
		);
	
		// procura pelo link do youtube
		foreach($video->{'link'} as $link) {
			if($link->{'type'} == 'text/html' && $link->{'rel'} == 'alternate') {
				$infos["link"] = $link->{'href'};
				break;
			}
		}
	
		// procura pelo link do player
		foreach($video->{'media$group'}->{'media$content'} as $media) {
			if($media->{'type'} == 'application/x-shockwave-flash' && $media->{'isDefault'} == 'true') {
				$infos["flash"]    = $media->{'url'};
				$infos["duration"] = $media->{'duration'};
				break;
			}
		}

		// obtém o ID do vídeo
		if(isset($infos["link"])) {
			preg_match('/\?v=([a-zA-Z0-9-_]+)/', $infos["link"], $id);
			if($id) {
				$infos["id"] = $id[1];
			}
		}

		return $infos;
	}

	/**
	 * Obtém as informações do primeiro vídeo da listagem.
	 * 
	 * @return Mixed JSON Object | Array(0)
	 */
	public function getFirstVideo() {
		if(count($this->response->{"feed"}->{"entry"}))
			return $this->response->{"feed"}->{"entry"}[0];
		
		return array();
	}
}
?>
