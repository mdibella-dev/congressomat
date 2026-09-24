<?php
namespace Congressomat\Third_Party\Rank_Math;



/** Prevent direct access */
defined( 'ABSPATH' ) or exit;



/**
 * Filter decision if taxonomy is excluded from the XML sitemap.
 *
 * @see     https://rankmath.com/kb/filters-hooks-api-developer/ RankMath knowledge base article.
 *
 * @since   3.0.0
 *
 * @param   bool   $exclude Default false
 * @param   string $type    Taxonomy name
 *
 * @return  bool true|false
 */
add_filter( 'rank_math/sitemap/exclude_taxonomy', function( $exclude, $type) {
    $taxonomies = [
        'event',
        'exhibition-package',
        'location',
        'partnership'
    ];

    if ( in_array( $type, $taxonomies ) ) {
        $exclude = true;
    }

    return $exclude;
 } );



/**
 * Filter decision if post type is excluded from the XML sitemap.
 *
 * @see     https://rankmath.com/kb/filters-hooks-api-developer/ RankMath knowledge base article.
 *
 * @since   3.0.0
 *
 * @param   bool   $exclude Default false
 * @param   string $type    Post type name
 *
 * @return  bool true|false
 */
add_filter( 'rank_math/sitemap/exclude_post_type', function( $exclude, $type ) {
    $post_types = [
        'speaker',
        'partner',
        'session',
        'exhibition-space'
    ];

    if ( in_array( $type, $post_types ) ) {
        $exclude = true;
    }

    return $exclude;
} );



/**
 * Filter to exclude post types from Analytics Index.
 *
 * @see     https://rankmath.com/kb/filters-hooks-api-developer/ RankMath knowledge base article.
 *
 * @since   3.1.0
 *
 * @param   array $post_types List of post types
 *
 * @return  array
 */
add_filter( 'rank_math/analytics/post_types', function( $post_types = [] ) {
    $excludes = [
        'speaker',
        'partner',
        'session',
        'exhibition-space'
    ];

    return array_diff_key( $post_types, array_flip( $excludes ) );
} );
