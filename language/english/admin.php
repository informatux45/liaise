<?php
define('_AM_LIAISE_MODULEADMIN_MISSING', 'The ModuleAdmin class is not installed, install it on your xoops.<br>/Frameworks/moduleclasses/moduleadmin/');
defined('_AM_DBUPDATED') or define('_AM_DBUPDATED', 'Database updated!');
defined('_AM_DBERROR') or define('_AM_DBERROR', 'Error database update!');

define('_AM_SAVE', 'Save');
define('_AM_COPIED', '%s copied');
define('_AM_ELE_CREATE', 'Create form element');
define('_AM_ELE_EDIT', 'Edit form elements: %s');
define('_AM_ELE_VIEW', 'View');

define('_AM_ELE_CAPTION', 'Title');
define('_AM_ELE_DEFAULT', 'Default value');
define('_AM_ELE_DETAIL', 'Detail');
define('_AM_ELE_REQ', 'Required');
define('_AM_ELE_ORDER', 'Sort');
define('_AM_ELE_DISPLAY', 'Show');

define('_AM_ELE_TEXT', 'Textbox');
define('_AM_ELE_TEXT_DESC', '{UNAME} displays the username<br>{EMAIL} displays the email address');
define('_AM_ELE_TAREA', 'Textarea');
define('_AM_ELE_SELECT', 'Selection');
define('_AM_ELE_CHECK', 'Check boxes');
define('_AM_ELE_RADIO', 'Radio button');
define('_AM_ELE_YN', 'Single radio button yes/no');
define('_AM_ELE_SEPARATOR', 'Break');

define('_AM_ELE_SIZE', 'Size');
define('_AM_ELE_MAX_LENGTH', 'Max length');
define('_AM_ELE_ROWS', 'Rows');
define('_AM_ELE_COLS', 'Columns');
define('_AM_ELE_OPT', 'Options');
define('_AM_ELE_OPT_DESC', 'Check boxes to select the default values');
define('_AM_ELE_OPT_DESC1', '<br>Only the first is used to check if the multiple selection is not allowed');
define('_AM_ELE_OPT_DESC2', 'Select the default values by checking the boxes');
define('_AM_ELE_ADD_OPT', 'Add %s options');
define('_AM_ELE_ADD_OPT_SUBMIT', 'Add');
define('_AM_ELE_SELECTED', 'Selected');
define('_AM_ELE_CHECKED', 'Checked');
define('_AM_ELE_MULTIPLE', 'Allow multiple selections');

define('_AM_ELE_CONFIRM_DELETE', 'Are you sure you want to delete this form element?');

######### version 1.1 #########
define('_AM_ELE_OTHER', 'To add OTHER, {OTHER | 30} knowing that 30 is the number of generated character in the text box.');

######### version 1.2 additions #########
define('_AM_FORM_LISTING', 'Forms list');
define('_AM_FORM_ORDER', 'Display order');
define('_AM_FORM_ORDER_DESC', '0 = Hide this form');
define('_AM_FORM_TITLE', 'Form title');
define('_AM_FORM_PERM', 'Allowed groups to use this form');
define('_AM_FORM_SENDTO', 'Send to :');
define('_AM_FORM_SENDTO_ADMIN', 'Site Administrator Email');
define('_AM_FORM_SEND_METHOD', 'Sending profile');
define('_AM_FORM_SEND_METHOD_DESC', 'Information can be sent by private message when the form is mailed to the  ' . _AM_FORM_SENDTO_ADMIN . ' or sent by anonymous users');
define('_AM_FORM_SEND_METHOD_MAIL', 'Email');
define('_AM_FORM_SEND_METHOD_PM', 'Private message');
define('_AM_FORM_DELIMETER', 'Want a box or button');
define('_AM_FORM_DELIMETER_SPACE', 'Empty space');
define('_AM_FORM_DELIMETER_BR', 'skip a line');
define('_AM_FORM_SUBMIT_TEXT', 'Text to submit button');
define('_AM_FORM_DESC', 'Description form');
define('_AM_FORM_DESC_DESC', 'Text to be displayed on the main page if more than one form is created');
define('_AM_FORM_INTRO', 'Description form');
define('_AM_FORM_INTRO_DESC', 'Text to be displayed in the form');
define('_AM_FORM_WHERETO', 'URL after sending form');
define('_AM_FORM_WHERETO_DESC', 'Leave blank for homepage {SITE_URL} which give ' . XOOPS_URL);

define('_AM_FORM_ACTION_EDITFORM', 'Edit form');
define('_AM_FORM_ACTION_EDITELEMENT', 'Edit form elements');
define('_AM_FORM_ACTION_CLONE', 'Clone form');
define('_AM_FORM_ACTION_ARCHIVE', 'View messages');

define('_AM_FORM_NEW', 'Create a new form');
define('_AM_FORM_EDIT', 'Edit form: %s');
define('_AM_FORM_CONFIRM_DELETE', 'Are you sure you want to delete this form and all form elements?');

define('_AM_ID', 'ID');
define('_AM_ACTION', 'Action');
define('_AM_RESET_ORDER', 'Order update');
define('_AM_SAVE_THEN_ELEMENTS', 'Save then change the elements');
define('_AM_SAVE_THEN_FORM', 'Save then change the form settings');
define('_AM_NOTHING_SELECTED', 'No selection.');
define('_AM_GO_CREATE_FORM', 'You must create a form.');

define('_AM_ELEMENTS_OF_FORM', 'Form Element of %s');
define('_AM_ELE_APPLY_TO_FORM', 'Apply to form');
define('_AM_ELE_HTML', 'text / HTML');

######### version 1.23 additions #########
// define('_AM_XOOPS_VERSION_WRONG', 'Votre version de XOOPS ne r&#233;pond pas aux exigences du syst&#232;me. Liaise ne fonctionnera pas correctement.');
define('_AM_XOOPS_VERSION_WRONG', '');
define('_AM_ELE_UPLOADFILE', 'Donwloaded File');
define('_AM_ELE_UPLOADIMG', 'Downloaded Image');
define('_AM_ELE_UPLOADIMG_MAXWIDTH', 'Max width (pixels)');
define('_AM_ELE_UPLOADIMG_MAXHEIGHT', 'Max height (pixels)');
define('_AM_ELE_UPLOAD_MAXSIZE', 'Max file size (bytes)');
define('_AM_ELE_UPLOAD_MAXSIZE_DESC', '1k = 1024 bytes');
define('_AM_ELE_UPLOAD_DESC_SIZE_NOLIMIT', '0 = no limit');
define('_AM_ELE_UPLOAD_ALLOWED_EXT', 'Extensions allowed');
define('_AM_ELE_UPLOAD_ALLOWED_EXT_DESC', "Separate file name extensions by | : example => jpg|jpeg|gif|png|tif|tiff'");
define('_AM_ELE_UPLOAD_ALLOWED_MIME', 'MIME types allowed');
define('_AM_ELE_UPLOAD_ALLOWED_MIME_DESC', "Separate MIME types by |  example : 'image/jpeg|image/pjpeg|image/png|image/x-png|image/gif|image/tiff'");
define('_AM_ELE_UPLOAD_DESC_NOLIMIT', 'Leave blank for no limit (not recommended for security reasons)');
define('_AM_ELE_UPLOAD_SAVEAS', 'Save the downloaded file');
define('_AM_ELE_UPLOAD_SAVEAS_MAIL', 'Send by email');
define('_AM_ELE_UPLOAD_SAVEAS_FILE', 'Direct download');

######### version 2.00 #########
define('_AM_XLIAISE_INDEX_NOFORM', 'No form created');
define('_AM_XLIAISE_INDEX_CREATED_FORM', "Created Form: <span style='color: green; font-weight: bold;'>%s</span>");
define('_AM_XLIAISE_INDEX_CREATED_FORMS', "Created Forms: <span style='color: green; font-weight: bold;'>%s</span>");
define('_AM_XLIAISE_INDEX_ACTIVATED_FORM', "Activated Form: <span style='color: green; font-weight: bold;'>%s</span>");
define('_AM_XLIAISE_INDEX_ACTIVATED_FORMS', "Activated Forms: <span style='color: green; font-weight: bold;'>%s</span>");
define('_AM_XLIAISE_INDEX_OFFLINE_FORM', "Offline Form: <span style='color: red; font-weight: bold;'>%s</span>");
define('_AM_XLIAISE_INDEX_OFFLINE_FORMS', "Offline Forms: <span style='color: red; font-weight: bold;'>%s</span>");


define('_AM_XLIAISE_ARCHIVE_ALL_POSTED_MSG', 'All Posted Messages on forms');
define('_AM_XLIAISE_ARCHIVE_ALL_DATE', 'Date');
define('_AM_XLIAISE_ARCHIVE_ALL_FORM', 'Formu');
define('_AM_XLIAISE_ARCHIVE_ALL_MESSAGE', 'Message');
define('_AM_XLIAISE_ARCHIVE_ALL_NO_MSG', 'No message for forms');

define('_AM_XLIAISE_ARCHIVE_VIEW_DATE', 'Date');
define('_AM_XLIAISE_ARCHIVE_VIEW_FORM', 'Form');
define('_AM_XLIAISE_ARCHIVE_VIEW_MESSAGE', 'Message');

define('_AM_XLIAISE_ARCHIVE_DELETE_CONFIRM', 'Are you sure you want to delete this message?');

define('_AM_XLIAISE_NO_MESSAGES', 'No messages for the form');

/**
 * @translation     AFUX (Association Francophone des Utilisateurs de Xoops)
 * @specification   _LANGCODE: fr
 * @specification   _CHARSET: UTF-8
 *
 * @translator      Tatane from frxoops.org
 *
 **/
