<?php
/**
 * Image tag plugin file.
 * @filesource
 *
 * @author guillaume l. <guillaume@geelweb.org> 
 * @link http://www.geelweb.org geelweb-dot-org 
 * @license http://opensource.org/licenses/bsd-license.php BSD License 
 * @copyright Copyright © 2006, guillaume luchet
 * @version CVS: $Id: xml2pdf.tag.image.php,v 1.8 2007/01/05 23:07:31 geelweb Exp $
 * @package Xml2Pdf
 * @subpackage Tag
 *
 * @todo find width and height automaticly
 * @todo manag many image format, not just jpg, png.
 */

// doc {{{
/**
 * <image> tag.
 *
 * The tag image is used to add image in the document. You can write text on the
 * image using tags text or paragraph. Tag image can be used to add image on
 * header. 
 *
 * {@example image.xml}
 *
 * @author guillaume l. <guillaume@geelweb.org>
 * @link http://www.geelweb.org
 * @license http://opensource.org/licenses/bsd-license.php BSD License 
 * @copyright copyright © 2006, guillaume luchet
 * @version CVS: $Id: xml2pdf.tag.image.php,v 1.8 2007/01/05 23:07:31 geelweb Exp $
 * @package Xml2Pdf
 * @subpackage Tag
 * @tutorial Xml2Pdf/Xml2Pdf.Tag.image.pkg
 */ // }}}
Class xml2pdf_tag_image {
    // class properties {{{

    /**
     * image file name.
     * @var string
     */
    public $file = null;

    /**
     * top margin.
     * @var float
     */
    public $top = 0;

    /**
     * left margin.
     * @var float
     */
    public $left = 0;

    /**
     * image width.
     * @var float
     */
    public $width = 0;

    /**
     * image height.
     * @var float
     */
    public $height = 0;

    /**
     * positioning mode.
     * @var string
     */
    public $position = 'relative';
    
    /**
     * image's type
     * @var string
     */
    public $type = 'png';
    
    /**
     * parent tag
     * @var object
     */
    private $_parent;

    protected $pdf;
    // }}}
    // xml2pdf_tag_image::__construct() {{{
    
    /**
     * Constructor.
     *
     * @param array $tagProperties tag properties
     * @param object $parent Object Xml2PfdTag
     * @return void
     */
    public function __construct($tagProperties, $parent=false) {
        if(isset($tagProperties['FILE'])) {
            $this->file = $tagProperties['FILE'];
        }
        if(isset($tagProperties['WIDTH'])) {
            $this->width = $tagProperties['WIDTH'];
        }
        if(isset($tagProperties['HEIGHT'])) {
            $this->height = $tagProperties['HEIGHT'];
        }
        if(isset($tagProperties['TOP'])) {
            $this->top = $tagProperties['TOP'];
        }
        if(isset($tagProperties['LEFT'])) {
            $this->left = $tagProperties['LEFT'];
        }
        if(isset($tagProperties['POSITION'])) {
            $this->position = $tagProperties['POSITION'];
        }
        if(isset($tagProperties['TYPE'])) {
            $this->type = $tagProperties['TYPE'];
        }

        $this->_parent = $parent;    
        $this->pdf = Pdf::singleton();
   }

    // }}}
   // xml2pdf_tag_image::addContent(string) {{{

    /**
     * Add content.
     *
     * @return void
     */
    public function addContent($content) {
        $this->file = base64_decode($content);
    } 
    
    // }}}
    // xml2pdf_tag_image::close() {{{
    
    /**
     * close the tag.
     *
     * @return void
     */
    public function close() {
        if (is_a($this->_parent, 'xml2pdf_tag_header')) {
                $this->_parent->elements[] = $this;
        } else {
            // Displaying the image
            if($this->position=='relative') {
                $this->left += $this->pdf->GetX();
                $this->top += $this->pdf->GetY();
            }
            $this->pdf->Image((string)$this->file, $this->left, $this->top, 
                $this->width, $this->height, $this->type);
        }
 
    }

    // }}}
}
?>
