<div class="wrap lsc-helper-wrap">
    <style>
        /* Modern WP Dashboard Layout with Sidebar Navigation */
        .lsc-helper-wrap {
            max-width: 1200px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
        }
        .lsc-helper-wrap .page-title {
            margin-bottom: 25px;
            font-weight: 600;
        }
        
        /* Layout Grid */
        .lsc-dashboard-layout {
            display: flex;
            gap: 25px;
            margin-top: 20px;
            align-items: flex-start;
        }
        
        /* Navigation Sidebar */
        .lsc-sidebar {
            width: 240px;
            flex-shrink: 0;
            background: #fff;
            border: 1px solid #ccd0d4;
            border-radius: 4px;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
            overflow: visible;
        }
        .lsc-tab-btn {
            display: block;
            width: 100%;
            padding: 14px 18px;
            background: none;
            border: none;
            border-left: 4px solid transparent;
            text-align: left;
            font-size: 14px;
            font-weight: 500;
            color: #1d2327;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            box-sizing: border-box;
            border-bottom: 1px solid #f0f0f1;
            position: relative;
        }

        /* Rounded corners for the top and bottom buttons */
        .lsc-tab-btn:first-child { border-top-left-radius: 4px; border-top-right-radius: 4px; }
        .lsc-tab-btn:last-child { border-bottom-left-radius: 4px; border-bottom-right-radius: 4px; }

        .lsc-tab-btn:hover {
            background: #f6f7f7;
            color: #2271b1;
        }
        
        .lsc-tab-btn.active {
            background: #f0f6fc;
            border-left-color: #2271b1;
            color: #2271b1;
            font-weight: 600;
        }

        /* Draws the outer border of the arrow */
        .lsc-tab-btn.active::before {
            content: "";
            position: absolute;
            right: -11px;
            top: 50%;
            transform: translateY(-50%);
            border-top: 11px solid transparent;
            border-bottom: 11px solid transparent;
            border-left: 11px solid #ccd0d4;
            z-index: 1;
        }

        /* Draws the inner background of the arrow */
        .lsc-tab-btn.active::after {
            content: "";
            position: absolute;
            right: -10px;
            top: 50%;
            transform: translateY(-50%);
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
            border-left: 10px solid #0a75ad; /* Matches active tab color */
            z-index: 2;
        }
        
        /* Main Workspace Container */
        .lsc-main-content {
            flex-grow: 1;
            background: transparent;
        }
        .lsc-tab-content {
            display: none;
        }
        .lsc-tab-content.active {
            display: block;
            animation: fadeIn 0.2s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .lsc-section-title {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.4em;
            font-weight: 600;
            color: #1d2327;
        }
        .lsc-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .lsc-card {
            background: #fff;
            border: 1px solid #ccd0d4;
            border-radius: 4px;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
            padding: 20px;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
        }
        .lsc-card h3 {
            margin-top: 0;
            margin-bottom: 12px;
            font-size: 1.1em;
            color: #1d2327;
            border-bottom: 1px solid #f0f0f1;
            padding-bottom: 10px;
        }
        .lsc-card p {
            color: #50575e;
            font-size: 13px;
            line-height: 1.5;
            margin-top: 0;
            flex-grow: 1;
        }
        .lsc-card-action {
            margin-top: 15px;
            padding-top: 15px;
        }
        .lsc-warning {
            color: #d63638;
            font-weight: 600;
        }
        .lsc-status-box {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f0f6fc;
            border-left: 4px solid #72aee6;
            border-radius: 3px;
            font-weight: 600;
            font-size: 13px;
            color: #1d2327;
        }
        .lsc-warning-quote {
            border-left: 4px solid #dba617; 
            background: #fcf9e8; 
            padding: 10px 15px; 
            margin: 0 0 15px 0; 
            font-size: 13px; 
            color: #50575e;
        }
        
        /* Structural Accents */
        .lsc-danger-card { border-top: 3px solid #d63638; }
        .lsc-info-card { border-top: 3px solid #2271b1; }
        .lsc-clear-card { border-top: 3px solid #00a32a; }
        .lsc-warning-card { border-top: 3px solid #dba617; }
        
        .lsc-card label { font-weight: 600; margin-bottom: 6px; display: inline-block; font-size: 13px; }
        .lsc-card select { width: 100%; margin-bottom: 15px; max-width: 100%; }
        .lsc-card button { width: 100%; text-align: center; justify-content: center; }
        .lsc-card a.button { width: 100%; text-align: center; box-sizing: border-box; }
        .lsc-header-actions { margin-bottom: 20px; }

        @media (max-width: 782px) {
            .lsc-dashboard-layout { flex-direction: column; }
            .lsc-sidebar { width: 100%; }
        }
    </style>

    <h1 class="wp-heading-inline page-title">LiteSpeed Cache Helper <small style="font-size: 13px; font-weight: 400; color: #646970; margin-left: 1px; vertical-align: middle;">v1.0.0</small></h1>
    <hr class="wp-header-end">

    <?php
    if( !lsc_debug_show_admin_content() ){ ?>
        <div class="lsc-header-actions">
            <a href="<?php echo esc_url(lsc_debug_admin_create_link()); ?>" class="button">&larr; Go back to Dashboard</a>
        </div>
    <?php
    }

    // Process Form Actions (Auto Purge Toggle)
    if (isset($_POST['lsc_helper_action']) && $_POST['lsc_helper_action'] === 'toggle_auto_purge') {
        check_admin_referer('lsc_helper_toggle_purge'); // Check nonce ONLY if this specific action is called
        $current_status = get_option('lsc_helper_disable_auto_purge', 'no');
        $new_status = ($current_status === 'yes') ? 'no' : 'yes';
        update_option('lsc_helper_disable_auto_purge', $new_status);
        echo '<div class="notice notice-success is-dismissible"><p>Auto Purge setting updated successfully.</p></div>';
    }

    // Process Metabox Clears
    if (isset($_POST['lsc_helper_action']) && $_POST['lsc_helper_action'] === 'clear_metabox_option' && check_admin_referer('lsc_helper_clear_metabox')) {
        $meta_key = isset($_POST['metabox_key']) ? sanitize_text_field($_POST['metabox_key']) : '';
        
        if ( function_exists('lsc_helper_clear_metabox_option') ) {
            $deleted_rows = lsc_helper_clear_metabox_option($meta_key);
            
            if ($deleted_rows !== false) {
                echo '<div class="notice notice-success is-dismissible"><p>Successfully removed <strong>' . intval($deleted_rows) . '</strong> database records for <code>' . esc_html($meta_key) . '</code>.</p></div>';
            } else {
                echo '<div class="notice notice-error is-dismissible"><p>Invalid meta key or an error occurred.</p></div>';
            }
        }
    }

    // Process Fast Forward Image Optm
    $img_optm_results = null;
    if (isset($_POST['lsc_helper_action']) && in_array($_POST['lsc_helper_action'], ['analyze_img_optm', 'apply_img_optm'])) {
        check_admin_referer('lsc_helper_img_optm'); // Check nonce ONLY if these specific actions are called
        
        if ($_POST['lsc_helper_action'] === 'analyze_img_optm') {
            $img_optm_results = lsc_helper_analyze_image_optm(false); // Dry Run
        } elseif ($_POST['lsc_helper_action'] === 'apply_img_optm') {
            $img_optm_results = lsc_helper_analyze_image_optm(true);  // Apply State
        }
        
        // Throw an error notice if the script fails execution limits or DB checks
        if ($img_optm_results && $img_optm_results['status'] === 'error') {
            echo '<div class="notice notice-error is-dismissible"><p>' . esc_html($img_optm_results['message']) . '</p></div>';
        }
    }

    // Process Debug Actions
    if(lsc_debug_test_if_debug_action()){
    $action = lsc_debug_get_action();
    if($action){
        if ( ! current_user_can('manage_options') ) {
            wp_die( esc_html__('Insufficient permissions.', 'litespeed-cache-helper') );
        }

        // GET "link" actions are protected by the URL nonce here.
        // POST "form" actions (node / TTL updates) verify their own nonce inside the function.
        if ( ! lsc_debug_action_self_verifies($action) ) {
            check_admin_referer('lsc_debug_action_' . $action);
        }

        $function = lsc_debug_get_action_function($action);
        if( function_exists($function) ){
            try{
                $function();
                lsc_debug_function_run_ok($action);
            }
            catch(Exception $e){
                lsc_debug_function_run_error($action);
            }
        }
        else echo '<p>Incorrect function called.</p>';
    }
    else echo '<p>Incorrect action added.</p>';
}

    if( lsc_debug_show_admin_content() ){
    ?>

    <div class="lsc-dashboard-layout">
        
        <div class="lsc-sidebar">
            <button class="lsc-tab-btn active" data-target="tab-diagnostics">System Diagnostics</button>
            <button class="lsc-tab-btn" data-target="tab-quic-cloud">QUIC.cloud Fixes</button>
            <button class="lsc-tab-btn" data-target="tab-nodes">Node Management</button>
            <button class="lsc-tab-btn" data-target="tab-extras">LiteSpeed Cache Extra</button>
        </div>

        <div class="lsc-main-content">

            <div id="tab-diagnostics" class="lsc-tab-content active">
                <h2 class="lsc-section-title">System Diagnostics</h2>
                <div class="lsc-grid">
                    <div class="lsc-card lsc-info-card">
                        <h3>View Server Info</h3>
                        <p>View detailed server configuration, IP routing headers, and complete PHP environment information. Essential for diagnosing setup issues.</p>
                        <div class="lsc-card-action">
                            <a href="<?php echo esc_url(lsc_debug_admin_create_link('generate_server_info')); ?>" class="button button-secondary">View Server Info</a>
                        </div>
                    </div>

                    <div class="lsc-card lsc-info-card">
                        <h3>Run Async Test</h3>
                        <p>Check the connection to the origin server for background AJAX calls (e.g., Image optimization). Helps identify if requests are being blocked by security constraints.</p>
                        <div class="lsc-card-action">
                            <a href="<?php echo esc_url(lsc_debug_admin_create_link('test_async')); ?>" class="button button-secondary">Run Async Test</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab-quic-cloud" class="lsc-tab-content">
                <h2 class="lsc-section-title">QUIC.cloud Troubleshooting & Clears</h2>
                <div class="lsc-grid">
                    <div class="lsc-card lsc-clear-card">
                        <h3>Clear Cloud Error Domains</h3>
                        <p>Removes the domain from the <code>err_domains</code> list. Run this to bypass the 10-day penalty if you cannot connect to QUIC.cloud services and debug logs show: <em>"home url is in err_domains, bypass request"</em>.</p>
                        <div class="lsc-card-action">
                            <a href="<?php echo esc_url(lsc_debug_admin_create_link('clear_err_domains')); ?>" class="button button-secondary">Clear Error Domains</a>
                        </div>
                    </div>

                    <div class="lsc-card lsc-clear-card">
                        <h3>Clear Disabled Nodes</h3>
                        <p>Clears the domain from the 24-hour bypass block for disabled nodes. Run this if all available nodes are restricted and debug logs show: <em>"nodes are in 503 failed nodes"</em>.</p>
                        <div class="lsc-card-action">
                            <a href="<?php echo esc_url(lsc_debug_admin_create_link('clear_disabled_nodes')); ?>" class="button button-secondary">Clear Disabled Nodes</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab-nodes" class="lsc-tab-content">
                <h2 class="lsc-section-title">Node & Service Management</h2>
                <div class="lsc-grid">
                    <div class="lsc-card">
                        <h3>Image Optimization Node</h3>
                        <p>Force QUIC.cloud to use a specific worker node for processing image optimization requests.</p>
                    
                        <?php 
                        $current_image_node = '';
                        if (class_exists('\LiteSpeed\Cloud')) {
                            $summary = \LiteSpeed\Cloud::get_summary();
                            $current_image_node = isset($summary['server.img_optm']) ? $summary['server.img_optm'] : 'Not set';
                        }
                        ?>
                        <div class="lsc-status-box">
                            Current Node: <?php echo esc_html($current_image_node); ?>
                        </div>
                        
                        <form method="post" action="">
                            <?php wp_nonce_field('litespeed_debug_redetect_image', 'litespeed_debug_nonce'); ?>
                            <input type="hidden" name="<?php echo esc_attr(LSCWP_DEBUG_PARAM_ACTION); ?>" value="redetect_image_node">
                            
                            <label for="image_node_select">Select Target Node:</label>
                            <select id="image_node_select" name="image_node">
                                <option value="node117">Node117</option>
                                <option value="node119">Node119</option>
                                <option value="node693">Node693</option>
                            </select>
                            <button type="submit" class="button button-secondary">Update Node</button>
                        </form>
                    </div>

                    <div class="lsc-card">
                        <h3>Page Optimization Node</h3>
                        <p>Reassign specific page generation services (UCSS, CCSS, VPI) to an optimal cloud node.</p>

                        <?php
                        $current_summary = [];
                        if (class_exists('\LiteSpeed\Cloud')) {
                            $current_summary = \LiteSpeed\Cloud::get_summary();
                        }
                        ?>

                        <div id="page_current_node" class="lsc-status-box">
                            Current Node: <?php
                            $service = isset($_POST['service']) ? sanitize_text_field($_POST['service']) : 'UCSS';
                            $service_key_map = [
                                'UCSS' => 'server.ucss',
                                'CCSS' => 'server.ccss',
                                'VPI' => 'server.vpi',
                                'LQIP' => 'server.lqip',
                                'Page Load Time' => 'server.health',
                                'PageSpeed Score' => 'server.health'
                            ];
                            $key = isset($service_key_map[$service]) ? $service_key_map[$service] : '';
                            echo isset($current_summary[$key]) ? esc_html($current_summary[$key]) : 'Not set';
                            ?>
                        </div>

                        <form method="post" action="">
                            <?php wp_nonce_field('litespeed_debug_redetect_page', 'litespeed_debug_nonce'); ?>
                            <input type="hidden" name="<?php echo esc_attr(LSCWP_DEBUG_PARAM_ACTION); ?>" value="redetect_page_node">
                            
                            <label for="service_select">Select Service:</label>
                            <select id="service_select" name="service">
                                <option value="UCSS" <?php selected($service, 'UCSS'); ?>>UCSS</option>
                                <option value="CCSS" <?php selected($service, 'CCSS'); ?>>CCSS</option>
                                <option value="VPI" <?php selected($service, 'VPI'); ?>>VPI</option>
                                <option value="LQIP" <?php selected($service, 'LQIP'); ?>>LQIP</option>
                                <option value="Page Load Time" <?php selected($service, 'Page Load Time'); ?>>Page Load Time</option>
                                <option value="PageSpeed Score" <?php selected($service, 'PageSpeed Score'); ?>>PageSpeed Score</option>
                            </select>

                            <label for="page_node_select">Select Target Node:</label>
                            <select id="page_node_select" name="page_node"></select>

                            <button type="submit" class="button button-secondary">Update Node</button>
                        </form>
                    </div>

                    <div class="lsc-card">
                        <h3>Reset Service TTLs</h3>
                        <p>Clear out the cached Time-To-Live parameters stored locally for specific cloud page optimization features.</p>

                        <?php
                        $ttl_ucss = $ttl_ccss = $ttl_vpi = 'Not set';
                        if (class_exists('\LiteSpeed\Cloud')) {
                            $ttl_ucss = isset($current_summary['ttl.ucss']) ? intval($current_summary['ttl.ucss']) : 'Not set';
                            $ttl_ccss = isset($current_summary['ttl.ccss']) ? intval($current_summary['ttl.ccss']) : 'Not set';
                            $ttl_vpi  = isset($current_summary['ttl.vpi'])  ? intval($current_summary['ttl.vpi']) : 'Not set';
                        }
                        ?>

                        <ul style="margin: 0 0 15px 0; padding: 0; list-style: none; color: #50575e; font-size: 13px; flex-grow: 1;">
                            <li style="margin-bottom: 5px;"><strong>UCSS TTL:</strong> <?php echo esc_html($ttl_ucss); ?></li>
                            <li style="margin-bottom: 5px;"><strong>CCSS TTL:</strong> <?php echo esc_html($ttl_ccss); ?></li>
                            <li><strong>VPI TTL:</strong> <?php echo esc_html($ttl_vpi); ?></li>
                        </ul>

                        <form method="post" action="">
                            <?php wp_nonce_field('litespeed_debug_reset_ttl', 'litespeed_debug_nonce'); ?>
                            <input type="hidden" name="<?php echo esc_attr(LSCWP_DEBUG_PARAM_ACTION); ?>" value="reset_ttl">
                            <button type="submit" class="button button-secondary">Reset TTL</button>
                        </form>
                    </div>
                </div>
            </div>

            <div id="tab-extras" class="lsc-tab-content">
                <h2 class="lsc-section-title">LiteSpeed Cache Extra</h2>
                <div class="lsc-grid">

                <div class="lsc-card lsc-info-card">
    <h3>Fast Forward Image Optimization</h3>
    <p style="margin-bottom: 12px;">Skip already optimized image groups and move the LiteSpeed image post id position directly to the first genuinely unoptimized image. This prevents scanning thousands of images/groups after a reset.</p>

    <?php 
    // Fetch Current Position and Max ID
    $current_next_post_id = '-';
    if (class_exists('\LiteSpeed\Img_Optm')) {
        $optm_summary = \LiteSpeed\Img_Optm::get_summary();
        $current_next_post_id = isset($optm_summary['next_post_id']) ? $optm_summary['next_post_id'] : '-';
    }
    
    global $wpdb;
    
    $max_attachment_id = $wpdb->get_var("SELECT MAX(ID) FROM {$wpdb->posts} WHERE post_type = 'attachment' AND post_mime_type IN ('image/jpeg', 'image/png', 'image/gif')");
    $max_attachment_id = $max_attachment_id ? $max_attachment_id : '-';
    ?>

    <ul style="margin: 0 0 15px 0; padding: 0; list-style: none; color: #50575e; font-size: 13px;">
        <li style="margin-bottom: 5px;"><strong>Current image post id position:</strong> <?php echo esc_html($current_next_post_id); ?></li>
        <li><strong>Maximum image post id:</strong> <?php echo esc_html($max_attachment_id); ?></li>
    </ul>

    <?php if ($img_optm_results && $img_optm_results['status'] === 'success'): ?>
            <div class="lsc-status-box" style="margin-top: auto; border-color: #00a32a; background-color: #f0fcf4;">
                <ul style="margin: 0 0 8px 0; padding: 0; list-style: none;">
                    <li><strong>Optimized Images Skipped:</strong> <?php echo esc_html($img_optm_results['optimized_count']); ?> image groups</li>
                    <li><strong>Unoptimized Remaining:</strong> <?php echo esc_html($img_optm_results['unoptimized_count']); ?> image groups</li>
                    <li><strong>Next Pending image post id:</strong> <?php echo $img_optm_results['first_pending_id'] !== -1 ? esc_html($img_optm_results['first_pending_id']) : 'None'; ?></li>
                </ul>
                <?php if (!empty($img_optm_results['message'])): ?>
                    <span style="color: #00a32a; font-weight: 700;"><?php echo esc_html($img_optm_results['message']); ?></span>
                <?php endif; ?>
            </div>
    <?php endif; ?>

        <div class="lsc-card-action" style="margin-top: <?php echo ($img_optm_results && $img_optm_results['status'] === 'success') ? '0' : 'auto'; ?>; padding-top: 0; display: flex; gap: 10px;">
            <form method="post" action="" style="flex: 1;">
                <?php wp_nonce_field('lsc_helper_img_optm'); ?>
                <input type="hidden" name="lsc_helper_action" value="analyze_img_optm">
                <button type="submit" class="button button-secondary" style="width: 100%;">Analyze (Dry Run)</button>
            </form>
            
            <form method="post" action="" style="flex: 1;" onsubmit="return confirm('Are you sure you want to fast-forward the optimization position?');">
                <?php wp_nonce_field('lsc_helper_img_optm'); ?>
                <input type="hidden" name="lsc_helper_action" value="apply_img_optm">
                <button type="submit" class="button button-primary" style="width: 100%;">Confirm & Apply</button>
            </form>
        </div>


</div>

                    <div class="lsc-card lsc-clear-card">
                        <h3>LiteSpeed Options Metabox</h3>
                        <p style="margin-bottom: 12px;">Bulk Turn OFF / Clear specific LiteSpeed metabox settings that were applied to individual posts, pages, or custom post types.</p>
                        
                        <form method="post" action="" onsubmit="return confirm('Are you sure you want to permanently delete these overrides from all posts? This action cannot be undone.');" style="display: flex; flex-direction: column; flex-grow: 1;">
                            <?php wp_nonce_field('lsc_helper_clear_metabox'); ?>
                            <input type="hidden" name="lsc_helper_action" value="clear_metabox_option">
                            
                            <label for="metabox_key_select">Select options to Turn OFF / Clear:</label>
                            <select id="metabox_key_select" name="metabox_key" style="margin-bottom: 15px;">
                                <option value="litespeed_no_cache">Turn OFF "Disable Cache"</option>
                                <option value="litespeed_no_image_lazy">Turn OFF "Disable Image Lazyload"</option>
                                <option value="litespeed_no_vpi">Turn OFF "Disable VPI"</option>
                                <option value="litespeed_vpi_list">Clear "Viewport Images" List</option>
                                <option value="litespeed_vpi_list_mobile">Clear "Viewport Images - Mobile" List</option>
                            </select>
                            
                            <div class="lsc-card-action" style="margin-top: auto; padding-top: 0;">
                                <button type="submit" class="button button-secondary">Clear Selected Option</button>
                            </div>
                        </form>
                    </div>
                    
                   

                    <div class="lsc-card lsc-warning-card">
                        <h3>Disable Auto Purge</h3>
                        <p style="margin-bottom: 12px;">When enabled, no automatic cache purge will occur. <a href="https://docs.litespeedtech.com/lscache/lscwp/troubleshoot/#disable-auto-purge" target="_blank" rel="noopener noreferrer">Learn more</a>.</p>
                        
                        <blockquote class="lsc-warning-quote">
                            <strong>Note:</strong> This option is recommended only for sites that do not actively or frequently update content. If you disable auto purge, you MUST purge the cache manually any time content on your site changes, or you run the risk of serving stale content.
                        </blockquote>

                        <?php $is_auto_purge_disabled = get_option('lsc_helper_disable_auto_purge', 'no') === 'yes'; ?>
                        
                        <div class="lsc-status-box" style="margin-top: auto; border-color: <?php echo $is_auto_purge_disabled ? '#d63638' : '#00a32a'; ?>; background-color: <?php echo $is_auto_purge_disabled ? '#fcf0f1' : '#f0fcf4'; ?>">
                            Status: <?php echo $is_auto_purge_disabled ? '<span style="color:#d63638;">Auto Purge is OFF (Disabled)</span>' : '<span style="color:#00a32a;">Auto Purge is ON (Normal)</span>'; ?>
                        </div>

                        <div class="lsc-card-action" style="margin-top: 0; padding-top: 0;">
                            <form method="post" action="">
                                <?php wp_nonce_field('lsc_helper_toggle_purge'); ?>
                                <input type="hidden" name="lsc_helper_action" value="toggle_auto_purge">
                                <button type="submit" class="button <?php echo $is_auto_purge_disabled ? 'button-primary' : 'button-secondary'; ?>">
                                    <?php echo $is_auto_purge_disabled ? 'Turn Auto Purge ON' : 'Turn Auto Purge OFF'; ?>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="lsc-card lsc-danger-card">
                        <h3>Clear All Settings</h3>
                        <p>Permanently deletes all LiteSpeed-related configurations and data from your database.</p>
                        <p class="lsc-warning">⚠️ Please create a database backup before proceeding with this action.</p>
                        <div class="lsc-card-action" style="margin-top: auto;">
                            <a href="<?php echo esc_url(lsc_debug_admin_create_link('clear_settings')); ?>" class="button button-primary" onclick="return confirm('WARNING: This will delete all LiteSpeed settings from the database. Do you have a backup?');">Clear All Settings</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        // Node Management Matrix Map
        const serviceNodesMap = {
            "UCSS": ["node17","node123","eu-service-ctr2"],
            "CCSS": ["node17","node123","eu-service-ctr2"],
            "VPI": ["node17","node123","eu-service-ctr2"],
            "LQIP": ["node13","node449","node3","node394"],
            "Page Load Time": ["node13","node449","node3","node394"],
            "PageSpeed Score": ["node13","node449","node3","node394"]
        };

        const serviceSelect = document.getElementById('service_select');
        const pageNodeSelect = document.getElementById('page_node_select');
        const pageCurrentNode = document.getElementById('page_current_node');

        const keyMap = {
            "UCSS":"server.ucss",
            "CCSS":"server.ccss",
            "VPI":"server.vpi",
            "LQIP":"server.lqip",
            "Page Load Time":"server.health",
            "PageSpeed Score":"server.health"
        };

        let summary = <?php echo json_encode($current_summary); ?>;

        function updateNodeOptions(){
            if(!serviceSelect) return;
            const selectedService = serviceSelect.value;
            const nodes = serviceNodesMap[selectedService] || [];

            pageNodeSelect.innerHTML = '';
            nodes.forEach(node => {
                const opt = document.createElement('option');
                opt.value = node;
                opt.textContent = node.replace(/^node/, 'Node ');
                pageNodeSelect.appendChild(opt);
            });

            let key = keyMap[selectedService] || '';
            let currentNode = summary[key] || 'Not set';
            pageCurrentNode.innerHTML = "Current Node: " + currentNode;
        }

        if(serviceSelect) {
            serviceSelect.addEventListener('change', updateNodeOptions);
            updateNodeOptions();
        }

        // --- Tab Selection Persistence ---
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.lsc-tab-btn');
            const contents = document.querySelectorAll('.lsc-tab-content');

            function switchTab(targetId) {
                tabs.forEach(tab => tab.classList.remove('active'));
                contents.forEach(content => content.classList.remove('active'));

                const activeTab = document.querySelector(`.lsc-tab-btn[data-target="${targetId}"]`);
                const activeContent = document.getElementById(targetId);

                if (activeTab && activeContent) {
                    activeTab.classList.add('active');
                    activeContent.classList.add('active');
                    // Retain session state tracking inside localStorage
                    localStorage.setItem('lsc_helper_active_tab', targetId);
                }
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    switchTab(this.getAttribute('data-target'));
                });
            });

            // Restore from state storage index fallback or load base tab
            const savedTab = localStorage.getItem('lsc_helper_active_tab');
            if (savedTab && document.getElementById(savedTab)) {
                switchTab(savedTab);
            }
        });
    </script>

    <?php } ?>
</div>
