<?php


/**
* This is the layout class. It builds the main content shit
*/
class Layout {

    public static $output = '';
    public static $template;
    public static $site_settings;
    public static $sidebar;
    public static $content;

    public function __construct($content = null){
        self::$site_settings = get_option('bswp_site_settings');
        self::getTemplateType();
        self::sidebarPosition();
        self::$content = $content;

    }

    public function __toString(){
        self::$output = self::scaffolding_init();
        return self::$output;
    }

    public static function is_body_contained() {
        $layout = self::$site_settings['misc']['layout'];
        $full_width = ($layout['full_width'] == 'no') ? true : false;

        return $full_width;
    }


    public static function contain_section() {
        $contained = self::is_body_contained();
        return $contained ? '' : 'container';
    }


    public static function loop()
    {
        $content = new Content();
        $content::set_template(self::$template);

        $output = '';
        /* ---------------------- The Loop ----------------------- */
        if (have_posts()){

            if($pagination_top == 'true'){
                $output .= new Pagination();
            }

            //open content-list/single wrapper
            if( !is_single() && !is_page() && !is_attachment() ){
                $output .= '<div class="content-feed">';
            }else{
                $output .= '<div class="content-single">';
            }
            while (have_posts()){
                the_post();
                $output .= $content;
            }

            $output .= '</div>'; //close content-list/single wrapper

            // pagination
            $output .= new Pagination();

        }else{
            $output .= '<div class="content-wrapper">';
                $output .= kjd_the_404();
            $output .= '</div>';
        }

        return $output;
    }



    public static function mainColumn($width = 'span12', $pagination_top = false, $content = null) {

        $output = '';
        //content div
        $output .= '<div id="main-content" class="'.$width.'">';

            $output .= $content ? $content : self::loop();

        //end main content
        $output .= '</div>'; // end maincontent span

        return $output;
    }


    public static function columns() {

        $template = self::$template;
        $width = in_array(self::$sidebar->position, array('left', 'right')) ? 'span9' : 'span12';

        // sidebar if on top on left
        if(self::$sidebar->position =='top' || self::$sidebar->position =='left')
            $output .= new Sidebar(self::$template, self::$sidebar->position, self::$sidebar->visibility);


        $output .= self::mainColumn($width, false, self::$content);

        // sidebar if on bottom or right
        if(self::$sidebar->position =='bottom' || self::$sidebar->position =='right')
            $output .= new Sidebar(self::$template, self::$sidebar->position, self::$sidebar->visibility);

        return $output;
    }


    public static function scaffolding_init(){

        $output = '';

        // get the title
        // $output .= self::$get_the_title();

        //start scaffolding
        $output .= '<div id="body" class="section section--body">';
            $output .= '<div class="'.self::contain_section().'">';
                $output .= '<div class="row">';


                    $output .= self::columns();

                    // close scaffolding

                $output .= '</div>';//	<!-- end row -->
            $output .= '</div>';// <!-- end container -->
        $output .= '</div>'; //<!-- end body -->


        return $output;

    }


    public static function sidebarPosition()
    {
        $layouts = self::$site_settings['layouts'];
        $sidebars = $layouts['sidebars'];

        // examine($sidebars);

        foreach($sidebars as $name=>$sidebar){

            if(strpos($name, self::$template) !== false) {
                self::$sidebar = json_decode($sidebar);
            }

        }
    }

    /**
    * This detects the current page's/post's /feed's template and gets teh layout settings appropriately
    * Layout settings for now, are nothing more than the position of the sidebar, as well as sidebar visibility.
    *
    * @param  [type] $template [description]
    * @return [type]           [description]
    */
    public static function getTemplateType() {

        //	if the page is a post type

        if( is_single() ){

            $template = 'single';

        }elseif( is_attachment() ){

            // $template = 'attachment';
            $template = 'single';

        }elseif( is_404() ){

            // $template = '404';
            $template = 'single';

        }elseif( is_feed() ){
            $template = self::is_feed();

        }elseif( is_front_page() ){

            $template = 'frontpage';

        }elseif( is_page() ){

            $template = 'single';
            // if current page is page template
            if( is_page_template() )
            $template = self::isPageTemplate();

            //fallback - if not a post template OR a page
        }else{

            $template = 'feed';
        }

        self::$template = $template;

    }


    public static function isFeed()
    {
        if( is_category() ){
            // $template = 'category';
            $template = 'feed';
        }elseif( is_archive() ){
            // $template = 'archive';
            $template = 'feed';
        }elseif( is_tag() ){
            // $template = 'tag';
            $template = 'feed';
        }elseif( is_author() ){
            // $template = 'author';
            $template = 'feed';
        }elseif( is_date() ){
            // $template = 'date';
            $template = 'feed';
        }elseif( is_search() ){
            // $template = 'search';
            $template = 'feed';
        }

        return $template;
    }

    public static function isPageTemplate()
    {

        $is_page_template = true;

        if ( is_page_template('pageTemplate1.php') ){

            $template = 'template_1';

        }elseif( is_page_template('pageTemplate2.php') ){

            $template = 'template_2';

        }elseif( is_page_template('pageTemplate3.php') ){

            $template = 'template_3';

        }elseif( is_page_template('pageTemplate4.php') ){

            $template = 'template_4';

        }elseif( is_page_template('pageTemplate5.php') ){

            $template = 'template_5';

        }elseif( is_page_template('pageTemplate6.php') ){

            $template = 'template_6';

        }else{

            $template = 'page';
        }

    }

}
