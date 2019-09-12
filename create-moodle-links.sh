#!/bin/bash

#
# Create symbolic links into /moodle from the Àgora source
#

echo "Creating symbolic links in /moodle"

# Language packs
ln -s ../html/moodle2/langpacks ./moodle/

# Themes

# Not working with symlink: folder contents must be copied!
# ln -s ../../html/moodle2/theme/xtec2 ./moodle/theme/
cp -a ./html/moodle2/theme/xtec2 ./moodle/theme/

# Course formats
ln -s ../../../html/moodle2/course/format/simple ./moodle/course/format/

# Activity modules
ln -s ../../html/moodle2/mod/journal ./moodle/mod/
ln -s ../../html/moodle2/mod/qv ./moodle/mod/
ln -s ../../html/moodle2/mod/choicegroup ./moodle/mod/
ln -s ../../html/moodle2/mod/jclic ./moodle/mod/
ln -s ../../html/moodle2/mod/geogebra ./moodle/mod/
ln -s ../../html/moodle2/mod/hotpot ./moodle/mod/
ln -s ../../html/moodle2/mod/questionnaire ./moodle/mod/

# Local extensions
ln -s ../../html/moodle2/local/mobile ./moodle/local/
ln -s ../../html/moodle2/local/oauth ./moodle/local/

# Reports

# Blocks

# Not working with symlink: folder contents must be copied!
# ln -s ../../html/moodle2/blocks/completion_progress ./moodle/blocks/
cp -a ./html/moodle2/blocks/completion_progress ./moodle/blocks/

# Atto plugins
ln -s ../../../../../html/moodle2/lib/editor/atto/plugins/fontsize ./moodle/lib/editor/atto/plugins/
ln -s ../../../../../html/moodle2/lib/editor/atto/plugins/fontfamily ./moodle/lib/editor/atto/plugins/

# Question types
ln -s ../../../html/moodle2/question/type/ordering ./moodle/question/type/

# Question formats
ln -s ../../../html/moodle2/question/format/hotpot ./moodle/question/format/

# User tests
ln -s ../../../html/moodle2/user/tests/group_non_members_selector_test.php ./moodle/user/tests/

# H5P

# Not working with symlink: folder contents must be copied!
# ln -s ../../html/moodle2/mod/hvp ./moodle/mod/
cp -a ./html/moodle2/mod/hvp ./moodle/mod/

# Marsupial

# Warning: invalid code in main repo. Use patched version instead!
# ln -s ../../html/moodle2/local/rcommon ./moodle/local/
ln -s ../../patches/moodle/local/rcommon ./moodle/local/

ln -s ../../html/moodle2/mod/rcontent ./moodle/mod/
ln -s ../../html/moodle2/blocks/my_books ./moodle/blocks/
ln -s ../../html/moodle2/blocks/rgrade ./moodle/blocks/

# ClickEdu
ln -s ../../html/moodle2/local/clickedu ./moodle/local/

# Vicens Vives
ln -s ../../html/moodle2/local/wsvicensvives ./moodle/local/
ln -s ../../html/moodle2/blocks/courses_vicensvives ./moodle/blocks/
ln -s ../../html/moodle2/blocks/licenses_vicensvives ./moodle/blocks/
ln -s ../../../html/moodle2/course/format/vv ./moodle/course/format/

# Wiris
ln -s ../../html/moodle2/filter/wiris ./moodle/filter/
ln -s ../../../../../html/moodle2/lib/editor/atto/plugins/wiris ./moodle/lib/editor/atto/plugins/
ln -s ../../../html/moodle2/question/type/essaywiris ./moodle/question/type/
ln -s ../../../html/moodle2/question/type/matchwiris ./moodle/question/type/
ln -s ../../../html/moodle2/question/type/multichoicewiris ./moodle/question/type/
ln -s ../../../html/moodle2/question/type/truefalsewiris ./moodle/question/type/
ln -s ../../../html/moodle2/question/type/multianswerwiris ./moodle/question/type/
ln -s ../../../html/moodle2/question/type/shortanswerwiris ./moodle/question/type/
ln -s ../../../html/moodle2/question/type/wq ./moodle/question/type/

# Agora specific
# ln -s ../../html/moodle2/local/agora ./moodle/local/
# ln -s ../../html/moodle2/report/coursequotas ./moodle/report/
# ln -s ../../html/moodle2/local/bigdata ./moodle/local/
# ln -s ../../html/moodle2/local/defaults.php ./moodle/local/

ln -s ../../html/moodle2/local/alexandriaimporter ./moodle/local/

echo "Done!"
