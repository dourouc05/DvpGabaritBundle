<?php

namespace Dvp\GabaritBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;

/**
 * A Twig extension for Developpez.com template. 
 * 
 * Many comments for the database part (say there will be no need to make it
 * useable everywhere, but still here "just in case"). 
 *
 * @author Thibaut
 */
class DvpGabaritExtension extends \Twig_Extension
{
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'gabarit';
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            'gab_up'      => new \Twig_Filter_Method($this, 'gabUp',      array('is_safe' => array('html'))),
            'gab_down'    => new \Twig_Filter_Method($this, 'gabDown',    array('is_safe' => array('html'))),
            'gab_license' => new \Twig_Filter_Method($this, 'gabLicense', array('is_safe' => array('html'))),
        );
    }
    
    public function gabUp($id)
    {
        return utf8_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/template/caches/tetexhtml' . $id . '.cache'));
    }
    
    public function gabDown($id)
    {
        return utf8_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/template/caches/piedxhtml' . $id . '.cache'));
    }
    
    public function gabLicense()
    {
        return utf8_encode(str_replace('<?php
echo $Annee;
?>', date('Y'), file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/template/licence3.php')));
    }
}