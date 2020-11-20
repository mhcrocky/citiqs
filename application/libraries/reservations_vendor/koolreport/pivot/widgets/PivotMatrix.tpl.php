<?php
    use \koolreport\core\Utility as Util; 
    $numDF = count($dataFields) > 0 ? count($dataFields) : 1;
?>

<style>

    <?php if ($hideSubTotalRows) { 
        echo "
            #{$this->name} .krpmRowHeaderTotal,
            #{$this->name} .krpmRowHeaderTotalParent,
            #{$this->name} .krpmDataCellRowTotal {
                display: none !important;
            }
        ";
    } ?>

    <?php if ($hideSubTotalColumns) { 
        echo "
            #{$this->name} .krpmColumnHeaderTotal,
            #{$this->name} .krpmColumnHeaderColTotal,
            #{$this->name} .krpmDataHeaderColumnTotal,
            #{$this->name} .krpmDataCellColumnTotal, 
            #{$this->name} .krpmDataCellColumnColTotal {
                display: none !important;
            }
        ";
    } ?>

    <?php if ($hideGrandTotalRow) { 
        echo "
            #{$this->name} .krpmRowHeaderGrandTotal,
            #{$this->name} .krpmDataCellRowGrandTotal {
                display: none !important;
            }
        ";
    } ?>

    <?php if ($hideGrandTotalColumn) { 
        echo "
            #{$this->name} .krpmColumnHeaderGrandTotal,
            #{$this->name} .krpmColumnHeaderColGrandTotal,
            #{$this->name} .krpmDataHeaderColumnGrandTotal,
            #{$this->name} .krpmDataCellColumnGrandTotal,
            #{$this->name} .krpmDataCellColumnColGrandTotal {
                display: none !important;
            }
        ";
    } ?>

</style>
<div id="<?=$uniqueId?>" class='krPivotMatrix animated'
        style="width:<?= $width ?>; height:<?= $height ?>; 
        overflow: hidden; visibility: ;
        animation-duration: 0.5s;">
    
    <table class='table'>
        <colgroup>
            <col>
            <col>
        </colgroup>
        <tbody>
            <tr>
                <td class='krpmFieldZone krpmWaitingFieldZone' 
                    data-zone="waiting" colspan=2 >
                    <?php
                        $zone = "waiting";
                        $mappedFields = $mappedWaitingFields;
                        $fieldsType = $waitingFieldsType;
                        $fieldsSort = $waitingFieldsSort;
                        $fields = $waitingFields;
                        include "FieldZone.tpl.php";
                    ?>
                </td>
            </tr>
            <tr>
                <td class='krpmFieldZone krpmDataFieldZone'
                    data-zone="data" >
                    <?php
                        $zone = "data";
                        $mappedFields = $mappedDataFields;
                        $fieldsType = $dataFieldsType;
                        $fieldsSort = $dataFieldsSort;
                        $fields = $dataFields;
                        include "FieldZone.tpl.php";
                    ?>
                </td>
                <td class='krpmFieldZone krpmColumnFieldZone' 
                    data-zone="column" colspan=1 >
                    <?php
                        $zone = "column";
                        $mappedFields = $mappedColFields;
                        $fieldsType = $columnFieldsType;
                        $fieldsSort = $columnFieldsSort;
                        $fields = $colFields;
                        include "FieldZone.tpl.php";
                    ?>
                </td>
            </tr>
            <tr>
                <td class='krpmFieldZone krpmRowFieldZone'
                    data-zone="row" >
                    <?php
                        $zone = "row";
                        $mappedFields = $mappedRowFields;
                        $fieldsType = $rowFieldsType;
                        $fieldsSort = $rowFieldsSort;
                        $fields = $rowFields;
                        include "FieldZone.tpl.php";
                    ?>
                </td>
                <td class='krpmColumnHeaderZone'>
                    <?php 
                        if (! isset($ColumnHeadersTpl))
                            $ColumnHeadersTpl = "ColumnHeaders.tpl.php";
                        include $ColumnHeadersTpl; 
                    ?>
                </td>
            </tr>
            <tr>
                <td class='krpmRowHeaderZone' >
                    <?php 
                        if (! isset($RowHeadersTpl))
                            $RowHeadersTpl = "RowHeaders.tpl.php";
                        include $RowHeadersTpl; 
                    ?>
                </td>
                <td class='krpmDataZone' colspan=1>
                    <?php 
                        if (! isset($DataCellsTpl))
                            $DataCellsTpl = "DataCells.tpl.php";
                        include $DataCellsTpl;
                    ?>
                </td>
            </tr>
            <tr class='krpmTrFooter'>
                <td class='krpmFooter'
                    colspan=<?= count($rowFields) + count($colIndexes) * $numDF; ?>>
                    <span id='krpmPagination'></span>
                    <span style='margin-left:10px'>Page size: </span>
                    <select id='krpmPageSizeSelect' class="form-control krpmPageSize">
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
    <div id="krpmDisabler" style="display: none" >
        <i class="krpmSpin fas fa-refresh fa-spin fa-3x fa-fw"></i>
    </div>
    <div id="krpmColumnFieldMenu" class="krpmFieldMenu" tabindex="0" 
        style="display: none;">
        <div class='krpmMenuItem' data-command='expand'>Expand All
            <i class='far fa-plus-square' aria-hidden='true'></i></div>
        <div class='krpmMenuItem' data-command='collapse'>Collapse All
            <i class='far fa-minus-square' aria-hidden='true'></i></div>
        <div class='krpmMenuItem' data-command='sort-asc'>Sort Asc
            <i class="krpmSortIcon fas fa-long-arrow-alt-left" aria-hidden="true"></i></div>
        <div class='krpmMenuItem' data-command='sort-desc'>Sort Desc
            <i class="krpmSortIcon fas fa-long-arrow-alt-right" aria-hidden="true"></i></div>
    </div>
    <div id="krpmRowFieldMenu" class="krpmFieldMenu" tabindex="0" 
        style="display: none;">
        <div class='krpmMenuItem' data-command='expand'>Expand All
            <i class='far fa-plus-square' aria-hidden='true'></i></div>
        <div class='krpmMenuItem' data-command='collapse'>Collapse All
            <i class='far fa-minus-square' aria-hidden='true'></i></div>
        <div class='krpmMenuItem' data-command='sort-asc'>Sort Asc
            <i class="krpmSortIcon fas fa-long-arrow-alt-up" aria-hidden="true"></i></div>
        <div class='krpmMenuItem' data-command='sort-desc'>Sort Desc
            <i class="krpmSortIcon fas fa-long-arrow-alt-down" aria-hidden="true"></i></div>
    </div>
    <div id="krpmDataFieldMenu" class="krpmFieldMenu" tabindex="0" 
        style="display: none;">
        <div class='krpmMenuItem' data-command='sort-asc-row'>Sort Row Asc
            <i class="krpmSortIcon fas fa-long-arrow-alt-up" aria-hidden="true"></i></div>
        <div class='krpmMenuItem' data-command='sort-desc-row'>Sort Row Desc
            <i class="krpmSortIcon fas fa-long-arrow-alt-down" aria-hidden="true"></i></div>
        <div class='krpmMenuItem' data-command='sort-asc-column'>Sort Column Asc
            <i class="krpmSortIcon fas fa-long-arrow-alt-left" aria-hidden="true"></i></div>
        <div class='krpmMenuItem' data-command='sort-desc-column'>Sort Column Desc
            <i class="krpmSortIcon fas fa-long-arrow-alt-right" aria-hidden="true"></i></div>
    </div>
    <input name="koolPivotConfig" class='krpmConfig' type='hidden' value='<?= htmlspecialchars(json_encode($config), ENT_QUOTES); ?>'/>
    <input name="koolPivotViewstate" class='krpmViewstate' type='hidden' value='<?= json_encode($viewstate); ?>'/>
    <!-- <input name="koolPivotScope" class='krpmScope' type='hidden' value='<?= json_encode($scope); ?>'/> -->
    <input name="koolPivotScope" class='krpmScope' type='hidden' value='<?= htmlspecialchars(json_encode($scope), ENT_QUOTES); ?>'/>
    <input name="koolPivotCommand" class='krpmCommand' type='hidden' />
</div>
<script type='text/javascript'>
    KoolReport.widget.init(
        <?php echo json_encode($this->getResources()); ?>,
        function() {
            var <?=$uniqueId?>_data = {
                uniqueId: "<?=$uniqueId?>",
                template: "<?=$this->template?>",
                columnCollapseLevels: <?=json_encode($columnCollapseLevels);?>,
                rowCollapseLevels: <?=json_encode($rowCollapseLevels);?>,
                isUpdate: <?php echo $isUpdate ? 1 : 0; ?>,
                clientEvents: <?=json_encode($clientEvents);?>,
            };
            <?=$uniqueId?> = KoolReport.PivotMatrix.create(<?=$uniqueId?>_data);
            <?php $this->clientSideReady("");?>
        }
    );
</script>
