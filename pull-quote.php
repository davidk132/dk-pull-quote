<?php
/*
Plugin Name:  DK Pull Quote Widget
Plugin URI:   https://developer.wordpress.org/plugins/the-basics/
Description:  Shortcode to build a traditional pull quote on the page
Version:      1.0.0
Author:       David Kissinger
Author URI:   http://www.davidkissinger.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  dk-pull-quote
Domain Path:  /languages
*/

/**
 *
 * This plugin builds a "pull quote", similar to what appears in newspapers
 * and magazines, for copy that should stand out. Copy is typically much larger
 * and stylized. Note that this NOT a substitute for HTML blockquotes.
 *
 */

/*
 * Execution aborts for security if file is called outside of core processing
 */
if ( ! defined( 'WPINC' ) ) {
  die;
}

/**
 * Main class for creating pull quotes.
 *
 * The shortcode is defined and hooked into core from this class. It can be
 * instantiated any number of times, in order to put more than one pull quotes
 * in the $content copy.
 *
 * Usage:
 *
 * `[dk_pull_quote]My Pull Quote Copy Here[/dk_pull_quote]`
 *
 * Attributes: The below shortcode attributes are default. They can all be
 * changed within the shortcode declaration. See the Shortcode API docs for
 * more information. Sample usage with attributes:
 *
 * `[dk_pull_quote justify="left" tag="h2" font_color=""]My Pull Quote Copy Here[/dk_pull_quote]`
 *
 * Default Attributes are defined in the function `make_pull_quote` below. The four
 * attributes for border side accept true or false; each side will be shown if true
 * and hidden if false.
 *
 * @since 1.0.0
 * @package dk_pull_quote
 */
class Pull_Quotes {

  /**
   * Array of attributes used to define CSS styling in the pull quote on the page.
   *
   * @since 1.0.0
   * @access private
   * @var    array    $atts    The array of CSS attributes
   */
  private $atts;

  /**
   * On initialization, sets up placeholder for deactivation and register the shortcode
   *
   * @since 1.0.0
   */
  public function __construct() {
    register_deactivation_hook( __FILE__, array( $this, 'register_deactivate' ) );
    $this->register_shortcode_hook();
  }

  /**
   * Executes any actions related to deactivation of this plugin. Anything can be
   * hooked onto the action `dk_pull_quote`, i.e. from `functions.php` or another
   * plugin class. Ideal use case might be to clean out specialized theme mods or
   * options used by this plugin. Always a good idea to clean up our messes!
   *
   * @since 1.0.0
   *
   */
  public function register_deactivate() {
    do_action( 'dk_pull_quote_deactivate' );
  }

  /**
   * Parses the shortcode declaration and returns HTML for insertion into the page.
   * Defines the default attributes for use in the pull quote's CSS.
   *
   * @since 1.0.0
   * @link https://codex.wordpress.org/Shortcode_API
   * @see parse_pull_quote_markup
   * @return    string    HTML markup of the actual pull quote
   *
   */
  public function make_pull_quote( $atts, $content = null, $tag = '' ) {
    // Parse atts and return the pull quote
    $this->atts = shortcode_atts(
      array(
        'tag' => 'div',
        'font_size' => '2rem',
        'font_color' => '#000000',
        'line_height' => '1.5',
        'justify' => 'right',
        'padding' => '10px',
        'margin' => '10px',
        'width' => '20%',
        'border_width' => '1px',
        'border_color' => '#0008A3',
        'border_top' => true,
        'border_right' => false,
        'border_bottom' => true,
        'border_left' => false,
      ),
      $atts, $tag
    );
    return $this->parse_pull_quote_markup( $content );
  }

  /**
   * Creates HTML string for the pull quote, including tag, CSS inline styles,
   * and content. CSS styles are parsed from the $atts array.
   *
   * @since 1.0.0
   * @see $atts    array    Instance variable containing shortcode attributes.
   *
   */
  private function parse_pull_quote_markup( $content = '' ) {
    $font_size = 'font-size: ' . esc_html( $this->atts['font_size'] ) . ';';
    $line_height = 'line-height: ' . esc_html( $this->atts['line_height'] ) . ';';
    $font_color = 'color: ' . esc_html( $this->atts['font_color'] ) . ';';
    $justify = $this->atts['justify'] == 'right' ? 'float: right;' : 'float: left;';
    $padding = 'padding: ' . esc_html( $this->atts['padding'] ) . ';';
    $margin = 'margin: ' . esc_html( $this->atts['margin'] ) . ';';
    $width = 'width: ' . esc_html( $this->atts['width'] ) . ';';
    $border_top = $this->atts['border_top'] ? 'border-top: ' . esc_html( $this->atts['border_width'] ) . ' solid ' . esc_html( $this->atts['border_color'] ) . ';' : '';
    $border_right = $this->atts['border_right'] ? 'border-right: ' . esc_html( $this->atts['border_width'] ) . ' solid ' . esc_html( $this->atts['border_color'] ) . ';' : '';
    $border_bottom = $this->atts['border_bottom'] ? 'border-bottom: ' . esc_html( $this->atts['border_width'] ) . ' solid ' . esc_html( $this->atts['border_color'] ) . ';' : '';
    $border_left = $this->atts['border_left'] ? 'border-left: ' . esc_html( $this->atts['border_width'] ) . ' solid ' . esc_html( $this->atts['border_color'] ) . ';' : '';

    $style = sprintf( '"%s %s %s %s %s %s %s %s %s %s %s"', $font_size, $line_height, $font_color, $justify, $padding, $margin, $width, $border_top, $border_right, $border_bottom, $border_left );

    return sprintf( '<%s class="dk-pull-quote" style=%s>%s</%s><!-- /.dk-pull-quote -->', $this->atts['tag'], $style, $content, $this->atts['tag'] );
  }

  /**
   * Registers our shortcode with WordPress core during execution.
   *
   * @since 1.0.0
   * @link https://codex.wordpress.org/Shortcode_API
   *
   */
  public function register_shortcode() {
    add_shortcode( 'dk_pull_quote', array( $this, 'make_pull_quote' ) );
  }

  /**
   * Since plugins load early, the shortcode setup must be hooked onto 'init'.
   * See WP official plugin docs for details.
   *
   * @since 1.0.0
   */
  private function register_shortcode_hook() {
    add_action( 'init', array( $this, 'register_shortcode' ) );
  }

}

$pull_quote = new Pull_Quotes();
