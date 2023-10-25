<?php

/**
 * NanoSupport Dashboard Scripts
 * 
 * Scripts specific to NanoSupport Dashboard widget only.
 *
 * @since  1.0.0
 * -----------------------------------------------------------------------
 */
function ns_dashboard_scripts()
{
    $screen = get_current_screen();
    if ('dashboard' === $screen->base) {
        wp_enqueue_style('ns-admin');
        wp_enqueue_script('ns-dashboard', NS()->plugin_url() . '/assets/js/nanosupport-dashboard.min.js', array('d3', 'c3'), NS()->version, true);
        global $current_user;
        wp_localize_script(
            'ns-dashboard',
            'ns',
            array(
                'pending'           => ns_ticket_status_count('pending'),
                'solved'            => ns_ticket_status_count('solved'),
                'inspection'        => ns_ticket_status_count('inspection'),
                'open'              => ns_ticket_status_count('open'),
                'pending_label'     => esc_html__('Pending Tickets', 'nanosupport'),
                'solved_label'      => esc_html__('Solved Tickets', 'nanosupport'),
                'open_label'        => esc_html__('Open Tickets', 'nanosupport'),
                'inspection_label'  => esc_html__('Under Inspection', 'nanosupport'),
                'my_pending'        => ns_ticket_status_count('pending', $current_user->ID),
                'my_solved'         => ns_ticket_status_count('solved', $current_user->ID),
                'my_inspection'     => ns_ticket_status_count('inspection', $current_user->ID),
                'my_open'           => ns_ticket_status_count('open', $current_user->ID),
            )
        );
    }
}

add_action('admin_enqueue_scripts', 'ns_dashboard_scripts');

/**
 * NanoSupport Widget
 *
 * Add a dashboard widget for the plugin to display general
 * information as per the user privilige.
 *
 * @since  1.0.0
 * -----------------------------------------------------------------------
 */
function nanosupport_dashboard_widget()
{
    wp_add_dashboard_widget(
        'nanosupport_widget',                   //dashboard ID
        '<i class="ns-icon-nanosupport"></i> ' . esc_html__('RMA Sunterra', 'nanosupport'),     //widget name
        'nanosupport_widget_callback'           //callback function
    );
}

add_action('wp_dashboard_setup', 'nanosupport_dashboard_widget');

/**
 * NanoSupport widget callback
 * ...
 */
function nanosupport_widget_callback()
{ ?>
    <section id="nanosupport-widget">

        <?php
        //Support Seekers
        if (ns_is_user('support_seeker')) { ?>

            <?php
            $ns_general_settings       = get_option('nanosupport_settings');
            $ns_knowledgebase_settings = get_option('nanosupport_knowledgebase_settings');
            ?>

            <div class="ns-row">
                <div class="nanosupport-left-column">
                    <h4 class="dashboard-head ns-text-center"><i class="ns-icon-tag"></i> <?php esc_html_e('Welcome to Support Ticketing', 'nanosupport'); ?></h4>
                    <p><?php
                        /* translators: Link to the user profile 1. link URL 2. user profile icon */
                        printf(wp_kses(__('This is the back end of the support ticketing system. If you want to edit your profile, you can do that from <a href="%1$s">%2$s Your Profile</a>.', 'nanosupport'), array('a' => array('href' => array()))), get_edit_user_link(get_current_user_id()), '<i class="ns-icon-user"></i>'); ?></p>

                    <?php
                    /**
                     * Display Knowledgebase on demand
                     * Display, if enabled in admin panel.
                     */
                    if ($ns_knowledgebase_settings['isactive_kb'] === 1) { ?>
                        <p><?php esc_html_e('Use the links here for exploring knowledgebase, visiting your support desk, or submitting new ticket. Before submitting new ticket, we prefer you to consider exploring the Knowledgebase for existing resources.', 'nanosupport'); ?></p>
                    <?php } else { ?>
                        <p><?php esc_html_e('Use the links here for visiting your support desk, or submitting new ticket.', 'nanosupport'); ?></p>
                    <?php } ?>
                </div>
                <div class="nanosupport-right-column ns-text-center">
                    <h4 class="dashboard-head"><i class="ns-icon-mouse"></i> <?php esc_html_e('My Tools', 'nanosupport'); ?></h4>
                    <a class="button button-primary ns-button-block" href="<?php echo esc_url(get_the_permalink($ns_general_settings['support_desk'])); ?>">
                        <i class="icon ns-icon-tag"></i> <?php esc_html_e('Support Desk', 'nanosupport'); ?>
                    </a>
                    <a class="button ns-button-danger ns-button-block" href="<?php echo esc_url(get_the_permalink($ns_general_settings['submit_page'])); ?>">
                        <i class="icon ns-icon-tag"></i> <?php _e('Submit Ticket', 'nanosupport'); ?>
                    </a>

                    <?php
                    /**
                     * Display Knowledgebase on demand
                     * Display, if enabled in admin panel.
                     */
                    if ($ns_knowledgebase_settings['isactive_kb'] === 1) { ?>
                        <a class="button ns-button-info ns-button-block" href="<?php echo esc_url(get_the_permalink($ns_knowledgebase_settings['page'])); ?>">
                            <strong><i class="icon ns-icon-docs"></i> <?php esc_html_e('Knowledgebase', 'nanosupport'); ?></strong>
                        </a>
                    <?php } ?>
                </div>
            </div>

        <?php } //support_seekers 
        ?>

        <?php
        //Agent & Manager
        if (ns_is_user('agent_and_manager')) { ?>
            <div class="ns-row">
                <div class="ns-text-center">
                    <h4 class="dashboard-head">
                        <i class="ns-icon-pie-chart"></i> <?php esc_html_e('Current Status', 'nanosupport'); ?>
                    </h4>
                    <?php
                    $total_tickets = ns_total_ticket_count('nanosupport');
                    if (0 === $total_tickets) : ?>
                        <div id="ns-no-activity">
                            <p class="smiley"></p>
                            <p><?php _e('Yet nothing to display!', 'nanosupport') ?></p>
                        </div>
                    <?php else : ?>
                        <!-- <div id="ns-chart"></div> -->
                        <?php foreach (ns_ticket_get_all_status() as $ticket_status) {
                            echo '<div class="ns-label-dashboard" style="background-color:' . $ticket_status['color'] . ';">';
                            echo '<div style="padding: 5px; margin-bottom: 5px; font-size: 15px; font-weight: 500; width: 25%; float: right;">' . ns_ticket_status_count($ticket_status['slug']) . '</div>';
                            echo '<div style="padding: 5px; margin-bottom: 5px; font-size: 15px; font-weight: 600; width: 75%; text-align: left;">' . $ticket_status['name'] . '</div>';
                            echo '</div>';
                        } ?>
                        <hr>
                        <div class="ns-total-ticket-count ns-text-center">
                            <?php
                            /* translators: Count in numbers */
                            printf(esc_html(_n('Total Ticket: %d', 'Total Tickets: %d', $total_tickets, 'nanosupport')), $total_tickets);
                            ?>
                        </div>
                    <?php endif; ?>
                </div> <!-- /.nanosupport-50-left -->

                <?php

                /**
                 * Agent only
                 * ...
                 */
                if (ns_is_user('agent')) { ?>

                    <div class="nanosupport-50-right">
                        <h4 class="dashboard-head ns-text-center">
                            <i class="ns-icon-pulse"></i> <?php _e('My Activity Status', 'nanosupport'); ?>
                        </h4>
                        <?php
                        global $current_user;
                        $my_total_tickets = ns_total_ticket_count('nanosupport', $current_user->ID);
                        if (0 === $my_total_tickets) : ?>
                            <div id="ns-no-activity">
                                <p class="smiley"></p>
                                <p><?php esc_html_e('You&rsquo;ve not assigned any ticket yet!', 'nanosupport') ?></p>
                            </div>
                        <?php else : ?>
                            <div id="ns-activity-chart"></div>
                            <div class="ns-total-ticket-count ns-text-center">
                                <?php
                                /* translators: Count in numbers */
                                printf(esc_html(_n('My Total Ticket: %d', 'My Total Tickets: %d', $my_total_tickets, 'nanosupport')), $my_total_tickets);
                                ?>
                            </div>
                        <?php endif; ?>
                    </div> <!-- /.nanosupport-50-right -->

                <?php } //agent only 
                ?>
            </div>
        <?php } //administrator/editor 
        ?>

    </section>
<?php
}

/**
 * NanoSupport Widget
 *
 * Add a dashboard widget for the plugin to display general
 * information as per the user privilige.
 *
 * @since  1.0.0
 * -----------------------------------------------------------------------
 */
function nanosupport_dashboard_activity_widget()
{
    wp_add_dashboard_widget(
        'nanosupport_activity_widget',                   //dashboard ID
        '<i class="ns-icon-nanosupport"></i> ' . esc_html__('RMA Sunterra', 'nanosupport'),     //widget name
        'nanosupport_activity_widget_callback'           //callback function
    );
}

add_action('wp_dashboard_setup', 'nanosupport_dashboard_activity_widget');

/**
 * NanoSupport widget callback
 * ...
 */
function nanosupport_activity_widget_callback()
{ ?>
    <section id="nanosupport-widget">
        <?php
        //Agent & Manager
        if (ns_is_user('agent_and_manager')) { ?>
            <div class="ns-row">
                <?php
                /**
                 * Manager only
                 * ...
                 */
                if (ns_is_user('manager')) { ?>
                    <h4 class="dashboard-head ns-text-center">
                        <i class="ns-icon-pulse"></i> <?php _e('Recent Response', 'nanosupport'); ?>
                    </h4>
                    <?php
                    $activity_arr = array();
                    $response_activity = get_comments(array(
                        'type'   => 'nanosupport_response',
                        'number' => 15,
                        'orderby' => 'comment_date'
                    ));
                    foreach ($response_activity as $response) {
                        $activity_arr[$response->comment_ID]['id']        = intval($response->comment_ID);
                        $activity_arr[$response->comment_ID]['type']      = 'response';
                        $activity_arr[$response->comment_ID]['date']      = $response->comment_date;
                        $activity_arr[$response->comment_ID]['author_id'] = intval($response->user_id);
                        $activity_arr[$response->comment_ID]['author']    = $response->comment_author;
                        $activity_arr[$response->comment_ID]['ticket']    = intval($response->comment_post_ID);
                    }

                    usort($activity_arr, 'ns_date_compare');

                    $counter = 0;
                    if (empty($activity_arr)) {
                        echo '<div id="ns-no-activity">';
                        echo '<p class="smiley"></p>';
                        echo '<p>' . esc_html__('No activity yet!', 'nanosupport') . '</p>';
                        echo '</div>';
                    } else {
                        foreach ($activity_arr as $activity) {
                            $counter++;

                            if ($counter <= 30) { ?>

                                <div>
                                    <strong><?php echo ns_date_time($activity['date']); ?></strong><br>
                                    <?php
                                    if ('response' === $activity['type']) {
                                        /* translators: 1. link URL 2. ticket title 3. ticket author */
                                        printf(
                                            '<i class="ns-icon-responses"></i> ' . wp_kses(__('Ticket #%1$s <a href="%2$s">%3$s</a> is responded by %4$s', 'nanosupport'), array('a' => array('href' => array()))),
                                            $activity['id'],
                                            get_edit_post_link($activity['ticket']),
                                            get_the_title($activity['ticket']),
                                            $activity['author']
                                        );
                                    }
                                    ?>
                                    <hr>
                                </div>

                    <?php
                            }
                        }
                    }
                    ?>
                <?php } //manager only 
                ?>
            </div>
        <?php } //administrator/editor 
        ?>

    </section>
<?php
}

/**
 * NanoSupport Widget
 *
 * Add a dashboard widget for the plugin to display general
 * information as per the user privilige.
 *
 * @since  1.0.0
 * -----------------------------------------------------------------------
 */
function nanosupport_dashboard_activity_new_widget()
{
    wp_add_dashboard_widget(
        'nanosupport_activity_new_widget',                   //dashboard ID
        '<i class="ns-icon-nanosupport"></i> ' . esc_html__('RMA Sunterra', 'nanosupport'),     //widget name
        'nanosupport_activity_widget_new_callback'           //callback function
    );
}

add_action('wp_dashboard_setup', 'nanosupport_dashboard_activity_new_widget');

/**
 * NanoSupport widget callback
 * ...
 */
function nanosupport_activity_widget_new_callback()
{ ?>
    <section id="nanosupport-widget">
        <?php
        //Agent & Manager
        if (ns_is_user('agent_and_manager')) { ?>
            <div class="ns-row">
                <?php
                /**
                 * Manager only
                 * ...
                 */
                if (ns_is_user('manager')) { ?>
                    <h4 class="dashboard-head ns-text-center">
                        <i class="ns-icon-pulse"></i> <?php _e('New RMA', 'nanosupport'); ?>
                    </h4>
                    <?php
                    $activity_arr = array();
                    $ticket_activity = get_posts(array(
                        'post_type'     => 'nanosupport',
                        'post_status'   => array('pending', 'private', 'publish'),
                        'posts_per_page' => 15,
                    ));
                    foreach ($ticket_activity as $ticket) {
                        $activity_arr[$ticket->ID]['id']        = $ticket->ID;
                        $activity_arr[$ticket->ID]['type']      = 'ticket';
                        $activity_arr[$ticket->ID]['date']      = $ticket->post_date;
                        $activity_arr[$ticket->ID]['author_id'] = intval($ticket->post_author);
                        $activity_arr[$ticket->ID]['author']    = ns_user_nice_name($ticket->post_author);
                        $activity_arr[$ticket->ID]['modified']  = $ticket->post_modified;
                        $activity_arr[$ticket->ID]['status']    = $ticket->post_status;
                    }

                    usort($activity_arr, 'ns_date_compare');

                    $counter = 0;
                    if (empty($activity_arr)) {
                        echo '<div id="ns-no-activity">';
                        echo '<p class="smiley"></p>';
                        echo '<p>' . esc_html__('No activity yet!', 'nanosupport') . '</p>';
                        echo '</div>';
                    } else {
                        foreach ($activity_arr as $activity) {
                            $counter++;

                            if ($counter <= 15) { ?>

                                <div>
                                    <strong><?php echo ns_date_time($activity['date']); ?></strong><br>
                                    <?php  
                                    if ('ticket' === $activity['type']) {
                                        /* translators: 1. link URL 2. ticket title 3. ticket author */
                                        printf(
                                            '<i class="ns-icon-tag"></i> ' . wp_kses(__('New Ticket #%1$s <a href="%2$s">%3$s</a> submitted by %4$s', 'nanosupport'), array('a' => array('href' => array()))),
                                            $activity['id'],
                                            get_edit_post_link($activity['id']),
                                            get_the_title($activity['id']),
                                            $activity['author']
                                        );
                                    }
                                    ?>
                                    <hr>
                                </div>

                            <?php
                            }
                        }
                    }
                    ?>
                <?php } //manager only 
                ?>
            </div>
        <?php } //administrator/editor 
        ?>

    </section>
<?php
}

/**
 * NanoSupport Widget
 *
 * Add a dashboard widget for the plugin to display general
 * information as per the user privilige.
 *
 * @since  1.0.0
 * -----------------------------------------------------------------------
 */
function nanosupport_dashboard_activity_update_widget()
{
    wp_add_dashboard_widget(
        'nanosupport_activity_update_widget',                   //dashboard ID
        '<i class="ns-icon-nanosupport"></i> ' . esc_html__('RMA Sunterra', 'nanosupport'),     //widget name
        'nanosupport_activity_update_widget_callback'           //callback function
    );
}

add_action('wp_dashboard_setup', 'nanosupport_dashboard_activity_update_widget');

/**
 * NanoSupport widget callback
 * ...
 */
function nanosupport_activity_update_widget_callback()
{ ?>
    <section id="nanosupport-widget">
        <?php
        //Agent & Manager
        if (ns_is_user('agent_and_manager')) { ?>
            <div class="ns-row">
                <?php
                /**
                 * Manager only
                 * ...
                 */
                if (ns_is_user('manager')) { ?>
                    <h4 class="dashboard-head ns-text-center">
                        <i class="ns-icon-pulse"></i> <?php _e('Last Updated', 'nanosupport'); ?>
                    </h4>
                    <?php
                    $activity_arr = array();
                    $ticket_activity = get_posts(array(
                        'post_type'     => 'nanosupport',
                        'post_status'   => array('pending', 'private', 'publish'),
                        'posts_per_page' => 15,
                        'orderby' => 'modified',
                        'order' => 'DESC'
                    ));
                    foreach ($ticket_activity as $ticket) {
                        $activity_arr[$ticket->ID]['id']        = $ticket->ID;
                        $activity_arr[$ticket->ID]['type']      = 'ticket';
                        $activity_arr[$ticket->ID]['date']      = $ticket->post_date;
                        $activity_arr[$ticket->ID]['author_id'] = intval($ticket->post_author);
                        $activity_arr[$ticket->ID]['author']    = ns_user_nice_name($ticket->post_author);
                        $activity_arr[$ticket->ID]['modified']  = $ticket->post_modified;
                        $activity_arr[$ticket->ID]['status']    = $ticket->post_status;
                    }

                    usort($activity_arr, 'ns_date_modified_compare');

                    $counter = 0;
                    if (empty($activity_arr)) {
                        echo '<div id="ns-no-activity">';
                        echo '<p class="smiley"></p>';
                        echo '<p>' . esc_html__('No activity yet!', 'nanosupport') . '</p>';
                        echo '</div>';
                    } else {
                        foreach ($activity_arr as $activity) {
                            $counter++;

                            if ($counter <= 15) { ?>

                                <div>
                                    <strong><?php echo ns_date_time($activity['modified']); ?></strong><br>
                                    <?php  
                                    if ('ticket' === $activity['type']) {
                                        /* translators: 1. link URL 2. ticket title 3. ticket author */
                                        printf(
                                            '<i class="ns-icon-tag"></i> ' . wp_kses(__('Ticket #%1$s updated <a href="%2$s">%3$s</a> submitted by %4$s', 'nanosupport'), array('a' => array('href' => array()))),
                                            $activity['id'],
                                            get_edit_post_link($activity['id']),
                                            get_the_title($activity['id']),
                                            $activity['author']
                                        );
                                    }
                                    ?>
                                    <hr>
                                </div>

                            <?php
                            }
                        }
                    }
                    ?>
                <?php } //manager only 
                ?>
            </div>
        <?php } //administrator/editor 
        ?>

    </section>
<?php
}

/**
 * NanoSupport Widget
 *
 * Add a dashboard widget for the plugin to display general
 * information as per the user privilige.
 *
 * @since  1.0.0
 * -----------------------------------------------------------------------
 */
function nanosupport_dashboard_form_factor_widget()
{
    wp_add_dashboard_widget(
        'nanosupport_form_factor_widget',                   //dashboard ID
        '<i class="ns-icon-nanosupport"></i> ' . esc_html__('RMA Sunterra', 'nanosupport'),     //widget name
        'nanosupport_form_factor_widget_callback'           //callback function
    );
}

add_action('wp_dashboard_setup', 'nanosupport_dashboard_form_factor_widget');

/**
 * NanoSupport widget callback
 * ...
 */
function nanosupport_form_factor_widget_callback()
{ ?>
    <section id="nanosupport-widget">
        <?php
        //Agent & Manager
        if (ns_is_user('agent_and_manager')) { ?>
            <div class="ns-row"><?php
                $blogusers = get_users();
                $form_factor_terms = get_terms( array(
                    'taxonomy' => 'nanosupport_form_factor',
                    'hide_empty' => false,
                ) );
                $i = 0;
                $x = 0;
                foreach ( $blogusers as $user ) {
                    if ( $form_factor_terms ) {
                        foreach ( $form_factor_terms as $form_factor_term ) {
                            $form_factor_ticket = get_posts(array(
                                'post_type'     => 'nanosupport',
                                'post_status'   => array('pending', 'private', 'publish'),
                                'author'		=> $user->ID,
                                'posts_per_page' => -1,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'nanosupport_form_factor',
                                        'field' => 'term_id',
                                        'terms' => $form_factor_term->term_id,
                                    )
                                )
                            ));
                            if($form_factor_ticket){
                                $form_factor_arry[$i]['userid'] .= $user->ID;
                                $form_factor_arry[$i]['slug'] .= $form_factor_term->slug;
                                $form_factor_arry[$i]['count'] .= count($form_factor_ticket);
                            }
                            $i++;
                        }
                    }
                }
                usort($form_factor_arry, 'ns_form_factor_compare');

                foreach($form_factor_arry as $form_factor_sort) {
                    if($x < 50){
                        $recentuser = get_user_by('id', $form_factor_sort['userid']);
                        echo $recentuser->display_name.'</br>';
                        echo get_user_meta($form_factor_sort['userid'], 'company_name', true).'</br>';
                        echo $recentuser->user_nicename.' - '.$recentuser->user_email.'</br>';
                        echo $form_factor_sort['slug'].' - '.$form_factor_sort['count'].'</br>';
                        echo '</br>';
                    }
                    $x++;
                }

            ?></div>
        <?php } //administrator/editor 
        ?>

    </section>
<?php
}

/**
 * NanoSupport Widget
 *
 * Add a dashboard widget for the plugin to display general
 * information as per the user privilige.
 *
 * @since  1.0.0
 * -----------------------------------------------------------------------
 */
function nanosupport_dashboard_user_widget()
{
    wp_add_dashboard_widget(
        'nanosupport_user_widget',                   //dashboard ID
        esc_html__('New user', 'nanosupport'),     //widget name
        'nanosupport_user_widget_callback'           //callback function
    );
}

add_action('wp_dashboard_setup', 'nanosupport_dashboard_user_widget');

/**
 * NanoSupport widget callback
 * ...
 */
function nanosupport_user_widget_callback()
{ ?>
    <section id="nanosupport-widget">
        <?php
        //Agent & Manager
        if (ns_is_user('agent_and_manager')) { ?>
            <div class="ns-row">
                <?php global $wpdb;
                $usernames = $wpdb->get_results("SELECT user_nicename, user_url, user_email, ID FROM $wpdb->users ORDER BY ID DESC LIMIT 15");
                foreach ($usernames as $username) {
                    $recentuser = get_user_by('id', $username->ID);
                    echo $username->ID.' - '.$recentuser->display_name.'</br>';
                    echo get_user_meta($username->ID, 'company_name', true).'</br>';
                    echo $recentuser->user_nicename.' - '.$recentuser->user_email.'</br>';
                    echo '</br>';
                } ?>
            </div>
        <?php } //administrator/editor 
        ?>
    </section>
<?php
}

/**
 * Remove Dashboard Widgets
 *
 * Remove unnecessary dashboard widgets for 'support_seeker' user role.
 * 
 * @author  WPBeginner
 * @author  Rajesh B
 * 
 * @link    http://www.wpbeginner.com/wp-tutorials/how-to-remove-wordpress-dashboard-widgets/
 * @link    http://wpsnippy.com/how-to-remove-wordpress-dashboard-welcome-panel/
 *
 * @since   1.0.0
 * -----------------------------------------------------------------------
 */
function ns_remove_dashboard_widgets()
{
    global $wp_meta_boxes;

    if (ns_is_user('support_seeker')) {
        remove_action('welcome_panel', 'wp_welcome_panel');
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); //WordPress News
    }
}

add_action('wp_dashboard_setup', 'ns_remove_dashboard_widgets');