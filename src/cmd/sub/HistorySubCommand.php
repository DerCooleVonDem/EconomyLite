<?php

namespace DerCooleVonDem\EconomyLite\cmd\sub;

use DerCooleVonDem\EconomyLite\EconomyLite;
use pocketmine\command\CommandSender;

class HistorySubCommand extends EconomyLiteSubCommand {

    public function __construct()
    {
        parent::__construct("history", "Displays the payment history of given player", "/economylite history <name> [limit=100]", "economylite.sub.history");
    }

    public function execute(CommandSender $sender, array $args): void
    {
        if(count($args) < 1) {
            $sender->sendMessage("Usage: " . $this->usage);
            return;
        }

        $player = $args[0];
        $limit = $args[1] ?? "100";

        if(!EconomyLite::hasAccount($player)) {
            $sender->sendMessage("Player does not have an account");
            return;
        }

        $history = EconomyLite::getPaymentHistory($player);
        $sender->sendMessage("Payment history of " . $player . ":");


        if($limit !== null) {
            $history = array_slice($history, 0, $limit);
        }

        foreach($history as $payment) {
            // keys: receiver, sender, money, date
            $sender->sendMessage("(" . $payment["date"] . ") " . $payment["sender"] . " -> " . $payment["receiver"] . ": " . $payment["money"]);
        }
    }
}