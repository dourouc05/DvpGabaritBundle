<?php 

namespace Dvp\GabaritBundle\Tests\Gabarit;
use Dvp\GabaritBundle\Gabarit\Header;

class HeaderTest extends \PHPUnit_Framework_TestCase {
    public function testHtml5() {
        $o = new Header(); 
        $data = $o->toHtml5(); 
        
        $this->assertNotContains($data, array('<meta name="MS.LOCALE"', '<meta name="MSN_')); 
        $this->assertContains($data, array('<!DOCTYPE HTML>')); 
        $this->assertNotContains($data, array('<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">')); 
    }
    
    public function testXhtml() {
        $o = new Header(); 
        $data = $o->toXhtml(); 
        
        $this->assertNotContains($data, array('<!DOCTYPE HTML>')); 
        $this->assertContains($data, array('<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">')); 
    }
    
    public function testTitle() {
        $o = new Header('12'); 
        $data = $o->toHtml5(); 
        
        $this->assertContains($data, array('<title>12')); 
    }
    
    public function testFavicon() {
        $o = new Header(); 
        $o->setMetaDescription('metadesc');
        $o->setMetaKeywords('metakey');
        $data = $o->toHtml5(); 
        
        $this->assertContains($data, array('<meta name="description" content="metadesc"/>', '<meta name="keywords" content="metakey"/>')); 
    }
    
    public function testMeta() {
        $o = new Header(); 
        $o->setFavicon('42.ico');
        $data = $o->toHtml5(); 
        
        $this->assertContains($data, array('<link rel="shortcut icon" type="image/x-icon" href="42.ico" />')); 
    }
    
    public function testJquery() {
        $o = new Header(; 
        $o->disableJquery();
        $data = $o->toHtml5(); 
        
        $this->assertNotContains($data, array('<script type="text/javascript" src="http://www.developpez.com/template/scripts/jquery-')); 
    }
    
    public function testJs() {
        {
            $o = new Header(); 
            $o->addHeadJs('42');
            $data = $o->toHtml5(); 
            
            $this->assertContains($data, array('<script type="text/javascript" src="42"></script>')); 
        }
        
        {
            $o = new Header(); 
            $o->addHeadJs('42');
            $o->addHeadJs('43');
            $data = $o->toHtml5(); 
            
            $this->assertContains($data, array('<script type="text/javascript" src="42"></script>', '<script type="text/javascript" src="43"></script>')); 
        }
    }
    
    public function testRawJs() {
        $o = new Header(); 
        $o->setJs('42');
        $data = $o->toHtml5(); 
        
        $this->assertNotContains($data, array('<script type=\"text/javascript\">\n//<![CDATA[\n42\n //]]>\n</script>')); 
    }
    
    public function testCss() {
        {
            $o = new Header(); 
            $o->addHeadCss('42');
            $data = $o->toHtml5(); 
            
            $this->assertContains($data, array('<link rel="stylesheet" type="text/css" href="42"></script>')); 
        }
        
        {
            $o = new Header(); 
            $o->addHeadCss('42');
            $o->addHeadCss('43');
            $data = $o->toHtml5(); 
            
            $this->assertContains($data, array('<link rel="stylesheet" type="text/css" href="42"></script>', '<link rel="stylesheet" type="text/css" href="43"></script>')); 
        }
    }
    
    public function testHead() {
        $o = new Header(); 
        $o->setHead('42');
        $data = $o->toHtml5(); 
        
        $this->assertContains($data, array('42')); 
    }
}