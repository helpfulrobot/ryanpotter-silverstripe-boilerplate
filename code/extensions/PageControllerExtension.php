<?php

/**
 * Class PageControllerExtension
 */
class PageControllerExtension extends Extension {

	public function onBeforeInit() {

        /** =========================================
         * Resources
        ===========================================*/

        $baseHref = Director::BaseURL();

        /** -----------------------------------------
         * Javascript
        -------------------------------------------*/

        Requirements::insertHeadTags('<script type="text/javascript" src="'.$baseHref.project().'/javascript/lib/modernizr.js"></script>');

        /**
         * Set All JS to be right before the closing </body> tag.
         */
        Requirements::set_force_js_to_bottom(true);
        Requirements::javascript(project().'/javascript/main.min.js');

        /** -----------------------------------------
         * CSS
        -------------------------------------------*/

        Requirements::css(project().'/css/font-awesome.min.css');
        Requirements::css(project().'/css/main.min.css');

        /** -----------------------------------------
         * Shivs
        -------------------------------------------*/

        Requirements::insertHeadTags('<!--[if lt IE 9]>
            <script type="text/javascript" src="'.$baseHref.project().'/javascript/lib/html5shiv.min.js"></script>
            <script type="text/javascript" src="'.$baseHref.project().'/javascript/lib/respond.min.js"></script>
        <![endif]-->');

    }

    // TODO Implement somewhere.
    /**
     * @return array
     * Change the page template depending on the "DisplayType" row.
     */
//    public function index(){
//        if($this->DisplayType == 'Grid'){
//            $class = $this->ClassName . "_Controller";
//            $controller = new $class($this);
//            return $controller->renderWith(array('MenuHolder_Grid', 'Page'));
//        }
//        return array();
//    }

}