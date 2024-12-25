<?php

namespace DerCooleVonDem\EconomyLite\cmd;

use DerCooleVonDem\EconomyLite\EconomyLite;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class PurseCommand extends Command {

    public function __construct()
    {
        parent::__construct("purse", "Shows how much money you have", "/economylite purse");
        $this->setPermission("economylite.cmd.purse");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!EconomyLite::hasAccount($sender->getName())) {
            $sender->sendMessage("You don't have an account");
            return;
        }

        $sender->sendMessage("You have " . EconomyLite::getMoney($sender->getName()) . " money");

        $paymentHistory = EconomyLite::getPaymentHistory($sender->getName());
        // only the first 5 payments
        $paymentHistory = array_slice($paymentHistory, 0, 5);
        if(count($paymentHistory) === 0) {
            $sender->sendMessage("\nNo payments");
            return;
        }

        $sender->sendMessage("\nRecent payments:");
        foreach($paymentHistory as $payment) {
            if($payment["sender"] === $sender->getName()) {
                $sender->sendMessage("(" . $payment["date"] . ") You paid " . $payment["receiver"] . " " . $payment["money"] . " money");
            } else {
                $sender->sendMessage("(" . $payment["date"] . ") " . $payment["sender"] . " paid you " . $payment["money"] . " money");
            }
        }
    }
}