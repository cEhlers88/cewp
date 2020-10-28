<?php

namespace CEWP\AssetManagement;

use CEWP\Core\AbstractExtension;

class AssetManagement extends AbstractExtension
{
    private string $distFolder;

    public function load(): void
    {
        $assets = new AssetCollection();
        do_action('cewp/assets', $assets);

        $this->loadConfig('assets.php');
    }

    public function setDistFolder(string $distFolder): void
    {
        $this->distFolder = $distFolder;
    }

    protected function enqueueAssets(array $assets): void
    {
        foreach ($assets as $asset) {
            $action = $asset['env'] === 'admin' ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts';
            add_action($action, function () use ($asset): void {
                if ($ext === 'css') {
                    wp_enqueue_style();
                }

                if ($ext === 'js') {
                    wp_enqueue_script();
                }
            });
        }
    }
}