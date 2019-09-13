# Agora-LAB

Adapted fork of https://github.com/projectestac/agora with simplified instances of WordPress and Moodle, useful for testing new features.

Clone this repository and define the `upstream` remote:

```bash
$ git clone --recurse-submodules https://github.com/frncesc/agora-lab.git
# ... long process! please be patient
$ cd agora-lab
$ git remote add upstream https://github.com/projectestac/agora.git
# Check with:
$ git remote -v
$ git fetch upstream
```

Download Moodle and WordPress and deploy it on `/moodle` and `/nodes`

Current versions are:
- Moodle 3.6.5 from: https://download.moodle.org/download.php/stable36/moodle-3.6.5.tgz
- WordPress 5.1.1 from: https://wordpress.org/wordpress-5.1.1.tar.gz


Prepare devilbox

```bash
# Replace "/path/to/devilbox" and 
# "/path/to/agora-lab" with the appropiate values
$ cd /path/to/devilbox
$ cd data/www
$ mkdir moodle
$ cd moodle
$ ln -s /path/to/agora-lab/moodle ./htdocs
```

Edit the file `/etc/hosts` and add this line:

```
127.0.0.1 moodle.loc nodes.loc
```

Launch Devilbox and create `moodle` and `nodes` databases in MySQL with PHPMyAdmin:

```SQL
CREATE USER 'moodle'@'%' IDENTIFIED WITH mysql_native_password;
GRANT USAGE ON *.* TO 'moodle'@'%' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
SET PASSWORD FOR 'moodle'@'%' = 'moodle';
CREATE DATABASE IF NOT EXISTS `moodle`;
GRANT ALL PRIVILEGES ON `moodle`.* TO 'moodle'@'%';
GRANT ALL PRIVILEGES ON `moodle\_%`.* TO 'moodle'@'%';
```

```SQL
CREATE USER 'nodes'@'%' IDENTIFIED WITH mysql_native_password;
GRANT USAGE ON *.* TO 'nodes'@'%' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
SET PASSWORD FOR 'nodes'@'%' = 'nodes';
CREATE DATABASE IF NOT EXISTS `nodes`;
GRANT ALL PRIVILEGES ON `nodes`.* TO 'nodes'@'%';
GRANT ALL PRIVILEGES ON `nodes\_%`.* TO 'nodes'@'%';
```

## Moodle setup

Install Moodle from scratch, navigating to https://moodle.loc

When finished, add the additional Moodle plugins by running:

```bash
$ ./create-moodle-links.sh
```

Update Moodle with the newly installed plugins, visiting again: https://moodle.loc

Add the 'Catalan' language pack and make it the default:

- Site Administration | Language Packs | Select `Català (ca)` | Install selected language pack
- Site Administration | Language Settings | Default language | Select `Català (ca)` | Save Changes
- Admin User | Preferences | Preferred language | Select `Català (ca)` | Save Changes

Select XTEC2 theme as default:

- Administració del lloc | Aparença | Selector de temes | A _Default_: Canvia el tema | Buscar XTEC2 | Utilitza el tema


## Nodes setup

Install WordPress in /nodes and launch https://nodes.loc to complete the initial set-up

Create a new folder for `wpdata`:
```bash
$ mkdir wpdata
```

Deactivate all WP plugins:

- Plugins | Select all | Bulk Actions - Deactivate | Apply

Edit `nodes/wp-config.php` and add the following lines just before `/* That's all, stop editing! Happy publishing. */`:

```php
/* Multisite */
define( 'WP_ALLOW_MULTISITE', true );
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'nodes.loc');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
```
Edit `nodes/.htaccess` and replace the current content by this one:

```apache
# BEGIN WordPress
<IfModule mod_rewrite.c>

RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]

# add a trailing slash to /wp-admin
RewriteRule ^([_0-9a-zA-Z-]+/)?wp-admin$ $1wp-admin/ [R=301,L]

RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]
RewriteRule ^([_0-9a-zA-Z-]+/)?(wp-(content|admin|includes).*) $2 [L]
RewriteRule ^([_0-9a-zA-Z-]+/)?(.*\.php)$ $2 [L]
RewriteRule . index.php [L]

</IfModule>
# END WordPress
```

For more info, check Wordpress Network Setup:

- Tools | Network Setup | Check _Sub-directories_ | Install

Create symlinks to Nodes specific plugins:

```bash
$ ./create-nodes-links.sh
```

Edit `nodes/wp-config.php` and add this line at the beggining of the file:

```php
include_once dirname(__FILE__) . '/wp-includes/xtec/lib.php';
```

Login again on https://nodes.loc and go to:

- My Sites | Network Admin | Settings | Default Language: Català | Save Changes

Then:

- Els meus llocs | Administrador de la Xarxa | Extensions | Select all | Accions massives -> Activa la xarxa | Aplica

Create sites...



---



# Àgora

[Àgora](http://agora.xtec.cat) is an on-line service integrated in the [Catalan Educational Telematic Network](http://www.xtec.cat) (XTEC) offering two types of educational platforms for schools:

- __Àgora Nodes__: a public web portal with intranet features based on [WordPress](https://wordpress.org/) and [BuddyPress](https://buddypress.org/)
- __Àgora-Moodle__: a complete Virtual Learning Environment based on [Moodle](https://moodle.org/)

Àgora has also a management module called __Àgora Portal__, addressed to school admins and based on [Zikula](https://zikula.org)

The service has currently about 1.500 instances of each platform running on an infrastructure that has only one software installation (replicated on several web servers behind a load balancer), shared by all schools. Each school has its own database and disk space for data storage, thus greatly simplifying the system maintenance while allowing to have its own independent platform.

School admins have full permissions to publish, create and edit sections, classrooms or any other type of content. They can also manage user accounts and grant permissions to teachers, students and parents.

## Àgora Nodes

The main components of the [Nodes](http://agora.xtec.cat/nodes) platform are:

- [WordPress](https://wordpress.org/), the world's most used Content Management System (CMS)
- [BuddyPress](https://buddypress.org/) providing a school private social network, tools for team collaboration and document management.
- A selection of [WordPress plugins](https://wordpress.org/plugins/), some of them adapted for specific requirements.
- New plugins developed for Nodes, like a [booking system](http://agora.xtec.cat/moodle/moodle/mod/glossary/view.php?id=1741&mode=entry&hook=2601) for managing classrooms, equipment and other school facilities.
- A specific WordPress responsive theme that gives a common visual look to all school sites, customizable with several color combinations and school logos.
- A set of web templates, each one with a structure of pages, categories and layouts specially designed for primary, secondary, rural, adult and languages schools.

More information and a showcase of school sites can be found at: http://agora.xtec.cat/nodes/ (in Catalan)

To learn more about "Nodes": [Nodes, reinventando la web de la escuela](https://drive.google.com/open?id=0B1Whk6C-0QRaQnh3ZUsyUVA0TFE) (in Spanish)


## Àgora Moodle

The open source Virtual Learning Environment [Moodle](https://moodle.org) has been used for a long time in Catalan schools. Àgora offers to each school a complete Moodle platform including:

- A huge collection of [Moodle plugins](https://moodle.org/plugins/) suitable for primary and secondary schools.
- Some plugins specifically designed for other projects developed by our team, like [JClic](https://moodle.org/plugins/mod_jclic) or [Geogebra](https://moodle.org/plugins/mod_geogebra)
- The [Marsupial](https://github.com/projectestac/marsupial) Moodle plugin, designed to facilitate the communication with digital textbooks provided by some publishing houses.
- A direct connection with [Alexandria](https://github.com/projectestac/marsupial), the repository of Open Educational Resources ([OER](https://www.oercommons.org/)) created and shared by catalan teachers.
- The Moodle course format _[Senzill per temes](http://ateneu.xtec.cat/wikiform/wikiexport/cmd/tac/moodle2/b3_cursos/format_senzill)_, especially indicated for primary schools and developed by the Ministry of Education of Andorra.


## Technical details

The [source code repository](https://github.com/projectestac/agora) is organized in [git submodules](https://git-scm.com/book/en/v2/Git-Tools-Submodules). The steps to reproduce to obtain the full source code are:

- Git clone the desired module. You can choose between:
    * Àgora-Nodes: `git clone https://github.com/projectestac/agora_nodes.git`
    * Àgora-Moodle: `git clone https://github.com/projectestac/agora_moodle2.git`
    * The full Àgora platform: `git clone https://github.com/projectestac/agora.git`

- Launch `git submodule update --init --recursive` to initialize all the submodules. Please be patient, because this step can take time.

- To update the repository content with the latest version of the software, launch anytime: `git pull --recurse-submodules`

See INSTALL.txt for installation instructions.


## License

Àgora is build entirely with open source software. Each component is released under its own license terms, usually [GPL 2.0](http://www.gnu.org/licenses/gpl-2.0.txt) or [GPL 3.0](http://www.gnu.org/licenses/gpl-2.0.txt).

Common parts and specific modules are relased under the terms of the [EUPL-1.1](https://spdx.org/licenses/EUPL-1.1.html)

## Contributors

Developers:
- Toni Ginard (aginard@xtec.cat)
- Pau Ferrer (pferre22@xtec.cat)
- Sara Arjona (sarjona@xtec.cat)
- Salva Valldeoriola (svallde2@xtec.cat)
- Xavier Meler (jmeler@xtec.cat)
- Víctor Saavedra (vsaavedr@xtec.cat)
- Albert Pérez (aperez16@xtec.cat)
- Jaume Miró (jmiro227@xtec.cat)
- Fèlix Casanellas (fcasanel@xtec.cat)
- Jaume Fernández (jfern343@xtec.cat)
- Aida Regi (aregi@xtec.cat)

With the support of:
- Francesc Busquets
- Eduard Cercós
- Mònica Grau
- Isabel Oussedik
- Pablo Mariña
- Jordi Vivancos
   
AGORA uses code from the following projects:

- Moodle: Learning Management System (http://moodle.org/)
- Nodes: CMS for Education & Social Network based on Wordpress & BuddyPress (http://agora.xtec.cat/nodes)


AGORA includes external resources like:

- Abecedario: True Type Font (revised version)
- /course/senzill/pix/f/flash.png: CC (by-nc-sa) http://barrymieny.deviantart.com/
- /course/senzill/pix/f/zip.png: CC (by-nc-nd) http://thvg.deviantart.com/


Special Thanks:
- Catalan schools involved in the project
- Albert Gasset
- Govern d'Andorra 
- UPCnet
- Itteria

