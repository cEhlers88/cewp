<?php

namespace CEWP;

use Exception;

class CEWP
{
    public const DEFAULT_NAMESPACE = "CEWP\Modules";
    /**
     * @var ModuleInterface[] $modules
     */

    private array $modules = [];

    public function __construct()
    {
        add_action('init',[$this,'registerCustomPostTypes']);
    }

    public function addModule(ModuleInterface $module):CEWP {
        $this->modules[] = $module;
        return $this;
    }

    public function activate(){
        $this->registerCustomPostTypes();

        flush_rewrite_rules();
    }

    public function deactivate(){
        flush_rewrite_rules();
    }

    public function enqueueAdmin(){
        wp_enqueue_script('cewp_backend',plugins_url('/../dist/js/backend.js',__FILE__));
        wp_enqueue_style('cewp_backend',plugins_url('/../dist/css/backend.css',__FILE__));

    }

    public function loadPlugins(string $modulesDirectory, string $namespace = ''){
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
                        $this->modules[] = $instance;
                    }
                }catch(Exception $exception){}
            }
        }
    }

    public function registerAdminScripts(){
        add_action('admin_enqueue_scripts',[$this,'enqueueAdmin']);
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