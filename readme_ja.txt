=================================================
Version: 1.27
Date:   2006-12-24
Author: Kenichi OHWADA
URL:    http://linux.ohwada.jp/
Email:  webmaster@ohwada.jp
=================================================

Liaise 1.26 �Υϥå��ǤǤ���

(1) ���ѥ��к��Ȥ��� GIJOE's Ticket Class ��Ƴ������
�ե�������Ƥǥ��顼�ˤʤ�ȡ��ե�������̤��ɽ������

- index.php
- include/gtickets.php (�ɲ�)
- include/form_render.php.php
- class/elementrenderer.php
- tepmlates/liaise_form.php

(2) �����Բ��̤ˤ� GIJOE's Ticket Class ��Ƴ������
- admin/admin_header.php
- admin/elements.php
- admin/editelement.php
- admin/index.php

(3) ���ѥ��к��Ȥ��� ����ǧ�ڤ�Ƴ������
����ǧ�ڤΥ��饹�ˤ� captcha_x ����Ѥ���
  http://www.phpclasses.org/browse/package/3023.html
�ե���Ȥˤ� Standard 35 TrueType Fonts ����Ѥ���
  http://www.rops.org/download/std35ttf.zip
�����Բ��̤�����/̤���Ѥ�����Ǥ��ޤ�

- server.php (�ɲ�)
- index.php
- xoops_version.php
- class/captcha_x/ (�ɲ�)
- include/form_render.php.php
- language/english/main.php
- language/english/modinfo.php
- language/japanese/main.php
- language/japanese/modinfo.php

(4) [���ܸ�] �᡼�뤬ʸ�����������Զ�����������
�֥᡼���������Υ��󥳡�����ˡ�פν���ͤ� EUC-JP ���� ISO-2022-JP ���ѹ�������
- xoops_version.php

(5) PHP5�б�
Notice [PHP]: Only variable references should be returned by reference
- class/elements.php

