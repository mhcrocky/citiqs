<?php
    use \koolreport\core\Utility as Util; 
?>
<div class='krpmDataZoneDiv'>
    <table class='table'>
        <colgroup>
            <?php foreach ($colIndexes as $c => $j) { 
                $colNodeInfo = $colNodesInfo[$j];
                $colClass = 'krpmDataCellCol';
                if (isset($colNodeInfo['hasTotal'])) 
                    $colClass = $colNodeInfo['fieldOrder'] === -1 ?
                        ' krpmDataCellColumnColGrandTotal' :
                        ' krpmDataCellColumnColTotal'; 

                foreach ($dataFields as $di => $df) 
                    echo "
                        <col 
                        data-data-field='$di'
                        data-column-field='{$colNodeInfo['fieldOrder']}'
                        data-column-index='$c'
                        class='$colClass'>
                    ";
            } ?>
        </colgroup>
        <tbody>
            <?php foreach($rowIndexes as $r => $i) { 
                $rowNodeInfo = $rowNodesInfo[$i]; ?>
                <tr class='krpmRow'
                    data-row-field=<?=$rowNodeInfo['fieldOrder']?>
                    style='display:'
                >
                    <?php foreach ($colIndexes as $c => $j) {
                        $colNodeInfo = $colNodesInfo[$j];
                        $dataRow = Util::get($indexToData, [$i, $j], []);
                        $mappedDataRow = Util::get($indexToMappedData, [$i, $j], []);
                        $dataRowClass = Util::get($indexToDataClass, [$i, $j], []);
                        foreach($dataFields as $di => $df) { 
                            $value = Util::get($dataRow, $df, null); ?>
                            <td class='krpmDataCell 
                                <?php
                                    if (isset($colNodeInfo['hasTotal'])) 
                                        echo $colNodeInfo['fieldOrder'] === -1 ?
                                            ' krpmDataCellColumnGrandTotal' :
                                            ' krpmDataCellColumnTotal';

                                    if (isset($rowNodeInfo['hasTotal'])) 
                                        echo $rowNodeInfo['fieldOrder'] === -1 ?
                                            ' krpmDataCellRowGrandTotal' :
                                            ' krpmDataCellRowTotal';
                                            
                                    echo ' ' . Util::get($dataRowClass, $df, '');
                                ?>' 
                                data-data-field=<?=$di?>
                                data-column-field=<?=$colNodeInfo['fieldOrder']?>
                                data-row-field=<?=$rowNodeInfo['fieldOrder']?>
                                data-row-index=<?=$r;?>
                                data-column-index=<?=$c;?>
                                data-row-layer=1
                                data-column-layer=1
                                data-page-layer=1
                                style='display:' 
                            >
                                <div class='krpmDataCellText'>
                                    <?php echo Util::get($mappedDataRow, $df, $emptyValue); ?>
                                </div>
                            </td>
                        <?php } ?>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>