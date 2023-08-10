<?php
require_once $_SERVER['DOCUMENT_ROOT']."/shared/load.all.php";

use \dmt\DMTReport;
// use \koolreport\processes\Sort;
// use \koolreport\processes\Limit;

class over_prov_tenants extends DMTReport
{
    use \koolreport\inputs\Bindable;
    use \koolreport\inputs\GETBinding;

    protected function defaultParamValues()
    {
        $cancelled_from   = (new DateTime("1970-01-01 00:00:00"))->modify('+0 day');
        $cancelled_to     = (new DateTime("9999-12-31 23:59:59"))->modify('+0 day');
        $termination_from = (new DateTime("1970-01-01 00:00:00"))->modify('+0 day');
        $termination_to   = (new DateTime("9999-12-31 23:59:59"))->modify('+0 day');

        $pagelength = 10;
        $status = "all";

        return array(
            "cancelled"=>array(
                $cancelled_from->format('Y-m-d'),
                $cancelled_to->format('Y-m-d')
            ),
            "termination"=>array(
                $termination_from->format('Y-m-d'),
                $termination_to->format('Y-m-d')
            ),
            "pagelength"=>$pagelength,
            "status" => $status
        );
    }

    protected function bindParamsToInputs()
    {
        return array(
            "cancelled"=>"cancelled",
            "termination"=>"termination",
            "pagelength"=>"pagelength",
            "status"=>"status"
        );
    }

}
