<?php

function lsc_debug_show_admin_content(){
    $action = lsc_debug_get_action();

    return !lsc_debug_show_back($action);
}

function lsc_debug_test_if_debug_action(){
	return isset($_REQUEST[LSCWP_DEBUG_PARAM_ACTION]);
}

function lsc_debug_get_action(){
    return isset($_REQUEST[LSCWP_DEBUG_PARAM_ACTION]) ? sanitize_key($_REQUEST[LSCWP_DEBUG_PARAM_ACTION]) : false;
}

// Action name to function
function lsc_debug_get_action_function($action){
    return isset(LSCWP_DEBUG_ACTIONS_FUNCTIONS[$action]['function']) ? 'lsc_debug_'.LSCWP_DEBUG_ACTIONS_FUNCTIONS[$action]['function'] : false;
}

// Admin Create admin link
function lsc_debug_admin_create_link($action = false){
    $url = admin_url('admin.php?page=litespeed-debug');
    if ($action) {
        $url = add_query_arg(LSCWP_DEBUG_PARAM_ACTION, $action, $url);
        $url = wp_nonce_url($url, 'lsc_debug_action_' . $action);
    }
    return $url;
}

// Whether this action verifies its own nonce inside its function (POST forms)
function lsc_debug_action_self_verifies($action){
    return ! empty(LSCWP_DEBUG_ACTIONS_FUNCTIONS[$action]['self_nonce']);
}

// Admin Show Back link
function lsc_debug_show_back($action){
    return isset(LSCWP_DEBUG_ACTIONS_FUNCTIONS[$action]['new_page']) && LSCWP_DEBUG_ACTIONS_FUNCTIONS[$action]['new_page'];
}

// Admin Messages
function lsc_debug_function_run_ok($action){
    if(!$action) return false;

    $message = isset(LSCWP_DEBUG_ACTIONS_FUNCTIONS[$action]['message_ok']) ? LSCWP_DEBUG_ACTIONS_FUNCTIONS[$action]['message_ok'] : false;
    if($message){
        echo lsc_debug_show_message($message);
    }
}


function lsc_debug_function_run_error($action){
    if(!$action) return false;

    $message = isset(LSCWP_DEBUG_ACTIONS_FUNCTIONS[$action]['message_error']) ? LSCWP_DEBUG_ACTIONS_FUNCTIONS[$action]['message_error'] : false;
    if($message){
        echo lsc_debug_show_message($message, 'error');
    }
}

// Admin Messages HTML
function lsc_debug_show_message($message = false , $type = 'success'){
    if($message){
        return '<div class="notice notice-'.$type.' is-dismissible">
            <p>'.$message.'</p>
        </div>';
    }
    else return '';
}

// Admin menu
function lsc_debug_admin_menu(){
	$hook = add_submenu_page(
		'litespeed',
		'LiteSpeed Cache Helper',
		'LiteSpeed Cache Helper',
		'manage_options',
		'litespeed-debug',
		'lsc_debug_admin_menu_page'
	);
	// Process actions BEFORE any output so we can redirect (PRG pattern)
	if ( $hook ) {
		add_action( 'load-' . $hook, 'lsc_debug_handle_actions' );
	}
}

function lsc_debug_admin_menu_page()
{
	require_once LSCWP_DEBUG_DIR.'litespeed-cache-helper_template.php';
}

// Clean page URL (no action / no nonce)
function lsc_debug_clean_page_url(){
	return admin_url('admin.php?page=litespeed-debug');
}

// Transient store for post-redirect feedback
function lsc_debug_store_feedback($data){
	set_transient('lsc_debug_feedback_' . get_current_user_id(), $data, 60);
}
function lsc_debug_get_feedback(){
	$key  = 'lsc_debug_feedback_' . get_current_user_id();
	$data = get_transient($key);
	if ( $data !== false ) {
		delete_transient($key);
		return $data;
	}
	return null;
}

// Central action handler — runs before output, then redirects clean
function lsc_debug_handle_actions(){
	if ( ! current_user_can('manage_options') ) {
		return;
	}

	$notices     = array();   // each: array($type, $html_message)
	$render_html = '';        // full-page output (Server Info / Async Test)
	$img_optm    = null;      // image-optm result array
	$did_action  = false;

	// ---- Helper POST actions (Auto Purge / Metabox / Image Optm) ----
	if ( isset($_POST['lsc_helper_action']) ) {
		$helper_action = sanitize_key($_POST['lsc_helper_action']);

		if ( $helper_action === 'toggle_auto_purge' && check_admin_referer('lsc_helper_toggle_purge') ) {
			$current = get_option('lsc_helper_disable_auto_purge', 'no');
			update_option('lsc_helper_disable_auto_purge', $current === 'yes' ? 'no' : 'yes');
			$notices[]  = array('success', 'Auto Purge setting updated successfully.');
			$did_action = true;
		}
		elseif ( $helper_action === 'clear_metabox_option' && check_admin_referer('lsc_helper_clear_metabox') ) {
			$meta_key = isset($_POST['metabox_key']) ? sanitize_text_field($_POST['metabox_key']) : '';
			$deleted  = function_exists('lsc_helper_clear_metabox_option') ? lsc_helper_clear_metabox_option($meta_key) : false;
			if ( $deleted !== false ) {
				$notices[] = array('success', 'Successfully removed <strong>' . intval($deleted) . '</strong> database records for <code>' . esc_html($meta_key) . '</code>.');
			} else {
				$notices[] = array('error', 'Invalid meta key or an error occurred.');
			}
			$did_action = true;
		}
		elseif ( in_array($helper_action, array('analyze_img_optm', 'apply_img_optm'), true) && check_admin_referer('lsc_helper_img_optm') ) {
			$img_optm = lsc_helper_analyze_image_optm( $helper_action === 'apply_img_optm' );
			if ( $img_optm && $img_optm['status'] === 'error' ) {
				$notices[] = array('error', esc_html($img_optm['message']));
			}
			$did_action = true;
		}
	}

	// ---- Debug actions (GET links + node/TTL POST forms) ----
	if ( lsc_debug_test_if_debug_action() ) {
		$action = lsc_debug_get_action();
		if ( $action ) {
			// GET links protected by URL nonce; POST forms self-verify inside their function.
			if ( ! lsc_debug_action_self_verifies($action) ) {
				check_admin_referer('lsc_debug_action_' . $action);
			}

			$function = lsc_debug_get_action_function($action);
			if ( function_exists($function) ) {
				try {
					if ( lsc_debug_show_back($action) ) {
						// "new_page" actions return their HTML for display after redirect
						$render_html = $function(false);
					} else {
						$function();
						$msg = isset(LSCWP_DEBUG_ACTIONS_FUNCTIONS[$action]['message_ok']) ? LSCWP_DEBUG_ACTIONS_FUNCTIONS[$action]['message_ok'] : false;
						if ( $msg ) { $notices[] = array('success', $msg); }
					}
				} catch ( Exception $e ) {
					$msg = isset(LSCWP_DEBUG_ACTIONS_FUNCTIONS[$action]['message_error']) ? LSCWP_DEBUG_ACTIONS_FUNCTIONS[$action]['message_error'] : false;
					if ( $msg ) { $notices[] = array('error', $msg); }
				}
			} else {
				$notices[] = array('error', 'Incorrect function called.');
			}
			$did_action = true;
		}
	}

	if ( ! $did_action ) {
		return; // plain page load — nothing to redirect
	}

	lsc_debug_store_feedback(array(
		'notices'     => $notices,
		'render_html' => $render_html,
		'img_optm'    => $img_optm,
	));

	wp_safe_redirect( lsc_debug_clean_page_url() );
	exit;
}
