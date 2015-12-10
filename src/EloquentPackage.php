<?php

    namespace ObjectivePHP\EloquentPackage;


    use ObjectivePHP\Application\ApplicationInterface;
    use Illuminate\Database\Capsule\Manager as CapsuleManager;

    /**
     * Class EloquentPackage
     *
     * @package ObjectivePHP\EloquentPackage
     */
    class EloquentPackage
    {

        /**
         * @param ApplicationInterface $app
         */
        public function __invoke(ApplicationInterface $app)
        {
            $app->on('bootstrap')->plug([$this, 'bootstrapEloquent']);
        }

        /**
         * @param ApplicationInterface $app
         *
         * @return null
         */
        public function bootstrapEloquent(ApplicationInterface $app)
        {
            $config = $app->getConfig()->eloquent->toArray();

            // add default values
            $config += ['charset' => 'utf8', 'collation' => 'utf8_unicode_ci'];


            if (!$config)
            {
                // eloquent has not been configured
                return null;
            }
            
            $capsuleManager = new CapsuleManager();

            $capsuleManager->addConnection($config);

            $capsuleManager->setAsGlobal();
            $capsuleManager->bootEloquent();

            // register the capsule manager as service
            $app->getServicesFactory()->registerService(['id' => 'eloquent.capsule', 'instance' => $capsuleManager]);

        }

    }