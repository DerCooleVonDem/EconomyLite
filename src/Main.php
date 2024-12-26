<?php

declare(strict_types=1);

namespace DerCooleVonDem\EconomyLite;

use DerCooleVonDem\EconomyLite\cmd\EconomyLiteCommand;
use DerCooleVonDem\EconomyLite\cmd\PayCommand;
use DerCooleVonDem\EconomyLite\cmd\PurseCommand;
use DerCooleVonDem\EconomyLite\config\ConfigProvider;
use DerCooleVonDem\EconomyLite\config\LanguageProvider;
use DerCooleVonDem\EconomyLite\db\SqlliteProvider;
use DerCooleVonDem\EconomyLite\event\PlayerListener;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

    private static Main $instance;

    public SqlLiteProvider $provider;
    public ConfigProvider $configProvider;
    public LanguageProvider $languageProvider;

    protected function onEnable(): void
    {
        $dataFolder = $this->getDataFolder();
        $this->provider = new SqlliteProvider($dataFolder);
        $this->configProvider = new ConfigProvider($dataFolder);
        $this->languageProvider = new LanguageProvider($dataFolder);

        $commandMap = $this->getServer()->getCommandMap();
        $commandMap->register("economylite", new EconomyLiteCommand());
        $commandMap->register("pay", new PayCommand());
        $commandMap->register("purse", new PurseCommand());

        // register event listener
        $pluginManager = $this->getServer()->getPluginManager();
        $pluginManager->registerEvents(new PlayerListener(), $this);

        self::$instance = $this;
    }

    public static function getInstance(): Main
    {
        return self::$instance;
    }
}
