var KoolReport = KoolReport || {};

KoolReport.PivotTable = KoolReport.PivotTable || (function () {

    var collapseClasses = ['far', 'fa-minus-square'];
    var expandClasses = ['far', 'fa-plus-square'];

    function findMatchedAncestor(el, selector) {
        while (el && ! el.matches(selector)) el = el.parentElement;
        return el;
    }

    function changeLayer(el, expand) {
        el.dataset.layer -= expand ? -1 : 1;
        if (expand && 1 * el.dataset.layer > 0)
            el.style.display = '';
        else if (!expand && 1 * el.dataset.layer < 1)
            el.style.display = 'none';
    }

    function toggleExpColIcon(icon) {
        collapseClasses.forEach(function(cls) {
            icon.classList.toggle(cls);
        });
        expandClasses.forEach(function(cls) {
            icon.classList.toggle(cls);
        });
        icon.dataset.command = icon.dataset.command === 'expand' ?
            'collapse' : 'expand';
    }
    
    function expandCollapseRow(e) {
        e.stopPropagation();
        var icon = e.currentTarget;
        var expand = icon.dataset.command === 'expand';
        var td = findMatchedAncestor(icon, 'td');
        var el = td.nextElementSibling;
        while (el) {
            this.changeLayer(el, expand);
            el = el.nextElementSibling;
        }
        el = td.parentElement;
        var i = 1;
        while (i < 1 * td.rowSpan) {
            el = el.nextElementSibling;
            for (var j = 0; j < el.children.length; j += 1) {
                var child = el.children[j];
                if (child.classList.contains('pivot-data-cell') &&
                    i === td.rowSpan - 1) {
                    child.classList.toggle('pivot-data-cell-row-total');
                    continue;
                }
                this.changeLayer(child, expand);
            }
            i += 1;
        }
        td.colSpan = expand ? 1 : this.numRowFields - td.dataset.rowField;
        toggleExpColIcon(icon);
    }
    
    function expandCollapseRowBun(e) {
        e.stopPropagation();
        var icon = e.currentTarget;
        var expand = icon.dataset.command === 'expand';
        var td = findMatchedAncestor(icon, 'td');
        var el = td.nextElementSibling;
        while (el) {
            el.classList.toggle('pivot-data-cell-row-total');
            el = el.nextElementSibling;
        }
        td.classList.toggle('pivot-row-header-total', expand);
        tr = td.parentElement;
        var i = 1;
        while (i < 1*td.dataset.numChildren) {
            tr = tr.nextElementSibling;
            for (var j = 0; j<tr.children.length; j+=1) {
                var child = tr.children[j];
                this.changeLayer(child, expand);
            }
            i += 1;
        }
        toggleExpColIcon(icon);
    }
    
    function expandCollapseColumn(e) {
        var icon = e.currentTarget;
        var expand = icon.dataset.command === 'expand';
        var td = findMatchedAncestor(icon, 'td');
        var rangeLeft = 1 * td.dataset.columnIndex;
        var numChildren = 1 * td.dataset.numChildren;
        var rangeRight = rangeLeft + numChildren / this.numDataFields;
    
        // var numDf = this.numDataFields;
        // var colspan = this.hideSubtotalColumn ?
        //     numChildren - numDf : numChildren;
        // td.colSpan = expand ? colspan : numDf;
    
        var el = td.parentElement;
        el = el.nextElementSibling;
        while (el) {
            var children = el.children;
            for (var i = 0; i < children.length; i += 1) {
                var child = children[i];
                var columnIndex = 1 * child.dataset.columnIndex;
                if (child.classList.contains('pivot-data-header') &&
                    columnIndex === rangeRight - 1) {
                    child.classList.toggle('pivot-data-header-total');
                    child.colSpan = expand ? 1 : td.colSpan/this.numDataFields;
                } else if (child.classList.contains('pivot-data-cell') &&
                    columnIndex === rangeRight - 1) {
                    child.classList.toggle('pivot-data-cell-column-total');
                    child.colSpan = expand ? 1 : td.colSpan/this.numDataFields;
                } else if (rangeLeft <= columnIndex && columnIndex < rangeRight)
                    this.changeLayer(child, expand);
            }
            el = el.nextElementSibling;
        }
        td.rowSpan = expand ? 1 : this.numColFields - td.dataset.columnField;
        toggleExpColIcon(icon);
    }
    
    function showHideColumn(td, show) {
        var rangeLeft = 1 * td.dataset.columnIndex;
        var rangeRight = rangeLeft + 1 * td.colSpan / this.numDataFields;
        var el = td.parentElement;
        el = el.nextElementSibling;
        while (el) {
            var children = el.children;
            for (var i = 0; i < children.length; i += 1) {
                var child = children[i];
                var columnIndex = 1 * child.dataset.columnIndex;
                if (rangeLeft <= columnIndex && columnIndex < rangeRight)
                    this.changeLayer(child, show);
            }
            el = el.nextElementSibling;
        }
        this.changeLayer(td, show);
    }

    function getParentHeaderOfTotal(type, header) {
        if (type === 'rowBun') return header;
        var attrFullType = type === 'column' ? 'column' : 'row';
        var childOrder = header.dataset.childOrder;
        var parentOrder = childOrder.substr(0, childOrder.lastIndexOf('.'));
        // var parentHeader = this.pivotEl.querySelector(
        //     '.pivot-' + attrFullType + '-header[data-child-order="' +  parentOrder + '"]'
        // );
        // return parentHeader;

        // var attrFullType = type === 'column' ? 'column' : 'row';
        // var fieldNum = 1*header.dataset[attrFullType + 'Field'];
        // var tr = header.parentElement;
        // while (tr = tr.previousElementSibling) {
        //     for (var i=0; i<tr.children.length; i+=1) {
        //         var child = tr.children[i];
        //         if (1*child.dataset[attrFullType + 'Field'] === fieldNum) {
        //             return child;
        //         }
        //     }
        // }
    }

    function toggleHeaderSelected(type, header, selected) {
        var set = header.dataset;
        var attrType = type === 'column' ? 'col' : 'row';
        var attrFullType = type === 'column' ? 'column' : 'row';
        var index = 1*set[attrFullType + 'Index'];
        var spanNum = 1*header[attrType + 'Span'];
        if (type === 'column') spanNum = spanNum / this.numDataFields;
        if (spanNum > 1) {
            header.classList.toggle('pivot-' + attrFullType + '-selected', selected);
            index += spanNum - 1;
        }
        var fieldNum = 1*set[attrFullType + 'Field'];
        var tds = this.pivotEl.querySelectorAll(
            '[data-' + attrFullType + '-index="' + index + '"]' + 
            '[data-' + attrFullType + '-field="' + fieldNum + '"]'
        );
        tds.forEach(function(td) {
            td.classList.toggle('pivot-' + attrFullType + '-selected', selected);
        });
        return tds;
    }

    function selectHeader(type, header, shiftKey, ctrlKey) {
        var set = header.dataset;
        var attrType = type === 'column' ? 'Col' : 'Row';
        var attrFullType = type === 'column' ? 'column' : 'row';
        this['selected' + attrType + 'Headers'] = 
            this['selected' + attrType + 'Headers'] || [];
        var selected = this['selected' + attrType + 'Headers'];
        
        if (header.classList.contains('pivot-data-header')) {
            var colField = set.columnField;
            var colIndex = set.columnIndex
            header = this.pivotEl.querySelector(
                '.pivot-column-header[data-column-index="' +  colIndex + '"]' +
                '[data-column-field="' + colField + '"]'
            );
        }
        if (header.classList.contains('pivot-' + attrFullType + '-header-total')) {
            header = this.getParentHeaderOfTotal(type, header);
        }
        var fieldNum = 1*set[attrFullType + 'Field'];
        var lastHeader = this['lastClicked' + attrType + 'Header'];
        var lastFieldNum = lastHeader ? 
            1*lastHeader.dataset[attrFullType + 'Field'] : fieldNum;

        //if clicking a header with a different col field
        if (fieldNum !== lastFieldNum) {
            //deselect all previous selected headers
            selected.forEach(function(aHeader) {
                this.toggleHeaderSelected(type, aHeader, false);
            }.bind(this));
            selected = [header];
            this['lastClicked' + attrType + 'Header'] = header;
            this.toggleHeaderSelected(type, header, true);
        } 
        //if clicking a header with the same col field
        else if (shiftKey) {
            //sort col index and last col index to min, max
            var index = 1*set[attrFullType + 'Index'];
            var lastIndex = lastHeader ? 
                1*lastHeader.dataset[attrFullType + 'Index'] : 0;
            var min = index;
            var max = lastIndex;
            [min, max] = min > max ? [max, min] : [min, max];
            //if no ctrl key, deselect all previous selected headers
            if (! ctrlKey) {
                selected.forEach(function(aHeader) {
                    this.toggleHeaderSelected(type, aHeader, false);
                }.bind(this));
                selected = [];
            }
            //select all cols of the same col field from last col index to 
            //the clicked col index
            for (var i=min; i<=max; i+=1) {
                var aHeader = this.pivotEl.querySelector(
                    '.pivot-' + attrFullType + '-header[data-' + attrFullType + '-index="' 
                    + i + '"][data-' + attrFullType + '-field="' + fieldNum + '"]'
                );
                if (! aHeader) continue;
                if (selected.indexOf(aHeader) === -1) {
                    selected.push(aHeader);
                }
                this.toggleHeaderSelected(type, aHeader, true);
            }
        } else if (ctrlKey) {
            //add or remove clicked header to previous selected headers
            var index = selected.indexOf(header);
            index === -1 ? selected.push(header) : selected.splice(index, 1);
            this['lastClicked' + attrType + 'Header'] = header;
            this.toggleHeaderSelected(type, header);
        } else {
            //deselect all previous selected col header
            selected.forEach(function(aHeader) {
                this.toggleHeaderSelected(type, aHeader, false);
            }.bind(this));
            selected = [header];
            this['lastClicked' + attrType + 'Header'] = header;
            this.toggleHeaderSelected(type, header, true);
        }
        this['selected' + attrType + 'Headers'] = selected;
    }

    function selectDataCell(dataCell, shiftKey, ctrlKey) {
        var set = dataCell.dataset;
        var rowHeader = this.pivotEl.querySelector(
            '.pivot-row-header[data-row-index="' + set.rowIndex + '"]' +
            '[data-row-field="' + set.rowField + '"]'
        );
        var colHeader = this.pivotEl.querySelector(
            '.pivot-column-header[data-column-index="' + set.columnIndex + '"]' +
            '[data-column-field="' + set.columnField + '"]'
        );
        var rowType = this.template === 'PivotTable-Bun' ? 'rowBun' : 'row';
        this.selectHeader(rowType, rowHeader, shiftKey, ctrlKey);
        this.selectHeader('column', colHeader, shiftKey, ctrlKey);
    }

    function rowHeaderClickListener(e) {
        console.log('click row', e.target.dataset.rowIndex);
        var rowHeader = e.target;
        var evtResult = this.fireEvent('beforeSelected', rowHeader, e.shiftKey, e.ctrlKey);
        if (evtResult === false) return;
        this.selectHeader('row', rowHeader, e.shiftKey, e.ctrlKey);
        this.fireEvent('selected', this.getSelectedTable());
    }

    function rowHeaderBunClickListener(e) {
        console.log('click row', e.target.dataset.rowIndex);
        var rowHeader = e.target;
        var evtResult = this.fireEvent('beforeSelected', rowHeader, e.shiftKey, e.ctrlKey);
        if (evtResult === false) return;
        this.selectHeader('rowBun', rowHeader, e.shiftKey, e.ctrlKey);
        this.fireEvent('selected', this.getSelectedTable());
    }

    function colHeaderClickListener(e) {
        console.log('click column', e.target.dataset.columnIndex);
        var colHeader = e.target;
        var evtResult = this.fireEvent('beforeSelected', colHeader, e.shiftKey, e.ctrlKey);
        if (evtResult === false) return;
        this.selectHeader('column', colHeader, e.shiftKey, e.ctrlKey);
        this.fireEvent('selected', this.getSelectedTable());
    }

    function dataCellClickListener(e) {
        var set = e.target.dataset;
        console.log('click data cell', set.rowIndex, '-', set.columnIndex);
        var dataCell = e.target;
        var evtResult = this.fireEvent('beforeSelected', dataCell, e.shiftKey, e.ctrlKey);
        if (evtResult === false) return;
        this.selectDataCell(dataCell, e.shiftKey, e.ctrlKey);
        this.fireEvent('selected', this.getSelectedTable());
    }

    function stopSelectListener(e) {
        if (e.shiftKey) e.preventDefault();
    }

    function getSelectedTable() {
        // var rowHeaders = this.selectedRowHeaders || [];
        // rowHeaders.sort(function(a, b) {
        //     return 1*a.dataset.rowIndex - 1*b.dataset.rowIndex;
        // });
        // var colHeaders = this.selectedColHeaders || [];
        // colHeaders.sort(function(a, b) {
        //     return 1*a.dataset.columnIndex - 1*b.dataset.columnIndex;
        // });
        var rowHeaders = this.pivotEl.querySelectorAll(
            '.pivot-row-header.pivot-row-selected' + 
            ':not([data-value="{{all}}"])'
        );
        var dataHeaders = this.pivotEl.querySelectorAll(
            '.pivot-data-header.pivot-column-selected'
        );
        if (dataHeaders.length === 0) {
            dataHeaders = this.pivotEl.querySelectorAll(
                '.pivot-column-header.pivot-column-selected' + 
                ':not([data-value="{{all}}"])'
            );
        }
        
        if (rowHeaders.length === 0 || dataHeaders.length === 0) return [];
        var selectedTable = [];
        var rowField = 1*rowHeaders[0].dataset.rowField;
        var row = rowField > -1 ? [this.rowFields[rowField]] : ['Total'];
        dataHeaders.forEach(function(v) {
            row.push(v.dataset.fullText);
        });
        selectedTable.push(row);

        for (var i=0; i<rowHeaders.length; i+=1) {
            var rowHeader = rowHeaders[i]; 
            var rowIndex = 1*rowHeader.dataset.rowIndex;
            var rowSpan = 1*rowHeader.rowSpan;
            rowIndex += rowSpan - 1;
            var selectedCells = this.pivotEl.querySelectorAll(
                '.pivot-data-cell.pivot-row-selected.pivot-column-selected' +
                '[data-row-index="' + rowIndex + '"]'
            );
            var row = [rowHeader.dataset.fullText];
            selectedCells.forEach(function(v) {
                row.push(1*v.dataset.value);
            });
            selectedTable.push(row);
        }

        return selectedTable;
    }

    function drawChart(data) {
        var chartPanel = this.pivotEl.querySelector('.chart-panel');
        if (data.length === 0 || data[0].length === 0) {
            chartPanel.style.display = 'none';
            chartPanel.parentElement.style.visibility = 'hidden';
            return; 
        }
        chartPanel.style.display = '';
        chartPanel.parentElement.style.visibility = '';
        google.charts.load('current', {'packages':['corechart']});
        var drawChart = function() {
            data = google.visualization.arrayToDataTable(data);
            var options = {
                // 'title':'',
                'width': this.pivotEl.offsetWidth * 2/3,
                'height': this.pivotEl.offsetWidth * 1 / 2,
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.ColumnChart(chartPanel);
            chart.draw(data, options);
        }.bind(this);
        google.charts.setOnLoadCallback(drawChart);
    }

    function fireEvent(evtName) {
        var args = [].slice.call(arguments, 1);
        var handler = this.clientEvents[evtName];
        if (typeof handler === 'string' && typeof window[handler] === 'function') {
            handler = window[handler];
        }
        if (typeof handler === 'function') {
            handler.apply(this, args);
        }
    }

    function create(piTbl_data) {
        var piTbl = piTbl_data;
        piTbl.init = init;
        piTbl.changeLayer = changeLayer;
        piTbl.expandCollapseRow = expandCollapseRow;
        piTbl.expandCollapseRowBun = expandCollapseRowBun;
        piTbl.expandCollapseColumn = expandCollapseColumn;
        piTbl.showHideColumn = showHideColumn;
        piTbl.rowHeaderClickListener = rowHeaderClickListener;
        piTbl.rowHeaderBunClickListener = rowHeaderBunClickListener;
        piTbl.colHeaderClickListener = colHeaderClickListener;
        piTbl.dataCellClickListener = dataCellClickListener;
        piTbl.stopSelectListener = stopSelectListener;
        piTbl.selectHeader = selectHeader;
        piTbl.selectDataCell = selectDataCell;
        piTbl.getParentHeaderOfTotal = getParentHeaderOfTotal;
        piTbl.toggleHeaderSelected = toggleHeaderSelected;
        piTbl.getSelectedTable = getSelectedTable;
        piTbl.drawChart = drawChart;
        piTbl.fireEvent = fireEvent;
        piTbl.init();
        return piTbl;
    }

    function init() {
        this.numRowFields = this.rowFields.length;
        this.numColFields = this.colFields.length;
        this.numDataFields = this.dataFields.length;
        var pivot = this.pivotEl = document.getElementById(this.id);

        var tds = pivot.getElementsByClassName('pivot-row-header');
        var expandCollapseFunc = 'expandCollapseRow';
        var selectRowFunc = 'rowHeaderClickListener';
        if (this.template === 'PivotTable-Bun') {
            expandCollapseFunc = 'expandCollapseRowBun';
            selectRowFunc = 'rowHeaderBunClickListener';
        }
        for (var i=0; i<tds.length; i+=1) {
            var td = tds[i];
            if (this.selectable) {
                td.addEventListener('mousedown', this.stopSelectListener);
                td.addEventListener('click', this[selectRowFunc].bind(this));
            }
            var icon = td.querySelector('.pivot-exp-col');
            if (! icon) continue;
            icon.addEventListener('click', this[expandCollapseFunc].bind(this));
        }
        for (var j = 0; j < this.rowCollapseLevels.length; j += 1) {
            var rowLevel = this.rowCollapseLevels[j];
            for (var i = 0; i < tds.length; i += 1) {
                var td = tds[i];
                if (td.dataset.rowField != rowLevel)
                    continue;
                var icon = td.querySelector('.pivot-exp-col');
                if (icon && icon.dataset.command === 'collapse')
                    icon.click();
            }
        }

        tds = pivot.getElementsByClassName('pivot-column-header');
        var expandCollapseFunc = 'expandCollapseColumn';
        var selectColFunc = 'colHeaderClickListener';
        for (var j=0; j<tds.length; j+=1) {
            var td = tds[j];
            if (this.selectable) {
                td.addEventListener('mousedown', this.stopSelectListener);
                td.addEventListener('click', this[selectColFunc].bind(this));
            }
            var icon = td.querySelector('.pivot-exp-col');
            if (! icon) continue;
            icon.addEventListener('click', this[expandCollapseFunc].bind(this));
        }
        for (var j = 0; j < this.colCollapseLevels.length; j += 1) {
            var colLevel = this.colCollapseLevels[j];
            for (var i = 0; i < tds.length; i += 1) {
                var td = tds[i];
                if (td.dataset.columnField != colLevel)
                    continue;
                var icon = td.querySelector('.pivot-exp-col');
                if (icon && icon.dataset.command === 'collapse')
                    icon.click();
            }
        }

        tds = pivot.getElementsByClassName('pivot-data-header');
        for (var j=0; j<tds.length; j+=1) {
            var td = tds[j];
            if (this.selectable) {
                td.addEventListener('mousedown', this.stopSelectListener);
                td.addEventListener('click', this[selectColFunc].bind(this));
            }
        }

        tds = pivot.getElementsByClassName('pivot-data-cell');
        for (var j=0; j<tds.length; j+=1) {
            var td = tds[j];
            if (this.selectable) {
                td.addEventListener('mousedown', this.stopSelectListener);
                td.addEventListener('click', this.dataCellClickListener.bind(this));
            }
        }

        pivot.style.visibility = 'visible';
    }

    return {
        create: create,
    };

})();

