# README: Pawtucket2 version 2.0

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


### About Pawtucket2 2.0

This version of Pawtucket2 is compatible with PHP versions 8.2 and 8.3. We are currently testing compatibility with PHP 8.4, but it should be usable with that version as well. It can be made to work with PHP versions as old as 7.4 if need be, but it is unsupported when used with pre 8.2 versions of PHP.


### Updating from version 1.7 or later

NOTE: The update process is relatively safe and rarely, if ever, causes data loss. That said, BACKUP YOUR EXISTING DATABASE AND CONFIGURATION prior to updating. You almost certainly will not need the backup, but if you do you'll be glad it's there.

Before attempting to upgrade your Pawtucket2 installation make sure your Providence installation has been updated to 2.0. While it is often possible to run an older version of Pawtucket2 with a newer version of Providence, compatibility is not guaranteed. It is usually not possible to run an older version of Providence with a newer version of Pawtucket2.

To update from a version 1.7.x installation decompress the CollectiveAccess Pawtucket2 2.0 tar.gz or zip file, and replace the files in your existing installation with those in the update. Take care to preserve your media directory, custom theme (in `themes/your_theme_name_here`) and your `setup.php` file.

Once the updated files are in place navigate in your web browser to the home page of your Pawtucket2 installation. If you see the home page you're done. If you see this message:

```"Your database is out-of-date. Please install all schema migrations starting with migration #xxx."```
 
your Providence installation has most likely not yet been updated to version 2.0. Perform the Providence update and check your Pawtucket2 installation again.


### Updating from version 1.6 or earlier

To update from a version 1.6.x or older installation, you must first update to version 1.7, then follow the 1.7 update instructions.

### Installing development versions

The latest development versions are available on GitHub in branches prefixed with `dev/`. If you are not sure what to run, use a release. If you are looking to work with an in-development feature, you can install a development branch using these steps:

# Clone this repository into the location where you wish it to run using git clone https://github.com/collectiveaccess/pawtucket2.
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
