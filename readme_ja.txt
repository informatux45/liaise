=================================================
Version: 1.27
Date:   2006-12-24
Author: Kenichi OHWADA
URL:    http://linux.ohwada.jp/
Email:  webmaster@ohwada.jp
=================================================

Liaise 1.26 のハック版です。

(1) スパム対策として GIJOE's Ticket Class を導入した
フォーム投稿でエラーになると、フォーム画面を再表示する

- index.php
- include/gtickets.php (追加)
- include/form_render.php.php
- class/elementrenderer.php
- tepmlates/liaise_form.php

(2) 管理者画面にも GIJOE's Ticket Class を導入した
- admin/admin_header.php
- admin/elements.php
- admin/editelement.php
- admin/index.php

(3) スパム対策として 画像認証を導入した
画像認証のクラスには captcha_x を採用した
  http://www.phpclasses.org/browse/package/3023.html
フォントには Standard 35 TrueType Fonts を採用した
  http://www.rops.org/download/std35ttf.zip
管理者画面より使用/未使用が選択できます

- server.php (追加)
- index.php
- xoops_version.php
- class/captcha_x/ (追加)
- include/form_render.php.php
- language/english/main.php
- language/english/modinfo.php
- language/japanese/main.php
- language/japanese/modinfo.php

(4) [日本語] メールが文字化けする不具合を修正した。
「メール送信時のエンコード方法」の初期値を EUC-JP から ISO-2022-JP に変更した。
- xoops_version.php

(5) PHP5対応
Notice [PHP]: Only variable references should be returned by reference
- class/elements.php

