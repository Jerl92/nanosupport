<img src="https://cloud.githubusercontent.com/assets/4551598/18225488/c7c6a738-7214-11e6-80bd-afed15d6cd00.png" alt="From" data-canonical-src="https://cloud.githubusercontent.com/assets/4551598/18225488/c7c6a738-7214-11e6-80bd-afed15d6cd00.png" style="max-width:100%;"></br>

## User
<img src="https://i.ibb.co/xXTv0tS/68747470733a2f2f692e6962622e636f2f574671636b71722f73756e746572726170632e706e67.png" alt="From" data-canonical-src="https://i.ibb.co/xXTv0tS/68747470733a2f2f692e6962622e636f2f574671636b71722f73756e746572726170632e706e67.png" style="max-width:100%;"></br>

<img src="https://i.ibb.co/8BsLYxT/68747470733a2f2f692e6962622e636f2f4b6d73774c79332f73756e74657272617063322e706e67.png" alt="From" data-canonical-src="https://i.ibb.co/8BsLYxT/68747470733a2f2f692e6962622e636f2f4b6d73774c79332f73756e74657272617063322e706e67.png" style="max-width:100%;"></br>

<img src="https://i.ibb.co/GWmYSz0/68747470733a2f2f692e6962622e636f2f6343347751354d2f56575245562e706e67.png" alt="From" data-canonical-src="https://i.ibb.co/GWmYSz0/68747470733a2f2f692e6962622e636f2f6343347751354d2f56575245562e706e67.png" style="max-width:100%;"></br>

## Admin
<img src="https://i.ibb.co/vBLzty3/68747470733a2f2f692e6962622e636f2f487839396b58442f73756e7465727261332e706e67.png" alt="From" data-canonical-src="https://i.ibb.co/vBLzty3/68747470733a2f2f692e6962622e636f2f487839396b58442f73756e7465727261332e706e67.png" style="max-width:100%;"></br>

<img src="https://i.ibb.co/82cmLms/68747470733a2f2f692e6962622e636f2f303278536d4c712f73756e7465727261342e706e67.png" alt="From" data-canonical-src="https://i.ibb.co/82cmLms/68747470733a2f2f692e6962622e636f2f303278536d4c712f73756e7465727261342e706e67.png" style="max-width:100%;"></br>

<img src="https://i.ibb.co/LSwCpm0/68747470733a2f2f692e6962622e636f2f32506e77486d562f73756e7465727261352e706e67.png" alt="From" data-canonical-src="https://i.ibb.co/LSwCpm0/68747470733a2f2f692e6962622e636f2f32506e77486d562f73756e7465727261352e706e67.png" style="max-width:100%;"></br>

```js
  $sn_args = array(
      'fields' => 'ids',
      'post_type'   => 'nanosupport',
      'meta_query'  => array(
          array(
          'key' => '_ns_ticket_serial_number',
          'value' => $meta_data_serial_number,
          'compare' => '='
          )
      )
  );
  $my_query = new WP_Query( $sn_args );
  $same_sn_count = $my_query->found_posts;
```

# NanoSupport <kbd>[**DOWNLOAD**](https://wordpress.org/plugins/nanosupport/)</kbd>
Smart Support Ticketing Plugin for WordPress

| Requires | Tested up to | Stable Release | w.org Rating | License | w.org Downloads |
|---|---|---|---|---|---|
| WordPress 4.4.0 | ![Tested WordPress version](https://img.shields.io/wordpress/v/nanosupport.svg?style=flat) | ![WordPress plugin](https://img.shields.io/wordpress/plugin/v/nanosupport.svg?style=flat) | ![WordPress.org rating](https://img.shields.io/wordpress/plugin/r/nanosupport.svg?style=flat) | [GPL-2.0+](http://www.gnu.org/licenses/gpl-2.0.txt) | [![Wordpress](https://img.shields.io/wordpress/plugin/dt/nanosupport.svg?style=flat)]() |

## Introduction
Create a fully featured Support Center within your WordPress environment without any third party system dependency &mdash; completely FREE. It has built-in Knowledgebase too. **No** 3rd party support ticketing system required, **no** external site/API dependency, **simply** create your own fully featured Support Center within your WordPress environment, and take your support into the next level.

It has a built-in Knowledgebase that can be used for information that are for public acknowledgement.

The plugin is to provide support to your users - the users those are taking product or services from you. So the plugin provides a manageable communication privately in between you and your specific customer only. Take a look at the [installation process](https://github.com/nanodesigns/nanosupport/wiki/Installation) and [how to use](https://github.com/nanodesigns/nanosupport/wiki/How-to-Use) the plugin.

[:white_check_mark: Read the List of its nice **Features**](https://github.com/nanodesigns/nanosupport/wiki/Introduction-&-Features)<br>
[:computer: See the **Screenshots**](https://github.com/nanodesigns/nanosupport/wiki/Screenshots)

---
[:notebook_with_decorative_cover: **User Guide**](https://github.com/nanodesigns/nanosupport/wiki) [:earth_asia: **Translate** NanoSupport](https://translate.wordpress.org/projects/wp-plugins/nanosupport)

---

### Available Automatic Translation
* Bengali (_Bangla_) - Bangladesh - `bn_BD`
* Danish - Denmark - `da_DK` (thanks to @nh123 and @ellegaarddk)
* Español - Spain - `es_ES` (thanks to @wptech68 and @fernandot)

## Contribute
NanoSupport is an Open Source and GPL licensed Free plugin. Feel free to contribute.

We're managing things using:

* `npm` ([Installing npm](https://docs.npmjs.com/getting-started/installing-node)), and
* `grunt` ([Installing grunt](https://gruntjs.com/getting-started))

Open the command console and type the following to install dependencies:

````
git clone https://github.com/nanodesigns/nanosupport.git nanosupport && cd nanosupport && npm install
````

Then run `grunt` to prepare necessary javascripts and styles.

* [:octocat: Fork on Github](https://github.com/nanodesigns/nanosupport) &mdash; <small>[:blue_book: Consult the Developer guide](https://github.com/nanodesigns/nanosupport/wiki/Developer-Guide)</small>
* [:bug: Report Bug/Limitations or Suggest Feature/Enhancement](https://github.com/nanodesigns/nanosupport/issues/new)
* [:flashlight: Get Support](https://github.com/nanodesigns/nanosupport/issues/new)
* [:earth_asia: Translate NanoSupport](https://translate.wordpress.org/projects/wp-plugins/nanosupport)

---
![nanosupport-icon](https://cloud.githubusercontent.com/assets/4551598/18225502/20899fb0-7215-11e6-89b2-77002df466d7.png) **NanoSupport**, by [**nano**designs](http://nanodesignsbd.com?ref=nanosupport) &mdash; [<kbd>Twitter</kbd>](https://twitter.com/nanodesigns/) [<kbd>Facebook</kbd>](https://facebook.com/nanodesignsbd/) [<kbd>LinkedIn</kbd>](http://www.linkedin.com/company/nanodesigns) [<kbd>Google+</kbd>](https://google.com/+Nanodesignsbd)
