<?php

class TabOrganizer{
    
    protected $tabs = array();
    protected $tabNames = array();
    protected $tabContents = array();

    private $tabButtons = array();

    public $posts_per_page = 26;

    public function __construct(){
    	add_action('after_different_menus_settings_page_end', array( $this, 'implementSettingsTabs' ));
    }

    public function tabItems(){
        $dir = __DIR__.'/TabItems';

        foreach(scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            require_once $dir . '/' . $file;
            $name = basename($file,".php");

            $className =  "TabItems\\$name".'\\TabItem';

            $tab = new $className();

            $btn = array();
            $btn['name'] = $tab->name;
            $btn['buttonId'] = $tab->buttonId;

            $content = array();
            $content['content'] = $tab->tabData();
            $content['buttonId'] = $tab->buttonId;

            // Use explicit property assignment
            $this->tabButtons[$tab->priority] = (object) $btn;
            $this->tabContents[$tab->priority] = (object) $content;
        }
    }

    public function tabButtons(){
        $btn = "";

        if (!empty($this->tabButtons)) {
            $btns = $this->tabButtons;
            ksort($btns);

            $x = 1;
            foreach ($btns as $key => $button) {
                $class = ($x == 1) ? 'is-active ' : '';
                $class .= esc_attr($button->buttonId);
                $btn .= '<li class="' . esc_attr($class) . '"><a href="#' . esc_attr($button->buttonId) . '">'
                    . do_action('before_different_menu_settings_tab_button')
                    . esc_html($button->name)
                    . do_action('after_different_menu_settings_tab_button')
                    . '</a></li>';
                $x++;
            }
        }

        return $btn;
    }



    public function tabOptions(){
        $option = "";

        if (!empty($this->tabButtons)) {
            $btns = $this->tabButtons;
            ksort($btns);

            $x = 1;
            foreach ($btns as $key => $button) {
                $selected = ($x == 1) ? 'selected' : '';
                $option .= '<option value="' . esc_attr($button->buttonId) . '" ' . esc_attr($selected) . '>';
                $option .= do_action('before_different_menu_settings_tab_button');
                $option .= esc_html($button->name);
                $option .= do_action('after_different_menu_settings_tab_button');
                $option .= '</option>';

                $x++;
            }
        }

        return $option;
    }

    public function tabContents($value='')
    {
        $tabContents = "";
        if (!empty($this->tabContents)) {
            $contents = $this->tabContents;
            ksort($contents);

            $x = 1;
            foreach ($contents as $key => $content) {
                $style = ($x == 1) ? 'display: block;' : 'display: none;';

                $tabContents .= '<div id="' . esc_attr($content->buttonId) . '" class="tab-contents" style="' . esc_attr($style) . '"><div id="tab-items" class="tab-items-template clearfix">';
                $tabContents .= do_action('before_different_menu_settings_tab_content');
                $tabContents .= $content->content;
                $tabContents .= do_action('after_different_menu_settings_tab_content');
                $tabContents .= '</div></div>';

                $x++;
            }

        }

        return $tabContents;
    }

    public function create_page_pagination( $current_page, $num_of_pages ) {
        $links_in_the_middle = 4;
        $links_in_the_middle_min_1 = $links_in_the_middle - 1;
        $first_link_in_the_middle   = $current_page - floor( $links_in_the_middle_min_1 / 2 );
        $last_link_in_the_middle    = $current_page + ceil( $links_in_the_middle_min_1 / 2 );
        if ( $first_link_in_the_middle <= 0 ) {
            $first_link_in_the_middle = 1;
        }
        if ( ( $last_link_in_the_middle - $first_link_in_the_middle ) != $links_in_the_middle_min_1 ) {
            $last_link_in_the_middle = $first_link_in_the_middle + $links_in_the_middle_min_1;
        }
        if ( $last_link_in_the_middle > $num_of_pages ) {
            $first_link_in_the_middle = $num_of_pages - $links_in_the_middle_min_1;
            $last_link_in_the_middle  = (int) $num_of_pages;
        }
        if ( $first_link_in_the_middle <= 0 ) {
            $first_link_in_the_middle = 1;
        }
        $pagination = '';
        if ( $current_page != 1 ) {
            $pagination .= '<li class="page-item"><a class="page-link" page_id="'.( $current_page - 1 ).'" href="/page/' . ( $current_page - 1 ) . '">Previous</a></li>';
        }
        if ( $first_link_in_the_middle >= 3 && $links_in_the_middle < $num_of_pages ) {
            $pagination .= '<li class="page-item"><a class="page-link" href="/page/" class="page-numbers">1</a></li>';

            if ( $first_link_in_the_middle != 2 ) {
                $pagination .= '<span class="page-numbers extend">...</span>';
            }
        }
        for ( $i = $first_link_in_the_middle; $i <= $last_link_in_the_middle; $i ++ ) {
            if ( $i == $current_page ) {
                $pagination .= '<li class="page-item active"><a class="page-link" page_id="'.$i.'" href="#">'.$i.'<span class="sr-only">(current)</span></a></li>';
            } else {
                $pagination .= '<li class="page-item"><a class="page-link" href="/page/' . $i . '" page_id="'.$i.'" class="page-numbers">' . $i . '</a></li>';
            }
        }
        if ( $last_link_in_the_middle < $num_of_pages ) {
            if ( $last_link_in_the_middle != ( $num_of_pages - 1 ) ) {
                $pagination .= '<span class="page-numbers extend" style="padding: 0 5px;">...</span>';
            }
            $pagination .= '<li class="page-item"><a class="page-link" href="/page/' . $num_of_pages . '" page_id="'.$num_of_pages.'" class="page-numbers">' . $num_of_pages . '</a></li>';
        }
        if ( $current_page != $last_link_in_the_middle ) {
            $pagination .= '<li class="page-item"><a class="page-link" href="/page/' . ( $current_page + 1 ) . '" page_id="'.($current_page + 1).'" class="next page-numbers">Next</a></li>';
        }

        return $pagination;
    }

    public function get_child_posts($posts, $level = 1){
        if (!empty($posts)) {
            $key = 'page';
            foreach ($posts as $key2 => $post) {

                echo '<div class="child_pages level_' . esc_attr($level) . '">';

                echo '<div class="child_page"><label><input type="checkbox" name="post_type[' . esc_attr($key) . '][' . esc_attr($post->post_name) . ']" /><span class="label_title">' . esc_html($post->post_title) . '</span><span class="diff_permalink">' . esc_url(get_permalink($post->ID)) . '</span></label></div>';

                $child_posts = get_posts( array( 'post_type' => $key, 'post_status' => 'publish', 'order' => 'ASC', 'orderby' => 'title', 'post_parent' => $post->ID) );

                if (!empty($child_posts)) {
                    $this->get_child_posts($child_posts, $level+1);
                }

                echo '</div>';
            }
        }
    }

    public function get_terms_hierarchical($posts_per_page=4) {

        $all_terms = get_terms('category');
        $terms = array_filter($all_terms, function($term) {
            return $term->parent == 0;
        });
        //get_term_link($term->slug, 'species')
        if (!empty($terms)) {
            $x = 1;
            foreach ($terms as $key => $term) {
                if ($x <= $posts_per_page) {

                    if ($x % 2 == 0 ) {
                        $class = 'float-right';
                    } else {
                        $class = 'float-left';
                    }
                    echo '<div class="parent_cat ' . esc_attr($class) . '"><div class="parent"><label><input type="checkbox" name="tax[category][' . esc_attr($term->slug) . ']"  /><span class="label_title">' . esc_html($term->name) . '</span><span class="diff_permalink">' . esc_url(get_term_link($term->slug, 'category')) . '</span></label></div>';

                    $all_terms = get_terms('category');

                    $child_cats = array_filter($all_terms, function($term0) use ($term) {
                        return $term0->parent == $term->term_id;
                    });

                    if (!empty($child_cats)) {
                        $this->get_terms_data_with_hierarchical($child_cats, 2);
                    }

                    echo '</div>';
                    $x++;
                }
            }
        }
    }
    public function get_terms_data_with_hierarchical($terms, $level = 1){
        if (!empty($terms)) {
            foreach ($terms as $key => $term) {

                echo '<div class="child_cats"><div class="child_cat cat_level_' . esc_attr($level) . '"><label><input type="checkbox" name="tax[category][' . esc_attr($term->slug) . ']"  /><span class="label_title">' . esc_html($term->name) . '</span><span class="diff_permalink">' . esc_url(get_term_link($term->slug, 'category')) . '</span></label></div>';

                $all_terms = get_terms('category');
                $child_cats = array_filter($all_terms, function($term0) use ($term) {
                    return $term0->parent == $term->term_id;
                });

                if (!empty($child_cats)) {
                    $this->get_terms_data_with_hierarchical($child_cats, $level+1);
                }

                echo '</div>';
            }
        }
    }


    public function differentMenusSettingsTab()
   	{
   		$this->tabItems();
   		ob_start();
   		?>

		<div id="set_conditions" class="modal" data-easein="flipXIn" tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h4 class="modal-title">
		                    <?php esc_html_e('Add different menu conditions', 'different-menu'); ?>
		                </h4>

		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		                    ×
		                </button>
		            </div>
		            <div class="modal-body">

		                <div class="tabs">
		                    <div class="tab-button-outer">
		                        <ul id="tab-button">
		                            <!-- Tab buttons -->
		                            <?php echo $this->tabButtons(); ?>
		                        </ul>
		                    </div>
		                    <div class="tab-select-outer">
		                        <select id="tab-select">
		                            <!-- Tab button options -->
		                            <?php echo $this->tabOptions(); ?>
		                        </select>
		                    </div>

		                    <!-- Tab contents -->
		                    <?php echo $this->tabContents(); ?>
		                </div>

		            </div>

		            <div class="modal-footer">
		                <div class="check_all" style="position: absolute;left: 50px;margin-top: 6px;">
		                    <input type="checkbox" id="check_all">
		                    <label for="check_all"> Check all</label>
		                </div>

		                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">
		                    Close
		                </button>
		                <button class="btn btn-primary save_conditions">
		                    <?php esc_html_e('Save changes', 'different-menu'); ?>
		                </button>
		            </div>
		        </div>
		    </div>
		</div>

   		<?php

   		$maintab = ob_get_clean();

   		return $maintab;
   	}

   	public function implementSettingsTabs()
   	{
   	    /*Main Settings Tab*/
	    echo $this->differentMenusSettingsTab();

	    /*Backup and restore settings Tab*/
	    require_once 'Tabs/BackUpAndRestore.php';

	    /*Duplicate menus Tab*/
	    require_once 'Tabs/DuplicateMenus.php';

	    /*Remove Menu Tab*/
	    require_once 'Tabs/RemoveMenu.php';

	    /*Reset Menu Tab*/
	    require_once 'Tabs/ResetSettings.php';
   	}

}
