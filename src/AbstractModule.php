<?php

namespace CEWP;

class AbstractModule implements ModuleInterface
{
    /**
     * @var PostType[]
     */
    private array $postTypes = [];

    private array $scriptsBackend = [];

    private array $scriptsFrontend = [];

    private array $stylesBackend = [];

    private array $stylesFrontend = [];

    public function addBackendScript(string $scriptPath):AbstractModule {
        $this->scriptsBackend[] = $scriptPath;
        return $this;
    }

    public function addPostType(PostType $postType):AbstractModule {
        $this->postTypes[] = $postType;
        return $this;
    }

    public function getPostTypes(): array {
        return $this->postTypes;
    }

    public function addFrontendScript(string $scriptPath): ModuleInterface {
        $this->scriptsFrontend[] = $scriptPath;
        return $this;
    }

    public function addBackendStyle(string $stylePath): ModuleInterface {
        $this->stylesBackend[] = $stylePath;
        return $this;
    }

    public function addFrontendStyle(string $stylePath): ModuleInterface {
        $this->stylesFrontend[] = $stylePath;
        return $this;
    }
}