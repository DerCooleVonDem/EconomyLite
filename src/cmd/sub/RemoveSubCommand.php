<?php

namespace DerCooleVonDem\EconomyLite\cmd\sub;

use DerCooleVonDem\EconomyLite\config\LanguageProvider;
use DerCooleVonDem\EconomyLite\EconomyLite;
use pocketmine\command\CommandSender;

class RemoveSubCommand extends EconomyLiteSubCommand {

    public function __construct()
    {
        parent::__construct("remove", LanguageProvider::getInstance()->tryGet("remove-sub-description"), LanguageProvider::getInstance()->tryGet("remove-sub-usage"), "economylite.sub.remove");
    }

    public function execute(CommandSender $sender, array $args): void
    {
        if(count($args) < 2) {
            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("remove-sub-usage"));
            return;
        }

        $name = $args[0];
        $amount = $args[1];

        if(!is_numeric($amount)) {
            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("remove-sub-amount-false-format"));
            return;
        }

        EconomyLite::removeMoney($name, $amount);

        $sender->sendMessage(LanguageProvider::getInstance()->tryGet("remove-sub-success", ["{AMOUNT}" => $amount, "{NAME}" => $name]));
        EconomyLite::addEconomyChange($sender->getName(), -$amount);
        EconomyLite::addPaymentHistory($name, "SERVER", $amount);
    }
}