<?php
    use \koolreport\core\Utility as Util;
    
    $cMetas = Util::get($meta, "columns", []);

	$tableCss = Util::get($this->cssClass,"table");
	$trClass = Util::get($this->cssClass,"tr");
	$tdClass = Util::get($this->cssClass,"td");
	$thClass = Util::get($this->cssClass,"th");
    $tfClass = Util::get($this->cssClass,"tf");

    $tableAttrs = Util::get($this->attributes, "table");
    $trAttrs = Util::get($this->attributes, "tr");
    $tdAttrs = Util::get($this->attributes, "td");
    $thAttrs = Util::get($this->attributes, "th");
    $tfAttrs = Util::get($this->attributes, "tf");

    $getMappedProperty = function($mappedProperty, $default) {
        $args = func_get_args();
        $args = array_slice($args, 2);
        $property = is_callable($mappedProperty) ? 
            call_user_func_array($mappedProperty, $args): $mappedProperty;
        if (! isset($property)) $property = $default;
        return $property;
    };

    $draw = (int) Util::get($this->submitType, 'draw', 0);
    $id = Util::get($this->submitType, 'id', null);
    $ds = $this->dataStore;
    $ajax = $this->serverSide && $id == $this->name;
    if ($ajax) {
        echo "<dt-ajax id='dt_{$this->name}'>";
        $resData = [
            'draw' => $draw + 1,
            'recordsTotal' => Util::get($meta, 'totalRecords', 0),
            'recordsFiltered' => Util::get($meta, 'filterRecords', 0),
            'data' => $ds->data()
        ];
        echo json_encode($resData);
        echo "</dt-ajax>";
    }
?>
<table id="<?php echo $this->name; ?>"
<?php 
    $attrs = $getMappedProperty($tableAttrs, [], $this->dataStore);
    foreach ($attrs as $k => $v) echo "$k='$v'";
    $cssClass = $getMappedProperty($tableCss, "table display", $this->dataStore);
    echo "class='$cssClass'"; 
    // echo ($tableCss)?" class='$tableCss'":" class='table display'"; 
?> >
    <thead>
        <?php if (! $this->complexHeaders) { ?>
        <tr>
        <?php
        foreach($showColumnKeys as $cKey)
        {
            $label = Util::get($cMetas,[$cKey, "label"], $cKey);
            $cMeta = Util::get($cMetas, $cKey, []);
        ?>
            <th <?php 
                $attrs = $getMappedProperty($thAttrs, [], $cKey, $cMeta);
                foreach ($attrs as $k => $v) echo "$k='$v'";
                $cssClass = $getMappedProperty($thClass, "", $cKey, $cMeta);
                echo "class='$cssClass'"; 
                // if($thClass){echo " class='".((gettype($thClass)=="string")?$thClass:$thClass($cKey, $cMeta))."'";} ?>>
                <?php echo $label; ?>
            </th>
        <?php    
        }
        ?>  
        </tr>  
    <?php } else {
        foreach ($headerRows as $aHeaderRow) {
            echo "<tr>";
            foreach ($aHeaderRow as $header) { 
                if (isset($header['text'])) { 
                    $text = $header['text']; 
                    $colspan = Util::get($header, 'colspan', 1); 
                    $rowspan = Util::get($header, 'rowspan', 1); 
                    // $class = is_callable($thClass) ? 
                    //     $thClass($text) : (is_string($thClass) ? 
                    //         $thClass : "");
                    $cssClass = $getMappedProperty($thClass, "", $text, []);
                    echo "<th class='$cssClass' colspan='$colspan' rowspan='$rowspan'>
                    $text</th>";
                } 
            }
            echo "</tr>";
        }
    } ?>
    </thead>
    <?php if (! $this->serverSide) { ?>
    <tbody>
        <?php
        $this->dataStore->popStart();
        while($row = $this->dataStore->pop())
        {
            $i=$this->dataStore->getPopIndex();
        ?>
            <tr <?php 
                $attrs = $getMappedProperty($trAttrs, [], $row, $cMetas);
                foreach ($attrs as $k => $v) echo "$k='$v'";
                $cssClass = $getMappedProperty($trClass, "", $row, $cMetas);
                echo "class='$cssClass'";
                // if($trClass){echo " class='".((gettype($trClass)=="string")?$trClass:$trClass($row, $cMetas))."'";} ?>>
            <?php
            foreach($showColumnKeys as $cKey)
            {
                $cMeta = Util::get($cMetas, $cKey, []);
            ?>
                <td <?php 
                    $attrs = $getMappedProperty($tdAttrs, [], $row, $cKey, $cMeta);
                    foreach ($attrs as $k => $v) echo "$k='$v'";
                    $cssClass = $getMappedProperty($tdClass, "", $row, $cKey, $cMeta);
                    echo "class='$cssClass'";
                    // if($tdClass)
                    //     echo "class='".
                    //         (gettype($tdClass)=="string"?$tdClass:$tdClass($row,$cKey,$cMeta))."'"; 
                    foreach (['data-order', 'data-search'] as $d)
                        if (isset($cMeta[$d]))
                            echo "$d='".Util::get($row, $cMeta[$d], '')."'";
                ?>>
                    <?php 
                        $formatValue = Util::get($cMeta,"formatValue",null);
                        $value = $cKey!=="#" ? Util::get($row, $cKey, $this->emptyValue) 
                            :($i+$cMeta["start"]);
                        if (isset($row[$cKey]) || is_callable($formatValue))
                            echo $this->formatValue($value,$cMeta,$row);
                        else
                            echo $this->emptyValue;
                    ?>
                </td>
            <?php    
            }
            ?>    
            </tr>
        <?php    
        }
        ?>
    </tbody>
    <?php } ?>
    <?php
    if($this->showFooter)
    {
    ?>
    <tfoot>
        <tr>
            <?php
            foreach($showColumnKeys as $cKey)
            {
                $cMeta = Util::get($cMetas, $cKey, []);
            ?>
                <td <?php 
                    $attrs = $getMappedProperty($tfAttrs, [], $cKey, $cMeta);
                    foreach ($attrs as $k => $v) echo "$k='$v'";
                    $cssClass = $getMappedProperty($tfClass, "", $cKey, $cMeta);
                    echo "class='$cssClass'";
                    // if($tfClass){echo " class='".((gettype($tfClass)=="string")?$tfClass:$tfClass($cKey, $cMeta))."'";} ?>>
                <?php
                $footerMethod = strtolower(Util::get($cMetas, [$cKey,"footer"]));
                $footerText = Util::get($cMetas, [$cKey,"footerText"]);
                $footerValue = null;
                switch($footerMethod)
                {
                    case "sum":
                    case "min":
                    case "max":
                    case "avg":
                        $footerValue = $this->dataStore->$footerMethod($cKey);
                    break;
                    case "count":
                        $footerValue = $this->dataStore->countData();
                    break;
                }
                $footerValue = ($footerValue!==null)?$this->formatValue($footerValue,$cMetas[$cKey]):"";
                if($footerText)
                {
                    echo str_replace("@value",$footerValue,$footerText);
                }
                else
                {
                    echo $footerValue;
                }
                ?>
                </td>
            <?php    
            }
            ?>
        </tr>
    </tfoot>
    <?php
    }
    ?>
</table>
<script type="text/javascript">
    KoolReport.widget.init(
        <?php echo json_encode($this->getResources()); ?>,
        function() {
            <?php $this->clientSideBeforeInit();?>

            var name = '<?php echo $this->name; ?>';
            var dt = window[name] = $('#' + name).DataTable(<?php echo ($this->options==array())?"":Util::jsonEncode($this->options); ?>);

            <?php if ($this->searchMode === 'or') { ?>
                function strToPhrases(str) {
                    var phrases = [];
                    str = str.replace(/"([^"]*)"/g, function(match, p1, offset, str) {
                        if (p1 !== "") phrases.push(p1);
                        return "";
                    });
                    str = str.replace(/[^\s\t]*/g, function(match, offset, str) {
                        if (match !== "") phrases.push(match);
                        return "";
                    });
                    return phrases;
                }

                function strToRegexStr(str) {
                    str = str.trim();
                    str = str.replace(/^\s*or\s+/gi, "");
                    str = str.replace(/\s+or\s*$/gi, "");
                    str = str.replace(/\sor\s/gi, " or ");
                    var searches = str.split(' or ');
                    var searchRegex = "^";
                    for (var i=0; i<searches.length; i+=1) {
                        var phrasesRegex = "";
                        var phrases = strToPhrases(searches[i]);
                        for (var j=0; j<phrases.length; j+=1) {
                            phrasesRegex += "(?=.*" + phrases[j] + ")";
                        }
                        phrasesRegex += ".+";
                        searches[i] = phrasesRegex;
                    }
                    searchRegex = searches.join('|');
                    return searchRegex;
                }
            <?php } ?>
            
            <?php if ($this->searchOnEnter) { ?>
                $('#' + name + '_filter input')
                .unbind()
                .bind('keydown', function (e) {
                    if(e.keyCode == 13) {
                        e.preventDefault(); //prevent form submit with enter input
                        <?php if ($this->searchMode === 'or' && ! $this->serverSide) { ?>
                            var value = $.fn.dataTable.util.escapeRegex(this.value);
                            searchRegex = strToRegexStr(value);
                            dt.search(searchRegex, true, false).draw();
                        <?php } else { ?>
                            dt.search(this.value).draw();
                        <?php } ?>
                    }
                })
                ;
            <?php } ?>

            <?php if (! $this->searchOnEnter && $this->searchMode === 'or') { ?>
                $('#' + name + '_filter input')
                .unbind()
                .bind('input', function (e) {
                    var value = $.fn.dataTable.util.escapeRegex(this.value);
                    searchRegex = strToRegexStr(value);
                    dt.search(searchRegex, true, false).draw();
                })
                ;
            <?php } ?>

            <?php if($this->clientEvents) {
                foreach($this->clientEvents as $eventName=>$function) { ?>
                    dt.on("<?php echo $eventName; ?>",<?php echo $function; ?>);
                <?php }
            } ?>
            <?php $this->clientSideReady();?>
        }
    );
</script>