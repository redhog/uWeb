# Short installation notes
If you are running PHP4, you must install the PHP_Compat Pear package:
'pear install PHP_Compat'.

Install PostgreSQL support for PHP.

You need to edit config.php to point to the database, and load
uweb.sql into the db. If you want example data loaded to play with
load uweb.data.sql aswell. Otherwise, run the sql-statement

insert into account (name, password) values ('myusername', 'mypassword');


# Using uWeb
If you installed uWeb in http://myserver/uWeb, go to
http://myserver/uWeb/uweb.php/ and click your way from there (PHP does
not support PATH_INFO for index.php!).


# Customizing uWeb

uWeb uses a list of template directories defined in the config-file
with the $templatesdirs variable to create the design of the web-page.
The templates in one directory overrides templates in another listed
after the first one in the config-file. Example:

$templatesdirs=array("site-templates", "templates");

Files from "site-templates" will override files from "templates".

You generally want to have "templates" as the last item in all but
very strange cases, as that template provides good defaults.


## How the templating work

It's far easier to explain this by example. For this example, we
assume $templatesdirs=array("my-site", "my-company", "templates").

When a user enters the URL
http://myserver/uWeb/uweb.php/boats/sailing-boats/wooden?action=view,
uWeb will try to load templates for the path
/boats/sailing-boats/wooden with action=view.

The first template loaded is a template called "page", and it might in
turn load other templates, like "menu", "top-banner", "object" and
"children".

To load the "page" template for /boats/sailing-boats/wooden with
action "view", the following files are searched for, in the order
below, and the first one found is loaded:

    my-site/page/boats/sailing-boats/wooden/nonrecursive.view.php
    my-company/page/boats/sailing-boats/wooden/nonrecursive.view.php
    templates/page/boats/sailing-boats/wooden/nonrecursive.view.php

    my-site/page/boats/sailing-boats/wooden/view.php
    my-site/page/boats/sailing-boats/view.php
    my-site/page/boats/view.php
    my-site/page/view.php
    my-company/page/boats/sailing-boats/wooden/view.php
    my-company/page/boats/sailing-boats/view.php
    my-company/page/boats/view.php
    my-company/page/view.php
    templates/page/boats/sailing-boats/wooden/view.php
    templates/page/boats/sailing-boats/view.php
    templates/page/boats/view.php
    templates/page/view.php

    my-site/page/boats/sailing-boats/wooden/default.php
    my-site/page/boats/sailing-boats/default.php
    my-site/page/boats/default.php
    my-site/page/default.php
    my-company/page/boats/sailing-boats/wooden/default.php
    my-company/page/boats/sailing-boats/default.php
    my-company/page/boats/default.php
    my-company/page/default.php
    templates/page/boats/sailing-boats/wooden/default.php
    templates/page/boats/sailing-boats/default.php
    templates/page/boats/default.php
    templates/page/default.php

Note that templates with other extensions than .php can be loaded in
the same manner, and that the action=view is assumed if no other
action is specified. Other standard actions include "edit", "save",
"log-in" and "log-in-save".

To load templates, the functions findTemplateServerPath and
findTemplateClientPath are used. The only difference between them is
that the former returns a path that you can do require() on from
within PHP, while the path returned by the latter one is suitable to
include in a script tag in the HTML you output.

Example usages:

    require(findTemplateServerPath("/boats/sailing-boats/wooden", "page", "view", "php"));
    echo "<script src='" .findTemplateClientPath("/boats/sailing-boats/wooden", "page", "view", "css") . "'></script>";


### Template sets

It is sometimes usefull to load a set of templates and concatenate
them all. For example, such templates can provide "boxes" to show on
the side of a web-page.

Template sets works very much like templates, except you use the
functions findTemplateSetServerPath and findTemplateSetClientPath
instaed of findTemplateServerPath and findTemplateClientPath, and
these functions return an array of template files instaed of a single
file.

Whil the template functions search for templates directly under e.g.
my-company/page, the template set functions does a directory listing
under each "template" director, and searches for templates in all of
those.

Example:

    findTemplateSetServerPath("/boats/sailing-boats/wooden", "boxes", "view", "php")

will list the directories under

    my-site/boxes
    my-company/boxes
    templates/boxes

say that the directories found are

    my-site/boxes/ticker
    my-site/boxes/search
    my-company/boxes/ticker
    templates/boxes/search
    templates/boxes/info

then the return value of the above call will be

    array(
     findTemplateServerPath("/boats/sailing-boats/wooden", "boxes/ticker", "view", "php"),
     findTemplateServerPath("/boats/sailing-boats/wooden", "boxes/search", "view", "php"),
     findTemplateServerPath("/boats/sailing-boats/wooden", "boxes/info", "view", "php"))


## Objects

Best explanation is to see any template that deals with objects
("object" and "children"). There is one "big" function that might
deserve an explanation here though, getObjects.

getObjects is used both to list/search for objects, and to get their
properties.

It takes the following parameters:

 * $path The path under which to perform the search, such as /boats/sailing-boats/wooden

 * $relation Specifies how $path is interpreted:
   * 0 means return the object specified by $path
   * 1 means return all children of the object specified by $path
   * 2 means return all descendants of the object specified by $path

 * $requires Restricts objects returned to ones having some specific properties set. E.g. to only return objects that are both visible and have the title "Blurb", set $requires to array("Visible => "yes", "Title" => "Blurb").

 *$properties List of properties to include in the output, or NULL to include all properties.

The return value is easies explained by an example (again):

    array(
     4711 => array('paths' => array('/boats/sailing-boats/wooden/sskaukasus', '/boats/large/sskaukasus'),
                   'properties' => array('Visible' => 'yes',
                                         'Title' => 'S/S Kaukasus',
                                         'Body' => 'S/S Kaukasus is one of our fines wooden +12m long boats with a total of 60m^s sail area.'))
     4712 => array('paths' => array('/boats/sailing-boats/metal/ssmaria', '/boats/small/ssmaria'),
                   'properties' => array('Visible' => 'yes',
                                         'Title' => 'S/S Maria',
                                         'Body' => 'S/S Maria is a 6m long easy-sailed boat perfect for the first-timer')))

(here 4711 and 4712 are the object identifiers of the objects. You
will usually not use these numbers, but the paths to the objects, e.g.
/boats/sailing-boats/wooden/sskaukasus or /boats/small/ssmaria).
