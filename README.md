# DK Pull Quote Widget

This plugin builds a "pull quote", similar to what appears in newspapers and magazines, for copy that should stand out. Copy is typically much larger and stylized. Note that this NOT a substitute for HTML blockquotes. See the included screenshot for an example.

### Style Notes

Pull quotes are supposed to be brief, tight stabs of text intended to catch your reader's eye. Do not put huge amounts of copy into the pull quote! It defeats the purpose and just looks bad. For this reason, this shortcode plugin does not include a clearfix hack, which allows the main article container to stretch in size (height, mostly) as the pull quote increases in size. If you need to use clearfix with this shortcode then you're probably doing it wrong.

### Use on your WordPress site

This shortcode makes use of CSS floats rather than CSS flexbox. It's supposed to be super easy and low-maintenance. YMMV if you use this plugin on a page that depends on flexbox, CSS Grid, or Bootstrap 4 which relies heavily on flexbox. This plugin is not designed to work with multi-column content areas, so use caution. As with all third-party plugins, be sure to test it on a staging site before putting it into production.

### Usage

Sample implementation:

`[dk_pull_quote]My Pull Quote Copy Here[/dk_pull_quote]`

In order for this or any shortcodes to work in excerpts or widgets, insert the following into your `functions.php`:

`add_filter( 'the_excerpt', 'do_shortcode' );`
`add_filter( 'widget_text', 'do_shortcode' );`

### Attributes

The below shortcode attributes are default. They can all be changed within the shortcode declaration. See the Shortcode API docs for more information. Sample usage with attributes:

`[dk_pull_quote justify="left" tag="h2" font_color="red"]My Pull Quote Copy Here[/dk_pull_quote]`

#### Default Attributes

Default Attributes are defined in the function `make_pull_quote`. The four attributes for border side accept true or false; each side will be shown if true and hidden if false.

For measurements of font size, line height, padding, margin, width and border_width, any valid CSS format is acceptable: px, em, rem, %, etc. For font_color, and valid CSS color is acceptable: hex colors, RGB, RGBA, 'red', etc.

* 'tag': HTML tag for the container around the pull quote. Defaults to `<div>`
* 'font_size': Size of text, defaults to `2rem`.
* 'font_color': Color of text defaults to `black`.
* 'line_height': Defaults to `1.5`.
* 'justify': Defaults to `right`. The only other acceptable option is `left`.
* 'padding': Defaults to `10px`.
* 'margin': Defaults to `10px`.
* 'width': Defaults to `20%`.
* 'border_width': Defaults to `1px`.
* 'border_color': Defaults to `blue`.
* 'border_top': Defaults to `true`, i.e., visible
* 'border_right':Defaults to `false`, i.e. invisible
* 'border_bottom': Defaults to `true`.
* 'border_left': Defaults to `false`.
