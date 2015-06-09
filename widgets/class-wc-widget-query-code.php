<?php

/**
 * Query Code Widget
 *
 * @author   David Alméciga
 * @category Widgets
 * @package  WC_AddCustom_OrderItem_MetaData/Widgets
 * @version  1.0.0
 * @extends  WP_Widget
 */
class WC_Widget_Query_Code extends WP_Widget {

  public function WC_Widget_Query_Code() {
    parent::WP_Widget(false, $name = 'Consulta tu PASSE');
	}

  public function widget($args, $instance) {
     global $wpdb;

     extract( $args );
     $title = apply_filters('widget_title', $instance['title']);
     $html = "";

     $redeem_code = isset( $_POST['wc_redeem_code'] ) ? esc_attr( $_POST['wc_redeem_code'] ) : '';
     $redeem = isset( $_POST['wc_redeem'] ) ? esc_attr( $_POST['wc_redeem'] ) : '';
     $username = isset( $_POST['wc_redeem_user'] ) ? esc_attr( $_POST['wc_redeem_user'] ) : '';
     $password = isset( $_POST['wc_redeem_password'] ) ? esc_attr( $_POST['wc_redeem_password'] ) : '';

     switch ($redeem) {
       case 'step1':
         $_results = $wpdb->get_results("SELECT order_item_id, meta_key FROM $wpdb->order_itemmeta
                                         WHERE meta_value = '" . $redeem_code . "'", ARRAY_A);
         $meta_key = $_results[0]["meta_key"];
         $order_item_id = $_results[0]["order_item_id"];

         if ($order_item_id && $meta_key) {
           $results = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->order_itemmeta
                                          WHERE order_item_id = $order_item_id
                                          AND meta_key IN ('_qty', '_line_subtotal', 'Ref', '$meta_key', '$meta_key"."_datetime', '$meta_key"."_is_active')", ARRAY_A);
           $html = '<div class="row">Ref: ' . $results[2]["meta_value"] .'</div>
                    <div class="row">Código: ' . $results[3]["meta_value"] .'</div>
                    <div class="row">Valor: $' . $results[1]["meta_value"] / $results[0]["meta_value"]  .'</div>
                    <div class="row">Estado: ' . ($results[5]["meta_value"] ? 'Activo' : 'Inactivo') . '</div>
                    <div class="row">Fecha y hora de ' . ($results[5]["meta_value"] ? 'activación' : 'canje') . ': ' . $results[4]["meta_value"] . '</div>
                    ' . ($results[5]["meta_value"] ? '<div class="row">
                                                        <form method="post">
                                                        <input type="hidden" name="wc_redeem" value="step2">
                                                        <input type="hidden" name="wc_redeem_code" value="' . $redeem_code . '">
                                                        <button type="submit">Redimir</button>
                                                        </form>
                                                      </div>' : '<div class="row">
                                                                  <form method="get">
                                                                  <button type="submit">Consulta Nuevo código</button>
                                                                  </form>
                                                                 </div>');
         } else {
           $html = '<p>No se encuentra el código solicitado</p>
                    <div class="row">
                      <form method="get">
                      <button type="submit">Reintentar</button>
                      </form>
                    </div>';
         }

         break;

       case 'step2':
         $html = '<form method="post">
                   <div class="row">
                     <label for="wc_redeem_user">Usuario</label>
                     <input type="text" id="wc_redeem_user" name="wc_redeem_user" value="' . $username . '">
                   </div>
                   <div class="row">
                     <label for="wc_redeem_password">Contraseña</label>
                     <input type="password" id="wc_redeem_password" name="wc_redeem_password">
                   </div>
                   <div class="row">
                     <label for="wc_redeem_code">Código</label>
                     <input type="text" id="wc_redeem_code" name="wc_redeem_code" value="' . $redeem_code . '">
                   </div>
                   <input type="hidden" name="wc_redeem" value="step3">
                   <button type="submit">Confirmar</button>
                 </form>';
         break;

       case 'step3':

         if ($this->check_username_password_caps($username, $password) && $redeem_code) {
           $_results = $wpdb->get_results("SELECT order_item_id, meta_key FROM $wpdb->order_itemmeta
                                           WHERE meta_value = '" . $redeem_code . "'", ARRAY_A);

           $meta_key = $_results[0]["meta_key"];
           $order_item_id = $_results[0]["order_item_id"];

           if ($meta_key && $order_item_id) {

             $now = new \DateTime("now");
             wc_update_order_item_meta($order_item_id, $meta_key . "_datetime", $now->format('Y-m-d H:i:s'));
             wc_update_order_item_meta($order_item_id, $meta_key . "_is_active", 0);

             $msg = "Se redimió el código " . $redeem_code . " para " . $meta_key . " por " . $username;
             wc_get_order($this->get_order_id_by_order_item_id($order_item_id))->add_order_note($msg);

           } else {
             $msg = "<p>No se encuentra el código solicitado</p>";
           }

           $html = '<p>' . $msg . '</p>
                    <div class="row">
                      <form method="get">
                      <button type="submit">Consulta Nuevo código</button>
                      </form>
                    </div>';

         } else {
           $html = '<p>Error de usuario y contraseña ó ' . $username . ' no está habilitado para redimir códigos</p>
                    <div class="row">
                      <form method="post">
                        <input type="hidden" id="wc_redeem_user" name="wc_redeem_user" value="' . $username . '">
                        <input type="hidden" id="wc_redeem_code" name="wc_redeem_code" value="' . $redeem_code . '">
                        <input type="hidden" name="wc_redeem" value="step2">
                        <button type="submit">Reintentar</button>
                      </form>
                    </div>';
         }

         break;

       default:
         $html = '<form method="post">
                    <div class="row">
                      <label for="wc_redeem_code">Ingresa el código del PASSE</label>
                      <input type="text" id="wc_redeem_code" name="wc_redeem_code" value="'. $redeem_code .'">
                    </div>
                    <input type="hidden" name="wc_redeem" value="step1">
                    <button type="submit">Enviar</button>
                  </form>';
         break;
     }

     echo $before_widget;
     if ( $title )
     echo $before_title . $title . $after_title;
     echo $html;
     echo $after_widget;
   }

   private function get_order_id_by_order_item_id($order_item_id) {
     global $wpdb;
     return $wpdb->get_var("SELECT order_id FROM $wpdb->prefix" . "woocommerce_order_items WHERE order_item_id = $order_item_id");
 	 }

   private function check_username_password_caps($username, $password) {
     $user = get_user_by('login', $username);
     if ($user && wp_check_password($password, $user->data->user_pass, $user->ID)) {
       return $user->has_cap("redeem_codes");
     } else {
       return false;
     }
   }

   public function update($new_instance, $old_instance) {
     $instance = $old_instance;
     $instance['title'] = strip_tags($new_instance['title']);
     return $instance;
   }

   /** @see WP_Widget::form */
   public function form($instance) {
     $title = esc_attr($instance['title']);
     ?>
         <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
     <?php
   }

}
