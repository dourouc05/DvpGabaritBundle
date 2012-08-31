h1. DvpGabaritBundle

A very simple bundle whose only goal is to provide direct access to Developpez.com 
template within Twig. As such, it is very easy to configure: add it to your AppKernel.php. 
::
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            // ...
            new Dvp\GabaritBundle\DvpGabaritBundle(),
        );

Then to your autoloader::
        $loader->registerNamespaces(array(
            'Symfony'          => array(__DIR__.'/../vendor/symfony/src', __DIR__.'/../vendor/bundles'),
            // ...
            'Dvp'              => __DIR__.'/../vendor/bundles',
        ));

And you're done (if the bundle is installed in /vendor/bundles/Dvp/GabaritBundle). 
If you want to use the deps method:: 
        [DvpGabaritBundle]
            git=http://github.com/dourouc05/DvpGabaritBundle.git
            target=/bundles/Dvp/GabaritBundle