<?php

namespace CEWP\Core;

abstract class AbstractExtension implements ExtensionInterface
{
    private $configFolder;

    public function setConfigFolder(string $configFolder): void
    {
        $this->configFolder = $configFolder;
    }

    protected function loadConfig(string $config): bool
    {
        $configPath = "{$this->configFolder}/{$config}";
        if (!file_exists($configPath)) {
            return false;
        }

        include_once $configPath;
        
        return true;
    }
}