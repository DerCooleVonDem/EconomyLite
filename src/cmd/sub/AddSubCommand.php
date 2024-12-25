<?php

namespace DerCooleVonDem\EconomyLite\cmd\sub;

use DerCooleVonDem\EconomyLite\EconomyLite;
use pocketmine\command\CommandSender;

class AddSubCommand extends EconomyLiteSubCommand {

    public function __construct()
    {
        parent::__construct("add", "Adds money into the economy", "/economylite give <name> <amount>", "economylite.sub.add");
    }

    public function execute(CommandSender $sender, array $args): void
    {
        if(count($args) < 2) {
            $sender->sendMessage("Usage: /economylite give <name> <amount>");
            return;
        }

        $name = $args[0];
        $amount = $args[1];

        // add to economy
        $result = EconomyLite::addMoney($name, $amount);

        if(!$result) {
            $sender->sendMessage("Amount would exceed the limit of allowed money");
            return;
        }

        $sender->sendMessage("Added $amount to $name");
        EconomyLite::addEconomyChange($sender->getName(), $amount);
        EconomyLite::addPaymentHistory("SERVER", $name, $amount);
    }
}