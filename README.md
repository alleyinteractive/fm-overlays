# fm-overlays

A Fieldmanager extension to render dynamic content in modal boxes/overlays on a site.


## Install & Setup

Requires [Fieldmanager](https://github.com/alleyinteractive/wordpress-fieldmanager) to be installed and activated.




### Types

fm-overlays currently supports two types of content; either a single **Image** or Rich Text.

#### Image

Image overlays utilize both the `srcset` attribute and the js `window.resize` event to ensure both proper resolution and aspect ratios are maintained regardless of device.  When creating an image overlay the user can also add a custom `Image Link` URL to wrap the image with a `<a>` tag, the `target` of this link can be customized as well.

#### Rich Text

Rich Text overlays are created using the classic **WYSIWYG editor**.




### Conditionals

Overlay conditionals allow the user to target where on the site the overlay will display.  The following conditionals are currently supported:

| Conditional   	| Supports Targeting 	| WP Function     	|
|---------------	|--------------------	|-----------------	|
| is_home       	| n/a                	| is_home()       	|
| is_front_page 	| n/a                	| is_front_page() 	|
| is_page       	| ✓                  	| is_page()       	|
| is_single     	| n/a                	| is_single()     	|
| is_tag        	| ✓                  	| is_tag()        	|
| has_tag       	| ✓                  	| has_tag()       	|
| is_category   	| ✓                  	| is_category()   	|
| has_category  	| ✓                  	| has_category()  	|

#### Targeting

Targeting allows the user to target an overlay to a specific page, taxonomy or tag.  Targeting an overlay drastically increases it's priority, explained in detail within [priority systems](### Priority Sytems).




### Priority System

Each overlay has a display priority point value calculated from it's conditional settings and menu order.  Each Overlay Priorities are used to determine what overlay should display when more than one is found targeting the current screen.  Each overlay's priority is tallied up and the one with the highest value is then displayed.

#### Point Breakdown

| Condition            |                         Description                         | Operator | Value | Frequency       |
|----------------------|:-----------------------------------------------------------:|:--------:|:-----:|-----------------|
| targeted conditional | If an overlay is targeting a specific page, taxonomy or tag |     +    |  200  | per conditional |
| matched conditional  | If an overlay conditional positively matches current screen |     +    |   50  | per conditional |
| menu order           | used for manual overrides and additional specificity        |     +    |   X   | per overlay     |

#### Specificity is prioritized over Menu Order

Conditionals that target specific posts and terms operate on a higher priority than those that target generally.  This is why whenver a targeted conditional is found it's priority is bumped by 200 points.

#### Menu Order

The `menu_order` attribute is utilized in two common scenarios.  The first is to determine priority when a targeted conditional can't be found.    The second is to provide additional specificity and override capabilities to non-targeted overlays.  If no priorities or conditionals have been set on the overlay the *published date* is used as a fallback.





### Cookies

fm-overlays determines how frequently to show each overlay through the use of cookies.  The cookies are set via javascript using the attr `data-cookiename` with an expiration time of 2 hours.

Cookie names will appear like `fm-overlay-2357` using the overlay ID as a unique identifier.

_Important: When implementing on a site visitors *must be notified* cookies are being set [per EU Guidelines](http://ec.europa.eu/ipg/basics/legal/cookies/index_en.htm). This plugin does not handle any such notifications._




## Styling Popup

fm-overlays feature a number of classes that designers can use to customize the look and feel of each overlay.


#### Standard Classes

You can style the popup via the `.fm-overlay-wrapper` overlay class.  Each overlay will display different classes depending on its configuration.

- `.fm-overlay-content` wraps your content
- `.fm-overlay-title` is the overlay's title
- `.fm-overlay-richtext` is the rich text wrapper class
- `.fm-overlay-image` is the image wrapper class
- `.fm-image-link` is the anchor tag wrapping the image
- `.fm-image` is the div that immediately wraps the `<img>` tag


#### Unique Overlay  Styles

Target styles to a specific overlay by using its dynamic class. The class is generated using the overlay ID and will look something like: `.fm-overlay-2357`.
