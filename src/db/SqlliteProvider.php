<?php

namespace DerCooleVonDem\EconomyLite\db;

use SQLite3;

class SqlliteProvider {

    private SQLite3 $db;

    public function __construct(string $path) {
        $this->db = new SQLite3($path . "economy.db");

        // db for balances
        $this->db->exec("CREATE TABLE IF NOT EXISTS economy (player TEXT PRIMARY KEY, money INTEGER)");

        // db for payment history
        $this->db->exec("CREATE TABLE IF NOT EXISTS payment_history (id INTEGER PRIMARY KEY AUTOINCREMENT, sender TEXT, receiver TEXT, money INTEGER, date TEXT)");

        // db for economy changes (money added/removed to/from the economy)
        $this->db->exec("CREATE TABLE IF NOT EXISTS economy_changes (id INTEGER PRIMARY KEY AUTOINCREMENT, player TEXT, money INTEGER, date TEXT)");
    }

    public function hasPlayer(string $player) : bool {
        $stmt = $this->db->prepare("SELECT player FROM economy WHERE player = :player");
        $stmt->bindValue(":player", $player);
        $result = $stmt->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);
        return $row !== false;
    }

    public function getMoney(string $player) : int {
        $stmt = $this->db->prepare("SELECT money FROM economy WHERE player = :player");
        $stmt->bindValue(":player", $player);
        $result = $stmt->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);
        return $row["money"];
    }

    public function setMoney(string $player, int $money) : void {
        $stmt = $this->db->prepare("INSERT OR REPLACE INTO economy (player, money) VALUES (:player, :money)");
        $stmt->bindValue(":player", $player);
        $stmt->bindValue(":money", $money);
        $stmt->execute();
    }

    public function addMoney(string $player, int $money) : void {
        if(!$this->hasPlayer($player)) {
            $this->setMoney($player, $money);
            return;
        }

        $stmt = $this->db->prepare("UPDATE economy SET money = money + :money WHERE player = :player");
        $stmt->bindValue(":player", $player);
        $stmt->bindValue(":money", $money);
        $stmt->execute();
    }

    public function removeMoney(string $player, int $money) : void {
        if(!$this->hasPlayer($player)) {
            return;
        }

        $stmt = $this->db->prepare("UPDATE economy SET money = money - :money WHERE player = :player");
        $stmt->bindValue(":player", $player);
        $stmt->bindValue(":money", $money);
        $stmt->execute();
    }

    public function getAllMoney() : int {
        // fetch all players money
        $result = $this->db->query("SELECT money FROM economy");
        $allMoney = 0;
        while($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $allMoney += $row["money"];
        }
        return $allMoney;
    }

    // add entry to payment history
    public function addPaymentHistory(string $sender, string $receiver, int $money) : void {
        $stmt = $this->db->prepare("INSERT INTO payment_history (sender, receiver, money, date) VALUES (:sender, :receiver, :money, :date)");
        $stmt->bindValue(":sender", $sender);
        $stmt->bindValue(":receiver", $receiver);
        $stmt->bindValue(":money", $money);
        $stmt->bindValue(":date", date("Y-m-d H:i:s"));
        $stmt->execute();
    }

    // add entry to economy changes
    public function addEconomyChange(string $player, int $money) : void {
        $stmt = $this->db->prepare("INSERT INTO economy_changes (player, money, date) VALUES (:player, :money, :date)");
        $stmt->bindValue(":player", $player);
        $stmt->bindValue(":money", $money);
        $stmt->bindValue(":date", date("Y-m-d H:i:s"));
        $stmt->execute();
    }

    // get payment history of a player (payments received/done)
    public function getPaymentHistoryOf(string $player) : array {
        $stmt = $this->db->prepare("SELECT * FROM payment_history WHERE sender = :player OR receiver = :player");
        $stmt->bindValue(":player", $player);
        $result = $stmt->execute();
        $history = [];
        while($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $history[] = $row;
        }

        // sort first element most recent payment
        usort($history, function($a, $b) {
            return strtotime($b["date"]) - strtotime($a["date"]);
        });

        return $history;
    }

    // get economy changes
    public function getEconomyChanges() : array {
        $result = $this->db->query("SELECT * FROM economy_changes");
        $changes = [];
        while($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $changes[] = $row;
        }

        // sort first element most recent change
        usort($changes, function($a, $b) {
            return strtotime($b["date"]) - strtotime($a["date"]);
        });

        return $changes;
    }

    public function deleteAccount(string $player) : void {
        $stmt = $this->db->prepare("DELETE FROM economy WHERE player = :player");
        $stmt->bindValue(":player", $player);
        $stmt->execute();

        $stmt = $this->db->prepare("DELETE FROM payment_history WHERE sender = :player OR receiver = :player");
        $stmt->bindValue(":player", $player);
        $stmt->execute();
    }

    public function close() : void {
        $this->db->close();
    }

    public function __destruct() {
        $this->close();
    }
}