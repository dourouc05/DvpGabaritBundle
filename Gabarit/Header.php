<?php 

namespace Dvp\GabaritBundle\Gabarit;

/**
 * With a given set of parameters, outputs the header (HTML), from DOCTYPE to content. 
 */ 
class Header {
    private $params = array(); 
    private $validEncodings = array('iso-8859-1', 'iso-8859-15', 'windows-1252', 'utf-8'); 
    
    // Default values. 
    
    public function __construct() {
        $this->params['encoding'] = 'utf-8'; 
        $this->params['meta_description'] = ''; 
        $this->params['meta_keywords'] = ''; 
        $this->params['jquery'] = true; 
        $this->params['jquery_version'] = false;
        $this->params['js'] = array(); 
        $this->params['css'] = array(); 
        $this->params['section'] = 1; 
    }
    
    private function toDefault() { // "Documentation" function. 
        $this->params['encoding'] = 'utf-8'; 
        $this->params['favicon'] = null; // see $validEncodings
        $this->params['meta_description'] = ''; 
        $this->params['meta_keywords'] = ''; 
        $this->params['jquery'] = true; 
        $this->params['jquery_version'] = false; // or string for the exact version asked (if available; only 1.4.4 and 1.7.2 at the time of writing)
        $this->params['js'] = array(); 
        $this->params['css'] = array(); 
        $this->params['raw_js'] = null; 
        $this->params['section'] = 1; 
        $this->params['head'] = null; 
        
        $this->params['output'] = 'xhtml'; // or 'html5' or 'html'; base script only changes DOCTYPE and <body xml:lang>. 
    }
    
    // Output functions. 

    public function toXhtml() {
        $this->params['output'] = 'xhtml'; 
        return stubOutput(); 
    }
    
    public function toHtml5() {
        $this->params['output'] = 'html5'; 
        return stubOutput(); 
    }
    
    public function toHtml4() {
        $this->params['output'] = 'html'; 
        return stubOutput(); 
    }
    
    private function stubOutput() {
        ob_start(); 
        
        {
            $gabarit_encodage = $this->params['encoding']; // Handles UTF-8 output if asked. 
            $meta_description = $this->params['meta_description']; 
            $meta_keywords = $this->params['meta_keywords']; 
            $rubrique = $this->params['section']; 
            
            if(isset($this->params['favicon'])) {
                $gabarit_favicon = $this->params['favicon']; 
            }
            
            switch($this->params['output']) { // Only effect on the base script: change DOCTYPE (none for HTML4, standard for HTML5, XHTML 1.0 Transitional for XHTML). 
            'html': 
                $xhtml = false; 
                break; 
            'html5': 
                $xhtml5 = true; 
                break; 
            'xhtml': 
                $xhtml = true; 
                break; 
            }
            
            if($this->params['jquery']) {
                if(isset($this->params['jquery_version'])) {
                    $gabarit_jquery = $this->params['jquery_version']; 
                } elseif 
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
    
    // Parameters. 
    
    public function setEncoding($e) {
        if(! in_array($e, $this->validEncodings) {
            throw new \InvalidArgumentException('The encoding ' . $e . ' is not (yet?) supported (' . implode($this->validEncodings, ', ') . ').'); 
        }
        
        $this->params['encoding'] = $e; 
    }
    
    public function setFavicon($f) {
        $this->params['favicon'] = $f; 
    }
    
    public function setMetaDescription($d) {
        $this->params['meta_description'] = $d; 
    }
    
    public function setMetaKeywords($k) {
        $this->params['meta_keywords'] = $k; 
    }
    
    public function disableJquery() { // So you can use your own. 
        $this->params['jquery'] = false; 
    }
    
    public function setLatestJquery() { // Available! 
        $this->params['jquery_version'] = true; 
    }
    
    public function setJqueryVersion($v) {
        $this->params['jquery_version'] = $v; 
    }
    
    public function addHeadJs($j) {
        $this->params['js'][] = $js; 
    }
    
    public function setJs($c) { // Raw JS output
        $this->params['raw_js'] = $c; 
    }
    
    public function addHeadCss($c) {
        $this->params['css'][] = $cs; 
    }
    
    public function setSection($s) {    
        $this->params['section'] = (int) $s; 
    }
    
    public function setHead($h) { // Supplementary tags to add in <head>
        $this->params['head'] = $h; 
    }
}