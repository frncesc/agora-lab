#!/bin/bash

#
# Create symbolic links into /nodes from the Àgora source 
#

echo "Creating symbolic links in /nodes"

ln -s ../../../html/wordpress/wp-content/plugins/buddypress-activity-plus ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/slideshow-jquery-image-gallery ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/blogger-importer ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/buddypress-like ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/table-of-contents-plus ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/xtec-booking ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/wp-recaptcha ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/buddypress ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/socialmedia ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/h5p ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/tabs-responsive ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/bbpress ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/bbpress-enable-tinymce-visual-tab ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/polylang ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/slideshare ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/pods ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/email-subscribers ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/tinymce-advanced ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/wordpress-telegram ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/invite-anyone ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/wordpress-php-info ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/disable-gutenberg ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/wordpress-social-login ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/add-to-any ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/google-analyticator ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/author-category ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/private-bp-pages ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/xtec-stats ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/xtec-ldap-login ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/grup-classe ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/buddypress-docs ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/pending-submission-notifications ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/import-users-from-csv-with-meta ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/widget-visibility-without-jetpack ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/plugins/wordpress-importer ./nodes/wp-content/plugins/
ln -s ../../../html/wordpress/wp-content/themes/reactor-primaria-1 ./nodes/wp-content/themes/
ln -s ../../../html/wordpress/wp-content/themes/reactor-serveis-educatius ./nodes/wp-content/themes/
ln -s ../../../html/wordpress/wp-content/themes/reactor-projectes ./nodes/wp-content/themes/
ln -s ../../../html/wordpress/wp-content/themes/reactor ./nodes/wp-content/themes/
ln -s ../../html/wordpress/wp-content/languages ./nodes/wp-content/
ln -s ../../html/wordpress/wp-includes/xtec ./nodes/wp-includes/

# Not working!
# ln -s ../../../html/wordpress/wp-content/plugins/google-calendar-events ./nodes/wp-content/plugins/
# ln -s ../../../html/wordpress/wp-content/plugins/buddypress-group-email-subscription ./nodes/wp-content/plugins/
# ln -s ../../../html/wordpress/wp-content/plugins/xtec-mail ./nodes/wp-content/plugins/

# Special cases:
ln -s ../../patches/wordpress/wp-content/mu-plugins ./nodes/wp-content/
ln -s ../../patches/wordpress/wp-content/plugins/enllacos-educatius ./nodes/wp-content/plugins/

# Derive uploads to wpdata:

if [ -d "./wpdata" ] 
then
    echo "Directory /wpdata already exists! Please remove it and try again." 
else
    if [ -d "./nodes/wp-content/uploads" ]
    then
        mv ./nodes/wp-content/uploads ./wpdata
        ln -s ../../wpdata ./nodes/wp-content/uploads
    else
        echo "Directory ./nodes/wp-content/uploads not created. Please initialize the WordPres Network and try again"
    fi
fi

echo "Done!"
