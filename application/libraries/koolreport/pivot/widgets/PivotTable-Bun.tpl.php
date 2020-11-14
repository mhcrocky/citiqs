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
<table id=<?php $uniqueId?>
    class='pivot-table table table-bordered' style='width:<?php $width ?>; visibility: hidden'>
    <tbody>
        <?php foreach ($colFields as $i => $cf) { ?>
            <tr class='pivot-column'>
            <?php if ($i === 0) { 
                $numCF = count($colFields);
                $rowspan = $this->showDataHeaders ? $numCF + 1 : $numCF; ?>
                <td class='pivot-data-field-zone'
                    rowspan=<?php $rowspan; ?>>
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
                        data-value='<?phphtmlspecialchars($node[$cf]);?>'
                        data-text='<?phphtmlspecialchars($mappedNode[$cf]);?>'
                        data-full-value='<?phphtmlspecialchars(implode(" || ", $nodeFullValue));?>'
                        data-full-text='<?phphtmlspecialchars(implode(" || ", $nodeFullText));?>'
                        data-column-field=<?php $colTotalHeader ? $i-1 : $i ?>
                        data-column-index=<?php $c; ?>
                        data-num-leaf=<?php 
                            $numLeaf = $colNodeInfo[$cf]['numLeaf'];
                            echo $numLeaf;
                        ?>
                        data-num-children=<?php
                            $numChildren = $colNodeInfo[$cf]['numChildren'];
                            echo $numChildren;
                        ?>
                        data-child-order=<?php $colNodeInfo[$cf]['childOrder'] ?>
                        colspan=<?php $hideSubTotalColumns ? $numLeaf : $numChildren; ?>
                        rowspan=<?php $colTotalHeader ? $colNodeInfo[$cf]['level'] : 1 ?>
                        data-layer=1
                    >
                        <div class="pivot-column-header-text">
                            <?php if ($i < count($colFields) - 1 && ! $colTotalHeader)  { ?>
                                <i class='pivot-exp-col far fa-minus-square' data-command='collapse' aria-hidden='true'></i>
                            <?php } ?>
                            <?php $mappedNode[$cf]; ?>
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
                        data-value='<?phphtmlspecialchars($df);?>'
                        data-text='<?phphtmlspecialchars($mappedDH);?>'
                        data-full-value='<?phphtmlspecialchars(implode(" || ", $nodeFullValue));?>'
                        data-full-text='<?phphtmlspecialchars(implode(" || ", $nodeFullText));?>'
                        data-data-field=<?php $di?>
                        data-column-field=<?php $colNodeInfo['fieldOrder']?>
                        data-column-index=<?php $c;?>
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
                            data-value='<?phphtmlspecialchars($node[$rf]);?>'
                            data-text='<?phphtmlspecialchars($mappedNode[$rf]);?>'
                            data-full-value='<?phphtmlspecialchars(implode(" || ", $nodeFullValue));?>'
                            data-full-text='<?phphtmlspecialchars(implode(" || ", $nodeFullText));?>'
                            data-row-field=<?php $rowTotalHeader ? $j-1 : $j?>
                            data-row-index=<?php $r?>
                            data-child-order=<?php $rowNodeInfo[$rf]['childOrder']?>
                            data-num-children=<?php $rowNodeInfo[$rf]['numChildren']; ?>
                            data-layer=1
                        >
                            <div class="pivot-row-header-text">
                                <?php for ($indent=0; $indent<$j; $indent++)
                                    echo "<span class='pivot-indent'>&nbsp</span>"; ?>
                                <?php if ($j < count($rowFields) - 1 && ! $rowTotalHeader) { ?>
                                    <i class='pivot-exp-col far fa-minus-square' data-command='collapse' aria-hidden='true'></i>
                                <?php } ?>
                                <?php $mappedNode[$rf]; ?>
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
                            data-value='<?phpUtil::get($dataRow, $df, $emptyValue);?>'
                            data-data-field=<?php $di?>
                            data-column-field=<?php $colNodeInfo['fieldOrder']?>
                            data-row-field=<?php $rowNodeInfo['fieldOrder']?>
                            data-row-index=<?php $r;?>
                            data-column-index=<?php $c;?>
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
            var <?php $uniqueId?>_data = {
                id: "<?php $uniqueId?>",
                template: "<?php $this->template?>",
                rowCollapseLevels: rowCollapseLevels,
                colCollapseLevels: colCollapseLevels,
                selectable: <?php echo $this->selectable ? 1 : 0; ?>,
                rowFields: <?php echo json_encode($rowFields); ?>,
                colFields: <?php echo json_encode($colFields); ?>,
                dataFields: <?php echo json_encode($dataFields); ?>,
                clientEvents: <?php echo Util::jsonEncode($this->clientEvents); ?>,
            };
            <?php $uniqueId?> = KoolReport.PivotTable.create(<?php $uniqueId?>_data);

            <?php $this->clientSideReady("");?>
        }
    );
</script>
