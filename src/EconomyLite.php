<?php

namespace DerCooleVonDem\EconomyLite;

use pocketmine\promise\Promise;

class EconomyLite {
    /**
     * Adds the specified amount of money to the user's account.
     * Ensures that the total money does not exceed the configured maximum limit.
     *
     * @param string $username The username of the user to add money to.
     * @param int $amount The amount of money to add.
     * @return void
     */
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

    /**
     * Removes the specified amount of money from the user's account.
     *
     * @param string $username The username of the user to remove money from.
     * @param int $amount The amount of money to remove.
     * @return void
     */
    public static function removeMoney(string $username, int $amount): void {
        $sqlite = Main::getInstance()->provider;
        $sqlite->removeMoney($username, $amount);
    }

    /**
     * Checks if the specified user has an account.
     *
     * @param string $username The username to check for an account.
     * @return Promise A promise resolving to a boolean indicating if the user has an account.
     */
    public static function hasAccount(string $username): Promise {
        $sqlite = Main::getInstance()->provider;
        return $sqlite->hasPlayer($username);
    }

    /**
     * Transfers a specified amount of money from the origin user's account to the target user's account.
     * Ensures that the origin user has sufficient balance before processing the transfer.
     *
     * @param string $originUsername The username of the user initiating the payment.
     * @param string $targetUsername The username of the user receiving the payment.
     * @param int $amount The amount of money to transfer.
     * @return void
     */
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

    /**
     * Retrieves the total amount of money across all accounts.
     *
     * @return Promise A promise that resolves with the total amount of money.
     */
    public static function getAllMoney(): Promise {
        $sqlite = Main::getInstance()->provider;
        return $sqlite->getAllMoney();
    }

    /**
     * Retrieves the amount of money associated with the specified user.
     *
     * @param string $getName The username of the user whose money is to be retrieved.
     * @return Promise A promise resolving to the user's current balance.
     */
    public static function getMoney(string $getName): Promise {
        $sqlite = Main::getInstance()->provider;
        return $sqlite->getMoney($getName);
    }

    /**
     * Records a payment transaction in the payment history.
     *
     * @param string $sender The username of the user who sent the payment.
     * @param string $receiver The username of the user who received the payment.
     * @param int $money The amount of money transferred in the transaction.
     * @return void
     */
    public static function addPaymentHistory(string $sender, string $receiver, int $money): void {
        $sqlite = Main::getInstance()->provider;
        $sqlite->addPaymentHistory($sender, $receiver, $money);
    }

    /**
     * Records an economy change by adding the specified amount to the player's account.
     *
     * @param string $player The name of the player whose economy change is being recorded.
     * @param int $money The amount of money to record as a change.
     * @return void
     */
    public static function addEconomyChange(string $player, int $money): void {
        $sqlite = Main::getInstance()->provider;
        $sqlite->addEconomyChange($player, $money);
    }

    /**
     * Retrieves the payment history for the specified user.
     *
     * @param string $getName The username of the user whose payment history is being retrieved.
     * @return Promise A promise resolving to the user's payment history.
     */
    public static function getPaymentHistory(string $getName): Promise {
        $sqlite = Main::getInstance()->provider;
        return $sqlite->getPaymentHistoryOf($getName);
    }

    /**
     * Retrieves the economy changes from the provider.
     *
     * @return Promise A promise that resolves with the economy changes data.
     */
    public static function getEconomyChanges(): Promise {
        $sqlite = Main::getInstance()->provider;
        return $sqlite->getEconomyChanges();
    }

    /**
     * Deletes the account associated with the specified player.
     *
     * @param string $player The username of the player whose account should be deleted.
     * @return void
     */
    public static function deleteAccount(string $player): void {
        $sqlite = Main::getInstance()->provider;
        $sqlite->deleteAccount($player);
    }

    /**
     * Creates a new account for the specified user by adding an initial starting balance.
     * Ensures the starting balance does not exceed the configured maximum limit
     * and updates the payment history and economy change records accordingly.
     *
     * @param string $name The name of the user for whom the account is being created.
     * @return void
     */
    public static function createAccount(string $name): void {
        $startMoneyAmount = Main::getInstance()->configProvider->get("start-money-if-possible");

        // check if it is possible to add this amount of money
        $maxMoney = Main::getInstance()->configProvider->get("max-money");
        $allMoney = self::getAllMoney();

        // add as much money as possible until the start money amount is reached
        $moneyToAdd = min($startMoneyAmount, $maxMoney - $allMoney);
        self::addMoney($name, $moneyToAdd);

        self::addPaymentHistory("SERVER", $name, $moneyToAdd);
        self::addEconomyChange("SERVER (AUTO)", $moneyToAdd);
    }
}