<?php
/**
 * Plugin Name: Subscriptions
 */

require_once __DIR__ . '/MN_widget_subscriptions.php';
require_once __DIR__ . '/helper_functions.php';
require_once __DIR__ . '/actions_helper.php';

function mn_create_table() {
    global $wpdb;

    $query = "CREATE TABLE IF NOT EXISTS `subscriber` (
		`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`name` varchar(50) NOT NULL,
		`email` varchar(50) NOT NULL,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    $wpdb->query($query);
}
register_activation_hook( __FILE__, 'mn_create_table' );

function mn_subscription_widget() {
    register_widget( 'MN_widget_subscriptions' );
}
add_action( 'widgets_init', 'mn_subscription_widget' );

function mn_enqueue_scripts() {
    wp_register_script( 'mn-scripts', plugins_url( '/accets/js/scripts.js',__FILE__ ), array( 'jquery' ), false, true );
    wp_enqueue_script( 'mn-scripts' );

    wp_localize_script( 'mn-scripts', 'mn_ajax', array( 'url' => admin_url( '/admin-ajax.php' ), 'nonce' => wp_create_nonce() ) );
}

function mn_admin_scripts( $hook ) {
    if ( $hook != 'settings_page_subscribers' )
        return;
    wp_enqueue_script( 'mn-admin-scripts', plugins_url( '/accets/js/admin_scripts.js', __FILE__ ), array( 'jquery' ), false, true );
}

function mn_option_page() {
    add_action( 'admin_enqueue_scripts', 'mn_admin_scripts' );
    add_options_page( 'Підписники', 'Підписники', 'manage_options', 'subscribers', 'mn_subscribers_cb' );

}
add_action( 'admin_menu', 'mn_option_page' );


function mn_subscribers_cb(){
    $pagination = mn_pagination();
    $subscribers = mn_get_subscribers( $pagination );
    ?>
    <form action="" method="post" id="send_sub">
    <table class="wp-list-table widefat fixed striped tags">
        <thead>
        <tr>
            <td id="cb" class="manage-column column-cb check-column">
                <label class="screen-reader-text" for="cb-select-all-1">Выделить все</label>
                <input id="cb-select-all-1" type="checkbox"></td>
            <th scope="col" id="name" class="manage-column column-name column-primary sortable desc"><span>Название</span><span class="sorting-indicator"></span></th>
            <th scope="col" id="email" class="manage-column column-description sortable desc"><span>Емейл</span><span class="sorting-indicator"></span></th>
        </tr>
        </thead>
    <tbody id="the-list" data-wp-lists="list:tag">
    <?php foreach ( $subscribers as $subscriber ) : ?>
        <tr>
            <td id="cb_<?php echo $subscriber['id'] ?>" class="manage-column column-cb check-column">
                <label class="screen-reader-text" for="cb_<?php echo $subscriber['id'] ?>">ID cb_<?php echo $subscriber['id'] ?></label>
                <input id="cb_<?php echo $subscriber['id'] ?>" name="params[cb_<?php echo $subscriber['id'] ?>]" value="<?php echo $subscriber['id'] ?>" type="checkbox"></td>
            <th scope="col" id="name_<?php echo $subscriber['id'] ?>" class="manage-column column-name column-primary sortable desc"><span><?php echo $subscriber['name'] ?></span><span class="sorting-indicator"></span><div class="pool"></div> </th>
            <th scope="col" id="email_<?php echo $subscriber['id'] ?>" class="manage-column column-description sortable desc"><span><?php echo $subscriber['email'] ?></span><span class="sorting-indicator"></span></th>
        </tr>
    <?php endforeach; ?>
    </tbody>
    </table>

    <?php
    echo paginate_links( array(
        'total' => $pagination['count_page'],
        'current' => $pagination['current'],
    ) );
    ?>
        <label for="tm_msg">wwwww</label><br>
        <textarea name="mess"></textarea><br>
        <input type="submit">
    </form>
    <?php
}