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
    
    public function gabDown($rubrique, $useFullInclude = false, $Licence = null)
    // Note: "$rubrique" is to be compatible with the include'd template. Would have been "$id". 
    // Note: "$Licence" chosen for the same reason. Would have been "$licence". 
    {
        // Variable name chosen for compatibility with include'd template. Would have been "$file". 
        $fichierCachePied = $_SERVER['DOCUMENT_ROOT'] . '/template/caches/piedxhtml' . $rubrique . '.cache'; 
        
        if(! $useFullInclude) {
            return utf8_encode(file_get_contents($fichierCachePied));
        } else {
            ob_start(); 
            $gabarit_utf8 = false; // Otherwise, as the include'd thing does itself some output buffering in case 
                                   // of UTF-8 output, it's a waste of time. 
            include $_SERVER['DOCUMENT_ROOT'] . '/template/pied.php'; 
            return utf8_encode(ob_get_clean()); 
        }
    }
    
    public function gabLicense()
    {
        return utf8_encode(str_replace('<?php
echo $Annee;
?>', date('Y'), file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/template/licence3.php')));
    }
}