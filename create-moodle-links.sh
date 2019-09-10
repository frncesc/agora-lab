#!/bin/bash

#
# Create symbolic links into /moodle from the Àgora source
#

echo "Creating symbolic links in /moodle"

ln -s ../../html/moodle2/theme/xtec2 ./moodle/theme/xtec2
ln -s ../../../html/moodle2/course/format/vv ./moodle/course/format/vv
ln -s ../../../html/moodle2/course/format/simple ./moodle/course/format/simple
ln -s ../../html/moodle2/mod/journal ./moodle/mod/journal
ln -s ../../html/moodle2/mod/qv ./moodle/mod/qv
ln -s ../../html/moodle2/mod/choicegroup ./moodle/mod/choicegroup
ln -s ../../html/moodle2/mod/jclic ./moodle/mod/jclic
ln -s ../../html/moodle2/mod/geogebra ./moodle/mod/geogebra
ln -s ../../html/moodle2/mod/hvp ./moodle/mod/hvp
ln -s ../../html/moodle2/mod/hotpot ./moodle/mod/hotpot
ln -s ../../html/moodle2/mod/questionnaire ./moodle/mod/questionnaire
ln -s ../../html/moodle2/mod/rcontent ./moodle/mod/rcontent
ln -s ../html/moodle2/langpacks ./moodle/langpacks
ln -s ../../../html/moodle2/user/tests/group_non_members_selector_test.php ./moodle/user/tests/group_non_members_selector_test.php
ln -s ../../html/moodle2/filter/wiris ./moodle/filter/wiris
ln -s ../../html/moodle2/local/clickedu ./moodle/local/clickedu
ln -s ../../html/moodle2/local/mobile ./moodle/local/mobile
ln -s ../../html/moodle2/local/bigdata ./moodle/local/bigdata
ln -s ../../html/moodle2/local/agora ./moodle/local/agora
ln -s ../../html/moodle2/local/alexandriaimporter ./moodle/local/alexandriaimporter
ln -s ../../html/moodle2/local/rcommon ./moodle/local/rcommon
ln -s ../../html/moodle2/local/defaults.php ./moodle/local/defaults.php
ln -s ../../html/moodle2/local/wsvicensvives ./moodle/local/wsvicensvives
ln -s ../../html/moodle2/local/oauth ./moodle/local/oauth
ln -s ../../html/moodle2/report/coursequotas ./moodle/report/coursequotas
ln -s ../../html/moodle2/blocks/licenses_vicensvives ./moodle/blocks/licenses_vicensvives
ln -s ../../html/moodle2/blocks/my_books ./moodle/blocks/my_books
ln -s ../../html/moodle2/blocks/completion_progress ./moodle/blocks/completion_progress
ln -s ../../html/moodle2/blocks/courses_vicensvives ./moodle/blocks/courses_vicensvives
ln -s ../../html/moodle2/blocks/rgrade ./moodle/blocks/rgrade
ln -s ../../../../../html/moodle2/lib/editor/atto/plugins/wiris ./moodle/lib/editor/atto/plugins/wiris
ln -s ../../../../../html/moodle2/lib/editor/atto/plugins/fontsize ./moodle/lib/editor/atto/plugins/fontsize
ln -s ../../../../../html/moodle2/lib/editor/atto/plugins/fontfamily ./moodle/lib/editor/atto/plugins/fontfamily
ln -s ../../../html/moodle2/question/type/essaywiris ./moodle/question/type/essaywiris
ln -s ../../../html/moodle2/question/type/matchwiris ./moodle/question/type/matchwiris
ln -s ../../../html/moodle2/question/type/multichoicewiris ./moodle/question/type/multichoicewiris
ln -s ../../../html/moodle2/question/type/truefalsewiris ./moodle/question/type/truefalsewiris
ln -s ../../../html/moodle2/question/type/multianswerwiris ./moodle/question/type/multianswerwiris
ln -s ../../../html/moodle2/question/type/ordering ./moodle/question/type/ordering
ln -s ../../../html/moodle2/question/type/shortanswerwiris ./moodle/question/type/shortanswerwiris
ln -s ../../../html/moodle2/question/type/wq ./moodle/question/type/wq
ln -s ../../../html/moodle2/question/format/hotpot ./moodle/question/format/hotpot

echo "Done!"
