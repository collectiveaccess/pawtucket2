# README: Pawtucket2 version 1.7.8

### About CollectiveAccess

CollectiveAccess is a web-based suite of applications providing a framework for management, description, and discovery of complex digital and physical collections in museum, archival, and research contexts. It is comprised of two applications. Providence is the “back-end” cataloging component of CollectiveAccess. It is highly configurable and supports a variety of metadata standards, data types, and media formats. (You can learn more about it at https://github.com/collectiveaccess/providence). Pawtucket2 is CollectiveAccess' general purpose public-access publishing tool. It provides an easy way to create web sites around data managed with Providence. **You must have a working Providence installation to use Pawtucket2**.

### About Pawtucket2

Pawtucket2 provides many features for finding, presenting and interacting with collections information, including:

* Full text search
* Configurable faceted browse
* Ability to browse within search results
* Configurable detail displays for collection objects and all authorities- you can show as much or as little information from your Providence back-end catalogue as you want
* Support for "galleries" - simple online exhibitions using curator-defined sets. 
* Support for user-created tags, comments and lightboxes.
* Not object-centric. While objects are usually the focus of a collections front-end, with Pawtucket2 they don't have to be. You can search and browse in any authority in addition to collection objects. This makes Pawtucket2 useful for specialized applications such as biographical catalogues (focussed on people rather than objects) and collection-level archival finding aids (focussed on collections rather than objects).

Pawtucket2 is meant to be customized. The download package includes a neutral default theme that supports all functionality. You can edit the CSS stylesheets and view templates to make Pawtucket fit into most any design scheme. 

All CollectiveAccess components are freely available under the open source GNU Public License version 3.


### About CollectiveAccess 1.7.8

Version 1.7.8 is a maintenance release with a handful of bug fixes. It is compatible with PHP 7.2 and will run under PHP versions 5.6, 7.0, 7.1 and 7.2. It has not been extensively tested with PHP 7.3 or MySQL 8.0. A list of changes is [available](https://clangers.collectiveaccess.org/jira/issues/?filter=11242).


### Updating from a previous version

NOTE: The update process is relatively safe and rarely, if ever, causes data loss. That said BACKUP YOUR EXISTING DATABASE AND CONFIGURATION prior to updating. You almost certainly will not need it, but if you do you'll be glad it's there.


#### Updating from version 1.7 or later

Before attempting to upgrade your Pawtucket2 installation to version 1.7.8 make sure your Providence installation has been updated to 1.7.8. While it is often possible to run an older version of Pawtucket2 with a newer version of Providence, it is not guaranteed. It is usually not possible to run an older version of Providence with a newer version of Pawtucket2.

To update from a version 1.7.x installation decompress the CollectiveAccess Pawtucket 1.7.8 tar.gz or zip file, and replace the files in your existing installation with those in the update. Take care to preserve your media directory, custom theme (in `themes/your_theme_name_here`) and your setup.php file.

Once the updated files are in place navigate in your web browser to the home page of your Pawtucket2 installation. If you see the home page you're done. If you see this message:

```"Your database is out-of-date. Please install all schema migrations starting with migration #xxx. Click here to automatically apply the required updates, or see the update HOW-TO for instructions on applying database updates manually."```
 
you have not updated your Providence installation to version 1.7.9.


#### Updating from version 1.6 or earlier

To update from a version 1.6.x or older installation decompress the CollectiveAccess Providence 1.7.8 tar.gz or zip file, and replace the files in your existing installation with those in the update. Take care to preserve your media directory and custom theme (in `themes/your_theme_name_here`). 

Next rename your existing setup.php to something else (Eg. `setup.php-old`). Then copy the version 1.7.8 template in `setup.php-dist` to `setup.php`. Edit this file with your database login information, system name and other basic settings. You can reuse the settings in your old setup.php file as-is. Only the format of the setup.php file has changed.

Once the updated files are in place navigate in your web browser to the home page of your Pawtucket2 installation. If you see the home page you're done. If you see this message:

```"Your database is out-of-date. Please install all schema migrations starting with migration #xxx. Click here to automatically apply the required updates, or see the update HOW-TO for instructions on applying database updates manually."```
 
you have not updated your Providence installation to version 1.7.8.

Version 1.7 introduced zoomable media versions for multipage documents such as PDFs, Microsoft Word or Powerpoint. Systems migrated from pre-1.7 versions of CollectiveAccess will not have these media versions available causing the built-in document viewer to fail. If your system includes multipage documents you should regenerate the media **in Providence** using the command-line caUtils utility in `support/bin`. See the [Providence README](https://github.com/collectiveaccess/providence) for details.


### Useful Links

* Web site: https://collectiveaccess.org
* Documentation: https://docs.collectiveaccess.org
* Demo: https://demo.collectiveaccess.org/
* Installation instructions: http://docs.collectiveaccess.org/wiki/Installing_Pawtucket2
* Upgrade instructions: http://docs.collectiveaccess.org/wiki/Upgrading_Pawtucket2
* Release Notes for 1.7:
  * https://docs.collectiveaccess.org/wiki/Release_Notes_for_Pawtucket2_1.7
  * https://docs.collectiveaccess.org/wiki/Release_Notes_for_Pawtucket2_1.7.8
* Forum: https://www.collectiveaccess.org/support/forum
* Bug Tracker: https://clangers.collectiveaccess.org

### Other modules

Providence: https://github.com/collectiveaccess/providence (Back-end cataloguing application)
