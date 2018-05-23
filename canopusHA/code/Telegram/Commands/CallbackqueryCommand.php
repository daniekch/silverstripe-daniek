<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Request;

use TelegramService;
use Config;

/**
 * Callback query command
 *
 * This command handles all callback queries sent via inline keyboard buttons.
 *
 * @see InlinekeyboardCommand.php
 */
class CallbackqueryCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'callbackquery';

    /**
     * @var string
     */
    protected $description = 'Reply to callback query';

    /**
     * @var string
     */
    protected $version = '1.1.1';

    /**
     * Command execute method
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute() {
    	
    	$config = Config::inst();
    	
        $callback_query    	= $this->getCallbackQuery();
        $callback_query_id 	= $callback_query->getId();
        $callback_data     	= $callback_query->getData();
        $message			= $callback_query->getMessage();
        
        $telegramService = new TelegramService();
        
        // Generate Callback answers
        if($callback_data == 'Light') {
        	
        	return Request::editMessageText($telegramService->GetLightKeyboard($message));
        }
        elseif ($callback_data == 'LightSwitch-'.$config->get('Raspberry_Pi', 'Relais_1')) {
		
	        return Request::editMessageText($telegramService->ActionLight($message, $callback_data));
        }
        elseif ($callback_data == 'Tool') {
        
        	return Request::editMessageText($telegramService->GetToolKeyboard($message));
        }
        elseif ($callback_data == 'AlarmSwitch-1') {
        
        	return Request::editMessageText($telegramService->ActionAlarm($message, $callback_data));
        }
        elseif ($callback_data == 'SunsetSwitch-1') {
        
        	return Request::editMessageText($telegramService->ActionSunset($message, $callback_data));
        }
        elseif ($callback_data == 'Camera') {
			
        	return Request::editMessageText($telegramService->GetCameraKeyboard($message));
        }
        elseif ($callback_data == 'CameraPicture') {
        		
        	return Request::sendMessage($telegramService->ActionCameraPicture($message));
        }
        elseif ($callback_data == 'VideoStreamSwitch') {
        
        	return Request::editMessageText($telegramService->ActionVideoStream($message));
        }
        elseif ($callback_data == 'CameraControl') {
        		
        	return Request::editMessageText($telegramService->GetCameraControlKeyboard($message));
        }
        elseif ($callback_data == 'ServoLeft') {
        
        	return Request::editMessageText($telegramService->ActionServoLeft($message));
        }
        elseif ($callback_data == 'ServoRight') {
        
        	return Request::editMessageText($telegramService->ActionServoRight($message));
        }
        elseif ($callback_data == 'ServoUp') {
        
        	return Request::editMessageText($telegramService->ActionServoUp($message));
        }
        elseif ($callback_data == 'ServoDown') {
        
        	return Request::editMessageText($telegramService->ActionServoDown($message));
        }
        elseif ($callback_data == 'ServoWebcam') {
        
        	return Request::editMessageText($telegramService->ActionServoWebcam($message));
        }
        elseif ($callback_data == 'ServoInhouse') {
        
        	return Request::editMessageText($telegramService->ActionServoInhouse($message));
        }
        elseif ($callback_data == 'Home') {
        	
        	return Request::editMessageText($telegramService->GetHomeKeyboard($message));
        }
        
		return Request::emptyResponse();
    }
}