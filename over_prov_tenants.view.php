<?php

    use \koolreport\datagrid\DataTables;
    use \koolreport\inputs\DateRangePicker;
    use \koolreport\inputs\Select;
    use \koolreport\widgets\google\BarChart;

class OverProvTableButtonExcel
{
    public static function render($business_partner_id)
    {
        return [
            "extend" => 'excelHtml5',
            "customize" => "
                function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
					
					
					// Delete row number 1
                    var rowToDelete = 1; // Row number to delete (1-based index)
                    var sheetData = $('sheetData', sheet);
                    
                    $('row', sheetData).eq(rowToDelete - 1).remove(); // Row index is 0-based
					
					
					
                    var numrows = 4;
                    var clR = $('row', sheet);

                    // Update Row
                    clR.each(function () {
                        var attr = $(this).attr('r');
                        var ind = parseInt(attr);
                        ind = ind + numrows;
                        $(this).attr('r', ind);
                    });

                    // Create row before data
                    $('row c', sheet).each(function () {
                        var attr = $(this).attr('r');
                        var pre = attr.substring(0, 1);
                        var ind = parseInt(attr.substring(1, attr.length));
                        ind = ind + numrows;
                        $(this).attr('r', pre + ind);
                    });
                
                    function Addrow(index, data) {
                        var msg = '<row r=\"' + index + '\">';
                        for (var i = 0; i < data.length; i++) {
                            var key = data[i].key;
                            var value = data[i].value;
                            msg += '<c t=\"inlineStr\" r=\"' + key + index + '\">';
                            msg += '<is>';
                            msg += '<t>' + value + '</t>';
                            msg += '</is>';
                            msg += '</c>';
                        }
                        msg += '</row>';
                        return msg;
                    }
					

                    // Extract data from the first row
                    var rowData = [];
                    $('row:nth-child(4) c t', sheet).each(function () {
                        rowData.push($(this).text());
                    });

                    // Insert transposed data as the first column
                    var r1 = Addrow(2, [{ key: 'A', value: 'BPID' }, { key: 'B', value: '" .  $business_partner_id  . "' }]);
                    
                    // Insert remaining data rows
                    var r2 = Addrow(3, [{ key: 'A', value: 'Customer' }, { key: 'B', value: rowData[rowData.length - 1] }]);
                    var r3 = Addrow(4, [{ key: 'A', value: 'LOB' }, { key: 'B', value: rowData[rowData.length - 4] }]);

                    sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + r3 + sheet.childNodes[0].childNodes[1].innerHTML;


                    $('row[r=\"2\"] c[r^=\"A2\"]', sheet).attr('s', '48');
                    $('row[r=\"3\"] c[r^=\"A3\"]', sheet).attr('s', '48');
                    $('row[r=\"4\"] c[r^=\"A4\"]', sheet).attr('s', '48');
					
					$('row[r=\"6\"] c[r^=\"A6\"]', sheet).attr('s', '48');
                    $('row[r=\"6\"] c[r^=\"B6\"]', sheet).attr('s', '48');
                    $('row[r=\"6\"] c[r^=\"C6\"]', sheet).attr('s', '48');
					$('row[r=\"6\"] c[r^=\"D6\"]', sheet).attr('s', '48');
                    $('row[r=\"6\"] c[r^=\"E6\"]', sheet).attr('s', '48');
                    $('row[r=\"6\"] c[r^=\"F6\"]', sheet).attr('s', '48');
					$('row[r=\"6\"] c[r^=\"G6\"]', sheet).attr('s', '48');
                    $('row[r=\"6\"] c[r^=\"H6\"]', sheet).attr('s', '48');
                    $('row[r=\"6\"] c[r^=\"I6\"]', sheet).attr('s', '48');
					$('row[r=\"6\"] c[r^=\"J6\"]', sheet).attr('s', '48');
					$('row[r=\"6\"] c[r^=\"K6\"]', sheet).attr('s', '48');
					$('row[r=\"6\"] c[r^=\"L6\"]', sheet).attr('s', '48');
					$('row[r=\"6\"] c[r^=\"M6\"]', sheet).attr('s', '48');
					$('row[r=\"6\"] c[r^=\"N6\"]', sheet).attr('s', '48');
					

// Delete columns with indices 14, 15, 16, and 17
                    var colsToDelete = [14, 15, 16, 17]; // Column indices to delete (0-based)
                    var sheetData = $('sheetData', sheet);
                    
                    $('row', sheetData).each(function() {
                        for (var i = colsToDelete.length - 1; i >= 0; i--) {
                            $(this).children('c').eq(colsToDelete[i]).remove(); // Column index is 0-based
                        }
                    });
                    
                    // Update remaining column indices
                    $('row c', sheetData).each(function () {
                        var attr = $(this).attr('r');
                        var row = parseInt(attr.match(/[0-9]+/)[0]);
                        var col = attr.match(/[A-Z]+/)[0];
                        
                        var colIndex = col.charCodeAt(0) - 'A'.charCodeAt(0);
                        for (var i = 0; i < colsToDelete.length; i++) {
                            if (colIndex > colsToDelete[i]) {
                                colIndex--; // Adjust for deleted columns
                            }
                        }
                        col = String.fromCharCode(colIndex + 'A'.charCodeAt(0));
                        
                        $(this).attr('r', col + row);
                    });
// //Delete column ends
					
					
                }
			"
        ];
    }
}





?>

 

<?php
/*
* Go here
*
* https://datatables.net/download/
*
* And click together what you want as table functionalities
*/
?>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.4.3/css/foundation.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/zf/jszip-2.5.0/dt-1.13.1/af-2.5.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/cr-1.6.1/date-1.2.0/r-2.4.0/rg-1.3.0/rr-1.3.1/sc-2.0.7/sb-1.4.0/sp-2.1.0/sl-1.5.0/sr-1.2.0/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/zf/jszip-2.5.0/dt-1.13.1/af-2.5.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/cr-1.6.1/date-1.2.0/r-2.4.0/rg-1.3.0/rr-1.3.1/sc-2.0.7/sb-1.4.0/sp-2.1.0/sl-1.5.0/sr-1.2.0/datatables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.4.3/js/foundation.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/jhyland87/DataTables-Keep-Conditions/118c5e107f1f603b1b91475dc139df6f53917e38/dist/dataTables.keepConditions.min.js"></script>

<style>

  .cssHeader {
    background-color:#272C31;
    color:#FFFFFF;
    font-size:18px;
  }

table.dataTable tr th {
  vertical-align: middle;
}

body {
    padding-top: 6rem;
}

.container {
    max-width: 2140px;
    margin-left: 15px;
}

 

/*
* Freeze the table header
*/

#tenants_table_wrapper table.dataTable thead  {
    position: sticky;
    top: 50px; /* adjust this value according to your preference */
    z-index: 1000;
    background-color: inherit; /* this will match the background color of the table header */
}

 

/*
*  Hide the sorting icons in the table header
*/

table.dataTable thead > tr > th[class*="sorting"]:before,
table.dataTable thead > tr > th[class*="sorting"]:after {
    opacity: 0;
}

 



</style>

 

<div class="report-content">
    <div class="text-center">
        <h1><?php echo $this->vars["title"]; ?></h1>
        <p class="lead"><?php echo $this->vars["description"]; ?></p>
    </div>

 

    <form method="GET">
        <div class="row">
            <div class="col-md-1 offset-md-0"><button class="btn btn-success"><i class="glyphicon glyphicon-refresh"></i> Load</button></div>
            <div class="col-md-0 offset-md-1" style="padding-top: 8px;">Cancelled:</div>
            <div class="col-md-2 offset-md-0">
                <div class="form-group">
                <?php
                DateRangePicker::create(array(
                    "name"=>"cancelled"
                ))
                ?>
                </div>
            </div>
            <div class="col-md-0 offset-md-1" style="padding-top: 8px;">Termination:</div>
            <div class="col-md-2 offset-md-0">
                <div class="form-group">
                <?php
                DateRangePicker::create(array(
                    "name"=>"termination"
                ))
                ?>
                </div>
            </div>
            <div class="col-md-0 offset-md-1" style="padding-top: 8px;">Status:</div>
            <div class="col-md-1 offset-md-0">
                <div class="form-group">
                <?php

                Select::create(array(

                    "name" => "status",

                    "data" => array(

                        "all" => "all",
                        "Open" => "Open",
                        "In Clarification" => "In Clarification",
                        "Awaiting Resolution" => "Awaiting Resolution",
                        "Sales Support" => "Sales Support",
                        "Customer Success" => "Customer Success",
                        "Renewal Scheduled" => "Renewal Scheduled",
                        "Termination Scheduled" => "Termination Scheduled",
                        "Forwarded to Responsible LoB" => "Forwarded to Responsible LoB",
                        # "Resolved" => "Resolved",
                        "In Escalation" => "In Escalation"

                    )
                ))
                ?>
                </div>
            </div>

            <input type="hidden" name="pagelength"/><script>var actCount=0; var actSearch=0; var actSort=0;</script>
        </div>
    </form>

 


	
    <?php
	
	if (isset($_GET['business_partner_id'])){
		$business_partner_id = $_GET['business_partner_id'];
	}
	else{
		$business_partner_id = " ";
	}

	global $databata;
	global $datatest;
	$datatest = $this->src('tc')
    ->query("SELECT DISTINCT op.lob AS 'LOB'
             FROM over_provisioning AS op
             WHERE op.ovr_live > 0
             AND op.business_partner_id = \"1187913\" ");
 //   ->fetchAssoc(); // Fetch the data as an associative array

if (!empty($datatest)) {
 //   echo ($datatest->[LOB]);
} else {
    echo "No data found";
}
    DataTables::create([

        "name"=>"tenants_table",
        "scrollY" => "calc(100vh - 200px)", // Adjust the height according to your preference
        "scrollCollapse" => true,

        "onReady" => "function() {
            // Code executed when the DataTable is ready
                tenants_table.on('length.dt', function(e, settings, len) {
                    document.querySelector('input[name=\"pagelength\"').value = len;
                    len = document.querySelector('input[name=\"pagelength\"').value;
                    // document.querySelector('form').submit();// This would do a page refresh
                });

                tenants_table.on('xhr.dt', function(e, settings, json, xhr) {
                    if(actSearch == 0) {
                        actSearch = 1;

                        /* Check if we have a hash, then parse that */
                        var queryString  = {};
                        var query        = window.location.hash.substring( 1 );
                        var queryparts   = query.split(\"=\");
                        var search       = queryparts[1];
                        var search_found = 0;

                        search = queryparts[1];

                        if (typeof search !== 'undefined') {
                            search = search.split(':')
                            for (let i = 0; i < search.length; i++) {
                                if (search[i].startsWith('f')) {
                                    search = search[i].substring(1);
                                    search_found = 1;
                                    break;
                                }
                            }		
                        }

                        if (search_found == 1) {
                            search = decodeURIComponent(search);
                            tenants_table.columns([]).search(search).draw();
                            tenants_table.search(search).draw(true);
                        }
                    }

                    if(actCount == 0) {
                        actCount = 1;
                        /* Check if we have a hash, then parse that */
                        var queryString  = {};
                        var query        = window.location.hash.substring( 1 );
                        var queryparts   = query.split(\"=\");
                        var length       = queryparts[1];
                        var length_found = 0;

                        if (length == '_') {
                            length = 20;
                        } else {
                            length = queryparts[1];
                            if (typeof length !== 'undefined') {
                                length = length.split(':')
                                for (let i = 0; i < length.length; i++) {
                                    if (length[i].startsWith('l')) {
                                        length = length[i].substring(1);
                                        length_found = 1;
                                        break;
                                    }
                                }
                            }
                        }
                        if (length_found == 1) {
                            if(isNaN(length)) {
                                length = 20;
                            }
                            /* Now we have the length, let's
                             * - update the length drop down,
                             * - redraw the table
                             */
                            tenants_table.page.len(length).draw();
                            tenants_table.draw();
                        }
                    }
					
                    if(actSort == 0) {
                        actSort = 1;

                        /* Check if we have a hash, then parse that */
                        var queryString  = {};
                        var query        = window.location.hash.substring( 1 );
                        var queryparts   = query.split(\"=\");
                        var sort         = queryparts[1];
                        var sort_found   = 0;
                        var direction    = \"\";

                        sort = queryparts[1];
                        if (typeof sort !== 'undefined') {
                            sort = sort.split(':')
                            for (let i = 0; i < sort.length; i++) {
                                if (sort[i].startsWith('o')) {
                                    direction = sort[i].substring(1,2);
                                    sort = sort[i].substring(2);
                                    sort_found = 1
                                    break;
                                }
                            }
                        }
                        if (sort_found == 1) {
                            sort = decodeURIComponent(sort);
                            var sortColumn = parseInt(sort);
                            if (direction == 'a') {
                                direction = 'asc';
                            } else {
                                direction = 'desc';
                            }
                            tenants_table.order([[sortColumn, direction]]).draw();
                        }
                    }
                });
            }",
			
			

        "dataSource"=>function() {
			
			if (isset($_GET['business_partner_id']))
			{
				
				// $datatest =  $this->src('tc')
					// ->query("SELECT DISTINCT op.lob AS 'LOB'
					// FROM over_provisioning AS op
					// WHERE op.ovr_live > 0
					// AND op.business_partner_id = \"1187913\" "
					// );
										
				$databata =  $this->src('tc')
					->query("
					WITH RECURSIVE seq AS (
						SELECT 1 AS num
						UNION ALL
						SELECT num + 1 FROM seq WHERE num <= 100
					)
					SELECT -- distinct
								op.entitlement_set_id  as `ES`
								, op.tpt_description     as `TPT Desc.`
								, op.zh_code             as `ZH`
								, op.quantity            as `Q Allowed`
								, op.tenants_live        as `Q Actual`
								, SUBSTRING_INDEX(SUBSTRING_INDEX(op.tenant_list, ',', seq.num), ',', -1) AS `Tenants`
								, SUBSTRING_INDEX(SUBSTRING_INDEX(op.tenant_external_names, ',', seq.num), ',', -1) AS `Tenants Ext.`
								, tc.created_on          as `Created On`
								,tc.phase_to as `Final Phase Date`
								, tc.last_access         as `Last Access`
								, group_concat(concat(tc.product_id, ' ', tc.product_name) SEPARATOR ', ') as `Products`
								, tc.system_data_center  as `DC`
								, dc.country_region      as `DC Region`
								, tc.lob as `LOB`
								, dc.sap_dc_name         as `DC NAME`
								, dc.infrastructure_service_provider as `DC Infra`
								, op.customer_name as `Customer`
					FROM
						over_provisioning as op
						JOIN seq ON seq.num <= 1 + LENGTH(op.tenant_list) - LENGTH(REPLACE(op.tenant_list, ',', ''))
							AND seq.num <= 1 + LENGTH(op.tenant_external_names) - LENGTH(REPLACE(op.tenant_external_names, ',', ''))
						JOIN ___tc as tc ON tc.tenant_id = SUBSTRING_INDEX(SUBSTRING_INDEX(op.tenant_list, ',', seq.num), ',', -1)
							AND tc.phase_cur = 1
						JOIN datacenters dc ON tc.system_data_center = dc.data_center_id
					WHERE
						op.ovr_live > 0
						AND op.business_partner_id =  \"".  $_GET['business_partner_id'] ."\"
					GROUP BY
						 `Customer`, `ES`, `Tenants`, `Tenants Ext.`, `ZH`, `Q Allowed`,
						`Q Actual`, `TPT Desc.`, `Created On`, `Last Access`, `DC`, `DC NAME`, `DC Infra`, `DC Region`
					ORDER BY
						op.lob, op.tpt_description, op.quantity
				") ;
				
				return $databata;
		
			}		
			else{
				return $this->src('tc')
				
					   ->query("
				WITH RECURSIVE seq AS (
					SELECT 1 AS num
					UNION ALL
					SELECT num + 1 FROM seq WHERE num <= 100
				)
				SELECT -- distinct
						   op.entitlement_set_id  as `ES`
							, op.tpt_description     as `TPT Desc.`
							, op.zh_code             as `ZH`
							, op.quantity            as `Q Allowed`
							, op.tenants_live        as `Q Actual`
							, SUBSTRING_INDEX(SUBSTRING_INDEX(op.tenant_list, ',', seq.num), ',', -1) AS `Tenants`
							, SUBSTRING_INDEX(SUBSTRING_INDEX(op.tenant_external_names, ',', seq.num), ',', -1) AS `Tenants Ext.`
							, tc.created_on          as `Created On`
							,tc.phase_to as `Final Phase Date`
							, tc.last_access         as `Last Access`
							, group_concat(concat(tc.product_id, ' ', tc.product_name) SEPARATOR ', ') as `Products`
							, tc.system_data_center  as `DC`
							, dc.country_region      as `DC Region`
							, tc.lob as `LOB`
							, dc.sap_dc_name         as `DC NAME`
							, dc.infrastructure_service_provider as `DC Infra`
							, op.customer_name as `Customer`
							, tc.lob as `LOB`
				FROM
					over_provisioning as op
					JOIN seq ON seq.num <= 1 + LENGTH(op.tenant_list) - LENGTH(REPLACE(op.tenant_list, ',', ''))
						AND seq.num <= 1 + LENGTH(op.tenant_external_names) - LENGTH(REPLACE(op.tenant_external_names, ',', ''))
					JOIN ___tc as tc ON tc.tenant_id = SUBSTRING_INDEX(SUBSTRING_INDEX(op.tenant_list, ',', seq.num), ',', -1)
						AND tc.phase_cur = 1
					JOIN datacenters dc ON tc.system_data_center = dc.data_center_id
				WHERE
					op.ovr_live > 0
					AND op.business_partner_id IN (SELECT business_partner_id  FROM over_provisioning)
				GROUP BY
					`Customer`, `ES`, `Tenants`, `Tenants Ext.`, `ZH`, `Q Allowed`,
					`Q Actual`, `TPT Desc.`, `Created On`, `Last Access`, `DC`, `DC NAME`, `DC Infra`, `DC Region`
				ORDER BY
					op.lob, op.tpt_description, op.quantity
				");	
			}
		},
		  
        "options" => array(
		"paging" => true,
		"searching" => true,
		"lengthMenu" => [[5, 10, 20, 50, -1], [5, 10, 20, 50, "All"]],
		"pageLength" => 50, // Set the default page length to 50
		"keepConditions" => true,
        "dom"=>"Blfrtip",
        "buttons"=> [
            'copyHtml5',

			OverProvTableButtonExcel::render($business_partner_id),
//			'excelHtml5',
            'csvHtml5',
            [
                "extend" => 'pdfHtml5',
                "orientation" => 'landscape',
                "pageSize" => 'A4'
            ],
            "print"
            ],
        ),  

        "cssClass"=>array(
            "table"=>"table table-striped table-hover table-bordered",
            "th"=>"cssHeader"
        ),
    ]);
	
