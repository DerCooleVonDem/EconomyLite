<?php

namespace DerCooleVonDem\EconomyLite;

use pocketmine\promise\Promise;

class EconomyLite {
    public static function addMoney(string $username, int $amount): void {
        $sqlite = Main::getInstance()->provider;
        $maxMoney = Main::getInstance()->configProvider->get("max-money");
        self::getAllMoney()->onCompletion(function($allMoney) use ($sqlite, $username, $amount, $maxMoney) {
            if($allMoney + $amount > $maxMoney) {
                return false;
            }

            $sqlite->addMoney($username, $amount);
            return true;
        }, fn() => null);
    }

    public static function removeMoney(string $username, int $amount): void {
        $sqlite = Main::getInstance()->provider;
        $sqlite->removeMoney($username, $amount);
    }

    public static function hasAccount(string $username): Promise {
        $sqlite = Main::getInstance()->provider;
        return $sqlite->hasPlayer($username);
    }

    public static function pay(string $originUsername, string $targetUsername, int $amount) {
        $sqlite = Main::getInstance()->provider;
        $sqlite->getMoney($originUsername)->onCompletion(function($balance) use ($sqlite, $amount, $originUsername, $targetUsername) {
            if($balance < $amount) {
                return;
            }

            $sqlite->removeMoney($originUsername, $amount);
            $sqlite->addMoney($targetUsername, $amount);
        }, fn() => null);
    }

    public static function getAllMoney(): Promise {
        $sqlite = Main::getInstance()->provider;
        return $sqlite->getAllMoney();
    }

    public static function getMoney(string $getName): Promise {
        $sqlite = Main::getInstance()->provider;
        return $sqlite->getMoney($getName);
    }

    public static function addPaymentHistory(string $sender, string $receiver, int $money): void {
        $sqlite = Main::getInstance()->provider;
        $sqlite->addPaymentHistory($sender, $receiver, $money);
    }

    public static function addEconomyChange(string $player, int $money): void {
        $sqlite = Main::getInstance()->provider;
        $sqlite->addEconomyChange($player, $money);
    }

    public static function getPaymentHistory(string $getName): Promise {
        $sqlite = Main::getInstance()->provider;
        return $sqlite->getPaymentHistoryOf($getName);
    }

    public static function getEconomyChanges(): Promise {
        $sqlite = Main::getInstance()->provider;
        return $sqlite->getEconomyChanges();
    }

    public static function deleteAccount(string $player): void {
        $sqlite = Main::getInstance()->provider;
        $sqlite->deleteAccount($player);
    }

    public static function createAccount(string $getName): void {
        $startMoneyAmount = Main::getInstance()->configProvider->get("start-money-if-possible");

        // check if it is possible to add this amount of money
        $maxMoney = Main::getInstance()->configProvider->get("max-money");
        $allMoney = self::getAllMoney();

        // add as much money as possible until the start money amount is reached
        $moneyToAdd = min($startMoneyAmount, $maxMoney - $allMoney);
        self::addMoney($getName, $moneyToAdd);

        self::addPaymentHistory("SERVER", $getName, $moneyToAdd);
        self::addEconomyChange("SERVER (AUTO)", $moneyToAdd);
    }
}