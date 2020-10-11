<?php

namespace CEWP;

interface ModuleInterface
{
    public function addBackendScript(string $scriptPath):ModuleInterface;

    public function addFrontendScript(string $scriptPath):ModuleInterface;

    public function addBackendStyle(string $stylePath):ModuleInterface;

    public function addFrontendStyle(string $stylePath):ModuleInterface;

    /**
     * @return PostType[]
     */
    public function getPostTypes():array;
}