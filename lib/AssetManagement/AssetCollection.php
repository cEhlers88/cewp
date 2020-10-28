<?php

namespace CEWP\AssetManagement;

class AssetCollection
{
    private string $key;
    private array $assets;

    public function add(string $src, array $deps = []): AssetCollection
    {
        $this->key = md5($src);
        $this->assets[$this->key] = [
            'src' => $src,
            'deps' => $deps,
            'env' => 'frontend',
            'condition' => true
        ];

        return $this;
    }

    public function environment(string $environment): AssetCollection
    {
        $this->assets[$this->key]['env'] = $environment;

        return $this;
    }

    public function condition(bool $condition): void
    {
        $this->assets[$this->key]['condition'] = $condition;
    }

    public function get(): array
    {
        return $this->assets;
    }
}