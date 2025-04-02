<?php

function countdown_timer_shortcode_func() {
  $output = '';
  $countdown_date = get_field('date');
  $future_date = strtotime($countdown_date);
  $today = strtotime(date('ymd'));

  if ($future_date <= $today) {
    $days_left = '0';
  } else {
    $days_left = ceil(abs($future_date - $today ) / 86400 ); // round up to full days
  }

  if($countdown_date) {
    $output .= "
    <h2 class='section-heading h3 align-left emphasis mb-3'>
      {$days_left} days left
    </h2>";
  }

  return $output;
}
add_shortcode('countdown_timer_shortcode', 'countdown_timer_shortcode_func');
