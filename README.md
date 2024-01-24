# README: Pawtucket2 version 2.0

### About CollectiveAccess

CollectiveAccess is collections management and presentation software maintained by the staff at Whirl-i-Gig and contributed to by the open-source community. The CollectiveAccess project began in 2003 as a response to the complete lack of non-commercial, affordable, open-source solutions for digital collections management. Almost two decades later, CollectiveAccess has projects on 5 continents, providing hundreds of institutions with configurable, up-to-date collections management software.

A web-based suite of applications providing a framework for management, description, and discovery of complex digital and physical collections in museum, archival, and research contexts, CollectiveAccess consists of two applications: Providence and Pawtucket2. Providence, the “back-end” cataloging component of CollectiveAccess, is highly configurable and supports a variety of metadata standards, data types, and media formats. Pawtucket2 is CollectiveAccess' general purpose public-access publishing tool, providing an easy way to create web sites around data managed with Providence. (You can learn more about Pawtucket2 at https://github.com/collectiveaccess/pawtucket2). **You must have a working Providence installation to use Pawtucket2**.

CollectiveAccess is freely available under the open source GNU Public License version 3, meaning it’s not only free to download and use but that users are encouraged to share and distribute code.


### About Pawtucket2

Pawtucket2 provides many features for finding, presenting and interacting with collections information, including:

* Full text search
* Configurable faceted browse
* Ability to browse within search results
* Configurable detail displays for collection objects and all authorities- you can show as much or as little information from your Providence back-end catalogue as you want
* Support for "galleries" - simple online exhibitions using curator-defined sets
* Support for user-created tags, comments and lightboxes
* Not object-centric. While objects are usually the focus of a collections front-end, with Pawtucket2 they don't have to be. You can search and browse in any authority in addition to collection objects. This makes Pawtucket2 useful for specialized applications such as biographical catalogues (focussed on people rather than objects) and collection-level archival finding aids (focussed on collections rather than objects).

Pawtucket2 is meant to be customized. The download package includes a neutral default theme that supports all functionality. You can edit the CSS stylesheets and view templates to make Pawtucket fit into most any design scheme. 

All CollectiveAccess components are freely available under the open source GNU Public License version 3.


### About CollectiveAccess 2.0

Pawtucket2 2.0 is compatible with PHP 7.4, 8.0, 8.2 and 8.2.


### Updating from a previous version

NOTE: The update process is relatively safe and rarely, if ever, causes data loss. That said, BACKUP YOUR EXISTING DATABASE AND CONFIGURATION prior to updating. You almost certainly will not need it, but if you do you'll be glad it's there.


#### Updating from version 1.7 or later

Before attempting to upgrade your Pawtucket2 installation to version 2.0, make sure your Providence installation has been updated to 2.0. While it is often possible to run an older version of Pawtucket2 with a newer version of Providence, it is not guaranteed. It is usually not possible to run an older version of Providence with a newer version of Pawtucket2.

To update from a version 1.7.x installation, decompress the CollectiveAccess Pawtucket2 2.0 tar.gz or zip file, and replace the files in your existing installation with those in the update. Take care to preserve your media directory, custom theme (in `themes/your_theme_name_here`) and your setup.php file. Note that themes written for use in 1.7 and PHP 7.x may require modifications for use for Pawtucket2 2.0 due to changes in the PHP programming language.

Once the updated files are in place, navigate in your web browser to the home page of your Pawtucket2 installation. If you see the home page you're done. If you see this message:

```"Your database is out-of-date. Please install all schema migrations starting with migration #xxx. Click here to automatically apply the required updates, or see the update HOW-TO for instructions on applying database updates manually."```
 
you have not updated your Providence installation to version 2.0.


#### Updating from version 1.6 or earlier

To update from a version 1.6.x or older installation, you must first update to version 1.7, the follow the 1.7 update instructions.


### Installing development versions

The latest development version is always available in the `develop` branch (https://github.com/collectiveaccess/pawtucket2/tree/develop). Other feature-specific development versions are in branches prefixed with `dev/`. To install a development branch follow these steps:

1. clone this repository into the location where you wish it to run using `git clone https://github.com/collectiveaccess/pawtucket2`.
2. by default, the newly cloned repository will use the main branch, which contains code for the current release. Choose the `develop` branch by running from within the cloned repository `git checkout develop`.
3. install the PHP package manager [Composer](https://getcomposer.org) if you do not already have it installed on your server.
4. run `composer` from the root of the cloned repository with `composer.phar install`. This will download and install all required 3rd party software libraries. 
5. follow the release version installation instructions to complete the installation.

### Useful Links

* Web site: https://collectiveaccess.org
* Documentation: https://manual.collectiveaccess.org
* Demo: https://demo.collectiveaccess.org/
* Installation instructions: https://manual.collectiveaccess.org/pawtucket/user/setup/index.html
* Release Notes for 2.0:
  * https://manual.collectiveaccess.org/release_notes
* Forum: https://www.collectiveaccess.org/support/

To report issues please use GitHub Issues: https://github.com/collectiveaccess/pawtucket2/issues

### Other modules

Providence: https://github.com/collectiveaccess/providence (Back-end cataloguing application)
