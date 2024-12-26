<?php

namespace DerCooleVonDem\EconomyLite\config;

use pocketmine\utils\Config;

class LanguageProvider {

    private static LanguageProvider $instance;

    private Config $config;

    public function __construct(string $languagePath)
    {
        $this->config = new Config($languagePath . "language.yml", Config::YAML);

        // Why do this?
        // Reason: If the key does not exist, it will be added to the file with the default value, so if a server admin accidentally deletes a key, it will be added again. No hassle.
        //         But it still keeps the customisation potential, because the server admin can still change the value in the file and the plugin will use the custom value.


        // Add Sub Command
        $this->addDefault("add-sub-description", "Adds money into the economy");
        $this->addDefault("add-sub-usage", "/economylite add <name> <amount>");
        $this->addDefault("add-sub-exceed-limit", "Amount would exceed the limit of allowed money");
        $this->addDefault("add-sub-success", "Added {AMOUNT} to {NAME}");

        // Delete Sub Command
        $this->addDefault("delete-sub-description", "Deletes the account of a player");
        $this->addDefault("delete-sub-usage", "/economylite delete <name>");
        $this->addDefault("delete-sub-no-account", "Player does not have an account");
        $this->addDefault("delete-sub-success", "Deleted account of {NAME}");

        // Help Sub Command
        $this->addDefault("help-sub-description", "Help about the economylite admin commands");
        $this->addDefault("help-sub-usage", "/economylite help");
        $this->addDefault("help-sub-header", "EconomyLite admin commands:");
        $this->addDefault("help-sub-item", "/economylite {NAME} - {DESCRIPTION} - {USAGE}");

        // History Sub Command
        $this->addDefault("history-sub-description", "Displays the payment history of given player");
        $this->addDefault("history-sub-usage", "/economylite history <name> [limit=100]");
        $this->addDefault("history-sub-no-account", "Player does not have an account");
        $this->addDefault("history-sub-header", "Payment history of {NAME}:");
        $this->addDefault("history-sub-item", "({DATE}) {SENDER} -> {RECEIVER}: {MONEY}");

        // Info Sub Command
        $this->addDefault("info-sub-description", "Get information about the economy");
        $this->addDefault("info-sub-usage", "/economylite info");
        $this->addDefault("info-sub-money-in-exchange", "Money in exchange: {MONEY}");
        $this->addDefault("info-sub-subheader", "\\nRecent economy changes:");
        $this->addDefault("info-sub-change-item", "({DATE}) {PLAYER} {ACTION} {MONEY}");

        // Remove Sub Command
        $this->addDefault("remove-sub-description", "Removes money from the economy");
        $this->addDefault("remove-sub-usage", "/economylite remove <name> <amount>");
        $this->addDefault("remove-sub-amount-false-format", "Amount must be a number");
        $this->addDefault("remove-sub-success", "Removed {AMOUNT} from {NAME}");

        // Show Sub Command
        $this->addDefault("show-sub-description", "Shows the balance of a player");
        $this->addDefault("show-sub-usage", "/economylite show <name>");
        $this->addDefault("show-sub-no-account", "Player does not have an account");
        $this->addDefault("show-sub-success", "{NAME} has {MONEY}");

        // Pay Command
        $this->addDefault("pay-cmd-description", "Pay someone");
        $this->addDefault("pay-cmd-usage", "/pay <name> <amount>");
        $this->addDefault("pay-cmd-console", "You cannot use this command in console");
        $this->addDefault("pay-cmd-amount-false-format", "Amount must be a number");
        $this->addDefault("pay-cmd-amount-is-negative", "Amount must be positive");
        $this->addDefault("pay-cmd-not-found", "Player not found");
        $this->addDefault("pay-cmd-no-money", "You do not have enough money");
        $this->addDefault("pay-cmd-success", "Paid {AMOUNT} to {NAME}");

        // Purse Command
        $this->addDefault("purse-cmd-description", "Shows your balance");
        $this->addDefault("purse-cmd-usage", "/purse");
        $this->addDefault("purse-cmd-no-account", "You do not have an account");
        $this->addDefault("purse-cmd-success", "You have {MONEY}");
        $this->addDefault("purse-cmd-no-history", "\\nNo payment history");
        $this->addDefault("purse-cmd-history-header", "\\nPayment history:");
        $this->addDefault("purse-cmd-history-item", "({DATE}) {SENDER} -> {RECEIVER}: {MONEY}");

        // EconomyLite Command
        $this->addDefault("economylite-cmd-description", "EconomyLite admin commands");
        $this->addDefault("economylite-cmd-usage", "/economylite <subcommand> [args]");
        $this->addDefault("economylite-cmd-no-permission", "You do not have permission to use this command");
        $this->addDefault("economylite-cmd-no-subcommand", "Subcommand not found or misspelled");

        self::$instance = $this;
    }

    public function tryGet(string $key, array $replacements = []): string {
        if(!$this->config->exists($key)) {
            return $key;
        }

        $unprepared = $this->config->get($key);

        foreach($replacements as $key => $value) {
            $unprepared = str_replace($key, $value, $unprepared);
        }

        return $unprepared;
    }

    /**
     * @throws \JsonException
     */
    public function addDefault(string $key, string $value) {
        if(!$this->config->exists($key)) {
            $this->config->set($key, $value);
            $this->config->save();
        }
    }

    public static function getInstance(): LanguageProvider
    {
        return self::$instance;
    }
}