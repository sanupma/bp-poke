<?php



// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class BP_Poke_Screens  {

	function __construct() {
          
            add_action( 'bp_setup_nav', array( $this, 'setup_settings_nav'), 11 );
	}
        
        function setup_settings_nav() {
            
            global $bp;

        
            if( is_user_logged_in() ){
                
                $settings_link = bp_loggedin_user_domain() . bp_get_settings_slug() . '/';
                bp_core_new_subnav_item( array( 'name' => __( 'Poke', 'bp-poke' ), 'slug' => 'pokes', 'parent_url' => $settings_link, 'parent_slug' => $bp->settings->slug, 'screen_function' => array( $this, 'screen_poke_list'), 'position' => 59, 'user_has_access' => bp_is_my_profile() ) );

            }
            
            
        }
        
        
     function screen_poke_list(){
         
        add_action( 'bp_template_title',   array( $this,'poke_page_title' ) );
	    add_action( 'bp_template_content', array( $this, 'poke_list_content') );
	    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
     }   

     function poke_page_title(){
         
         echo '<h3>'. __('Pokes', 'bp-poke') . '</h3>';
     }
     
     function poke_list_content(){ 

                        
            $poked_id =  get_current_user_id();
            $pokes    =  bp_get_user_meta( $poked_id,'pokes',true );
            $url      =  bp_core_get_user_domain( $poked_id );
            if( $pokes ):
                echo '<ul class="poke-list">';
                foreach( $pokes as $poke ):?>
                  <li class="poke-item"> <?php printf( '<strong>%s</strong> poked you', bp_core_get_user_displayname( $poke['poked_by'] ) );?>
                      <a class="poke-back"  title="<?php _e('Poke back', 'bp-poke' );?>" href="<?php echo bp_poke_get_poke_back_url( $poke['poked_by'] ) ;?>"> <?php _e('Poke Back', 'bp-poke');?></a>
                   </li>
                   
                <?php endforeach;?>
                <?php echo '</ul>';?>
            <?php else: ?>     
              <div id="message" class="info"><p><?php _e( 'Nothing to be seen!','bp-poke'); ?></p></div> 
            <?php endif;
         }
     
}

new BP_Poke_Screens();