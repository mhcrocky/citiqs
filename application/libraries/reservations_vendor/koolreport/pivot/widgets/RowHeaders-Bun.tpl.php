<?php
    use \koolreport\core\Utility as Util; 
?>  
<div class='krpmRowHeaderZoneDiv'>
    <table class='table'>
        <tbody>
            <?php 
            foreach($rowIndexesBun as $r => $i) {
                $node = $rowNodes[$i];
                $mappedNode = $mappedRowNodesBun[$i];
                $nodeClass = $rowNodesClass[$i];
                $rowNodeInfo = $rowNodesInfoBun[$i]; ?>
                <tr class='krpmRow'>
                    <?php foreach ($rowFields as $j => $rf) {
                        $rowTotalHeader = isset($rowNodeInfo[$rf]['total']);
                        $subTotalHeader = $rowTotalHeader && $j > 0;
                        if (isset($rowNodeInfo[$rf]['numChildren']) && 
                            ! $subTotalHeader) { ?>
                            <td class='krpmRowHeader
                                <?php
                                    if (isset($rowNodeInfo['hasTotal'])) {
                                        echo $rowNodeInfo['fieldOrder'] === -1 ? 
                                            ' krpmRowHeaderGrandTotal' : 
                                            ' krpmRowHeaderTotal';
                                    }
                                    echo ' ' . Util::get($nodeClass, $rf, '');
                                ?>'
                                data-row-field=<?= $rowTotalHeader ? $j-1 : $j?>
                                data-row-index=<?=$r?>
                                data-node='<?= htmlspecialchars($node[$rf], ENT_QUOTES) ?>'
                                data-num-children=<?= $rowNodeInfo[$rf]['numChildren']; ?> 
                                data-row-layer=1
                                data-column-layer=1
                                data-page-layer=1
                                style='display:' 
                            >
                                <div class='krpmHeaderText'>
                                    <?php for ($indent=0; $indent<$j; $indent++)
                                        echo "<span class='krpm-indent'>&nbsp</span>"; ?>
                                    <?php if ($j < count($rowFields) - 1 && 
                                        ! $rowTotalHeader) { ?>
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