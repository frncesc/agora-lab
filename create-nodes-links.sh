#!/bin/bash

#
# Create symbolic links into /nodes from the Àgora source 
#

echo "Creating symbolic links in /nodes"

ln -s ../../../html/wordpress/wp-content/plugins/buddypress-activity-plus ./nodes/wp-content/plugins/buddypress-activity-plus
ln -s ../../../html/wordpress/wp-content/plugins/slideshow-jquery-image-gallery ./nodes/wp-content/plugins/slideshow-jquery-image-gallery
ln -s ../../../html/wordpress/wp-content/plugins/blogger-importer ./nodes/wp-content/plugins/blogger-importer
ln -s ../../../html/wordpress/wp-content/plugins/buddypress-like ./nodes/wp-content/plugins/buddypress-like
ln -s ../../../html/wordpress/wp-content/plugins/table-of-contents-plus ./nodes/wp-content/plugins/table-of-contents-plus
ln -s ../../../html/wordpress/wp-content/plugins/xtec-booking ./nodes/wp-content/plugins/xtec-booking
ln -s ../../../html/wordpress/wp-content/plugins/wp-recaptcha ./nodes/wp-content/plugins/wp-recaptcha
ln -s ../../../html/wordpress/wp-content/plugins/buddypress ./nodes/wp-content/plugins/buddypress
ln -s ../../../html/wordpress/wp-content/plugins/socialmedia ./nodes/wp-content/plugins/socialmedia
ln -s ../../../html/wordpress/wp-content/plugins/h5p ./nodes/wp-content/plugins/h5p
ln -s ../../../html/wordpress/wp-content/plugins/tabs-responsive ./nodes/wp-content/plugins/tabs-responsive
ln -s ../../../html/wordpress/wp-content/plugins/enllacos-educatius ./nodes/wp-content/plugins/enllacos-educatius
ln -s ../../../html/wordpress/wp-content/plugins/bbpress ./nodes/wp-content/plugins/bbpress
ln -s ../../../html/wordpress/wp-content/plugins/bbpress-enable-tinymce-visual-tab ./nodes/wp-content/plugins/bbpress-enable-tinymce-visual-tab
ln -s ../../../html/wordpress/wp-content/plugins/polylang ./nodes/wp-content/plugins/polylang
ln -s ../../../html/wordpress/wp-content/plugins/slideshare ./nodes/wp-content/plugins/slideshare
ln -s ../../../html/wordpress/wp-content/plugins/pods ./nodes/wp-content/plugins/pods
ln -s ../../../html/wordpress/wp-content/plugins/google-calendar-events ./nodes/wp-content/plugins/google-calendar-events
ln -s ../../../html/wordpress/wp-content/plugins/email-subscribers ./nodes/wp-content/plugins/email-subscribers
ln -s ../../../html/wordpress/wp-content/plugins/tinymce-advanced ./nodes/wp-content/plugins/tinymce-advanced
ln -s ../../../html/wordpress/wp-content/plugins/wordpress-telegram ./nodes/wp-content/plugins/wordpress-telegram
ln -s ../../../html/wordpress/wp-content/plugins/xtec-mail ./nodes/wp-content/plugins/xtec-mail
ln -s ../../../html/wordpress/wp-content/plugins/invite-anyone ./nodes/wp-content/plugins/invite-anyone
ln -s ../../../html/wordpress/wp-content/plugins/wordpress-php-info ./nodes/wp-content/plugins/wordpress-php-info
ln -s ../../../html/wordpress/wp-content/plugins/disable-gutenberg ./nodes/wp-content/plugins/disable-gutenberg
ln -s ../../../html/wordpress/wp-content/plugins/wordpress-social-login ./nodes/wp-content/plugins/wordpress-social-login
ln -s ../../../html/wordpress/wp-content/plugins/add-to-any ./nodes/wp-content/plugins/add-to-any
ln -s ../../../html/wordpress/wp-content/plugins/google-analyticator ./nodes/wp-content/plugins/google-analyticator
ln -s ../../../html/wordpress/wp-content/plugins/author-category ./nodes/wp-content/plugins/author-category
ln -s ../../../html/wordpress/wp-content/plugins/private-bp-pages ./nodes/wp-content/plugins/private-bp-pages
ln -s ../../../html/wordpress/wp-content/plugins/buddypress-group-email-subscription ./nodes/wp-content/plugins/buddypress-group-email-subscription
ln -s ../../../html/wordpress/wp-content/plugins/xtec-stats ./nodes/wp-content/plugins/xtec-stats
ln -s ../../../html/wordpress/wp-content/plugins/xtec-ldap-login ./nodes/wp-content/plugins/xtec-ldap-login
ln -s ../../../html/wordpress/wp-content/plugins/grup-classe ./nodes/wp-content/plugins/grup-classe
ln -s ../../../html/wordpress/wp-content/plugins/buddypress-docs ./nodes/wp-content/plugins/buddypress-docs
ln -s ../../../html/wordpress/wp-content/plugins/pending-submission-notifications ./nodes/wp-content/plugins/pending-submission-notifications
ln -s ../../../html/wordpress/wp-content/plugins/import-users-from-csv-with-meta ./nodes/wp-content/plugins/import-users-from-csv-with-meta
ln -s ../../../html/wordpress/wp-content/plugins/widget-visibility-without-jetpack ./nodes/wp-content/plugins/widget-visibility-without-jetpack
ln -s ../../../html/wordpress/wp-content/plugins/wordpress-importer ./nodes/wp-content/plugins/wordpress-importer
ln -s ../../html/wordpress/wp-content/mu-plugins ./nodes/wp-content/mu-plugins
ln -s ../../html/wordpress/wp-content/uploads ./nodes/wp-content/uploads
ln -s ../../../html/wordpress/wp-content/themes/reactor-primaria-1 ./nodes/wp-content/themes/reactor-primaria-1
ln -s ../../../html/wordpress/wp-content/themes/reactor-serveis-educatius ./nodes/wp-content/themes/reactor-serveis-educatius
ln -s ../../../html/wordpress/wp-content/themes/reactor-projectes ./nodes/wp-content/themes/reactor-projectes
ln -s ../../../html/wordpress/wp-content/themes/reactor ./nodes/wp-content/themes/reactor
ln -s ../../html/wordpress/wp-content/languages ./nodes/wp-content/languages
ln -s ../../html/wordpress/wp-includes/xtec ./nodes/wp-includes/xtec

echo "Done!"
