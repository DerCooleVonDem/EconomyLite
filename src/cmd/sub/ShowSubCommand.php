<?php

namespace DerCooleVonDem\EconomyLite\cmd\sub;

use DerCooleVonDem\EconomyLite\EconomyLite;
use pocketmine\command\CommandSender;

class ShowSubCommand extends EconomyLiteSubCommand {

    public function __construct()
    {
        parent::__construct("show", "Shows the balance of a player", "/economylite show <name>", "economylite.sub.show");
    }

    public function execute(CommandSender $sender, array $args): void
    {
        if(count($args) < 1) {
            $sender->sendMessage("Usage: " . $this->usage);
            return;
        }
        $player = $args[0];

        if(!EconomyLite::hasAccount($player)) {
            $sender->sendMessage("Player does not have an account");
            return;
        }

        $sender->sendMessage("The balance of " . $player . " is: " . EconomyLite::getMoney($player));
    }
}