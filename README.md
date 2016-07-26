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

- is_home
- is_front_page
- *is_category*
- *has_category*
- is_single
- *is_page*
- *is_tag*
- *has_tag*

Conditionals marked with *italics* allow the user to specifically target a page, category, or tag.



### Priorities

Each overlay has a display priority that can be set using the `menu_order` attribute.  The larger the `menu_order` the higher the display priority.  If no priorities have been set the *published date* is used as a fallback.



### Specificity is prioritized over Menu Order

Conditionals that target specific posts and terms operate on a higher priority than those that target generally.




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
