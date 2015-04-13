# Work-Shop Projects Makefile
# 'Always Use a Trailing Slash...'

CONFIG = wp-config.php
THEME = wp-content/themes/cm/
URL = http://localhost/cm

DB_NAME = creative_mind
DUMP_NAME = $(DB_NAME).sql
DB_STORE = .databases/
DB_UTILITIES = util/


# running 'make' is the same as running make open 
# followed by 'make sass-watch'
all: open sass-watch

# open
# this rule opens 
#
open:
	open $(URL)

# sass-watch
# This rule runs sass' watch command on the core style.scss
# file, writing css to the core style.css file
sass-watch:
	sass --watch $(THEME)assets/css/style.scss:$(THEME)assets/css/style.css

# pull-db
# This rule takes a pulls a current snapshot
# of the project's database, and places it 
# in the databases archive. As of now, it
# rewrites the current snapshot, if one exists.
pull-db:
	$(DB_STORE)$(DB_UTILITIES)pull-db.sh $(DB_NAME) $(DB_STORE)$(DUMP_NAME)

# push-db
# This rule looks for a current database in 
# the project's .databases directory and reads it
# into MAMP's mysql instance, updating the specificed database
# finally, it updates the wp-config file to point
push-db: update-config
	$(DB_STORE)$(DB_UTILITIES)push-db.sh $(DB_NAME) $(DB_STORE)$(DUMP_NAME)
