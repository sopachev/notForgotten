<?php

	class bungieNet
	{
		private $apiKey = 'YOUR API KEY';
		private $debug = false; // Выводить ли отладочную информацию методом $this->debug
		
		public function __construct()
		{
			$this->debug('bungieNet constructor');
		}
		
		public function checkNotForgotten($nick)
		{
			if($user = $this->getUserByNick($nick))
			{
				$this->debug($user, 'User found');
				if($this->checkUserHasItem($user, '3260604717'))
				{
					$this->debug($nick.' has');
					return true;
				}
				else $this->debug($nick.' hasn\'t');
			}
			return false;
		}
		
		private function getUserByNick($nick)
		{
			if($response = $this->call('/Destiny2/SearchDestinyPlayer/-1/'.str_replace('#', '%23', $nick).'/'))
			{
				if(isset($response['Response']) && is_array($response['Response']) && isset($response['Response'][0]))
					return $response['Response'][0];
			}
			return false;
		}
		
		private function checkUserHasItem($user, $item)
		{
			if($response = $this->call('/Destiny2/'.$user['membershipType'].'/Profile/'.$user['membershipId'].'/?components=Collectibles'))
			{
				if(	isset($response['Response']) && 
					isset($response['Response']['profileCollectibles']) && 
					isset($response['Response']['profileCollectibles']['data']) && 
					isset($response['Response']['profileCollectibles']['data']['collectibles']) && 
					isset($response['Response']['profileCollectibles']['data']['collectibles'][$item]) && 
					isset($response['Response']['profileCollectibles']['data']['collectibles'][$item]['state']) && 
					$response['Response']['profileCollectibles']['data']['collectibles'][$item]['state'] === 0
				) return true;
			}
			return false;
		}
		
		private function call($url)
		{
			if(strpos($url, 'https://www.bungie.net/Platform') !== 0) $url = 'ht'.'tps://www.bungie.net/Platform'.$url;
			$this->debug('Calling '.$url);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-Key: '.$this->apiKey));
			$response = curl_exec($ch);
			if($response && $jsonResponse = json_decode($response, true))
			{
				$this->debug($jsonResponse, 'Response (json)');
				if(isset($jsonResponse['ErrorCode']) && $jsonResponse['ErrorCode'] == 1)
					return $jsonResponse;
			}
			else $this->debug($response, 'Response');
			return false;
		}
		
		private function debug($data, $title = false)
		{
			if(is_array($data)) $data = print_r($data, true);
			if($title) $data = $title.': '.$data;
			$data = date('y.m.d H:i:s ').$data;
			if($this->debug) echo $data."\n";
		}
		
		public function __destruct()
		{
			$this->debug('bungieNet destructor');
		}
	}

?>