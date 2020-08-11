<?php 
    use \koolreport\core\Utility as Util;
?>
<style>

    .pivot-exp-col {
        cursor: pointer;
    }

    .pivot-row {
        white-space: nowrap;
    }

    <?php if ($hideSubTotalRows) { 
        echo "
            #{$this->name} .pivot-row-header-total,
            #{$this->name} .pivot-data-cell-row-total {
                display: none !important;
            }
        ";
    } ?>

    <?php if ($hideSubTotalColumns) { 
        echo "
            #{$this->name} .pivot-column-header-total,
            #{$this->name} .pivot-data-cell-column-total,
            #{$this->name} .pivot-data-header-total {
                display: none !important;
            }
        ";
    } ?>

    <?php if ($hideGrandTotalRow) { 
        echo "
            #{$this->name} .pivot-row-header-grand-total,
            #{$this->name} .pivot-data-cell-row-grand-total {
                display: none !important;
            }
        ";
    } ?>

    <?php if ($hideGrandTotalColumn) { 
        echo "
            #{$this->name} .pivot-column-header-grand-total,
            #{$this->name} .pivot-data-header-grand-total,
            #{$this->name} .pivot-data-cell-column-grand-total {
                display: none !important;
            }
        ";
    } ?>

</style>
<table id=<?=$uniqueId?> 
    class='pivot-table table table-bordered' style='width:<?= $width ?>; visibility: hidden'>
    <tbody>
        <?php foreach ($colFields as $i => $cf) { ?>
            <tr class='pivot-column'>
            <?php if ($i === 0) { 
                $numCF = count($colFields);
                $rowspan = $this->showDataHeaders ? $numCF + 1 : $numCF; ?>
                <td class='pivot-data-field-zone'
                    rowspan=<?= $rowspan; ?>>
                    <div class='pivot-data-field-content'>
                        <?php echo implode(' | ', $mappedDataFields); ?>
                    </div>
                </td>
            <?php }
            foreach ($colIndexes as $c => $j) {
                $node = $colNodes[$j];
                $mappedNode = $mappedColNodes[$j];
                $nodeClass = $colNodesClass[$j];
                $nodeFullValue = array_slice($node, 0, $i+1);
                $nodeFullText = array_slice($mappedNode, 0, $i+1);
                $colNodeInfo = $colNodesInfo[$j];
                $colTotalHeader = isset($colNodeInfo[$cf]['total']);
                if (isset($colNodeInfo[$cf]['numChildren'])) { ?>
                    <td class="pivot-column-header 
                        <?php 
                            if ($colTotalHeader) {
                                echo $i === 0 ? 
                                    ' pivot-column-header-grand-total' : 
                                    ' pivot-column-header-total'; 
                            } 
                            echo ' ' . Util::get($nodeClass, $cf, '');
                        ?>"
                        data-value='<?=htmlspecialchars($node[$cf]);?>'
                        data-text='<?=htmlspecialchars($mappedNode[$cf]);?>'
                        data-full-value='<?=htmlspecialchars(implode(" || ", $nodeFullValue));?>'
                        data-full-text='<?=htmlspecialchars(implode(" || ", $nodeFullText));?>'
                        data-column-field=<?= $colTotalHeader ? $i-1 : $i ?>
                        data-column-index=<?= $c; ?>
                        data-num-leaf=<?php 
                            $numLeaf = $colNodeInfo[$cf]['numLeaf'];
                            echo $numLeaf;
                        ?>
                        data-num-children=<?php
                            $numChildren = $colNodeInfo[$cf]['numChildren'];
                            echo $numChildren;
                        ?>
                        data-child-order=<?= $colNodeInfo[$cf]['childOrder'] ?>
                        colspan=<?= $hideSubTotalColumns ? $numLeaf : $numChildren; ?>
                        rowspan=<?= $colTotalHeader ? $colNodeInfo[$cf]['level'] : 1 ?>
                        data-layer=1
                    >
                        <div class="pivot-column-header-text">
                            <?php if ($i < count($colFields) - 1 && ! $colTotalHeader)  { ?>
                                <i class='pivot-exp-col far fa-minus-square' data-command='collapse' aria-hidden='true'></i>
                            <?php } ?>
                            <?= $mappedNode[$cf]; ?>
                        </div>
                    </td>
                <?php }
            } ?>
            </tr>
        <?php } 
        if ($this->showDataHeaders) { ?>
            <tr class='pivot-column'> <?php
            foreach ($colIndexes as $c => $j) {
                $nodeFullValue = $node = $colNodes[$j];
                $nodeFullText = $mappedNode = $mappedColNodes[$j];
                $colNodeInfo = $colNodesInfo[$j];
                foreach($dataFields as $di => $df) { 
                    $mappedDH = $mappedDataHeaders[$df]; 
                    array_push($nodeFullValue, $df);
                    array_push($nodeFullText, $mappedDH); ?>
                    <td class='pivot-data-header
                        <?php 
                            if (isset($colNodeInfo['hasTotal'])) 
                                echo $colNodeInfo['fieldOrder'] === -1 ?
                                    ' pivot-data-header-grand-total' :
                                    ' pivot-data-header-total';  
                            echo ' ' . Util::get($dataHeadersClass, $df, '');
                        ?>' 
                        data-value='<?=htmlspecialchars($df);?>'
                        data-text='<?=htmlspecialchars($mappedDH);?>'
                        data-full-value='<?=htmlspecialchars(implode(" || ", $nodeFullValue));?>'
                        data-full-text='<?=htmlspecialchars(implode(" || ", $nodeFullText));?>'
                        data-data-field=<?=$di?>
                        data-column-field=<?=$colNodeInfo['fieldOrder']?>
                        data-column-index=<?=$c;?>
                        data-layer=1
                    >
                        <div class="pivot-data-header-text">
                            <?php echo $mappedDH; ?>
                        </div>
                    </td>
                    <?php					
                }
            }
        } ?> </tr>
        <?php
        foreach($rowIndexesBun as $r => $i) {
            $node = $rowNodes[$i];
            $mappedNode = $mappedRowNodesBun[$i];
            $nodeClass = $rowNodesClass[$i];
            $rowNodeInfo = $rowNodesInfoBun[$i]; ?>
            <tr class='pivot-row'>
                <?php 
                foreach($rowFields as $j => $rf) {
                    $nodeFullValue = array_slice($node, 0, $j+1);
                    $nodeFullText = array_slice($mappedNode, 0, $j+1);
                    $rowTotalHeader = isset($rowNodeInfo[$rf]['total']);
                    $subTotalHeader = $rowTotalHeader && $j > 0;
                    if (isset($rowNodeInfo[$rf]['numChildren']) && ! $subTotalHeader) { ?>
                        <td class='pivot-row-header 
                            <?php 
                                if (isset($rowNodeInfo['hasTotal'])) {
                                    echo $rowNodeInfo['fieldOrder'] === -1 ? 
                                        ' pivot-row-header-grand-total' : 
                                        ' pivot-row-header-total';
                                }
                                echo ' ' . Util::get($nodeClass, $rf, '');
                            ?>'
                            data-value='<?=htmlspecialchars($node[$rf]);?>'
                            data-text='<?=htmlspecialchars($mappedNode[$rf]);?>'
                            data-full-value='<?=htmlspecialchars(implode(" || ", $nodeFullValue));?>'
                            data-full-text='<?=htmlspecialchars(implode(" || ", $nodeFullText));?>'
                            data-row-field=<?= $rowTotalHeader ? $j-1 : $j?>
                            data-row-index=<?=$r?>
                            data-child-order=<?=$rowNodeInfo[$rf]['childOrder']?> 
                            data-num-children=<?= $rowNodeInfo[$rf]['numChildren']; ?> 
                            data-layer=1
                        >
                            <div class="pivot-row-header-text">
                                <?php for ($indent=0; $indent<$j; $indent++)
                                    echo "<span class='pivot-indent'>&nbsp</span>"; ?>
                                <?php if ($j < count($rowFields) - 1 && ! $rowTotalHeader) { ?>
                                    <i class='pivot-exp-col far fa-minus-square' data-command='collapse' aria-hidden='true'></i>
                                <?php } ?>
                                <?= $mappedNode[$rf]; ?>
                            </div>
                        </td>
                        <?php					
                    }
                }
                foreach ($colIndexes as $c => $j) {
                    $colNodeInfo = $colNodesInfo[$j];
                    $dataRow = Util::get($indexToData, [$i, $j], []);
                    $mappedDataRow = Util::get($indexToMappedData, [$i, $j], []);
                    $dataRowClass = Util::get($indexToDataClass, [$i, $j], []);
                    foreach($dataFields as $di => $df) {
                        $value = Util::get($dataRow, $df, null); ?>
                        <td class='pivot-data-cell  
                            <?php 
                                if (isset($colNodeInfo['hasTotal'])) 
                                    echo $colNodeInfo['fieldOrder'] === -1 ?
                                        ' pivot-data-cell-column-grand-total' :
                                        ' pivot-data-cell-column-total';  
                                if (isset($rowNodeInfo['hasTotal'])) 
                                    echo $rowNodeInfo['fieldOrder'] === -1 ?
                                        ' pivot-data-cell-row-grand-total' :
                                        ' pivot-data-cell-row-total';
                                echo ' ' . Util::get($dataRowClass, $df, '');
                            ?>' 
                            data-value='<?=Util::get($dataRow, $df, $emptyValue);?>'
                            data-data-field=<?=$di?>
                            data-column-field=<?=$colNodeInfo['fieldOrder']?>
                            data-row-field=<?=$rowNodeInfo['fieldOrder']?>
                            data-row-index=<?=$r;?>
                            data-column-index=<?=$c;?>
                            data-layer=1>
                            <div class="pivot-data-cell-text">
                                <?php echo Util::get($mappedDataRow, $df, $emptyValue); ?>
                            </div>
                        </td>
                        <?php					
                    }
                } ?>
            </tr>
        <?php } ?>
        <tr class='pivot-chart'>
            <td style='visibility:hidden' colspan=9999>
                <div class='chart-panel' style='display:none'></div>
            </td>
        </tr>
    </tbody>
</table>
<script type='text/javascript'>
    KoolReport.widget.init(
        <?php 
            $resources = $this->getResources();
            $jsResource = Util::init($resources, 'js', []);
            // array_push($jsResource, 'https://www.gstatic.com/charts/loader.js');
            $resources['js'] = $jsResource;
            echo json_encode($resources); ?>,
        function() {
            var rowCollapseLevels = <?php echo json_encode($rowCollapseLevels); ?>;
            rowCollapseLevels.sort(function(a,b){ return b-a;});
            var colCollapseLevels = <?php echo json_encode($colCollapseLevels); ?>;
            colCollapseLevels.sort(function(a,b){ return b-a;});
            var <?=$uniqueId?>_data = {
                id: "<?=$uniqueId?>",
                template: "<?=$this->template?>",
                rowCollapseLevels: rowCollapseLevels,
                colCollapseLevels: colCollapseLevels,
                selectable: <?php echo $this->selectable ? 1 : 0; ?>,
                rowFields: <?php echo json_encode($rowFields); ?>,
                colFields: <?php echo json_encode($colFields); ?>,
                dataFields: <?php echo json_encode($dataFields); ?>,
                clientEvents: <?php echo Util::jsonEncode($this->clientEvents); ?>,
            };
            <?=$uniqueId?> = KoolReport.PivotTable.create(<?=$uniqueId?>_data);

            <?php $this->clientSideReady("");?>
        }
    );
</script>
