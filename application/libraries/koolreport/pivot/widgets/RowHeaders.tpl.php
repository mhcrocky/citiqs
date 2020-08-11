<?php
    use \koolreport\core\Utility as Util; 
?>  
<div class='krpmRowHeaderZoneDiv'>
    <table class='table'>
        <tbody>
            <?php 
            foreach($rowIndexes as $r => $i) {
                $node = $rowNodes[$i];
                $mappedNode = $mappedRowNodes[$i];
                $nodeClass = $rowNodesClass[$i];
                $rowNodeInfo = $rowNodesInfo[$i]; ?>
                <tr class='krpmRow'>
                    <?php foreach ($rowFields as $j => $rf) {
                        $rowTotalHeader = isset($rowNodeInfo[$rf]['total']);
                        if (isset($rowNodeInfo[$rf]['numChildren'])) { ?>
                            <td class='krpmRowHeader
                                <?php
                                    if ($rowTotalHeader) {
                                        echo $j === 0 ?
                                            ' krpmRowHeaderGrandTotal' :
                                            ' krpmRowHeaderTotal';
                                    }
                                    echo ' ' . Util::get($nodeClass, $rf, '');
                                ?>'
                                data-row-field=<?= $rowTotalHeader ? $j-1 : $j?>
                                data-row-index=<?=$r?>
                                data-node = '<?= htmlspecialchars($node[$rf], ENT_QUOTES) ?>'
                                rowspan=<?= $rowNodeInfo[$rf]['numChildren']; ?> 
                                <?php if ($rowTotalHeader)
                                    echo "colspan=".$rowNodeInfo[$rf]['level']; ?>
                                data-row-layer=1
                                data-column-layer=1
                                data-page-layer=1
                                style='display:' 
                            >
                                <div class='krpmHeaderText'>
									<?php if ($j < count($rowFields) - 1 
									&& ! $rowTotalHeader)  { ?>
									<i class='krpmExpCol far fa-minus-square' data-command='collapse' aria-hidden='true'></i>
								<?php } ?>
									<?= $mappedNode[$rf]; ?>
								</div>
                            </td>
                        <?php }   
                    } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>