<?php

namespace DerCooleVonDem\EconomyLite\cmd\sub;

use pocketmine\command\CommandSender;

class HelpSubCommand extends EconomyLiteSubCommand {

    public function __construct()
    {
        parent::__construct("help", "Help about the economylite commands", "/economylite help", "economylite.sub.help");
    }

    public function execute(CommandSender $sender, array $args): void
    {
        $sender->sendMessage("Get some help");
    }
}