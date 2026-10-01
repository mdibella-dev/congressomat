<?php
namespace Congressomat\Backend;

use \Congressomat as Core;



/** Prevent direct access */
defined( 'ABSPATH' ) or exit;



/**
 * Prepares the admin pages.
 *
 * @since   3.1.0
 *
 * @param   $screen
 *
 * @return  void
 */
function current_screen( $screen ) {

    $post_types = [
         'speaker',
         'partner',
         'session',
         'exhibition_space'
    ];

    if ( isset( $screen->post_type ) and in_array( $screen->post_type, $post_types ) ) {
        add_action( 'in_admin_header', __NAMESPACE__ . '\in_admin_header' );
        add_filter( 'admin_footer_text', __NAMESPACE__ . '\admin_footer_text', 99, 0 );
        add_action( 'admin_print_footer_scripts',  __NAMESPACE__ . '\admin_footer_scripts' );
    }
}

add_action( 'current_screen', __NAMESPACE__ . '\current_screen' );



/**
 * Shows plugin name, version and credits in the footer.
 *
 * @since   3.1.0
 *
 * @param   void
 *
 * @return  string
 */
function admin_footer_text() {
    return sprintf(
        __( '<strong>Congressomat</strong> %1$s | Made by %2$s', 'congressomat' ),
        Core\PLUGIN_VERSION,
        '<a href="https://www.marcodibella.de" target="_blank">Marco Di Bella</a>'
    );
}



/**
 * Prints any scripts and data queued for the footer.
 *
 * @since   3.1.0
 *
 * @param   void
 *
 * @return  void
 */
function admin_footer_scripts() {
?>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
<?php
}



/**
 * Shows the Congrossmat page header.
 *
 * @since   3.1.0
 *
 * @param   void
 *
 * @return  void
 */
function in_admin_header() {

    $screen           = get_current_screen();
    $do_custom_header = false;

    if ( isset( $screen->id ) ) {

        $page_button_link  = '';
        $page_button_title = '';

        switch ( $screen->id ) {

            case 'session':
            case 'speaker':
            case 'partner':
            case 'exhibition_space':
            case 'edit-event':
            case 'edit-location':
            case 'edit-partnership':
            case 'edit-exhibition_package':
                $do_custom_header = true;
                break;

            case 'edit-session':
            case 'edit-partner':
            case 'edit-speaker':
            case 'edit-exhibition_space':
                    $do_custom_header = true;
                    $post_type_object = get_post_type_object( $screen->post_type );

                    if ( empty ( $screen->action ) ) {
                        $page_button_link  = 'post-new.php?post_type=' . $screen->post_type;
                        $page_button_title = $post_type_object->labels->add_new_item;
                    }
                break;
        }

        if ( $do_custom_header ) {

            $page_title = esc_html( get_admin_page_title() );
?>
<div class="congressomat-page-header">
    <div class="congressomat-page-header-left">
        <h1 class="congressomat-page-title"><strong>Congressomat</strong> / <?php echo $page_title; ?></h1>
    </div>
	<div class="congressomat-page-header-center">
	        <?php
            if ( ! empty( $page_button_link ) and ! empty( $page_button_title ) ) {
            ?>
	<a href="<?php echo $page_button_link; ?>" class="button button-compact button-primary"> <i data-lucide="plus"></i> <?php echo $page_button_title; ?></a>
	        <?php
            }
            ?>
	</div>
	<div class="congressomat-page-header-right"><?php /** Reserved for future use */ ?></div>
</div>
<?php
        }
    }
}
