<?php

namespace DerCooleVonDem\EconomyLite\cmd\sub;

use DerCooleVonDem\EconomyLite\config\LanguageProvider;
use DerCooleVonDem\EconomyLite\EconomyLite;
use pocketmine\command\CommandSender;

class AddSubCommand extends EconomyLiteSubCommand {

    public function __construct()
    {
        parent::__construct("add", LanguageProvider::getInstance()->tryGet("add-sub-description"), LanguageProvider::getInstance()->tryGet("add-sub-usage"), "economylite.sub.add");
    }

    public function execute(CommandSender $sender, array $args): void
    {
        if(count($args) < 2) {
            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("add-sub-usage"));
            return;
        }

        $name = $args[0];
        $amount = $args[1];

        // add to economy
        EconomyLite::addMoney($name, $amount);

        $sender->sendMessage(LanguageProvider::getInstance()->tryGet("add-sub-success", ["{AMOUNT}" => $amount, "{NAME}" => $name]));
        EconomyLite::addEconomyChange($sender->getName(), $amount);
        EconomyLite::addPaymentHistory("SERVER", $name, $amount);
    }
}