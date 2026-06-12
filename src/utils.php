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
	add_submenu_page(
		'litespeed',
		'LiteSpeed Cache Helper',
		'LiteSpeed Cache Helper',
		'manage_options',
		'litespeed-debug',
		'lsc_debug_admin_menu_page'
	);
}

function lsc_debug_admin_menu_page()
{
	require_once LSCWP_DEBUG_DIR.'litespeed-cache-helper_template.php';
}
