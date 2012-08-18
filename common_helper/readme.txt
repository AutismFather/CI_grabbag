This is my common helper that I include with each CI install.

This allows me to do some things very quickly, such as calling CI's config and language information quickly.


Currently, the functions available are:

pr($x, $bool)
This prints a string or array unless $bool is set to true, in which case it returns the value instead.

config($x)
This is a shortcut for $this->config->item(). It pulls a value from config.php

lang($x, $string)
This is a shortcut for $this->lang->line.
It is also a handy way to run sprintf(string) or vsprintf(array) on the language file to replace values in the language strings for dynamic processing.

js($js)
$js can be a string or an array of strings.
Quick way to add <script src> tags.
Intelligently detects absolute and relative paths.

css($css)
$css can be a string or an array of strings.
Quick way to add <link> tags.
Intelligently detects absolute and relative paths.

site_name()
Simply returns the site name as set in config.php

element($element)
This allows me to put HTML elements that can be used in multiplate places into an 'elements' subfolder in the view/templates folder and then call them with this within a view.
ie: <ul><?php element('li_users'); ?></ul> - This would call /views/elements/li_users.php