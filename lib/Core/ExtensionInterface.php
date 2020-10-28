<?php

namespace CEWP\Core;

interface ExtensionInterface
{
    public function setConfigFolder(string $configFolder): void;
    public function load(): void;
}