REM You must have PHP 5 setup on the machine you want to run this script
REM You can download it from http://www.php.net/downloads.php

REM Change this path to the path on your system
SET PHPCGI="C:\Program Files\CodeGear\Delphi for PHP\1.0\php\php-cgi.exe" -c php.ini


%PHPCGI% test_label.inc.php script=/test_label.inc.php
%PHPCGI% test_customlabel.inc.php script=/test_customlabel.inc.php

%PHPCGI% test_groupbox.inc.php script=/test_groupbox.inc.php
%PHPCGI% test_imagefade.inc.php script=/test_imagefade.inc.php
%PHPCGI% test_mapshape.inc.php script=/test_mapshape.inc.php
%PHPCGI% test_panel.inc.php script=/test_panel.inc.php
%PHPCGI% test_speedbutton.inc.php script=/test_speedbutton.inc.php
%PHPCGI% test_button.inc.php script=/test_button.inc.php
%PHPCGI% test_bitbtn.inc.php script=/test_bitbtn.inc.php
%PHPCGI% test_buttoncontrol.inc.php script=/test_buttoncontrol.inc.php

%PHPCGI% test_scrollbar.inc.php script=/test_scrollbar.inc.php
%PHPCGI% test_action.inc.php script=/test_action.inc.php
%PHPCGI% test_qwidget.inc.php script=/test_qwidget.inc.php
%PHPCGI% test_radiobutton.inc.php script=/test_radiobutton.inc.php

%PHPCGI% test_hiddenfield.inc.php script=/test_hiddenfield.inc.php

%PHPCGI% test_customedit.inc.php script=/test_customedit.inc.php
%PHPCGI% test_edit.inc.php script=/test_edit.inc.php

%PHPCGI% test_memo.inc.php script=/test_memo.inc.php
%PHPCGI% test_custommemo.inc.php script=/test_custommemo.inc.php
%PHPCGI% test_checkbox.inc.php script=/test_checkbox.inc.php
%PHPCGI% test_customcheckbox.inc.php script=/test_customcheckbox.inc.php
%PHPCGI% test_component.inc.php script=/test_component.inc.php             
%PHPCGI% test_control.inc.php script=/test_control.inc.php
%PHPCGI% test_customcontrol.inc.php script=/test_customcontrol.inc.php
%PHPCGI% test_custompanel.inc.php script=/test_custompanel.inc.php

%PHPCGI% test_customgrid.inc.php script=/test_customgrid.inc.php

%PHPCGI% test_focuscontrol.inc.php script=/test_focuscontrol.inc.php
%PHPCGI% test_graphiccontrol.inc.php script=/test_graphiccontrol.inc.php

%PHPCGI% test_object.inc.php script=/test_object.inc.php
%PHPCGI% test_persistent.inc.php script=/test_persistent.inc.php
%PHPCGI% test_system.inc.php script=/test_persistent.inc.php

%PHPCGI% test_input_filter.inc.php script=/test_input_filter.inc.php