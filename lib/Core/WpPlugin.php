<?php

namespace CEWP\Core;

use CEWP\Admin\AdminSiteRules;
use Exception;

class WpPlugin
{
    public const DEFAULT_NAMESPACE = "CEWP\Modules";

    /**
     * @var ModuleInterface[] $modules
     */
    private array $modules = [];
    private string $configFolder;
    private AdminSiteRules $adminSiteRules;

    public function __construct()
    {
        $this->adminSiteRules = new AdminSiteRules();
    }

    public function AdminSiteRules(): AdminSiteRules
    {
        return $this->adminSiteRules;
    }

    public function setConfigFolder(string $configFolder): WpPlugin
    {
        $this->configFolder = $configFolder;

        return $this;
    }

    public function addModule(ModuleInterface $module): WpPlugin
    {
        $this->modules[] = $module;

        return $this;
    }

    public function activate()
    {
        flush_rewrite_rules();
    }

    public function init()
    {
        add_action('init', [$this, 'registerCustomPostTypes']);

        $this->AdminSiteRules()->execute();
    }

    public function deactivate()
    {
        flush_rewrite_rules();
    }

    public function enqueueAdminScripts()
    {
        foreach ($this->assets['backend']['scripts'] as $file) {
            wp_enqueue_script('cewp_backend', plugins_url('..' . $file, __FILE__), '', true);
        }
    }

    public function enqueueAdminStyles()
    {
        foreach ($this->assets['backend']['styles'] as $file) {
            wp_enqueue_style('cewp_backend', plugins_url('..' . $file, __FILE__), '', true);
        }
    }

    public function enqueueScripts()
    {
        foreach ($this->assets['frontend']['scripts'] as $file) {
            wp_enqueue_script('cewp_frontend', plugins_url('..' . $file, __FILE__), '', true);
        }
    }

    public function loadExtension(AbstractExtension $extension): WpPlugin
    {
        $extension->setConfigFolder($this->configFolder);
        $extension->load();

        return $this;
    }

    public function loadPlugins(string $modulesDirectory, string $namespace = self::DEFAULT_NAMESPACE): WpPlugin
    {
        foreach (scandir($modulesDirectory) as $subDirectory) {
            if ($subDirectory === '.' || $subDirectory === '..') {
                continue;
            }

            $classname = $namespace . '\\' . $subDirectory . '\\' . $subDirectory;
            try {
                if (!class_exists($classname)) {
                    continue;
                }

                $instance = new $classname();
                if (!$instance instanceof ModuleInterface) {
                    continue;
                }

                $this->registerModulesAssets($subDirectory);

                $instance->init($this);

                add_action('cmb2_admin_init', function () use ($instance) {
                    $instance->createCmb2Boxes();
                });

                $this->modules[] = $instance;
            } catch (Exception $exception) {
            }
        }

        if (count($this->assets['backend']['scripts']) > 0) {
            add_action('admin_enqueue_scripts', [$this, 'enqueueAdminScripts']);
        }

        if (count($this->assets['frontend']['scripts']) > 0) {
            add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        }

        if (count($this->assets['backend']['styles']) > 0) {
            add_action('admin_enqueue_scripts', [$this, 'enqueueAdminStyles']);
        }

        return $this;
    }

    private function registerModulesAssets($moduleName)
    {
        foreach (['js', 'css'] as $type) {
            foreach (['backend', 'frontend'] as $enviroment) {
                $path = $this->distFolder . '/' . $type . '/' . $moduleName . '/' . $enviroment . '.' . $type;
                if (file_exists(__DIR__ . '/..' . $path)) {
                    $this->assets[$enviroment][$type === 'js' ? 'scripts' : 'styles'][] = $path;
                } else {
                    $notFound = true;
                }
            }
        }
    }

    private function registerCustomPostTypes()
    {
        foreach ($this->modules as $module) {
            foreach ($module->getPostTypes() as $postType) {
                register_post_type($postType->getKey(), $postType->getArgs());
            }
        }
    }
}