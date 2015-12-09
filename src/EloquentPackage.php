<?php

    namespace ObjectivePHP\EloquentPackage;


    use ObjectivePHP\Application\ApplicationInterface;
    use Illuminate\Database\Capsule\Manager as CapsuleManager;

    class EloquentPackage
    {

        public function __invoke(ApplicationInterface $app)
        {
            $app->on('bootstrap')->plug([$this, 'bootstrapEloquent']);
        }


        public function bootstrapEloquent(ApplicationInterface $app)
        {
            $config = $app->getConfig()->eloquent->toArray();

            if(!$config)
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