<?php

namespace DerCooleVonDem\EconomyLite\cmd;

use DerCooleVonDem\EconomyLite\config\LanguageProvider;
use DerCooleVonDem\EconomyLite\EconomyLite;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\console\ConsoleCommandSender;
use pocketmine\plugin\PluginOwnedTrait;

class PayCommand extends Command {

    use PluginOwnedTrait;

    public function __construct()
    {
        parent::__construct("pay", LanguageProvider::getInstance()->tryGet("pay-cmd-description"), LanguageProvider::getInstance()->tryGet("pay-cmd-usage"));
        $this->setPermission("economylite.cmd.pay");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof ConsoleCommandSender) {
            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("pay-cmd-console"));
            return;
        }

        if(!$this->testPermission($sender)) {
            return;
        }

        if(count($args) < 2) {
            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("pay-cmd-usage"));
            return;
        }

        $name = array_shift($args);
        $amount = array_shift($args);

        if(!is_numeric($amount)) {
            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("pay-cmd-amount-false-format"));
            return;
        }

        $amount = (int) $amount;

        if($amount < 0) {
            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("pay-cmd-amount-is-negative"));
            return;
        }

        EconomyLite::hasAccount($name)->onCompletion(function($exists) use ($sender, $name, $amount) {
            if(!$exists) {
                $sender->sendMessage(LanguageProvider::getInstance()->tryGet("pay-cmd-not-found"));
                return;
            }

            EconomyLite::getMoney($sender->getName())->onCompletion(function($senderMoney) use ($sender, $amount, $name) {
                if($senderMoney < $amount) {
                    $sender->sendMessage(LanguageProvider::getInstance()->tryGet("pay-cmd-no-money"));
                }

                EconomyLite::pay($sender->getName(), $name, $amount);

                $sender->sendMessage(LanguageProvider::getInstance()->tryGet("pay-cmd-success", ["{AMOUNT}" => $amount, "{NAME}" => $name]));
                EconomyLite::addPaymentHistory($sender->getName(), $name, $amount);
            }, fn() => null);
        }, fn() => null);
    }
}