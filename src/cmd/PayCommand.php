<?php

namespace DerCooleVonDem\EconomyLite\cmd;

use DerCooleVonDem\EconomyLite\EconomyLite;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class PayCommand extends Command {

    public function __construct()
    {
        parent::__construct("pay", "Pay someone", "/pay <name> <amount>");
        $this->setPermission("economylite.cmd.pay");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$this->testPermission($sender)) {
            return;
        }

        if(count($args) < 2) {
            $sender->sendMessage("Usage: /pay <name> <amount>");
            return;
        }

        $name = array_shift($args);
        $amount = array_shift($args);

        if(!is_numeric($amount)) {
            $sender->sendMessage("Amount must be a number");
            return;
        }

        $amount = (int) $amount;

        if($amount < 0) {
            $sender->sendMessage("Amount must be positive");
            return;
        }

        if(!EconomyLite::hasAccount($name)) {
            $sender->sendMessage("Player not found");
            return;
        }

        $result = EconomyLite::pay($sender->getName(), $name, $amount);

        if(!$result) {
            $sender->sendMessage("You don't have enough money");
            return;
        }

        $sender->sendMessage("Paid $amount to $name");
        EconomyLite::addPaymentHistory($sender->getName(), $name, $amount);
    }
}