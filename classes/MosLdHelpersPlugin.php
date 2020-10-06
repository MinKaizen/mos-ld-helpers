<?php

class MosLdHelpersPlugin {

  private $path = '';
  private $url = '';


  public function __construct( $plugin_file ) {
    $this->path = plugin_dir_path( $plugin_file );
    $this->url = plugin_dir_url( $plugin_file );
  }

  
  public function init() {
    $this->load_dependencies();
    $this->register_shortcodes();
  }


  private function load_dependencies() {

  }


  private function register_shortcodes() {
    add_shortcode( 'mos_ld_progress', [$this, 'mos_ld_progress_shortcode']);
    add_shortcode( 'mos_ld_mark_complete', [$this, 'mos_ld_mark_complete_shortcode']);
  }


  /**
   * Shortcode to display a user's course progress
   *
   * @param int     $user                 User WP ID
   * @param int     $course               Course post ID
   * @return string $progress_formatted   Progress formatted like "23/55"
   */
  public function mos_ld_progress_shortcode( array $passed_atts ) {
    // Extract attributes from shortcode
    $atts = shortcode_atts( [
      "user" => 0,
      "course" => 0,
    ], $passed_atts );

    $progress = self::course_progress( $atts['user'], $atts['course'] );
    $progress_formatted = $progress['formatted'];

    return $progress_formatted;
  }


  /**
   * Get course progress by user and course
   *
   * @param integer $user_id           WP User ID
   * @param integer $course_id         Post ID of the course
   * @return array  $course_progress   Associative array
   */
  public static function course_progress( int $user_id, int $course_id ) {
    // Default values
    $course_progress = [
      'completed' => 0,
      'total' => 0,
      'formatted' => '',
    ];

    // Extract course progress from usermeta
    $course_progress_meta = get_user_meta($user_id, '_sfwd-course_progress', true);
    if ( !empty( $course_progress_meta ) ) {
      $course_progress['completed'] = $course_progress_meta[$course_id]['completed'];
      $course_progress['total'] = $course_progress_meta[$course_id]['total'];
      $course_progress['formatted'] = "$course_progress[completed]/$course_progress[total]";
    }

    return $course_progress;
  }


  /**
   * Shortcode to display Mark Complete button
   *
   * @param string $class                   custom class name for button
   * @param string $id                      custom id for button
   * @return string $mark_complete_button   html to output Mark Complete button
   */
  public function mos_ld_mark_complete_shortcode( $passed_atts ) {
    $atts = shortcode_atts( [
      'class' => 'ld-mark-complete',
      'id' => 'ld-mark-complete',
    ], $passed_atts);

    $options = [
      'button' => [
        'class' => $atts['class'],
        'id' => $atts['id'],
      ],
    ];

    $mark_complete_button = learndash_mark_complete(get_post(), $options); 

    return $mark_complete_button;
  }
}