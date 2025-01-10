<?php

namespace DerCooleVonDem\EconomyLite\config;

use pocketmine\utils\Config;

class ConfigProvider {

    public Config $config;

    /**
     * @throws \JsonException
     */
    public function __construct(string $configPath)
    {
        $this->config = new Config($configPath . "config.yml", Config::YAML);
        $this->addDefault("max-money", 100000);
        $this->addDefault("start-money-if-possible", 1000);
    }

    public function get(string $key) {
        return $this->config->get($key);
    }

    public function getCurrencyProperty(string $currency, string $property) {
        $currencies = $this->config->get("currencies");
        return $currencies[$currency][$property] ?? null;
    }

    public function setCurrencyProperty(string $currency, string $property, $value) {
        $currencies = $this->config->get("currencies");
        if (!isset($currencies[$currency])) {
            $currencies[$currency] = [];
        }
        $currencies[$currency][$property] = $value;
        $this->config->set("currencies", $currencies);
        $this->config->save();
    }

    /**
     * @throws \JsonException
     */
    public function addDefault(string $key, $value) {
        if(!$this->config->exists($key)) {
            $this->config->set($key, $value);
            $this->config->save();
        }
    }

    public function addCurrencyDefault(string $currency, array $properties) {
        $currencies = $this->config->get("currencies") ?? [];
        if (!isset($currencies[$currency])) {
            $currencies[$currency] = $properties;
            $this->config->set("currencies", $currencies);
            $this->config->save();
        }
    }
}