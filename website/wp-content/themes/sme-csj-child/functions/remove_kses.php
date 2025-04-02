<?php

// Ability to add unfiltered HTML & JS to content

function remove_kses() {
    $user = wp_get_current_user();
    $roles = array(
        "administrator",
        "sme_admin"
    );
    foreach ($roles as $role) {
        if ( in_array( $role, (array) $user->roles ) ) {
            remove_all_filters("content_save_pre");
        }
    }
}

add_action( 'init', 'remove_kses');

?>