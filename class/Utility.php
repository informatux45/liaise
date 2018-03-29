<?php namespace XoopsModules\Liaise;

use Xmf\Request;
use XoopsModules\Liaise;
use XoopsModules\Liaise\Common;

/**
 * Class Utility
 */
class Utility
{
    use Common\VersionChecks; //checkVerXoops, checkVerPhp Traits

    use Common\ServerStats; // getServerStats Trait

    use Common\FilesManagement; // Files Management Trait

    //--------------- Custom module methods -----------------------------
}
