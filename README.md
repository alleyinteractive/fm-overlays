# fm-overlays
A Fieldmanager extension to render dynamic content in modal boxes/overlays on a site.

## Install & Setup

Requires [Fieldmanager](https://github.com/alleyinteractive/wordpress-fieldmanager) to be installed and activated.

### Cookies

FM-Overlays use cookies in order to control how frequently they appear for the user.  Currently the cookie expiration time is set to expire after 20 hours.

Cookies are set in the `set_overlay_cookie` function inside of `class-fm-overlays.php` using the overlay ID to dynamically generate a name like `fm-overlay-2357`.

_Important: When implementing on a site visitors *must be notified* cookies are being set [per EU Guidelines](http://ec.europa.eu/ipg/basics/legal/cookies/index_en.htm). This plugin does not handle any such notifications._

### Styling Popup

You can style the popup via the `.fm-overlay-wrapper` overlay class.
`.fm-overlay-content` wraps your content
`.fm-overlay-title` is the overlay's title
