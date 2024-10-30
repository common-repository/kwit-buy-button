<?php
/*
Plugin Name: Kwit Buy Button
Plugin URI: https://kwit.pl/api/kup_w_kwit
Description: Include "Buy in Kwit.pl" button after ingredients lists.
Version: 1.0.1
Author: Saving Cloud
Author URI: http://savingcloud.pl/
*/


function kwit_add_pages() {
    // Add a new submenu under Options:
    add_options_page('Przycisk Kwit', 'Przycisk Kwit', 6, 'kwit', 'kwit_option_page');
}
function kwit_option_page() {
  if ($_REQUEST['submit'])
  {
    kwit_update_options();
  }
  echo '<h1>Przycisk "Kup w Kwit.pl": Ustawienia</h1>';
  echo '<form method="post"><table class="form-table"><tbody>';
  echo '<tr><th scope="row">Klucz właściciela:</th>';
  echo '<td><input type="text" name="kwit_bw_uid" class="regular-text" value="'.(get_option("kwit_bw_uid") ? get_option("kwit_bw_uid") : "").'" /></td></tr></table>';
  echo '<p class="submit"><input type="submit" class="button-primary" value="Zatwierdź zmiany" name="submit" /></p></form>';
}

function kwit_update_options(){
  $ok = false;
  if ($_REQUEST['kwit_bw_uid'])
  {
    update_option('kwit_bw_uid', $_REQUEST['kwit_bw_uid']);
    $ok = true;
  }
  if ($ok)
  {
    echo 'Zapisano opcje';
  }
  else
  {
    echo 'Brak opcji do zapisania';
  }

}
function include_kwit_script() {
  wp_enqueue_script( 'kwit_buy_button', 'https://kwit.pl/assets/kwit_blogwidget.js', array(), null, true );
  if(get_option('kwit_bw_uid')){
    $uid = get_option('kwit_bw_uid'); 
    wp_localize_script('kwit_buy_button', 'kwit_bw_uid', $uid ); 
  }
  $iswordpress = "true";
  wp_localize_script('kwit_buy_button', 'kwitIsWordpress', $iswordpress);
}

add_action('init', 'include_kwit_script' );
// Hook for adding admin menus
add_action('admin_menu', 'kwit_add_pages');
?>