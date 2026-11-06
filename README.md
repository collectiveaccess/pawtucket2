# README: Pawtucket2 version 2.0.12

### About CollectiveAccess

CollectiveAccess is a web-based suite of applications providing a framework for management, description, and discovery of complex digital and physical collections in museum, archival, and research contexts. It is comprised of two applications. Providence is the “back-end” cataloging component of CollectiveAccess. It is highly configurable and supports a variety of metadata standards, data types, and media formats. (You can learn more about it at https://github.com/collectiveaccess/providence). Pawtucket2 is CollectiveAccess' general purpose public-access publishing tool. It provides an easy way to create web sites around data managed with Providence. **You must have a working Providence installation to use Pawtucket2**.

### About Pawtucket2

Pawtucket2 provides many features for finding, presenting and interacting with collections information, including:

* Full text search
* Configurable faceted browse
* Browse within search results
* Configurable detail displays for collection objects and all authorities- you can show as much or as little information from your Providence back-end catalogue as desired
* Support for "galleries" - simple online exhibitions using curator-defined sets. 
* Support for user-created tags, comments and lightboxes.
* Not object-centric. While objects are usually the focus of a collections front-end, with Pawtucket2 they don't have to be. You can search and browse in any authority in addition to collection objects. This makes Pawtucket2 useful for specialized applications such as biographical catalogues (focussed on people rather than objects) and collection-level archival finding aids (focussed on collections rather than objects).

Pawtucket2 is meant to be customized. The download package includes a neutral default theme that supports all functionality. You can edit the CSS stylesheets and view templates to make Pawtucket fit into most any design scheme. 

All CollectiveAccess components are freely available under the open source GNU Public License version 3.


### About Pawtucket2 2.0.12

This version of CollectiveAccess is compatible with PHP versions 8.2, 8.3, 8.4 and 8.5. It cannot be run with PHP versions prior to 8.2. 

Version 2.0.12 provides many bug fixes and improvements:

* Address potential unauthorized disclosure of media housed in Media-type metadata elements (See https://github.com/collectiveaccess/pawtucket2/security/advisories/GHSA-fjpc-8pvw-mpjq). Access control for metadata element attribute download endpoints is now uniformly enforced, and elements offering downloads must now be explicitly enumerated in the theme `detail.conf` configuration file. (Note that this is a breaking change. If your theme offers downloads and media metadata elements you will have to modify your `detail.conf` file. Most themes do not offers such downloads, however).
* Expanded display template system now supports display of previous metadata values and value histories.
* Annotations are now possible for HEIC and WebP format images, and for additional video types.
* New `enableAnnotations` option in `detail.conf` provides means to disable annotation features when they are not needed. Annotations are now disabled by default. If your theme requires annotations you must modify your theme to reënable them.


### Installing development versions

The latest development versions are available on GitHub in branches prefixed with `dev/`. If you are not sure what to run, use a release. If you are looking to work with an in-development feature, you can install a development branch using these steps:

* Clone this repository into the location where you wish it to run using git clone https://github.com/collectiveaccess/pawtucket2.
* By default, the newly cloned repository will use the main branch, which contains code for the current release. Choose the desired branch by running from within the cloned repository `git checkout <branch name>`.
* Install the PHP package manager [Composer](https://getcomposer.org) if you do not already have it installed on your server.
* Run `composer` from the root of the cloned repository with `composer.phar install.` This will download and install all required 3rd party software libraries.
* Follow the release version installation instructions to complete the installation.

### Useful Links

* Web site: https://collectiveaccess.org
* Documentation: https://docs.collectiveaccess.org
* Demo: https://demo.collectiveaccess.org/
* Installation instructions: https://docs.collectiveaccess.org/providence/user/setup/installation.html
* Forum: https://www.collectiveaccess.org/support/forum

To report issues please use GitHub Issues.

### Other modules

Providence: https://github.com/collectiveaccess/providence (Back-end cataloguing application)
