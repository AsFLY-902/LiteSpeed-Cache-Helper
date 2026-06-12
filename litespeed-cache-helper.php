<?php

/**
 * Plugin Name:       LiteSpeed Cache Helper
 * Plugin URI:        https://www.litespeedtech.com/products/cache-plugins/wordpress-acceleration
 * Description:       Helper plugin for LiteSpeed Cache
 * Version:           1.0.0
 * Author:            LiteSpeed Technologies
 * Author URI:        https://www.litespeedtech.com
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl.html
 * Text Domain:       litespeed-cache
 * Domain Path:       /lang
 *
 * Copyright (C) 2015-2026 LiteSpeed Technologies, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.

 */

defined('WPINC') || exit();

add_action('init', 'lsc_debug_start', 99);

function lsc_debug_start(){
	!defined('LSCWP_DEBUG_DIR') && define('LSCWP_DEBUG_DIR', __DIR__ . '/');

	require_once LSCWP_DEBUG_DIR.'src/const.php';
	require_once LSCWP_DEBUG_DIR.'src/utils.php';
	require_once LSCWP_DEBUG_DIR.'src/actions.php';
	
	// Add admin menu and show content
	add_action('admin_menu', 'lsc_debug_admin_menu', 9999);
}

// Handle Disable Auto Purge functionality
add_action('init', 'lsc_helper_apply_disable_auto_purge');
function lsc_helper_apply_disable_auto_purge() {
    // Check if the setting is enabled in the database
    if (get_option('lsc_helper_disable_auto_purge', 'no') === 'yes') {
        if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], "LSCWP_NONCE") === false) {
            ob_start(function($buffer) {
                @header('X-LiteSpeed-Purge: nothing');
                return $buffer;
            });
        }
    }
}

// Fast Forward Image Optimization Position
function lsc_helper_analyze_image_optm( $apply = false ) {
    if ( ! is_admin() || ! current_user_can('manage_options') ) {
        return ['status' => 'error', 'message' => 'Unauthorized access.'];
    }
    
    if ( function_exists('set_time_limit') ) {
        @set_time_limit(300);
    }

    global $wpdb;
    
    $attachment_ids = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND post_mime_type IN ('image/jpeg', 'image/png', 'image/gif') ORDER BY ID ASC" );

    if ( empty($attachment_ids) ) {
        return ['status' => 'error', 'message' => 'No media attachments found.'];
    }

    $first_pending_id = -1;
    $last_optimized_id = 0; // Track the safe posd id position
    $optimized_count = 0;
    $unoptimized_count = 0;

    foreach ( $attachment_ids as $id ) {
        $optimized = false;

        // 1. Check LiteSpeed Metadata
        if ( get_post_meta( $id, 'litespeed-optimize-size', true ) || get_post_meta( $id, 'litespeed-optimize-set', true ) ) {
            $optimized = true;
        }

        // 2. Check Physical Files and Native Upload Types
        if ( ! $optimized ) {
            $mime_type = get_post_mime_type( $id );
            if ( in_array( $mime_type, ['image/webp', 'image/avif'] ) ) {
                $optimized = true;
            } else {
                $full_path = get_attached_file( $id );
                if ( ! empty( $full_path ) ) {
                    if ( file_exists( $full_path . '.webp' ) || file_exists( $full_path . '.avif' ) ) {
                        $optimized = true;
                    }
                }
            }
        }

        if ( $optimized ) {
            $optimized_count++;
            $last_optimized_id = (int) $id; // Move the post id forward
        } else {
            $unoptimized_count++;
            if ( $first_pending_id === -1 ) {
                $first_pending_id = (int) $id;
            }
        }
    }

    // Set target to the last confirmed optimized image so LiteSpeed resumes scanning immediately after it
    $cursor_target = $last_optimized_id;

    $result = [
        'status' => 'success',
        'optimized_count' => $optimized_count,
        'unoptimized_count' => $unoptimized_count,
        'first_pending_id' => $first_pending_id,
        'cursor_target' => $cursor_target
    ];

    // Apply logic to override LiteSpeed Summary
    if ( $apply ) {
        if ( class_exists('\LiteSpeed\Img_Optm') ) {
            $summary = \LiteSpeed\Img_Optm::get_summary();
            $summary['next_post_id'] = $cursor_target;
            \LiteSpeed\Img_Optm::save_summary( $summary, false, true );
            
            if ( $first_pending_id !== -1 ) {
                $result['message'] = "image post id position updated to {$cursor_target}. LiteSpeed will correctly scan starting from post id: {$first_pending_id}.";
            } else {
                $result['message'] = "All images are optimized! image post id position updated to max post id {$cursor_target} to skip rescanning on your next upload.";
            }
        } else {
            $result['status'] = 'error';
            $result['message'] = "LiteSpeed Img_Optm class not found. Ensure LSCWP is active.";
        }
    }

    return $result;
}

// Bulk Clear LiteSpeed Metabox Options
function lsc_helper_clear_metabox_option( $meta_key ) {
    if ( ! is_admin() || ! current_user_can('manage_options') ) {
        return false;
    }

    global $wpdb;
    
    $allowed_keys = [
        'litespeed_no_cache',
        'litespeed_no_image_lazy',
        'litespeed_no_vpi',
        'litespeed_vpi_list',
        'litespeed_vpi_list_mobile'
    ];

    if ( in_array( $meta_key, $allowed_keys, true ) ) {
        // Safely execute the deletion query
        $deleted = $wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->postmeta} WHERE meta_key = %s", $meta_key ) );
        return $deleted; // Returns the number of affected rows
    }

    return false;
}
