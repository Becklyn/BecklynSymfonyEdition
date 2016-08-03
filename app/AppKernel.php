<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;


class AppKernel extends Kernel
{
    public function registerBundles ()
    {
        $bundles = [
            // region Core bundles
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Symfony\Bundle\MonologBundle\MonologBundle(),
            new \Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new \Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            // endregion

            // region Extension bundles
            new \Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new \Becklyn\RadBundle\BecklynRadBundle(),
            new \Becklyn\BugsnagBundle\BecklynBugsnagBundle(),
            // endregion

            // region Application bundles
            new \AppBundle\AppBundle(),
            // endregion
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true))
        {
            $bundles[] = new \Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new \Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new \Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
        }

        return $bundles;
    }



    /**
     * @inheritdoc
     */
    public function getRootDir ()
    {
        return __DIR__;
    }



    /**
     * @inheritdoc
     */
    public function getCacheDir ()
    {
        return dirname(__DIR__) . '/var/cache/' . $this->getEnvironment();
    }



    /**
     * @inheritdoc
     */
    public function getLogDir ()
    {
        return dirname(__DIR__) . '/var/logs';
    }



    /**
     * @inheritdoc
     */
    public function registerContainerConfiguration (LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
