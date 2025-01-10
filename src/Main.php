<?php

declare(strict_types=1);

namespace DerCooleVonDem\EconomyLite;

use DerCooleVonDem\EconomyLite\cmd\EconomyLiteCommand;
use DerCooleVonDem\EconomyLite\cmd\PayCommand;
use DerCooleVonDem\EconomyLite\cmd\PurseCommand;
use DerCooleVonDem\EconomyLite\config\ConfigProvider;
use DerCooleVonDem\EconomyLite\config\LanguageProvider;
use DerCooleVonDem\EconomyLite\db\SQLiteProvider;
use DerCooleVonDem\EconomyLite\event\PlayerListener;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

    private static Main $instance;

    public SQLiteProvider $provider;
    public ConfigProvider $configProvider;
    public LanguageProvider $languageProvider;

    protected function onEnable(): void
    {
        $this->saveResources();
        self::$instance = $this;

        $dataFolder = $this->getDataFolder();
        $this->configProvider = new ConfigProvider($dataFolder);
        $this->languageProvider = new LanguageProvider($dataFolder);
        $this->provider = new SqliteProvider($dataFolder);

        $commandMap = $this->getServer()->getCommandMap();
        $commandMap->register("economylite", new EconomyLiteCommand());
        $commandMap->register("pay", new PayCommand());
        $commandMap->register("purse", new PurseCommand());

        // register event listener
        $pluginManager = $this->getServer()->getPluginManager();
        $pluginManager->registerEvents(new PlayerListener(), $this);
    }

    public function saveResources() {
        $this->saveResource("config.yml");
        $this->saveResource("language.yml");
    }

    public static function getInstance(): Main
    {
        return self::$instance;
    }
}
