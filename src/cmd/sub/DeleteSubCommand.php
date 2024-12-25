<?php

namespace DerCooleVonDem\EconomyLite\cmd\sub;

use DerCooleVonDem\EconomyLite\EconomyLite;
use pocketmine\command\CommandSender;

class DeleteSubCommand extends EconomyLiteSubCommand {

    public function __construct()
    {
        parent::__construct("delete", "Deletes the account of a player", "/economylite delete <name>", "economylite.sub.delete");
    }

    public function execute(CommandSender $sender, array $args): void
    {
        if(count($args) < 1) {
            $sender->sendMessage("Usage: " . $this->usage);
            return;
        }

        if(!EconomyLite::hasAccount($args[0])) {
            $sender->sendMessage("Player does not have an account");
            return;
        }

        $playerMoney = EconomyLite::getMoney($args[0]);
        EconomyLite::addEconomyChange($sender->getName(), -$playerMoney);
        EconomyLite::deleteAccount($args[0]);
        $sender->sendMessage("Deleted account of " . $args[0]);
    }

}