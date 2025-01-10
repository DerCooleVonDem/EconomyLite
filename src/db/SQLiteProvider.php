<?php

namespace DerCooleVonDem\EconomyLite\db;

use DerCooleVonDem\EconomyLite\lib\poggit\libasynql\DataConnector;
use DerCooleVonDem\EconomyLite\lib\poggit\libasynql\libasynql;
use DerCooleVonDem\EconomyLite\Main;
use pocketmine\promise\Promise;
use pocketmine\promise\PromiseResolver;

/**
 * Class SQLiteProvider
 *
 * Provides functionality to interact with the SQLite database, managing operations related to economy,
 * payment history, and economy changes for individual players.
 */
class SQLiteProvider {

    private Main $plugin;
    private DataConnector $database;
    private string $name;

    public function __construct() {
        $this->plugin = Main::getInstance();

        $configData = $this->plugin->configProvider->get("database");
        $this->database = libasynql::create($this->plugin, $configData, [
            "sqlite" => "database/sqlite.sql"
        ]);
        $this->name = strtolower($configData["type"] ?? "libasynql");

        $this->database->executeGeneric('table.economy');
        $this->database->executeGeneric('table.payment_history');
        $this->database->executeGeneric('table.economy_changes');
    }

    public function hasPlayer(string $player): Promise {
        $promise = new PromiseResolver();
        $this->database->executeSelect("data.economy.get", ["player" => $player], function (array $rows) use ($promise): void {
            $promise->resolve(!empty($rows));
        });
        return $promise->getPromise();
    }

    public function getMoney(string $player): Promise {
        $promise = new PromiseResolver();
        $this->database->executeSelect("data.economy.get", ["player" => $player], function (array $rows) use ($promise): void {
            $promise->resolve($rows[0]["money"] ?? 0);
        });
        return $promise->getPromise();
    }

    public function addMoney(string $player, int $money): void {
        // check if player exists
        $promise = $this->hasPlayer($player);

        $promise->onCompletion(function (bool $exists) use ($player, $money) {
            $this->database->executeChange("data.economy" . ($exists ? ".add" : ".set"), [
                "player" => $player,
                "money" => $money
            ]);
        }, function () {});
    }

    public function removeMoney(string $player, int $money): void {
        $this->hasPlayer($player)->onCompletion(function (bool $exists) use ($player, $money): void {
            if ($exists) {
                $this->database->executeChange("data.economy.remove", [
                    "player" => $player,
                    "money" => $money
                ]);
            }
        }, fn() => null);
    }

    public function getAllMoney(): Promise {
        $promise = new PromiseResolver();
        $this->database->executeSelect("data.economy.all", [], function (array $money) use ($promise): void {
            $promise->resolve($money[0]["total_money"] ?? 0);
        });
        return $promise->getPromise();
    }

    public function addPaymentHistory(string $sender, string $receiver, int $money): void {
        $this->database->executeInsert("data.payment_history.add", [
            "sender" => $sender,
            "receiver" => $receiver,
            "money" => $money,
            "date" => date("Y-m-d H:i:s")
        ]);
    }

    public function addEconomyChange(string $player, int $money): void {
        $this->database->executeInsert("data.economy_changes.add", [
            "player" => $player,
            "money" => $money,
            "date" => date("Y-m-d H:i:s")
        ]);
    }

    public function getPaymentHistoryOf(string $player): Promise {
        $promise = new PromiseResolver();
        $this->database->executeSelect("data.payment_history.get", ["player" => $player], function (array $rows) use ($promise): void {
            usort($rows, fn($a, $b) => strtotime($b["date"]) - strtotime($a["date"]));
            $promise->resolve($rows);
        });
        return $promise->getPromise();
    }

    public function getEconomyChanges(): Promise {
        $promise = new PromiseResolver();
        $this->database->executeSelect("data.economy_changes.all", [], function (array $rows) use ($promise): void {
            usort($rows, fn($a, $b) => strtotime($b["date"]) - strtotime($a["date"]));
            $promise->resolve($rows);
        });
        return $promise->getPromise();
    }

    public function deleteAccount(string $player): void {
        $this->database->executeChange("data.economy.delete_player", ["player" => $player]);
        // Controversial implementation, needs change! // $this->database->executeChange("data.payment_history.delete", ["player" => $player]);
    }

    public function close(): void {
        $this->database->close();
    }
}
