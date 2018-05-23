<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;

use TelegramService;

class HelloCommand extends UserCommand {
	
    protected $name = 'hello';
    protected $description = 'Weak Up CanopsHA Bot';
    protected $usage = '/hello';
    protected $version = '1.0.0';

    public function execute() {
    	
    	$message = $this->getMessage();
    	$user = $this->getMessage()->getFrom();
    	
    	$telegramService = new TelegramService();
    	
    	if ($telegramService->Authentication($user) !== null) {
    		
    		return Request::sendMessage($telegramService->GetHomeKeyboard($message));
    	}
        
        return Request::sendMessage($telegramService->GetNoAuthMessage($message));
    }
}
