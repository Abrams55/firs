<?php

class MN_widget_subscriptions extends WP_Widget {

    public function __construct() {
        $args = array(
            'name' => 'Віджет підписки',
            'description' => 'Віджет підписки - опис',
        );
        parent::__construct( 'mn_sub_widget', '', $args );
    }

    public function widget( $args, $instance ) {
        add_action( 'wp_footer', 'mn_enqueue_scripts' );
        echo $instance['title'];
        ?>
        <form action="" method="post" id="mn_sub">
            <input type="text" id="mn_name" name="mn_name" value=""><br>
            <input type="email" id="mn_email" name="mn_email" value=""><br>
            <input type="submit">
            <div class="res"></div>
        </form>
        <?php
    }

    public function form( $instance ) {
        ?>
        <lable for="<?php echo $this->get_field_id( 'title' ); ?>">Заголовок</lable><input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" value="<?php if ( ! empty( $instance['title'] ) ) : echo $instance['title']; endif; ?>">
        <?php
    }
}