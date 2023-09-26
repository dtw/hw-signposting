# Healthwatch Signposting

Creates a custom post type for signposting content in Wordpress.

Local Healthwatch have a duty to "[provide] advice and information about access to local care services and about choices that may be made with respect to aspects of those services" (https://www.legislation.gov.uk/ukpga/2007/28/part/14/crossheading/local-involvement-networks)

This plugin was created to facilitate that process. It supports the creation of multiple "signposts", which quickly and simply describe a service or a source of information. The signpost content is configured to support responsive WordPress themes.

## Features

Adds:

* ```signposts``` post type
* ```signpost_categories``` taxonomy - name, slug, category, description, icon (through the WordPress media selector)
* WordPress shortcodes for:
  * [signposts_menu] - outputs a graphical menu based on the taxonomy
  * [embed_signpost] - displays a single signpost (by post ID) with the option to hide the title e.g. [signpost_object signpost_id="49784" hide_title="false"]
  * [signpost_panel] - displays a single signpost (by post ID) with a custom title, as bootstrap accordion panel e.g. [signpost_panel title="Step 1 of X" signpost_id="54673"] 
  * Responsive formats with icon prompts using:
    * [signpost_address] - e.g. [signpost_address]10 Downing Street, Westminster, London, SW1A 2AA[/signpost_address]
    * [signpost_location]
    * [signpost_website]
    * [signpost_email]
    * [signpost_phone]
    * [signpost_text] (SMS)

## License
Unless otherwise specified, all the plugin files, scripts and images are licensed under GNU General Public License version 2, see http://www.gnu.org/licenses/gpl-2.0.html.

## Dependencies

Some features require the ```scaffold-widget-tweaks``` plugin
