<?php

namespace CEWP;

use CEWP\core\AdminSiteRules;
use Exception;

class CEWP
{
    public const DEFAULT_NAMESPACE = "CEWP\Modules";

    /**
     * @var ModuleInterface[] $modules
     */
    private array $modules = [];

    private string $distFolder;

    private array $assets;

    private AdminSiteRules $adminSiteRules;

    public function AdminSiteRules(): AdminSiteRules {
        return $this->adminSiteRules;
    }

    public function getDistFolder(): string
    {
        return $this->distFolder;
    }

    public function setDistFolder(string $distFolder): CEWP {
        $this->distFolder = $distFolder;
        return $this;
    }

    public function __construct() {
        $this->adminSiteRules = new AdminSiteRules();

        add_action('init',[$this,'registerCustomPostTypes']);

        $this->assets = [
            'backend' => ['scripts'=>[],'styles'=>[]],
            'frontend' => ['scripts'=>[],'styles'=>[]]
        ];
    }

    public function addModule(ModuleInterface $module):CEWP {
        $this->modules[] = $module;
        return $this;
    }

    public function activate(){
        $this->registerCustomPostTypes();

        flush_rewrite_rules();
    }

    public function createFilters(){
        $this->AdminSiteRules()->execute();
    }

    public function deactivate(){
        flush_rewrite_rules();
    }

    public function enqueueAdminScripts(){
        foreach ($this->assets['backend']['scripts'] as $file){
            wp_enqueue_script('cewp_backend',plugins_url('..'.$file,__FILE__),'',true);
        }
    }

    public function enqueueAdminStyles(){
        foreach ($this->assets['backend']['styles'] as $file){
            wp_enqueue_style('cewp_backend',plugins_url('..'.$file,__FILE__),'',true);
        }
    }

    public function enqueueScripts(){
        foreach ($this->assets['frontend']['scripts'] as $file){
            wp_enqueue_script('cewp_frontend',plugins_url('..'.$file,__FILE__),'',true);
        }
    }

    public function loadPlugins(string $modulesDirectory, string $namespace = ''):CEWP {
        if($namespace===''){
            $namespace = self::DEFAULT_NAMESPACE;
        }
        foreach (scandir($modulesDirectory) as $subDirectory){
            if($subDirectory!=='.' && $subDirectory!=='..'){
                $classname = $namespace.'\\'.$subDirectory.'\\'.$subDirectory;
                try {
                    if(!class_exists($classname)){
                        continue;
                    }
                    $instance = new $classname();
                    if($instance instanceof ModuleInterface){
                        $this->registerModulesAssets($subDirectory);

                        $instance->init($this);

                        add_action('cmb2_admin_init', function () use ($instance){
                            $instance->createCmb2Boxes();
                        });

                        $this->modules[] = $instance;
                    }
                }catch(Exception $exception){}
            }
        }

        if(count($this->assets['backend']['scripts'])>0){
            add_action('admin_enqueue_scripts',[$this,'enqueueAdminScripts']);
        }

        if(count($this->assets['frontend']['scripts'])>0){
            add_action('wp_enqueue_scripts',[$this,'enqueueScripts']);
        }

        if(count($this->assets['backend']['styles'])>0){
            add_action('admin_enqueue_scripts',[$this,'enqueueAdminStyles']);
        }

        return $this;
    }

    private function registerModulesAssets($moduleName){
        foreach (['js','css'] as $type){
            foreach (['backend','frontend'] as $enviroment){
                $path = $this->distFolder.'/'.$type.'/'.$moduleName.'/'.$enviroment.'.'.$type;
                if(file_exists(__DIR__.'/..'.$path)){
                    $this->assets[$enviroment][$type === 'js' ? 'scripts' : 'styles'][] = $path;
                }else{
                    $notFound = true;
                }
            }
        }
    }

    public function registerCustomPostTypes(){
        foreach ($this->modules as $module){
            foreach ($module->getPostTypes() as $postType){
                register_post_type($postType->getKey(),$postType->getArgs());
            }
        }

    }

    public function uninstall(){
        foreach ($this->modules as $module){
            foreach ($module->getPostTypes() as $postType){
                $posts = get_posts(['post_type'=>$postType->getKey(),'numberposts'=>-1]);
                foreach ($posts as $post){
                    wp_delete_post($post->ID, false);
                }
            }
        }
    }
}