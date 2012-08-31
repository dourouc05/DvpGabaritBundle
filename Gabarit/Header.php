<?php 

namespace Dvp\GabaritBundle\Gabarit;

/**
 * With a given set of parameters, outputs the header (HTML), from DOCTYPE to content. 
 */ 
class Header {
    private $params = array(); 
    private $validEncodings = array('iso-8859-1', 'iso-8859-15', 'windows-1252', 'utf-8'); 
    
    // Default values. 
    
    public function __construct($title = '', $section = 1) {
        $this->params['encoding'] = 'utf-8'; 
        $this->params['meta_description'] = ''; 
        $this->params['meta_keywords'] = ''; 
        $this->params['jquery'] = true; 
        $this->params['js'] = array(); 
        $this->params['css'] = array(); 
        $this->params['section'] = $section; 
        $this->params['title'] = $title; 
    }
    
    private function toDefault() { // "Documentation" function. 
        $this->params['encoding'] = 'utf-8'; 
        $this->params['favicon'] = null; // see $validEncodings
        $this->params['meta_description'] = ''; 
        $this->params['meta_keywords'] = ''; 
        $this->params['jquery'] = true; 
        $this->params['jquery_version'] = null; // true (latest) or string for the exact version asked (if available; only 1.4.4 and 1.7.2 at the time of writing)
        $this->params['js'] = array(); 
        $this->params['css'] = array(); 
        $this->params['raw_js'] = null; 
        $this->params['section'] = 1; 
        $this->params['head'] = null; 
        $this->params['title'] = ''; 
        
        $this->params['output'] = 'xhtml'; // or 'html5' or 'html'; base script only changes DOCTYPE and <body xml:lang>. 
    }
    
    // Output functions. 

    public function toXhtml() {
        $this->params['output'] = 'xhtml'; 
        return $this->stubOutput(); 
    }
    
    public function toHtml5() {
        $this->params['output'] = 'html5'; 
        return $this->html5Cleanup($this->stubOutput()); 
    }
    
    public function toHtml4() {
        $this->params['output'] = 'html'; 
        return $this->stubOutput(); 
    }
    
    private function stubOutput() {
        ob_start(); 
        
        {
            $gabarit_encodage = $this->params['encoding']; // Handles UTF-8 output if asked. 
            $meta_description = $this->params['meta_description']; 
            $meta_keywords = $this->params['meta_keywords']; 
            $rubrique = $this->params['section']; 
            $titre_page = $this->params['title']; 
            
            if(isset($this->params['favicon'])) {
                $gabarit_favicon = $this->params['favicon']; 
            }
            
            switch($this->params['output']) { // Only effect on the base script: change DOCTYPE (none for HTML4, standard for HTML5, XHTML 1.0 Transitional for XHTML). 
            case 'html': 
                $xhtml = false; 
                break; 
            case 'html5': 
                $xhtml5 = true; 
                break; 
            case 'xhtml': 
                $xhtml = true; 
                break; 
            }
            
            if($this->params['jquery'] && isset($this->params['jquery_version'])) {
                if($this->params['jquery_version'] === true) {
                    $gabarit_jquery = true; 
                } else {
                    $gabarit_jquery = $this->params['jquery_version']; 
                }
            } else {
                $gabarit_jquery = false; 
            }
            
            if(count($this->params['js']) > 0) {
                $gabarit_js = $this->params['js']; 
            }
            
            if(count($this->params['css']) > 0) {
                $gabarit_css = $this->params['css']; 
            }
            
            if(isset($this->params['raw_js'])) {
                $javascript = $this->params['raw_js']; 
            }
            
            if(isset($this->params['head'])) {
                $gabarit_extrahead = $this->params['head']; 
            }
            
            include $_SERVER['DOCUMENT_ROOT'] . '/template/entete.php';
        }
        
        return ob_get_clean();
    }
    
    private function html5Cleanup($string) {
        $string = preg_replace('/<meta name="MS(.*)>/', '', $string); // MS.LOCALE and MSN_*, incompatible with HTML5
        return $string; 
    }
    
    // Parameters. 
    
    public function setEncoding($e) {
        if(! in_array($e, $this->validEncodings)) {
            throw new \InvalidArgumentException('The encoding ' . $e . ' is not (yet?) supported (' . implode($this->validEncodings, ', ') . ').'); 
        }
        
        $this->params['encoding'] = $e; 
        return $this; 
    }
    
    public function setFavicon($f) {
        $this->params['favicon'] = $f; 
        return $this; 
    }
    
    public function setMetaDescription($d) {
        $this->params['meta_description'] = $d; 
        return $this; 
    }
    
    public function setMetaKeywords($k) {
        $this->params['meta_keywords'] = $k; 
        return $this; 
    }
    
    public function disableJquery() { // So you can use your own. 
        $this->params['jquery'] = false; 
        return $this; 
    }
    
    public function setLatestJquery() { // Available! 
        $this->params['jquery_version'] = true; 
        return $this; 
    }
    
    public function setJqueryVersion($v) {
        $this->params['jquery_version'] = $v; 
        return $this; 
    }
    
    public function addHeadJs($j) {
        $this->params['js'][] = $js; 
        return $this; 
    }
    
    public function setJs($c) { // Raw JS output
        $this->params['raw_js'] = $c; 
        return $this; 
    }
    
    public function addHeadCss($c) {
        $this->params['css'][] = $cs; 
        return $this; 
    }
    
    public function setSection($s) {    
        $this->params['section'] = (int) $s; 
        return $this; 
    }
    
    public function setHead($h) { // Supplementary tags to add in <head>
        $this->params['head'] = $h; 
        return $this; 
    }
    
    public function setTitle($t) {
        $this->params['title'] = $t; 
        return $this; 
    }
}