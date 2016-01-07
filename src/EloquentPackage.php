<?php

    namespace ObjectivePHP\Package\Eloquent;


    use ObjectivePHP\Application\ApplicationInterface;
    use Illuminate\Database\Capsule\Manager as CapsuleManager;
    use ObjectivePHP\Package\Eloquent\Config\EloquentCapsule;

    /**
     * Class EloquentPackage
     *
     * @package ObjectivePHP\Package\Eloquent
     */
    class EloquentPackage
    {

        /**
         * @param ApplicationInterface $app
         */
        public function __invoke(ApplicationInterface $app)
        {
            $app->getStep('bootstrap')->plug([$this, 'bootstrapEloquent']);
        }

        /**
         * @param ApplicationInterface $app
         *
         * @return null
         */
        public function bootstrapEloquent(ApplicationInterface $app)
        {
            $capsules = $app->getConfig()->subset(EloquentCapsule::PREFIX);

            if (!$capsules)
            {
                // eloquent has not been configured
                return null;
            }

            $capsuleManager = new CapsuleManager();

            // loop over declared capsules
            foreach($capsules as $id => $capsule)
            {
                // add default values
                $capsule += ['charset' => 'utf8', 'collation' => 'utf8_unicode_ci'];

                $capsuleManager->addConnection($capsule, $id);

            }

            // register the capsule manager as service
            $app->getServicesFactory()
                ->registerService(['id' => 'eloquent.capsule', 'instance' => $capsuleManager])
            ;
            $capsuleManager->setAsGlobal();
            $capsuleManager->bootEloquent();

        }

    }
