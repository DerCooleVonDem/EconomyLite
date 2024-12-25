<?php

namespace DerCooleVonDem\EconomyLite\cmd\sub;

use DerCooleVonDem\EconomyLite\EconomyLite;
use pocketmine\command\CommandSender;

class RemoveSubCommand extends EconomyLiteSubCommand {

    public function __construct()
    {
        parent::__construct("remove", "Removes money from the economy", "/economylite remove <name> <amount>", "economylite.sub.remove");
    }

    public function execute(CommandSender $sender, array $args): void
    {
        if(!$sender->hasPermission($this->permission)) {
            $sender->sendMessage("You do not have permission to use this command");
            return;
        }

        if(count($args) < 2) {
            $sender->sendMessage("Usage: " . $this->usage);
            return;
        }

        $name = $args[0];
        $amount = $args[1];

        if(!is_numeric($amount)) {
            $sender->sendMessage("Amount must be a number");
            return;
        }

        EconomyLite::removeMoney($name, $amount);

        $sender->sendMessage("Removed $amount from $name");
        EconomyLite::addEconomyChange($sender->getName(), -$amount);
        EconomyLite::addPaymentHistory($name, "SERVER", $amount);
    }
}