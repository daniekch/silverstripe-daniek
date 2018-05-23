<?php

use Longman\TelegramBot\Entities\InlineKeyboard;

use SocketService;
use Config;
use function GuzzleHttp\json_decode;

class TelegramService {
	
	private $config;
	private $socketService;
	
	function __construct() {
	
		$this->config = Config::inst();
		$this->socketService = new SocketService();
	}
	
	/**
	 * Authenticate user by ID.
	 */
	public function Authentication($user) {
		
		$allowed_users = $this->config->get('CanopusHA_Bot', 'auth_users');
		
		if (in_array($user->getId(), $allowed_users)) {
			
			return $user->getFirstName();
		}
		
		return null;
	}
	
	/**
	 * Genearate the home Keyboard.
	 */
	public function GetHomeKeyboard($message) {
		
		$inline_keyboard = new InlineKeyboard(
			[
				['text' => 'Licht', 'callback_data' => 'Light'],
				['text' => 'Kamera', 'callback_data' => 'Camera']
			],
			[
				['text' => 'Tools', 'callback_data' => 'Tool']
			],
			[
				['text' => 'Web Interface', 'url' => 'https://www.daniek.ch/tools/canopusha']
			]);
		
		$data = [
			'chat_id'		=>	$message->getChat()->getId(),
			'message_id'	=>	$message->getMessageId(),
			'text'			=> 	TelegramHelper::Salutation().', was darf ich bedienen?',
			'reply_markup'	=> 	$inline_keyboard,
		];
		
		return $data;
	}
	
	/**
	 * Generate the Light switch keyboard.
	 */
	public function GetLightKeyboard($message) {
		
		$status = $this->socketService->sendData('LightStatus-'.$this->config->get('Raspberry_Pi', 'Relais_1'));
		
		$inline_keyboard = new InlineKeyboard(
			[
				['text' => 'Licht 1 ('.$status.')', 'callback_data' => 'LightSwitch-'.$this->config->get('Raspberry_Pi', 'Relais_1')]
			],
			[
				['text' => 'Home', 'callback_data' => 'Home']
			]);
		 
		$data = [
			'chat_id'      	=>	$message->getChat()->getId(),
			'message_id'	=>	$message->getMessageId(),
			'text'         	=>	'Waehle ein Lichtschalter:',
			'reply_markup' 	=>	$inline_keyboard,
		];
		
		return $data;
	}
	
	/**
	 * Generate the Alarm switch keyboard.
	 */
	public function GetToolKeyboard($message) {
	
		$alarmstatus = $this->socketService->sendData('AlarmStatus-1');
		$sunsetstatus = $this->socketService->sendData('SunsetStatus-1');
	
		$inline_keyboard = new InlineKeyboard(
				[
					['text' => 'Inhouse Control ('.$alarmstatus.')', 'callback_data' => 'AlarmSwitch-1']
				],
				[
					['text' => 'Sunset Callback ('.$sunsetstatus.')', 'callback_data' => 'SunsetSwitch-1']
				],
				[
					['text' => 'Home', 'callback_data' => 'Home']
				]);
		
		$data = [
				'chat_id'      	=>	$message->getChat()->getId(),
				'message_id'	=>	$message->getMessageId(),
				'text'         	=>	'Weitere Tools auf CanopusHA:',
				'reply_markup' 	=>	$inline_keyboard,
		];
	
		return $data;
	}
	
	/**
	 * Generate the Light switch keyboard.
	 */
	public function GetCameraKeyboard($message) {
		
		$status = $this->socketService->sendData('VideoStreamStatus-1');
		$status = ($status == 'OFF') ? 'einschalten' : 'ausschalten';
	
		$inline_keyboard = new InlineKeyboard(
			[
				['text' => 'Sende Bild', 'callback_data' => 'CameraPicture']
			],
			[
				['text' => 'Videostream '.$status, 'callback_data' => 'VideoStreamSwitch']
			],
			[
				['text' => 'Camera Control', 'callback_data' => 'CameraControl']
			],
			[
				['text' => 'Home', 'callback_data' => 'Home']
			]);
			
		$data = [
				'chat_id'      	=>	$message->getChat()->getId(),
				'message_id'	=>	$message->getMessageId(),
				'text'         	=>	'Waehle eine Kamerafunktion:',
				'reply_markup' 	=>	$inline_keyboard
		];
	
		return $data;
	}
	
	public function GetCameraControlKeyboard($message) {
		
		$inline_keyboard = new InlineKeyboard(
				[
					['text' => "\xF0\x9F\x91\x86", 'callback_data' => 'ServoUp']
				],
				[
					['text' => "\xF0\x9F\x91\x88", 'callback_data' => 'ServoLeft'],
					['text' => "\xF0\x9F\x91\x89", 'callback_data' => 'ServoRight']
				],
				[
					['text' => "\xF0\x9F\x91\x87", 'callback_data' => 'ServoDown']
				],
				[
					['text' => 'OUT', 'callback_data' => 'ServoWebcam'],
					['text' => 'IN', 'callback_data' => 'ServoInhouse']
				],
				[
					['text' => "Back", 'callback_data' => 'Camera']
				]);
			
		$data = [
				'chat_id'      	=>	$message->getChat()->getId(),
				'message_id'	=>	$message->getMessageId(),
				'text'         	=>	"Waehle eine Poistion:",
				'reply_markup' 	=>	$inline_keyboard
		];
		
		return $data;
	}
	
	/**
	 * Perform light switch action.
	 */
	public function ActionLight($message, $callback_data) {
		
		$this->socketService->sendData($callback_data);
		
		return $this->GetLightKeyboard($message);
	}
	
	/**
	 * Perform alarm switch action.
	 */
	public function ActionAlarm($message, $callback_data) {
	
		$this->socketService->sendData($callback_data);
	
		return $this->GetToolKeyboard($message);
	}
	
	/**
	 * Perform Sunset switch action.
	 */
	public function ActionSunset($message, $callback_data) {
	
		$this->socketService->sendData($callback_data);
	
		return $this->GetToolKeyboard($message);
	}
	
	/**
	 * Generate message for no authenficated user.
	 */
	public function GetNoAuthMessage($message) {
		
		$data = [
			'chat_id'		=>	$message->getChat()->getId(),
			'message_id'	=>	$message->getMessageId(),
			'text'			=> 	TelegramHelper::Salutation().' '.$message->getFrom()->getFirstName().'. Ich mag mich nicht so recht an Sie erinnern...'
		];
		
		return $data;
	}
	
	/**
	 * Send picture generate command
	 */
	public function ActionCameraPicture($message) {
		
		$this->socketService->sendData('CameraPicture-1');
		
		$data = [
				'chat_id'      	=>	$message->getChat()->getId(),
				'message_id'	=>	$message->getMessageId(),
				'text'         	=>	'Gerne, ich melde mich gleich bei dir. Bis dann!'
		];
		
		return $data;
	}
	
	/**
	 * Switch Stream ON or OFF
	 */
	public function ActionVideoStream($message) {
	
		$this->socketService->sendData('VideoStreamSwitch-1');
	
		return $this->GetCameraKeyboard($message);
	}
	
	/**
	 * Turn servo motor left
	 */
	public function ActionServoLeft($message) {
	
		$this->socketService->sendData('ServoLeft-1');
	
		return $this->GetCameraControlKeyboard($message);
	}
	
	/**
	 * Turn servo motor left
	 */
	public function ActionServoRight($message) {
	
		$this->socketService->sendData('ServoRight-1');
	
		return $this->GetCameraControlKeyboard($message);
	}
	
	/**
	 * Turn servo motor up
	 */
	public function ActionServoUp($message) {
	
		$this->socketService->sendData('ServoUp-1');
	
		return $this->GetCameraControlKeyboard($message);
	}
	
	/**
	 * Turn servo motor down
	 */
	public function ActionServoDown($message) {
	
		$this->socketService->sendData('ServoDown-1');
	
		return $this->GetCameraControlKeyboard($message);
	}
	
	/**
	 * Turn servo motor to webcam
	 */
	public function ActionServoWebcam($message) {
	
		$this->socketService->sendData('ServoWebcam-1');
	
		return $this->GetCameraControlKeyboard($message);
	}
	
	/**
	 * Turn servo motor to inhouse
	 */
	public function ActionServoInhouse($message) {
	
		$this->socketService->sendData('ServoInhouse-1');
	
		return $this->GetCameraControlKeyboard($message);
	}
}