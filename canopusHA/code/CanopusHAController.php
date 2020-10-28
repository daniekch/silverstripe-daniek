<?php

use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Request;

class CanopusHAController extends Controller {
	
	private $config;

	private static $allowed_actions = array(
			'RefreshIP',
			'ImageService',
			'Telegram_Bot_vdv4pQdMIqlgrz3FyjMJGIco0tVan6VN',
			'SendToTelegramBot_vdv4pQdMIqlgrz3FyjMJGIco0tVan6VN'
	);
	
	private $mysql_credentials = [
			'host'     => '*****',
			'user'     => '*****',
			'password' => '*****',
			'database' => '*****'
	];
	
	public function init() {
	
		$this->config = Config::inst();
		
		parent::init();
	}
	
	public function RefreshIP(SS_HTTPRequest $request) {
		
		if($request->isPOST()) {
			
			// Verify Basic Auth User
			if ($member = BasicAuth::requireLogin("IP Refresh")) {
					
				$ips = CanopusHAData::get();
				
				if($ips->exists()) {
					
					$ip = $ips->first();
				}
				else {
					
					$ip = new CanopusHAData();
				}
				
				$ip->IP = $request->getIP();
				$ip->write(false, false, true, false);
			
				$this->response->addHeader('content-type', "text/plain");
				$this->response->setBody("ok");
				$this->response->setStatusCode(204);
			}
			else {
			
				SS_Log::log('Home IP - Basic Auth is not valid from IP '.$request->getIP(), SS_Log::WARN);
				$this->response->setStatusCode(403);
			}
		}
		else {
			
			// Methode not allowed.
			$this->response->addHeader('Allow', 'POST');
			$this->response->setStatusCode(405);
		}
		
		return $this->response;
	}
	
	/**
	 * Interface for Telegram Bot API
	 * Receive information from Telegram and handel with CanopusHA Bot
	 * @param SS_HTTPRequest $request
	 */
	public function Telegram_Bot_vdv4pQdMIqlgrz3FyjMJGIco0tVan6VN(SS_HTTPRequest $request) {
		
		try {
			
			$commands_paths = [
				__DIR__  . '/Telegram/Commands/',
			];
			
			$telegram = new Telegram($this->config->get('CanopusHA_Bot', 'api_key'), $this->config->get('CanopusHA_Bot', 'bot_username'));
			$telegram->enableMySql($this->mysql_credentials);
			$telegram->enableAdmin($this->config->get('CanopusHA_Bot', 'admin'));
			$telegram->addCommandsPaths($commands_paths);
			$telegram->handle();
			
		} catch (TelegramException $e) {
			
			SS_Log::log($e, SS_Log::ERR);
		}
	}
	
	/**
	 * Interface for CanopusHA.
	 * Receive data from CanopusHA and redirect it to Telegram Bot API
	 */
	public function SendToTelegramBot_vdv4pQdMIqlgrz3FyjMJGIco0tVan6VN(SS_HTTPRequest $request) {
	
		if($request->isPOST()) {
			
			// Verify Basic Auth User
			if ($member = BasicAuth::requireLogin("IP Refresh")) {
				
				try {
					
					$telegram = new Telegram($this->config->get('CanopusHA_Bot', 'api_key'), $this->config->get('CanopusHA_Bot', 'bot_username'));
					
					if($request->postVar('action') == 'textmessage') {
						
						$message = $request->postVar('message');
						$result = Request::sendMessage(['chat_id' => 538830872, 'text' => $message]);
					}
					elseif ($request->postVar('action') == 'photomessage') {
												
						if ($request->postVar('photo')['name'] != ""){
					
							$target_dir = $this->config->get('Directories', 'tmp_upload');
							$filename = $request->postVar('photo')['name'];
							$temp_name = $request->postVar('photo')['tmp_name'];
							
							// Move file in temp folder.
							move_uploaded_file($temp_name, $target_dir.'/'.$filename);
							
							$result = Request::sendPhoto(['chat_id' => 538830872, 'photo' => Request::encodeFile($target_dir.'/'.$filename)]);
						}
					}
				} catch (Exception $e) {
					
					SS_Log::log($e, SS_Log::ERR);
				}
			}
		}
	}
	
	public function ImageService(SS_HTTPRequest $request) {
		
		if($request->isPOST()) {
				
			// Verify Basic Auth User
			if ($member = BasicAuth::requireLogin("IP Refresh")) {
				
				// if request from webcam upload
				if ($request->postVar('action') == 'webcamphoto' &&
					$request->postVar('photo')['name'] != "") {
						
					$target_dir = $this->config->get('Directories', 'tmp_upload').'/';
					$filename = $request->postVar('photo')['name'];
					$temp_name = $request->postVar('photo')['tmp_name'];
					
					$folderObject = DataObject::get_one("Folder", "`Filename` = '{$target_dir}'");
					$newImage = file_get_contents($temp_name);
					$oldImage = fopen($target_dir.$filename, 'w');
					fwrite($oldImage, $newImage);
					$closed = fclose($oldImage);
					
					if (!DataObject::get_one('Image', "`Name` = '{$filename}'"))	{
						
						$page = DataObject::get_one("CanopusHAPage");
						
						$imgObject = Object::create('Image');
						$imgObject->ParentID = $folderObject->ID;
						$imgObject->Name = $filename;
						$imgObject->OwnerID = (Member::currentUser() ? Member::currentUser()->ID : 0);
						$imgObject->write();
						
						$page->WebcamImageID = DataObject::get_one('Image', "`Name` = '{$filename}'")->ID;
						
					}

					if($closed) {

						$this->response->addHeader('content-type', "text/plain");
						$this->response->setBody("ok");
						$this->response->setStatusCode(200);
					}
				}
			}
			else {
					
				SS_Log::log('Home IP - Basic Auth is not valid from IP '.$request->getIP(), SS_Log::WARN);
				$this->response->setStatusCode(403);
			}
		}
		else {
				
			// Methode not allowed.
			$this->response->addHeader('Allow', 'POST');
			$this->response->setStatusCode(405);
		}
		
		return $this->response;
	}
}
