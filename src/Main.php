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

    private const PLUGIN_NAME = "EconomyLite";

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
        $this->provider = new SqliteProvider();

        $commandMap = $this->getServer()->getCommandMap();
        $commandMap->register(self::PLUGIN_NAME, new EconomyLiteCommand());
        $commandMap->register(self::PLUGIN_NAME, new PayCommand()); // Its not clear why the fallback needs to be that, but sure okay
        $commandMap->register(self::PLUGIN_NAME, new PurseCommand()); // hm

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
