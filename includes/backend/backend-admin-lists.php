<?php
namespace Congressomat\Backend;



/** Prevent direct access */
defined( 'ABSPATH' ) or exit;



/**
 * Hides various columns in the admin overview by default.
 *
 * @since   1.0.0
 *
 * @param   array $hidden
 * @param   $screen
 *
 * @return  array
 */
function default_hidden_columns( $hidden, $screen ) {

    if ( isset( $screen->id ) ) {
        switch ( $screen->id ) {
            case 'edit-event':
                $hidden[] = 'slug' ;
                break;

            case 'edit-location':
            case 'edit-partnership':
            case 'edit-exhibition_package':
                $hidden[] = 'description';
                $hidden[] = 'slug';
                break;
        }
    }

    return $hidden;
}

add_filter( 'default_hidden_columns', __NAMESPACE__ . '\default_hidden_columns', 10, 2 );



/**
 * Remove months dropdown
 *
 * @see     https://developer.wordpress.org/reference/hooks/disable_months_dropdown/
 *
 * @since   3.0.0
 *
 * @param   bool  $disable
 * @param   array $type
 *
 * @return  bool
 */
function disable_months_dropdown( $disable, $type ) {
    $post_types = [
        'speaker',
        'partner',
        'session',
        'exhibition_space'
    ];

    if ( in_array( $type, $post_types ) ) {
        $disable = true;
    }

    return $disable;
}

add_filter( 'disable_months_dropdown', __NAMESPACE__ . '\disable_months_dropdown', 10, 2 );



/**
 * Remove view link in row actions
 *
 * @see     https://developer.wordpress.org/reference/hooks/post_row_actions/
 *
 * @since   3.1.0
 *
 * @param   array $actions
 * @param   $post
 *
 * @return  array
 */
function modify_list_row_actions( $actions, $post ) {
    $post_types = [
        'speaker',
        'partner',
        'session',
        'exhibition_space'
    ];

    if ( in_array( $post->post_type, $post_types ) ) {
        unset( $actions['view'] );
    }
    return $actions;
}

add_filter( 'post_row_actions', __NAMESPACE__ . '\modify_list_row_actions', 10, 2 );
