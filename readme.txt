=================================================
Version 2.01
Author : INFORMATUX / Mamba
URL    : https://dev.informatux.com
=================================================

Support PHP7
Notice [PHP]: Only variable references should be returned by reference
- class/elements.php

Xoops version
- Only for XOOPS 2.5.8 and up
- Updated infos

=================================================
Version 2.00
Author : INFORMATUX
URL    : https://dev.informatux.com
=================================================

[ADMIN] Compatible avec le Framework "Module Classes" 1.1
[ADMIN] Ajout d'un controle de l'affichage du Breadcrumb dans les préférences (Option OUI/NON)
[ADMIN] Ajout d'un élément de formulaire (BREAK ou SEPARATEUR) qui permet de fractionner les formulaires avec thématiques de questions
[ADMIN] Ajout d'une section "Tous les messages"
[ADMIN] Tous les messages saisis dans les formulaires sont stockés en base de données
[ADMIN] Visualisation des messages reçus depuis l'administration
[ADMIN] Ajout d'une feuille de style Liaise (css/xliaise_style.css)
[ADMIN] Refonte de l'icon LIAISE
[ADMIN] Nombreuses corrections bugs (ex: mauvaises soumissions de certains formulaires)
[ADMIN] Titre des formulaires dans les tableaux
[ADMIN] Modification de l'architecture des dossiers suivant le nouveau modele XOOPS
[ADMIN] Passage en version 2.00, c'est plus sympa comme chiffre ;-)
[CLIENT] Ajout du nouvel élément (BREAK ou SEPARATEUR)
Version 1.27

=================================================
Version: 1.27
Date:   2006-12-24
Author: Kenichi OHWADA
URL:    http://linux2.ohwada.net/
Email:  webmaster@ohwada.jp
=================================================

This is hack version for Liaise 1.26

(1) support GIJOE's Ticket Class for anti-spam
reload form, if error ocure

- index.php
- include/gtickets.php (added)
- include/form_render.php.php
- class/elementrenderer.php
- tepmlates/liaise_form.php

(2) support GIJOE's Ticket Class in admin page too
- admin/admin_header.php
- admin/elements.php
- admin/editelement.php
- admin/index.php

(3) support Captcha for anti-spam
adopted captcha_x for class lib
  http://www.phpclasses.org/browse/package/3023.html
adopted Standard 35 TrueType Fonts for fonts lib
  http://www.rops.org/download/std35ttf.zip
admin can choice use or not use in admin page

- server.php (added)
- index.php
- xoops_version.php
- class/captcha_x/ (added)
- include/form_render.php.php
- language/english/main.php
- language/english/modinfo.php
- language/japanese/main.php
- language/japanese/modinfo.php

(4) [Japanese] bug fix: wrong charset
changed charset EUC-JP to ISO-2022-JP
- xoops_version.php
