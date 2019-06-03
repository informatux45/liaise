<?php
define('_AM_LIAISE_MODULEADMIN_MISSING', "La classe ModuleAdmin n'est pas présente, installez là sur votre xoops.<br />/Frameworks/moduleclasses/moduleadmin/");
defined('_AM_DBUPDATED') or define('_AM_DBUPDATED', 'Base mise &#224; jour avec succ&#232;s!');
defined('_AM_DBERROR') or define('_AM_DBERROR', 'Erreur lors de la mise &#224; jour');

// $Id: admin.php 26 2005-09-04 09:52:40Z tuff $
define('_AM_SAVE', 'Enregistrer');
define('_AM_COPIED', '%s copi&#233;');
define('_AM_ELE_CREATE', 'Cr&#233;er un &#233;l&#233;ment de formulaire');
define('_AM_ELE_EDIT', 'Editer les &#233;l&#233;ments du formulaire: %s');
define('_AM_ELE_VIEW', 'Visualiser');

define('_AM_ELE_CAPTION', 'Titre');
define('_AM_ELE_DEFAULT', 'Valeur par d&#233;faut');
define('_AM_ELE_DETAIL', 'Detail');
define('_AM_ELE_REQ', 'Requis');
define('_AM_ELE_ORDER', 'Poids');
define('_AM_ELE_DISPLAY', 'Afficher');

define('_AM_ELE_TEXT', 'Zone de texte');
define('_AM_ELE_TEXT_DESC', '{UNAME} permet d&#39;afficher le nom d&#39;utilisateur<br />{EMAIL} permet d&#39;afficher l&#39;adresse email');
define('_AM_ELE_TAREA', 'Zone de textarea');
define('_AM_ELE_SELECT', 'Selection');
define('_AM_ELE_CHECK', 'Cochez les cases');
define('_AM_ELE_RADIO', 'Bouton radio');
define('_AM_ELE_YN', 'Simple bouton radio oui/non');
define('_AM_ELE_SEPARATOR', 'S&#233;parateur');

define('_AM_ELE_SIZE', 'Taille');
define('_AM_ELE_MAX_LENGTH', 'Longueur maximale');
define('_AM_ELE_ROWS', 'Rang&#233;s');
define('_AM_ELE_COLS', 'Colonnes');
define('_AM_ELE_OPT', 'Options');
define('_AM_ELE_OPT_DESC', 'Cases &#224; cocher pour s&#233;lectionner les valeurs par d&#233;faut');
define('_AM_ELE_OPT_DESC1', '<br />Seul le premier est utilis&#233; v&#233;rifi&#233; si la s&#233;lection multiple n&#39;est pas autoris&#233;');
define('_AM_ELE_OPT_DESC2', 'Selectionnez les valeurs par defaut en cochant les cases');
define('_AM_ELE_ADD_OPT', 'Ajouter %s options');
define('_AM_ELE_ADD_OPT_SUBMIT', 'Ajouter');
define('_AM_ELE_SELECTED', 'Selectionn&#233;');
define('_AM_ELE_CHECKED', 'V&#233;rifi&#233;');
define('_AM_ELE_MULTIPLE', 'Autoriser les s&#233;lections multiples');

define('_AM_ELE_CONFIRM_DELETE', 'Etes-vous s&#251;r de vouloir supprimer cet &#233;l&#233;ment de formulaire ?');

######### version 1.1 #########
define('_AM_ELE_OTHER', 'Pour mettre Autre, ajoutez {OTHER|30} sachant que 30 correspond au nombre de caract&#233;re g&#233;n&#233;r&#233; dans la boite de texte.');

######### version 1.2 additions #########
define('_AM_FORM_LISTING', 'Liste des formulaires');
define('_AM_FORM_ORDER', 'Ordre d&#39;affichage');
define('_AM_FORM_ORDER_DESC', '0 = Cacher ce formulaire');
define('_AM_FORM_TITLE', 'Titre du formulaire');
define('_AM_FORM_PERM', 'Groupes autoris&#233;s &#224; utiliser ce formulaire');
define('_AM_FORM_SENDTO', 'Envoyer &#224; :');
define('_AM_FORM_SENDTO_ADMIN', 'Email de l&#39;administrateur du site');
define('_AM_FORM_SEND_METHOD', 'Mode d&#39;envoi');
define('_AM_FORM_SEND_METHOD_DESC', 'L&#39;information ne peut &#234;tre envoy&#233; par message priv&#233; lorsque le formulaire est envoy&#233; par courrier &#224; l&#39; ' . _AM_FORM_SENDTO_ADMIN . ' ou envoy&#233; par des utilisateurs anonymes');
define('_AM_FORM_SEND_METHOD_MAIL', 'Email');
define('_AM_FORM_SEND_METHOD_PM', 'Message priv&#233;');
define('_AM_FORM_DELIMETER', 'Delimiter par une case ou un bouton');
define('_AM_FORM_DELIMETER_SPACE', 'Espace vide');
define('_AM_FORM_DELIMETER_BR', 'sauter une ligne');
define('_AM_FORM_SUBMIT_TEXT', 'Texte du bouton de soumission');
define('_AM_FORM_DESC', 'Formulaire de d&#233;scription');
define('_AM_FORM_DESC_DESC', 'Texte qui sera affich&#233; dans la page principale si plus d&#39;un formulaire est mis en ligne');
define('_AM_FORM_INTRO', 'Formulaire de d&#233;scription');
define('_AM_FORM_INTRO_DESC', 'Texte qui sera affich&#233; dans la page de formulaire lui-m&#234;me');
define('_AM_FORM_WHERETO', 'URL pour aller apr&#232;s l&#39;envoi du formulaire');
define('_AM_FORM_WHERETO_DESC', 'Laissez en blanc pour la page d&#39;accueil de ce site; {SITE_URL} ce qui donnera ' . XOOPS_URL);

define('_AM_FORM_ACTION_EDITFORM', 'Editer le formulaire');
define('_AM_FORM_ACTION_EDITELEMENT', 'Editer les &#233;l&#233;ments du formulaire');
define('_AM_FORM_ACTION_CLONE', 'Cloner le formulaire');
define('_AM_FORM_ACTION_ARCHIVE', 'Consulter les messages');

define('_AM_FORM_NEW', 'Cr&#233;&#233;r un nouveau formulaire');
define('_AM_FORM_EDIT', 'Editer le formulaire : %s');
define('_AM_FORM_CONFIRM_DELETE', 'Etes-vous s&#251;r de vouloir supprimer ce formulaire et tous ses &#233;l&#233;ments de formulaire ?');

define('_AM_ID', 'ID');
define('_AM_ACTION', 'Action');
define('_AM_RESET_ORDER', 'Ordre de mise &#224; jour');
define('_AM_SAVE_THEN_ELEMENTS', 'Sauvegarder puis modifier les &#233;l&#233;ments');
define('_AM_SAVE_THEN_FORM', 'Enregistrer puis sur Modifier les param&#232;tres de formulaire');
define('_AM_NOTHING_SELECTED', 'Aucune s&#233;lection.');
define('_AM_GO_CREATE_FORM', 'Vous devez cr&#233;er un premier formulaire.');

define('_AM_ELEMENTS_OF_FORM', 'El&#233;ment de formulaire de %s');
define('_AM_ELE_APPLY_TO_FORM', 'Appliquer au formulaire');
define('_AM_ELE_HTML', 'text / HTML');

######### version 1.23 additions #########
// define("_AM_XOOPS_VERSION_WRONG", "Votre version de XOOPS ne r&#233;pond pas aux exigences du syst&#232;me. Liaise ne fonctionnera pas correctement.");
define('_AM_XOOPS_VERSION_WRONG', '');
define('_AM_ELE_UPLOADFILE', 'Fichier t&#233;l&#233;charg&#233;');
define('_AM_ELE_UPLOADIMG', 'Image t&#233;l&#233;charg&#233;');
define('_AM_ELE_UPLOADIMG_MAXWIDTH', 'Largeur maximale (pixels)');
define('_AM_ELE_UPLOADIMG_MAXHEIGHT', 'Hauteur maximale (pixels)');
define('_AM_ELE_UPLOAD_MAXSIZE', 'Taille maximale des fichiers (bytes)');
define('_AM_ELE_UPLOAD_MAXSIZE_DESC', '1k = 1024 bytes');
define('_AM_ELE_UPLOAD_DESC_SIZE_NOLIMIT', '0 = pas de limite');
define('_AM_ELE_UPLOAD_ALLOWED_EXT', 'Extensions autoris&#233;s');
define('_AM_ELE_UPLOAD_ALLOWED_EXT_DESC', "S&#233;parez les extensions de nom de fichier par un | : exemple => jpg|jpeg|gif|png|tif|tiff'");
define('_AM_ELE_UPLOAD_ALLOWED_MIME', 'types MIME autoris&#233;s');
define('_AM_ELE_UPLOAD_ALLOWED_MIME_DESC', "S&#233;par&#233; vos types MIME par un |  exemple : 'image/jpeg|image/pjpeg|image/png|image/x-png|image/gif|image/tiff'");
define('_AM_ELE_UPLOAD_DESC_NOLIMIT', 'Laissez en blanc pour pas de limite (non recommand&#233; pour des raisons de s&#233;curit&#233;)');
define('_AM_ELE_UPLOAD_SAVEAS', 'Enregistrer le fichier t&#233;l&#233;charg&#233;');
define('_AM_ELE_UPLOAD_SAVEAS_MAIL', 'Envoyer par mail');
define('_AM_ELE_UPLOAD_SAVEAS_FILE', 't&#233;l&#233;charger directement');

######### version 2.00 #########
define('_AM_XLIAISE_INDEX_NOFORM', 'Aucun formulaire cr&#233;&#233;');
define('_AM_XLIAISE_INDEX_CREATED_FORM', "Formulaire cr&#233;&#233; : <span style='color: green; font-weight: bold'>%s</span>");
define('_AM_XLIAISE_INDEX_CREATED_FORMS', "Formulaires cr&#233;&#233;s : <span style='color: green; font-weight: bold'>%s</span>");
define('_AM_XLIAISE_INDEX_ACTIVATED_FORM', "Formulaire activ&#233; : <span style='color: green; font-weight: bold'>%s</span>");
define('_AM_XLIAISE_INDEX_ACTIVATED_FORMS', "Formulaires activ&#233;s : <span style='color: green; font-weight: bold'>%s</span>");
define('_AM_XLIAISE_INDEX_OFFLINE_FORM', "Formulaire d&#233;sactiv&#233; : <span style='color: red; font-weight: bold'>%s</span>");
define('_AM_XLIAISE_INDEX_OFFLINE_FORMS', "Formulaires d&#233;sactiv&#233;s : <span style='color: red; font-weight: bold'>%s</span>");

define('_AM_XLIAISE_ARCHIVE_ALL_POSTED_MSG', 'Tous les messages post&#233;s sur les formulaires');
define('_AM_XLIAISE_ARCHIVE_ALL_DATE', 'Date');
define('_AM_XLIAISE_ARCHIVE_ALL_FORM', 'Formulaire');
define('_AM_XLIAISE_ARCHIVE_ALL_MESSAGE', 'Message');
define('_AM_XLIAISE_ARCHIVE_ALL_NO_MSG', 'Pas de message pour les formulaires');

define('_AM_XLIAISE_ARCHIVE_VIEW_DATE', 'Date');
define('_AM_XLIAISE_ARCHIVE_VIEW_FORM', 'Formulaire');
define('_AM_XLIAISE_ARCHIVE_VIEW_MESSAGE', 'Message');

define('_AM_XLIAISE_ARCHIVE_DELETE_CONFIRM', 'Etes vous s&#251;r de vouloir supprimer ce message ?');

/**
 * @translation     AFUX (Association Francophone des Utilisateurs de Xoops)
 * @specification   _LANGCODE: fr
 * @specification   _CHARSET: UTF-8
 *
 * @translator   Tatane from frxoops.org
 *
 * @version         $Id$
 **/
