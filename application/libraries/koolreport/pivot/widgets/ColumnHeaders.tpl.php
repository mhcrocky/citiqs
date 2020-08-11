<?php
    use \koolreport\core\Utility as Util; 
?>    
<div class='krpmColumnHeaderZoneDiv'>
    <table class='table'>
        <tbody>
            <?php 
            foreach ($colFields as $i => $cf) { ?>
                <tr>
                <?php foreach ($colIndexes as $c => $j) {
                    $node = $colNodes[$j];
                    $mappedNode = $mappedColNodes[$j];
                    $nodeClass = $colNodesClass[$j];
                    // print_r($nodeClass);
                    // echo "cf=$cf";
                    $colNodeInfo = $colNodesInfo[$j];
                    $colTotalHeader = isset($colNodeInfo[$cf]['total']);
                    if (isset($colNodeInfo[$cf]['numChildren'])) { ?>
                        <td class='krpmColumnHeader
                            <?php
                                error_reporting(E_ALL);
                                if ($colTotalHeader) {
                                    echo $i === 0 ?
                                        ' krpmColumnHeaderGrandTotal' : 
                                        ' krpmColumnHeaderTotal';
                                }
                                echo ' ' . Util::get($nodeClass, $cf, '');
                            ?>'
                            data-column-field=<?=$colTotalHeader ? $i-1 : $i?>
                            data-column-index=<?=$c;?>
                            data-column-layer=1
                            data-row-layer=1
                            data-page-layer=1
                            data-num-leaf=<?php 
                                $numLeaf = $colNodeInfo[$cf]['numLeaf'];
                                echo $numLeaf;
                            ?>
                            data-num-children=<?php 
                                $numChildren = $colNodeInfo[$cf]['numChildren'];
                                echo $numChildren;
                            ?>
                            data-node = '<?= htmlspecialchars($node[$cf], ENT_QUOTES) ?>'
                            colspan=<?= $hideSubTotalColumns ? $numLeaf : $numChildren; ?>
                            rowspan=<?= $colTotalHeader ? $colNodeInfo[$cf]['level'] : 1 ?>
                            style='display:' 
                        >
                            <div class='krpmHeaderText'>
								<?php if ($i < count($colFields) - 1 && ! $colTotalHeader) { ?>
									<i class='krpmExpCol far fa-minus-square' data-command='collapse' aria-hidden='true'></i>
								<?php } ?>
                                <?= $mappedNode[$cf]; ?>
                            </div>
                        </td>
                    <?php } ?>
                <?php } ?>
                </tr>
            <?php } ?>
            <?php if ($this->showDataHeaders) { ?>
                <tr class='krpmDataHeaderRow'>
                <?php foreach ($colIndexes as $c => $j) {
                    $colNodeInfo = $colNodesInfo[$j];
                    foreach($dataFields as $di => $df) { ?>
                        <td class='krpmDataHeader 
                            <?php
                                if (isset($colNodeInfo['hasTotal'])) 
                                    echo $colNodeInfo['fieldOrder'] === -1 ?
                                        ' krpmDataHeaderColumnGrandTotal' :
                                        ' krpmDataHeaderColumnTotal';  
                                echo ' ' . Util::get($dataHeadersClass, $df, '');
                            ?>' 
                            data-data-field=<?=$di?>
                            data-column-field=<?=$colNodeInfo['fieldOrder']?>
                            data-column-index=<?=$c;?>
                            data-column-layer=1
                            data-row-layer=1
                            data-page-layer=1 
                        >
                            <div class='krpmDataHeaderText'>
                            <?php 
                                echo $mappedDataHeaders[$df]; ?>
                            </div>
                        </td>
                    <?php } ?>
                <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
        <colgroup>
            <?php 
                foreach ($colIndexes as $c => $j) { 
                    $colNodeInfo = $colNodesInfo[$j];
                    $colClass = 'krpmColumnHeaderCol ';
                    if (isset($colNodeInfo['hasTotal'])) 
                        $colClass .= $colNodeInfo['fieldOrder'] === -1 ?
                            ' krpmColumnHeaderColGrandTotal' :
                            ' krpmColumnHeaderColTotal'; 

                    foreach ($dataFields as $di => $df) 
                        echo "
                            <col 
                            data-data-field='$di'
                            data-column-field='{$colNodeInfo['fieldOrder']}'
                            data-column-index='$c'
                            class='$colClass'>
                        ";
                } 
            ?>
        </colgroup>
    </table>
</div>
