var KoolReport = KoolReport || {};
KoolReport.PivotMatrix = KoolReport.PivotMatrix || (function(global){

    var collapseClasses = ['far', 'fa-minus-square'];
    var expandClasses = ['far', 'fa-plus-square'];

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

    function findMatchedAncestor(el, selector) {
        while (el && ! el.matches(selector)) el = el.parentElement;
        return el;
    }

    function simpleExtend (dest, src) {
        for (var p in src)
            if (src.hasOwnProperty(p))
                dest[p] = src[p];
    }

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    var pivotFunctions = (function() {

        var loadConfig = function() {
            this.config = JSON.parse(this.configEl.value);
        }

        var saveConfig = function() {
            this.configEl.value = JSON.stringify(this.config);
        }

        var loadViewstate = function() {
            this.viewstate = JSON.parse(this.viewstateEl.value);
        }

        var saveViewstate = function() {
            this.saveScroll();
            this.viewstateEl.value = JSON.stringify(this.viewstate);
        }

        var saveCommand = function() {
            this.commandEl.value = JSON.stringify(this.command);
        }

        function setAndExecute(wrappingEl, innerHTML)
        {
            wrappingEl.innerHTML = innerHTML;
            var x = wrappingEl.getElementsByTagName("script"); 
            for(var i=0; i<x.length; i++)
                eval(x[i].text);
        }

        function convertObjToPostStr(args) {
            var postStr = "";
            for (var p in args)
                if (args.hasOwnProperty(p)) {
                    if (typeof args[p] === 'object')
                        postStr += '&' + p + '=' 
                            + encodeURIComponent(JSON.stringify(args[p]));
                    else
                        postStr += '&' + p + '=' + encodeURIComponent(args[p]);
                }
            return postStr.substr(1);
        }
		
		function myEncodeURIComponent(v) {
			return  (typeof v === 'string') ? encodeURIComponent(v) : v;
		}

        function convertScopeToPostStr(scope) {
            var postStr = "";
            for (var p in scope)
                if (scope[p] instanceof Array) {
                    for (var i=0; i<scope[p].length; i+=1)
                        if (scope[p][i] !== null && scope[p][i] !== false)
                            postStr += '&' + p + '[]=' + encodeURIComponent(scope[p][i]);
                }
                else if (scope[p] !== null && scope[p] !== false)
                    postStr += '&' + p + '=' + encodeURIComponent(scope[p]);
            return postStr.substr(1);
        }

        var updateScope = function(name, data) {
            this.scope[name] = data;
        };

        var update = function(func) {
            var pivotEl = this.pivotEl;
            var disablerEl = pivotEl.querySelector("#krpmDisabler");
            disablerEl.style.position = 'absolute';
            disablerEl.style.height = pivotEl.offsetHeight + 'px';
            disablerEl.style.width = pivotEl.offsetWidth + 'px';
            disablerEl.style.top = pivotEl.offsetTop + 'px';
            disablerEl.style.left = pivotEl.offsetLeft + 'px';
            disablerEl.style.display = "";

            var id = this.config.pivotMatrixId;
            var args = {
                koolPivotUpdate: true,
                koolPivotConfig: this.config,
                koolPivotViewstate: this.viewstate,
                koolPivotCommand: this.command,
            };
            // for (var p in this.scope)
                // if (this.scope.hasOwnProperty(p))
                    // args[p] = this.scope[p];
            
            var oReq = new XMLHttpRequest();
            oReq.addEventListener("load", function() {
                if (oReq.status >= 200 && oReq.status < 400) {
                    var wrappingEl = document.querySelector('#' + id);
                    var text = oReq.responseText;
                    var startString = "<pivotmatrix id='" + id + "'>";
                    var endString = "</pivotmatrix>";
                    var start = text.indexOf(startString);
                    var updateText = text.substring(start + startString.length, text.length - endString.length);
                    setAndExecute(wrappingEl, updateText);
                    this.fireEvent('afterUpdate', {pivot: this});
                    if (typeof func === 'function') func();
                } else {
                    // We reached our target server, but it returned an error
                }
            }.bind(this));

            oReq.open('POST', global.location.href, true);
            oReq.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            args.partialRender = true;
            oReq.send(convertObjToPostStr(args) + '&' 
                + convertScopeToPostStr(this.scope));
            // oReq.setRequestHeader("Content-Type", "application/json");
            // oReq.send(JSON.stringify(args));
			
			// $.ajax({
				 // type: "POST",
				 // url: global.location.href,
				 // data: { data: JSON.stringify(args) },
				 // // contentType: "application/json",
				 // // dataType: "json",
				 // success: function(text) {
					// var wrappingEl = document.querySelector('#' + id);
                    // // var text = oReq.responseText;
                    // var startString = "<pivotmatrix id='" + id + "'>";
                    // var endString = "</pivotmatrix>";
                    // var start = text.indexOf(startString);
                    // var updateText = text.substring(start + startString.length, text.length - endString.length);
                    // setAndExecute(wrappingEl, updateText);
                    // this.fireEvent('afterUpdate', {pivot: this});
                    // if (typeof func === 'function') func();
				 // }
			// });
        }

        var init = function(initProp) {
            simpleExtend(this, initProp);
            // KoolReport.extend(this, initProp);
            var pivotEl = this.pivotEl = document.getElementById(this.uniqueId);
            this.configEl = pivotEl.querySelector('.krpmConfig');
            this.viewstateEl = pivotEl.querySelector('.krpmViewstate');
            this.commandEl = pivotEl.querySelector('.krpmCommand');
            this.loadViewstate();
            this.loadConfig();
            this.scope = JSON.parse(pivotEl.querySelector('.krpmScope').value);
            this.command = {
                column: {},
                row: {}
            };
            config = this.config;
            viewstate = this.viewstate;
            this.pageNum = viewstate.paging ? viewstate.paging.page : null;
            this.numDataFields = config.dataFields.length;
            this.numColumnFields = config.columnFields.length;
            this.numRowFields = config.rowFields.length;

            if (! this.eventHandlers) this.eventHandlers = {};
            for (var p in this.clientEvents)
                this.registerEvent(p, this.clientEvents[p]);

            // this.registerEvent('fieldMove', function(args){
            //     var pivot = args.pivot;
            //     var uniqueId = pivot.uniqueId;
            //     pivot.update(function(){
            //         // console.log('after field move');
            //         var newPivot = KoolReport[uniqueId];
            //         args.pivot = newPivot;
            //         newPivot.fireEvent('afterFieldMove', args);
            //     });
            // });

            var menuItemClickListener = function(ev) {
                var menuItemEl = ev.currentTarget;
                if (menuItemEl.classList.contains('krpmDisableMenu'))
                    return;

                var ds = this.lastMenuField.dataset;
                var command = menuItemEl.dataset.command;
                switch (command) {
                    case 'expand':
                    case 'collapse':
                        var zone = ds.fieldType;
                        var level = ds.fieldOrder;
                        this.batchExpandCollapse(zone, level, command);
                        break;
                    case 'sort-asc':
                    case 'sort-desc':
                    case 'sort-asc-row':
                    case 'sort-desc-row':
                    case 'sort-asc-column':
                    case 'sort-desc-column':
                        var args = command.split('-');
                        var zone = args[2] ? args[2] : ds.fieldType; 
                        var name = ds.fieldName;
                        var sort = this.config[zone + 'Sort'];
                        if (sort instanceof Array) sort = {};
                        for (var p in sort)
                            if (this.config.dataFields.indexOf(p) > -1)
                                sort[p] = 'ignore';
                        sort[name] = args[1];
                        break;
                    default: break;
                }
            
                this.lastMenuField = null;
                var fieldMenuEl = findMatchedAncestor(menuItemEl, '.krpmFieldMenu');
                fieldMenuEl.style.display = 'none';

                if (command.indexOf('sort') > - 1) {
                    this.saveViewstate();
                    this.update();
                }
            };

            var menuItemEls = pivotEl.querySelectorAll('.krpmMenuItem');
            for (var i=0; i<menuItemEls.length; i+=1)
                menuItemEls[i].addEventListener('click', menuItemClickListener.bind(this));

            var fieldMenuEls = pivotEl.querySelectorAll('.krpmFieldMenu');
            for (var i=0; i<fieldMenuEls.length; i+=1)
                fieldMenuEls[i].addEventListener('blur', function(ev) {
                    if (this.lastMouseDownMenuField !== this.lastMenuField) {
                        this.lastMenuField = null;
                        ev.target.style.display = 'none';
                    }
                }.bind(this));

            var dropDownEls = pivotEl.querySelectorAll('.krpmDropDown');
            for (var i=0; i<dropDownEls.length; i+=1) {
                dropDownEls[i].addEventListener(
                    'click', this.dropDownClickHandler.bind(this));         
                dropDownEls[i].addEventListener(
                    'mousedown', function(ev) {
                        this.lastMouseDownMenuField = ev.target.parentElement;
                    }.bind(this));   
            }
            
            var fieldDrops = pivotEl.querySelectorAll(
                '.krpmFieldDropContainer, .krpmFieldDrop');
            for (var i=0; i<fieldDrops.length; i+=1) {
                var fDrops = fieldDrops[i];
                fDrops.addEventListener('drop', 
                    this.dropHandler.bind(this));
                fDrops.addEventListener('dragover', 
                    this.dragOverHandler.bind(this));
                fDrops.addEventListener('dragenter', 
                    this.dragEnterHandler.bind(this));
                fDrops.addEventListener('dragleave', 
                    this.dragLeaveHandler.bind(this));
            }
            
            var fields = pivotEl.querySelectorAll('.krpmField');
            for (var i=0; i<fields.length; i+=1) {
                var field = fields[i];
                field.setAttribute('draggable', true);
                field.addEventListener('dragstart', 
                    this.dragStartHandler.bind(this));
            }

            if (viewstate.paging) {
                var paging = viewstate.paging;
                this.numRow = this.getNumRow();

                var paginationEl = document.querySelector('#' + this.uniqueId + ' #krpmPagination');
                this.pagination = KoolReport.newPagination(paginationEl, {
                    currentPage: this.pageNum,
                    numItems: this.numRow,
                    pageSize: paging.size,
                    maxDisplayedPages: paging.maxDisplayedPages,
                    onPageClick: function(pageNum) {
                        // console.log(pageNum);
                        this.saveViewstate();
                        this.showPage(pageNum);
                    }.bind(this),
                });
    
                var pageSizeSelect = document.querySelector('#' + this.uniqueId + ' #krpmPageSizeSelect');
                for (var i=0; i<viewstate.paging.sizeSelect.length; i+=1) {
                    var option = document.createElement('option');
                    option.value = option.textContent
                        = viewstate.paging.sizeSelect[i];
                    pageSizeSelect.appendChild(option);
                }
                pageSizeSelect.value = viewstate.paging.size;
                pageSizeSelect.addEventListener('change', function(ev) {
                    this.updatePageSize(pageSizeSelect.value);
                    this.saveViewstate();
                    this.showPage(this.pageNum);
                }.bind(this));
            }
            else
                pivotEl.querySelector('.krpmTrFooter').style.display = 'none';

            var tds = pivotEl.querySelectorAll('.krpmRowHeader');
            var expandCollapseFunc = 'expandCollapseRow';
            if (this.template === 'PivotMatrix-Bun') {
                expandCollapseFunc = 'expandCollapseRowBun';
            }
            for (var i=0; i<tds.length; i+=1) {
                var icon = tds[i].querySelector('.krpmExpCol');
                if (! icon) continue;
                icon.addEventListener('click', this[expandCollapseFunc].bind(this));
            }
            var tds = pivotEl.querySelectorAll('.krpmColumnHeader');
            var expandCollapseFunc = 'expandCollapseColumn';
            for (var i=0; i<tds.length; i+=1) {
                var icon = tds[i].querySelector('.krpmExpCol');
                if (! icon) continue;
                icon.addEventListener('click', this[expandCollapseFunc].bind(this));
            }
        
            this.batchCollapseTree('row');
            this.batchCollapseTree('column');

            for (var i = 0; i < this.rowCollapseLevels.length; i+=1) {
                if (this.isUpdate) continue;
                var level = this.rowCollapseLevels[i];
                var headers = this.pivotEl.querySelectorAll(
                    '.krpmRowHeader[data-row-field="' + level + '"]');
                for (var j=0; j<headers.length; j+=1) {
                    var icon = headers[j].querySelector('.krpmExpCol');
                    if (icon && icon.dataset.command === 'collapse')
                        icon.click();
                }
            }
            for (var i = 0; i < this.columnCollapseLevels.length; i+=1) {
                if (this.isUpdate) continue;
                var level = this.columnCollapseLevels[i];
                var headers = this.pivotEl.querySelectorAll(
                    '.krpmColumnHeader[data-column-field="' + level + '"]');
                for (var j=0; j<headers.length; j+=1) {
                    var icon = headers[j].querySelector('.krpmExpCol');
                    if (icon && icon.dataset.command === 'collapse')
                        icon.click();
                }
            }

            var columnHeaderZoneDiv = pivotEl.querySelector('.krpmColumnHeaderZoneDiv');
            var rowHeaderZoneDiv = pivotEl.querySelector('.krpmRowHeaderZoneDiv');
            var dataZoneDiv = pivotEl.querySelector('.krpmDataZoneDiv');
            dataZoneDiv.addEventListener('scroll', function(ev) {
                rowHeaderZoneDiv.scrollTop = dataZoneDiv.scrollTop;
                columnHeaderZoneDiv.scrollLeft = dataZoneDiv.scrollLeft;
            }.bind(this));
            
            rowHeaderZoneDiv.addEventListener("wheel", function (e) {
                var oldScrollTop = rowHeaderZoneDiv.scrollTop;
                rowHeaderZoneDiv.scrollTop += e.deltaY  / 3;
                dataZoneDiv.scrollTop += e.deltaY  / 3;
                
                if (oldScrollTop != rowHeaderZoneDiv.scrollTop)
                    e.preventDefault();
            }.bind(this));
            
            this.showPage(this.pageNum);

            setTimeout(function() { 
                pivotEl.style.visibility = 'visible';
                pivotEl.classList.add('fadeIn');
            }, 0);
        };

        var getNumRow = function() {
            var numRow = 0;
            var rowEls = this.pivotEl.querySelectorAll('.krpmRowHeaderZone .krpmRow');
            for (var i=0; i<rowEls.length; i+=1) {
                var td = rowEls[i].firstElementChild;
                if (td && td.dataset.rowLayer > 0)
                    numRow += 1;
            }
            return numRow;
        };

        var updatePageSize = function(pageSize) {
            this.viewstate.paging.size = pageSize;
            var numRow = this.numRow = this.getNumRow();
            var maxNumRow = Math.ceil(numRow / pageSize);
            if (this.pageNum > maxNumRow) {
                this.pageNum = maxNumRow;
            }
            this.pagination.change('pageSize', pageSize);
        };

        var saveScroll = function() {
            var dataZoneDiv = this.pivotEl.querySelector('.krpmDataZoneDiv');
            if (dataZoneDiv.scrollHeight !== dataZoneDiv.clientHeight)
                this.viewstate.scrollTopPercentage = 100 * dataZoneDiv.scrollTop / (dataZoneDiv.scrollHeight-dataZoneDiv.clientHeight);
            if (dataZoneDiv.scrollWidth !== dataZoneDiv.clientWidth)
                this.viewstate.scrollLeftPercentage = 100 * dataZoneDiv.scrollLeft / (dataZoneDiv.scrollWidth-dataZoneDiv.clientWidth);
        };

        var restoreScroll = function() {
            var pivotEl = this.pivotEl;
            var dataZoneDiv = pivotEl.querySelector('.krpmDataZoneDiv');
            dataZoneDiv.scrollTop = (dataZoneDiv.scrollHeight-dataZoneDiv.clientHeight) * this.viewstate.scrollTopPercentage / 100 ;
            dataZoneDiv.scrollLeft = (dataZoneDiv.scrollWidth-dataZoneDiv.clientWidth) * this.viewstate.scrollLeftPercentage / 100 ;
        };

        var updateNumRow = function() {
            if (! this.viewstate.paging)
                return;
            var numRow = this.numRow = this.getNumRow();
            var pageSize = this.viewstate.paging.size;
            var maxNumRow = Math.ceil(numRow / pageSize);
            if (this.pageNum > maxNumRow) 
                this.pageNum = maxNumRow;
            this.pagination.change('numItems', numRow);
        };

        var fixSize = function() {
            //The first line stops table height from jumping when changing page
            this.fixColumnWidth(); 
            setTimeout(function() {
                this.fixColumnWidth();
                this.restoreScroll();
            }.bind(this), 0);
        };

        var fixColumnWidth = function() {
            var isFirefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
            var pivotEl = this.pivotEl;
            var disablerEl = pivotEl.querySelector('#disabler');
            var waitingFieldZone = pivotEl.querySelector('.krpmWaitingFieldZone');
            var dataFieldZone = pivotEl.querySelector('.krpmDataFieldZone');
            var columnFieldZone = pivotEl.querySelector('.krpmColumnFieldZone');
            var dataFieldZone = pivotEl.querySelector('.krpmDataFieldZone');
            var columnHeaderZone = pivotEl.querySelector('.krpmColumnHeaderZone');
            var columnHeaderZoneDiv = pivotEl.querySelector('.krpmColumnHeaderZoneDiv');
            var rowHeaderZoneDiv = pivotEl.querySelector('.krpmRowHeaderZoneDiv');
            var dataZone = pivotEl.querySelector('.krpmDataZone');
            var dataZoneDiv = pivotEl.querySelector('.krpmDataZoneDiv');
            var pivotFooter = pivotEl.querySelector('.krpmFooter');

            var columnHeaderZoneTable = columnHeaderZoneDiv.querySelector('table');
            var rowHeaderZoneTable = rowHeaderZoneDiv.querySelector('table');
            var dataZoneTable = dataZoneDiv.querySelector('table');
            // columnHeaderZoneTable.style.tableLayout = 'auto';
            // dataZoneTable.style.tableLayout = 'auto';

            waitingFieldZone.style.height = dataFieldZone.style.height = columnFieldZone.style.height = 'auto';
            // columnHeaderZoneDiv.style.width = dataZoneDiv.style.width = 'auto';
            columnHeaderZoneDiv.style.overflowY = '';
            columnHeaderZoneTable.style.height = 'auto';
            columnHeaderZoneDiv.style.height = '100%';
            // setTimeout(function() {
                // if (isFirefox)
                columnHeaderZoneDiv.style.height = columnHeaderZone.offsetHeight + 'px';
                // columnHeaderZoneDiv.style.height = columnHeaderZoneDiv.offsetHeight + 1 + 'px';
                columnHeaderZoneTable.style.height = columnHeaderZoneDiv.offsetHeight + 2 + 'px'; 
            // }, 10);
            columnHeaderZoneDiv.style.width = dataZoneDiv.style.width = 'auto';
            rowHeaderZoneDiv.style.height = dataZoneDiv.style.height = 'auto';

            var columnColGroup = columnHeaderZoneDiv.querySelectorAll('col');
            var dataColGroup = dataZoneDiv.querySelectorAll('col');
            var dataRowEls = dataZoneDiv.querySelectorAll('.krpmRow');
            for (var i=0; i<dataRowEls.length; i+=1)
                for (var j=0; j<dataRowEls[i].children.length; j+=1)
                    if (dataRowEls[i].children[j].style.display !== 'none') {
                        var dataRowEl = dataRowEls[i];
                        break;
                    }
            // for (var i=0; i<columnColGroup.length; i+=1) {
            //     columnColGroup[i].style.width = dataColGroup[i].style.width = '70px';
            // }
            if (dataRowEl) {
                for (var i=0; i<dataRowEl.children.length; i+=1) {
                    if (dataRowEl.children[i].style.display !== 'none') 
                    {
                        // var width = dataRowEl.children[i].offsetWidth;
                        // if (width > 0)
                        // columnColGroup[i].style.display = dataColGroup[i].style.display = '';
                        columnColGroup[i].style.width = dataColGroup[i].style.width = this.config.columnWidth;

                        if (columnColGroup[i].classList.contains('krpmColumnHeaderColTotalCollapse')) {
                            columnColGroup[i].classList.replace(
                                'krpmColumnHeaderColTotalCollapse', 'krpmColumnHeaderColTotal');
                        }
                        if (dataColGroup[i].classList.contains('krpmDataCellColumnColTotalCollapse')) {
                            dataColGroup[i].classList.replace(
                                'krpmDataCellColumnColTotalCollapse', 'krpmDataCellColumnColTotal');
                        }
                        
                        // columnColGroup[i].style.width = dataColGroup[i].style.width = 
                        //     (width > 70 ? width : 70) + 'px';
                        // columnColGroup[i].style.width = 70) + 'px';
                    }
                    else {
                        // columnColGroup[i].style.display = dataColGroup[i].style.display = 'none';
                        columnColGroup[i].style.width = dataColGroup[i].style.width = '0.1px';

                        if (columnColGroup[i].classList.contains('krpmColumnHeaderColTotal')) {
                            columnColGroup[i].classList.replace(
                                'krpmColumnHeaderColTotal', 'krpmColumnHeaderColTotalCollapse');
                        }
                        if (dataColGroup[i].classList.contains('krpmDataCellColumnColTotal')) {
                            dataColGroup[i].classList.replace(
                                'krpmDataCellColumnColTotal', 'krpmDataCellColumnColTotalCollapse');
                        }
                        
                    }
                }
                columnHeaderZoneTable.style.tableLayout = 'fixed';
                dataZoneTable.style.tableLayout = 'fixed';
            }
            // if (this.config.dataFields.length === 0) {
            //     dataZoneTable.style.width = columnHeaderZoneTable.offsetWidth + 'px';
            //     dataZoneTable.style.height = rowHeaderZoneTable.offsetHeight + 'px';
            // }

            
            
            for (var i=0; i<2; i+=1) {
                var dataViewWidth = (pivotEl.offsetWidth - rowHeaderZoneDiv.offsetWidth - 2);
                var dataViewHeight = (pivotEl.offsetHeight - waitingFieldZone.offsetHeight - dataFieldZone.offsetHeight 
                - columnHeaderZoneDiv.offsetHeight -  pivotFooter.offsetHeight - 2);

                columnHeaderZoneDiv.style.width = dataViewWidth + 'px';
                rowHeaderZoneDiv.style.height = dataViewHeight + 'px';
                dataZoneDiv.style.width = dataViewWidth + 'px';

                if (pivotEl.style.height !== 'auto' ) {
                    dataZoneDiv.style.height = dataViewHeight + 'px';
                }
                else {
                    rowHeaderZoneDiv.style.height = 'auto';
                }

                //Placehoder scrollbars
                if (dataViewWidth < dataZoneTable.offsetWidth) {
                    rowHeaderZoneDiv.style.overflowX = 'scroll';
                }
                else {
                    rowHeaderZoneDiv.style.overflowX = '';
                }

                if (dataViewHeight < dataZoneTable.offsetHeight) {
                    columnHeaderZoneDiv.style.overflowY = 'scroll';
                }
                else {
                    columnHeaderZoneDiv.style.overflowY = '';
                }
            }
        };
        
        var changeLayer = function(el, expand, rc) {
            var d = el.dataset;
            d[rc + 'Layer'] -= expand ? -1 : 1;
            var isShown = 1*d.rowLayer > 0 && 1*d.columnLayer > 0
            if (expand && isShown && 1*d.pageLayer === 1)
                el.style.display = '';
            else if (! expand && ! isShown)
                el.style.display = 'none';
        };

        var changePageLayer = function(el, pageShow) {
            var d = el.dataset;
            d.pageLayer = pageShow ? 1 : 0;
            if (1*d.pageLayer === 1 && 1*d.rowLayer > 0 && 1*d.columnLayer > 0)
                el.style.display = '';
            else if (1*d.pageLayer === 0)
                el.style.display = 'none';
        };
        
        var expandCollapseRow = function(e) {
            var icon = e.currentTarget;
            if (! this.batchOperation)
                this.saveViewstate();
            var expand = icon.dataset.command === 'expand';
            var td = findMatchedAncestor(icon, 'td');
            var tr = td.parentElement;

            //Update expand tree and get new data
            var nodes = [td.dataset.node];
            var rf = 1*td.dataset.rowField;
            var tmpTr = tr;
            while (rf > 0) {
                rf -= 1;
                var parentNode = null;
                while (! parentNode) {
                    for (var k=0; k<=rf && k<tmpTr.children.length; k+=1) {
                        var child = tmpTr.children[k];
                        if (1*child.dataset.rowField === rf) {
                            parentNode = child;
                            nodes.unshift(parentNode.dataset.node);
                            break;
                        }
                    }
                    if (! parentNode)
                        tmpTr = tmpTr.previousElementSibling;
                }
            }
            var tree = this.config.expandTrees.row;
            var treeLevel = 0;
            for (var i=0; i<nodes.length; i+=1) {
                for (var j=0; j<tree.children.length; j+=1)
                    //use == instead of === because sometimes 
                    //nodename like '1' is converted to 1, which causes inequality
                    if (tree.children[j].name == nodes[i]) {
                        tree = tree.children[j];
                        treeLevel += 1;
                        break;
                    }
            }
            var nodeLevel = 1*td.dataset.rowField + 1;
            if (expand && nodeLevel === treeLevel + 1) {
                var newExpandNode = {
                    name: td.dataset.node,
                    children: []
                };
                tree.children.push(newExpandNode);
                if (! this.batchOperation) 
                    this.update();
                else
                    this.needUpdate = true;

                return;
            }
            if (expand && nodeLevel === treeLevel)
                delete tree.collapse;
            if (! expand && nodeLevel === treeLevel)
                tree.collapse = true;

            //Hide rest of row
            var el = td.nextElementSibling;
            while (el) {
                this.changeLayer(el, expand, 'row');
                el = el.nextElementSibling;
            }
            var rowIndex = td.dataset.rowIndex;
            var dataRowEl = this.pivotEl.querySelectorAll
                ('.krpmDataZone .krpmRow')[rowIndex];
            for (var j=0; j<dataRowEl.children.length; j+=1) 
                if (1*td.rowSpan > 1)
                    this.changeLayer(dataRowEl.children[j], expand, 'row');
                else 
                    dataRowEl.children[j].classList.toggle('krpmDataCellRowTotal');
                
            //Hide rows below
            el = td.parentElement;
            var i = 1;
            while (i < 1 * td.rowSpan) {
                el = el.nextElementSibling;
                for (var j = 0; j < el.children.length; j += 1) 
                    this.changeLayer(el.children[j], expand, 'row');
                var rowIndex = el.children[0].dataset.rowIndex;
                var dataRowEl = this.pivotEl.querySelectorAll
                    ('.krpmDataZone .krpmRow')[rowIndex];
                for (var j=0; j<dataRowEl.children.length; j+=1) 
                    if (i !== td.rowSpan - 1)
                        this.changeLayer(dataRowEl.children[j], expand, 'row');
                    else 
                        dataRowEl.children[j].classList.toggle('krpmDataCellRowTotal');

                i += 1;
            }

            //Change colspan and expand/collapse icon
            td.colSpan = expand ? 1 : this.numRowFields - td.dataset.rowField;
            toggleExpColIcon(icon);

            if (! this.batchOperation) {
                this.updateNumRow();
                this.showPage(this.pageNum);
            }
        };

        var expandCollapseRowBun = function(e) {
            var icon = e.currentTarget;
            if (! this.batchOperation)
                this.saveViewstate();
            var expand = icon.dataset.command === 'expand';
            var td = findMatchedAncestor(icon, 'td');
            var tr = td.parentElement;

            //Update expand tree and get new data
            var nodes = [td.dataset.node];
            var rf = 1*td.dataset.rowField;
            var tmpTr = tr;
            while (rf > 0) {
                rf -= 1;
                var parentNode = null;
                while (! parentNode) {
                    for (var k=0; k<=rf && k<tmpTr.children.length; k+=1) {
                        var child = tmpTr.children[k];
                        if (1*child.dataset.rowField === rf) {
                            parentNode = child;
                            nodes.unshift(parentNode.dataset.node);
                            break;
                        }
                    }
                    if (! parentNode)
                        tmpTr = tmpTr.previousElementSibling;
                }
            }
            var tree = this.config.expandTrees.row;
            var treeLevel = 0;
            for (var i=0; i<nodes.length; i+=1) {
                for (var j=0; j<tree.children.length; j+=1)
                    //use == instead of === because sometimes 
                    //nodename like '1' is converted to 1, which causes inequality
                    if (tree.children[j].name == nodes[i]) {
                        tree = tree.children[j];
                        treeLevel += 1;
                        break;
                    }
            }
            var nodeLevel = 1*td.dataset.rowField + 1;
            if (expand && nodeLevel === treeLevel + 1) {
                var newExpandNode = {
                    name: td.dataset.node,
                    children: []
                };
                tree.children.push(newExpandNode);
                if (! this.batchOperation) 
                    this.update();
                else
                    this.needUpdate = true;

                return;
            }
            if (expand && nodeLevel === treeLevel)
                delete tree.collapse;
            if (! expand && nodeLevel === treeLevel)
                tree.collapse = true;

            //Hide rest of row
            // var el = td.nextElementSibling;
            // while (el) {
            //     this.changeLayer(el, expand, 'row');
            //     el = el.nextElementSibling;
            // }
            td.classList.toggle('krpmRowHeaderTotal', expand);
            var rowIndex = td.dataset.rowIndex;
            var dataRowEl = this.pivotEl.querySelectorAll
                ('.krpmDataZone .krpmRow')[rowIndex];
            for (var j=0; j<dataRowEl.children.length; j+=1) {
                // if (1*td.rowSpan > 1)
                //     this.changeLayer(dataRowEl.children[j], expand, 'row');
                // else 
                    dataRowEl.children[j].classList.toggle('krpmDataCellRowTotal');
            }
                
            //Hide rows below
            el = td.parentElement;
            var i = 1;
            while (i < 1 * td.dataset.numChildren) {
                el = el.nextElementSibling;
                for (var j = 0; j < el.children.length; j += 1) 
                    this.changeLayer(el.children[j], expand, 'row');
                var rowIndex = el.children[0].dataset.rowIndex;
                var dataRowEl = this.pivotEl.querySelectorAll
                    ('.krpmDataZone .krpmRow')[rowIndex];
                for (var j=0; j<dataRowEl.children.length; j+=1) {
                    this.changeLayer(dataRowEl.children[j], expand, 'row');
                }
                i += 1;
            }

            //Change colspan and expand/collapse icon
            toggleExpColIcon(icon);

            if (! this.batchOperation) {
                this.updateNumRow();
                this.showPage(this.pageNum);
            }
        };
        
        var expandCollapseColumn = function(e) {
            var icon = e.currentTarget;
            if (! this.batchOperation)
                this.saveViewstate();
            var expand = icon.dataset.command === 'expand';
            var td = findMatchedAncestor(icon, 'td');
            var rangeLeft = 1 * td.dataset.columnIndex;
            var numDf = this.numDataFields;
            numDf = numDf > 0 ? numDf : 1;
            var numLeaf = 1 * td.dataset.numLeaf;
            var numChildren = 1 * td.dataset.numChildren;
            var rangeRight = rangeLeft + numChildren / numDf;
            // var rangeRight = rangeLeft + 1 * td.colSpan / numDf;
            var tr = td.parentElement;

            var expandTree = this.config.expandTrees.row;
            var nodes = [td.dataset.node];
            var nodeEls = [td];
            var columnIndex = 1 * td.dataset.columnIndex;
            var cf = 1*td.dataset.columnField;
            var tmpTr = tr;
            while (cf > 0) {
                cf -= 1;
                tmpTr = tmpTr.previousElementSibling;
                var parentNode = null;
                while (! parentNode) {
                    for (var i=0; i<tmpTr.children.length; i+=1) {
                        var child =tmpTr.children[i];
                        var rl = 1 * child.dataset.columnIndex;
                        var rr = rl + child.dataset.numChildren / numDf;
                        // var rr = rl + 1 * child.colSpan / numDf;
                        if (rl <= columnIndex && columnIndex < rr) {
                            parentNode = child;
                            nodes.unshift(parentNode.dataset.node);
                            nodeEls.unshift(parentNode);
                            break;
                        }
                    }
                }
            }
            var expandTree = this.config.expandTrees.column;
            var tree = expandTree;
            var treeLevel = 0;
            for (var i=0; i<nodes.length; i+=1) {
                for (var j=0; j<tree.children.length; j+=1)
                    //use == instead of === because sometimes 
                    //nodename like '1' is converted to 1, which causes inequality
                    if (tree.children[j].name == nodes[i]) {
                        tree = tree.children[j];
                        treeLevel += 1;
                        break;
                    }
            }
            var nodeLevel = 1*td.dataset.columnField + 1;
            if (expand && nodeLevel === treeLevel + 1) {
                var newExpandNode = {
                    name: td.dataset.node,
                    children: []
                };
                tree.children.push(newExpandNode);
                if (! this.batchOperation)
                    this.update();
                else
                    this.needUpdate = true;
                return;
            }
            if (expand && nodeLevel === treeLevel)
                delete tree.collapse;
            if (! expand && nodeLevel === treeLevel)
                tree.collapse = true;

            //Hide column headers below
            el = tr.nextElementSibling;
            while (el && ! el.classList.contains('krpmDataHeaderRow')) {
                var children = el.children;
                for (var i = 0; i < children.length; i += 1) {
                    var child = children[i];
                    var columnIndex = 1 * child.dataset.columnIndex;
                    if (rangeLeft <= columnIndex && 
                        columnIndex < rangeRight)
                        this.changeLayer(child, expand, 'column');
                }
                el = el.nextElementSibling;
            }

            var colHeadCols = this.pivotEl.querySelectorAll(
                '.krpmColumnHeaderZone col');
            var dataCellCols = this.pivotEl.querySelectorAll(
                '.krpmDataZone col');
            var tdColIndex = 1 * td.dataset.columnIndex;
            var startIndex = tdColIndex * numDf + numChildren - numDf;
            for (var k = 0; k < numDf; k += 1) {
                colHeadCols[startIndex + k].classList.toggle(
                    'krpmColumnHeaderColTotal', expand);
                dataCellCols[startIndex + k].classList.toggle(
                    'krpmDataCellColumnColTotal', expand);
            }

            if (this.hideSubTotalColumns && expand) {
                var colspanDiff = - td.dataset.lastColspan + td.colSpan;
                td.colSpan = td.dataset.lastColspan;
            }
            else if (this.hideSubTotalColumns && ! expand) {
                td.dataset.lastColspan = td.colSpan;
                var colspanDiff = numChildren - td.colSpan;
                td.colSpan = numChildren;
            }
            for (var i = 0; i < nodeEls.length - 1; i += 1) {
                var nodeEl = nodeEls[i];
                if (this.hideSubTotalColumns && expand)
                    nodeEl.colSpan = 1 * nodeEl.colSpan - colspanDiff;
                else if (this.hideSubTotalColumns && ! expand)
                    nodeEl.colSpan = 1 * nodeEl.colSpan + colspanDiff;
            }

            var dataHeaderRow = this.pivotEl.querySelector('.krpmDataHeaderRow');
            var children = dataHeaderRow && dataHeaderRow.children || [];
            var firstColumnInAll = true;
            for (var i=0; i<children.length; i+=1) {
                var child = children[i];
                var columnIndex = 1 * child.dataset.columnIndex;
                if (columnIndex === rangeRight - 1) { //column in All group
                    child.colSpan = expand ? 1 
                        : (firstColumnInAll ? numChildren - numDf + 1 : 1);
                    firstColumnInAll = false;
                    // child.colSpan = expand ? 1 : td.colSpan / numDf;
                    child.classList.toggle('krpmDataHeaderColumnTotal');
                } else if (rangeLeft <= columnIndex && columnIndex < rangeRight - 1) {
                    this.changeLayer(child, expand, 'column');
                    firstColumnInAll = true;
                }
            }

            //Hide data cells below
            var dataRowEls = this.pivotEl.querySelectorAll
                ('.krpmDataZone .krpmRow');
            for (var j=0; j<dataRowEls.length; j+=1) {
                var el = dataRowEls[j];
                var children = el.children;
                var firstColumnInAll = true;
                for (var i = 0; i < children.length; i += 1) {
                    var child = children[i];
                    var columnIndex = 1 * child.dataset.columnIndex;
                    if (columnIndex === rangeRight - 1) { //column in All group
                        child.colSpan = expand ? 1 
                            : (firstColumnInAll ? numChildren - numDf + 1 : 1);
                        firstColumnInAll = false;
                        // child.colSpan = expand ? 1 : td.colSpan / numDf;
                        child.classList.toggle('krpmDataCellColumnTotal');
                    }
                    else if (rangeLeft <= columnIndex && columnIndex < rangeRight - 1) {
                        this.changeLayer(child, expand, 'column');
                        firstColumnInAll = true;
                    }
                }
            }

            td.rowSpan = expand ? 1 : this.numColumnFields - td.dataset.columnField;
            toggleExpColIcon(icon);
            
            if (! this.batchOperation)
                this.fixSize();
        };

        var collapseTree = function(zone, expandTree, level, td) {
            var Zone = capitalizeFirstLetter(zone);
            var childrenEls = [];
            if (level === 0) {
                var tds = this.pivotEl.querySelectorAll('.krpm' + Zone + 'Header');
                for (var i = 0; i < tds.length; i += 1) 
                    if (1*tds[i].dataset[zone + 'Field'] === level)
                        childrenEls.push(tds[i]);
            }
            else if (zone === 'row') {
                var rowspan = 1 * td.rowSpan;
                if (this.template === 'PivotMatrix-Bun')
                    rowspan = 1 * td.dataset.numChildren;
                var count = 1;
                if (td.nextElementSibling)
                    childrenEls.push(td.nextElementSibling);
                var tmpTr = td.parentElement;
                while (count < rowspan) {
                    tmpTr = tmpTr.nextElementSibling;
                    var firstChild = tmpTr.firstElementChild;
                    if (firstChild && 
                        1*firstChild.dataset.rowField === 1*td.dataset.rowField + 1)
                        childrenEls.push(firstChild);
                    count += 1;
                }
            }
            else if (zone === 'column') {
                var rangeLeft = 1*td.dataset.columnIndex;
                var numDf = this.numDataFields;
                numDf = numDf > 0 ? numDf : 1;
                var numChildren = 1 * td.dataset.numChildren;
                var rangeRight = rangeLeft + numChildren / numDf;
                var tmpTr = td.parentElement.nextElementSibling; //next row
                if (tmpTr)
                    for (var i=0; i<tmpTr.children.length; i+=1) {
                        var child = tmpTr.children[i];
                        var columnIndex = 1*child.dataset.columnIndex;
                        if (rangeLeft <= columnIndex && columnIndex < rangeRight) 
                            childrenEls.push(child);
                    }
            }
            var children = expandTree.children;
            if (! children) return;
            for (var i=0; i<childrenEls.length; i+=1) {
                var childTree = null;
                var childrenEl = childrenEls[i];
                for (var j=0; j<children.length; j+=1) {
                    if (children[j].name + '' === childrenEl.dataset.node + '') {
                        childTree = children[j];
                        break;
                    }
                }
                if (! childTree || (childTree && childTree.collapse)) {
                    if (childTree)
                        this.collapseTree(zone, childTree, level + 1, childrenEl);
                    var icon = childrenEl.querySelector('.krpmExpCol');
                    if (icon && icon.dataset.command === 'collapse')
                        icon.click();
                }
                else {
                    this.collapseTree(zone, childTree, level + 1, childrenEl);
                }
            }
        };

        var batchCollapseTree = function(zone) {
            var expandTree = this.config.expandTrees[zone];
            if (! expandTree) return;
            this.batchOperation = true;
            var level = 0;
            this.collapseTree(zone, expandTree, level, null);
            this.batchOperation = false;
            if (zone === 'row') {
                this.updateNumRow();
                this.showPage(this.pageNum);
            }
            else {
                this.fixSize();
            }
        };

        var batchExpandCollapse = function(zone, level, expandCollapse) {
            this.batchOperation = true;
            this.saveViewstate();
            var Zone = capitalizeFirstLetter(zone);
                
            var tds = this.pivotEl.querySelectorAll('.krpm' + Zone + 'Header');
            for (var i = 0; i < tds.length; i += 1) {
                var td = tds[i];
                if (td.dataset[zone + 'Field'] != level)
                    continue;
                var icon = td.querySelector('.krpmExpCol');
                if (icon && icon.dataset.command === expandCollapse)
                    icon.click();
            }
            this.batchOperation = false;
            if (expandCollapse === 'expand' && this.needUpdate) {
                this.needUpdate = false;
                this.update();
            }
            else {
                if (zone === 'row') {
                    this.updateNumRow();
                    this.showPage(this.pageNum);
                }
                else {
                    this.fixSize();
                }
            }
        };

        var expandUptoLevel = function(zone, level) {
            if (zone !== 'column' && zone !== 'row') return;
            if (! this.command[zone])
                this.command[zone] = {};
            this.command[zone].expand = level;
            this.saveCommand();
            this.update();
        }

        var showHideColumn = function (td, viewstate, show) {
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
        };

        var showPage = function(pageNum) {
            if (pageNum === null) return;
            // console.log('Go to page ' + pageNum);
            this.viewstate.paging.page = this.pageNum = pageNum;
            var rowEls = this.pivotEl.querySelectorAll('.krpmRowHeaderZone .krpmRow');
            var pageSize = this.viewstate.paging ? 
                1*this.viewstate.paging.size : rowEls.length;
            var startRow = (pageNum - 1) * pageSize;
            var n = 0;
            for (var i=0; i<rowEls.length; i+=1) {
                var show = startRow <= n && n < startRow + pageSize;
                var rowEl = rowEls[i]; 
                var td = rowEl.firstElementChild;
                if (td && 1*td.dataset.rowLayer < 1) {
                    for (var j = 0; j < rowEl.children.length; j += 1) {
                        var child = rowEl.children[j];
                        this.changePageLayer(child, show);
                    }
                    continue;
                }
                for (var j = 0; j < rowEl.children.length; j += 1) {
                    var child = rowEl.children[j];
                    this.changePageLayer(child, show);
                    if (startRow === n)
                        child.classList.toggle('krpmRowHeaderFirst', true);
                    child.classList.toggle('krpmRowHeaderTotalParent', false);
                    child.classList.toggle('krpmRowHeaderNormalParent', false);
                    //For the first row of page, show its parent node (even in previous page)
                    if (j === 0 && startRow === n) {
                        var rf = 1*child.dataset.rowField;
                        if (child.dataset.node === "{{all}}") rf += 1;
                        var tmpTr = rowEls[i-1];
                        while (rf > 0 && tmpTr) {
                            rf -= 1;
                            var parentNode = null;
                            while (! parentNode) {
                                for (var k=0; k<=rf && k<tmpTr.children.length; k+=1) {
                                    var tmpChild = tmpTr.children[k];
                                    if (1*tmpChild.dataset.rowField === rf) {
                                        parentNode = tmpChild;
                                        break;
                                    }
                                }
                                if (! parentNode)
                                    tmpTr = tmpTr.previousElementSibling;
                            }
                            if (this.template !=='PivotMatrix-Bun' && startRow === n) {
								this.changePageLayer(parentNode, show);
								if (child.dataset.node === '{{all}}')
									parentNode.classList.toggle('krpmRowHeaderTotalParent', show);
							} else if (show && child.dataset.node !== '{{all}}') {
                                parentNode.classList.toggle('krpmRowHeaderNormalParent', show);
								// parentNode.classList.toggle('krpmRowHeaderTotalParent', false);
							}
                        }
                    }
                }
                n += 1;
            }

            var rowEls = this.pivotEl.querySelectorAll('.krpmDataZone .krpmRow');
            var n = 0;
            for (var i=0; i<rowEls.length; i+=1) {
                var show = startRow <= n && n < startRow + pageSize;
                var rowEl = rowEls[i]; 
                if (! rowEl.firstElementChild)
                    continue;
                if (1*rowEl.firstElementChild.dataset.rowLayer < 1) {
                    for (var j = 0; j < rowEl.children.length; j += 1) {
                        var child = rowEl.children[j];
                        this.changePageLayer(child, show);
                    }
                    continue;
                }
                rowEl.style.display = '';
                for (var j = 0; j < rowEl.children.length; j += 1) {
                    var child = rowEl.children[j];
                    this.changePageLayer(child, show);
                }
                n += 1;
            }

            if (this.viewstate.paging)
                this.pagination.change('currentPage', this.pageNum);
            this.fixSize();
        };

        var headerTextClicked = function(el) {
            
        };

        return function () {
            this.init = init;
            this.updateScope = updateScope;
            this.update = update;
            this.loadConfig = loadConfig;
            this.saveConfig = saveConfig;
            this.loadViewstate = loadViewstate;
            this.saveViewstate = saveViewstate;
            this.getNumRow = getNumRow;
            this.updatePageSize = updatePageSize;
            this.updateNumRow = updateNumRow;
            this.saveScroll = saveScroll;
            this.restoreScroll = restoreScroll;
            this.fixSize = fixSize;
            this.fixColumnWidth = fixColumnWidth;
            this.changeLayer = changeLayer;
            this.changePageLayer = changePageLayer;
            this.expandCollapseRow = expandCollapseRow;
            this.expandCollapseRowBun = expandCollapseRowBun;
            this.expandCollapseColumn = expandCollapseColumn;
            this.batchExpandCollapse = batchExpandCollapse;
            this.collapseTree = collapseTree;
            this.batchCollapseTree = batchCollapseTree;
            this.showHideColumn = showHideColumn;
            this.showPage = showPage;
            this.headerTextClicked = headerTextClicked;
            this.saveCommand = saveCommand;
            this.expandUptoLevel = expandUptoLevel;
        };
    })();

    var eventFunctions = (function(){
        var registerEvent = function(evtName, func) {
            if (! this.eventHandlers[evtName])
                this.eventHandlers[evtName] = [];
            this.eventHandlers[evtName].push(func);
        };
    
        var fireEvent = function(evtName, args) {
            var clientEventResult = null;
            var eventHandlers = this.eventHandlers;
            if (eventHandlers && eventHandlers[evtName]) {
                var evtHandlers = eventHandlers[evtName];
                for (var i=0; i<evtHandlers.length; i+=1) {
                    var handler = evtHandlers[i];
                    if (typeof handler !== 'function')
                        handler = global[handler];
                    if (typeof handler === 'function')
                        clientEventResult = handler(args);
                }
            }

            return clientEventResult;
        };

        return function() {
            this.registerEvent = registerEvent;
            this.fireEvent = fireEvent;
        };
    })();

    var pivotMoveFunctions = (function() {
        
        var showDropZone = function(el, bool) {
            el.style.border = bool ? "2px dashed gray" : "none";
            el.style.margin = bool ? '-2px' : '0';
        }

        var getZoneType = function(el) {
            while (el && ! el.dataset.zone) el = el.parentElement;
            if (el) return el.dataset.zone;
            else return null;
        }

        var dragStartHandler = function(ev) {
            var target = ev.target;
            ev.dataTransfer.setDragImage(target, 0, 0);

            ev.dataTransfer.setData("uniqueId", this.uniqueId);
            ev.dataTransfer.setData("srcZone", getZoneType(target));
            ev.dataTransfer.setData("fieldType", target.dataset.fieldType);
            ev.dataTransfer.setData("fieldOrder", target.dataset.fieldOrder);
            ev.dropEffect = "move";
        };
        
        var dragOverHandler = function (ev) {
            ev.preventDefault();
            // ev.dataTransfer.dropEffect = "move"
            if (ev.target.getAttribute("draggable") == "true")
                ev.dataTransfer.dropEffect = "none"; // dropping is not allowed
            else
                ev.dataTransfer.dropEffect = "move"; // drop it like it's hot
        };

        var dragEnterHandler = function (ev) {
            if (! ev.target.dataset.fieldDrop)
                return;
            showDropZone(ev.target, true);
        };
        
        var dragLeaveHandler = function (ev) {
            if (! ev.target.dataset.fieldDrop)
                return;
            showDropZone(ev.target, false);
        };

        var dropHandler = function (ev) {
            ev.preventDefault();
            ev.stopPropagation();
            var target = ev.target;
            showDropZone(target, false);

            if (! target.dataset.fieldDrop)
                return;

            var uniqueId = ev.dataTransfer.getData("uniqueId");
            if (uniqueId !== this.uniqueId)
                return;
                
            var srcZone = ev.dataTransfer.getData("srcZone");
            var srcFieldType = ev.dataTransfer.getData("fieldType");
            
            var isDataField = (srcFieldType === "data");
            var dropZone = getZoneType(target);
            var isDataDropZone = (dropZone === 'data');
            if (dropZone !== 'waiting' && isDataField !== isDataDropZone)
            return;
            
            var config = this.config;
            var srcFields = config[srcZone + 'Fields'];
            var destFields = config[dropZone + 'Fields'];
            var srcFieldsType = config[srcZone + 'FieldsType'];
            var destFieldsType = config[dropZone + 'FieldsType'];

            var srcFieldOrder = ev.dataTransfer.getData("fieldOrder");
            var destFieldOrder = target.dataset.fieldOrder || destFields.length;
        
            //Don't move anything if a field is dropped at its surrounding places
            if (srcFields === destFields && (srcFieldOrder === destFieldOrder ||
                1*srcFieldOrder === destFieldOrder - 1)) return;
        
            var args = {
                pivot: this,
                field: movingField,
                source: srcZone,
                destination: dropZone,
                sourceOrder: srcFieldOrder,
                destinationOrder: destFieldOrder
            };
            var result = this.fireEvent('fieldMove', args);

            if (result === false) return;

            //Move the dropped field to destination fields
            var movingField = srcFields.splice(srcFieldOrder, 1)[0];
            destFields.splice(destFieldOrder, 0, movingField);
            var movingFieldType = srcFieldsType.splice(srcFieldOrder, 1)[0];
            destFieldsType.splice(destFieldOrder, 0, movingFieldType);

            this.saveConfig();
            var uniqueId = this.uniqueId;
            this.update(function(){
                // var newPivot = KoolReport[uniqueId];
                var newPivot = window[uniqueId];
                args.pivot = newPivot;
                newPivot.fireEvent('afterFieldMove', args);
            });
        };

        var getTotalOffset = function(el, topLeft) {
            var a = el, o = 0;
            topLeft = capitalizeFirstLetter(topLeft);
            while (a) {
                var style = window.getComputedStyle(a, null);
                if (style.position === 'absolute' ||
                    style.position === 'relative') 
					break;
                o += a['offset' + topLeft];
                a = a.offsetParent;
            }
            return o;
        }

        var dropDownClickHandler = function(ev) {
            var fieldEl = ev.target.parentElement;
            var zone = fieldEl.dataset.fieldType;
            var Zone = capitalizeFirstLetter(zone);
            var pivotEl = this.pivotEl;
            var fieldMenuEl = pivotEl.querySelector('#krpm' + Zone + 'FieldMenu');
            
            if (this.lastMenuField && this.lastMenuField === fieldEl) {
                fieldMenuEl.style.display = 'none';
                this.lastMenuField = null;
            }
            else {
                if (zone !== 'data') {
                    var fieldOrder = fieldEl.dataset.fieldOrder;
                    var menuItemEls = fieldMenuEl.querySelectorAll('.krpmMenuItem');
                    if (1*fieldOrder + 1 === this.config[zone + 'Fields'].length) {
                        menuItemEls[0].classList.add('krpmDisableMenu');
                        menuItemEls[1].classList.add('krpmDisableMenu');
                    }
                    else {
                        menuItemEls[0].classList.remove('krpmDisableMenu');
                        menuItemEls[1].classList.remove('krpmDisableMenu');
                    }
                }

                this.lastMenuField = fieldEl;
                fieldMenuEl.style.position = 'absolute';
                fieldMenuEl.style.top = getTotalOffset(fieldEl, 'top') 
                    + fieldEl.offsetHeight + 'px';
                fieldMenuEl.style.left = getTotalOffset(fieldEl, 'left') + 'px';
                fieldMenuEl.style.display = '';
                fieldMenuEl.focus();
            }
            this.lastMouseDownMenuField = null;
        }

        return function() {
            this.dragStartHandler = dragStartHandler;
            this.dragOverHandler = dragOverHandler;
            this.dropHandler = dropHandler;
            this.dragEnterHandler = dragEnterHandler;
            this.dragLeaveHandler = dragLeaveHandler;
            this.dropDownClickHandler = dropDownClickHandler;
        }
    })();

    var PivotMatrix = function() {};
    pivotFunctions.call(PivotMatrix.prototype);
    eventFunctions.call(PivotMatrix.prototype);
    pivotMoveFunctions.call(PivotMatrix.prototype);

    return {
        create: function(pm_data) {
            var piMatrix =  new PivotMatrix();
            piMatrix.init(pm_data);
            return piMatrix;
        }
    }

})(window);

KoolReport.extend = KoolReport.extend || (function(global){
    // Pass in the objects to merge as arguments.
    // For a deep extend, set the first argument to `true`.
    var extend = function () {

        // Variables
        var extended = arguments[0];
        var deep = false;
        var i = 1;
        var length = arguments.length;

        // Check if a deep merge
        if ( Object.prototype.toString.call( arguments[i] ) === '[object Boolean]' ) {
            deep = arguments[i];
            i++;
        }

        // Merge the object into the extended object
        var merge = function (obj) {
            for ( var prop in obj ) {
                if ( Object.prototype.hasOwnProperty.call( obj, prop ) ) {
                    // If deep merge and property is an object, merge properties
                    if ( deep && Object.prototype.toString.call(obj[prop]) === '[object Object]' ) {
                        extended[prop] = extend( true, extended[prop], obj[prop] );
                    } else {
                        extended[prop] = obj[prop];
                    }
                }
            }
        };

        // Loop through each object and conduct a merge
        for ( ; i < length; i++ ) {
            var obj = arguments[i];
            merge(obj);
        }

        return extended;

    };

    return extend;
})(window);

KoolReport.newPagination = KoolReport.newPagination || (function(global){

    var create = function(el, opt){
        this.el = el;
        var numItems = this.numItems = opt.numItems || 0;
        var pageSize = this.pageSize = opt.pageSize || 10;
        var maxDisplayedPages = this.maxDisplayedPages
            = opt.maxDisplayedPages || 10;
        var firstText = this.firstText = opt.firstText || '<i class="fa fa-step-backward" aria-hidden="true"></i>';
        var prevText = this.prevText = opt.prevText || '<i class="fa fa-angle-left" aria-hidden="true"></i>';
        var nextText = this.nextText = opt.nextText || '<i class="fa fa-angle-right" aria-hidden="true"></i>';
        var lastText = this.lastText = opt.lastText || '<i class="fa fa-step-forward" aria-hidden="true"></i>';
        var currentPage = this.currentPage = opt.currentPage || 1;
        var pageClickListener = opt.onPageClick || function() {};
        var numPages = this.numPages = Math.ceil(numItems / pageSize);

        this.getGoPage = function(pageNum, refresh) {
            return function() {
                var page = pageNum;
                if (page === 'first')
                    page = 1;
                else if (page === 'prev')
                    page = this.currentPage - 1;
                else if (page === 'next')
                    page = this.currentPage + 1;
                else if (page === 'last')
                    page = this.numPages;
                else if (page === 'prev10')
                    page = this.startPage - 1;
                else if (page === 'next10')
                    page = this.endPage + 1;
                if (page < 1 || page > this.numPages)
                    return;
                var changePage = page != this.currentPage ? true : false;
                this.currentPage = page;
                if (page < this.startPage || page > this.endPage) {
                    this.buildPages();
                }
                this.change('currentPage', page);
                if (changePage || refresh) {
                    // console.log('change to page ' + page); 
                    pageClickListener.call(this, page);
                }
            }.bind(this);
        };

        var ul = document.createElement('ul');
        ul.className = 'pagination';
        el.appendChild(ul);

        this.addPageEl = function(href, n, text) {
            var li = document.createElement('li');
            if (n === this.currentPage) li.className = 'active';
            var a = document.createElement('a');
            a.href = href;
            a.className = 'page-link';
            a.innerHTML = text ? text : n;
            a.addEventListener('click', this.getGoPage(n));
            li.dataset.page = n;
            li.appendChild(a);
            this.el.firstElementChild.appendChild(li);
        }.bind(this);

        this.buildPages = function() {
            var ul = this.el.firstElementChild;
            ul.innerHTML = "";
            this.addPageEl('#first-page', 'first', this.firstText)
            this.addPageEl('#prev-page', 'prev', this.prevText)
            var maxPages = this.maxDisplayedPages;
            var numPages = this.numPages;
            var currentPage = this.currentPage;
            var r = (currentPage - 1) % maxPages;
            var startPage = this.startPage = currentPage - r;
            var endPage = this.endPage = currentPage - r + maxPages - 1;
            if (startPage > 1)
                this.addPageEl('#page-' + (startPage-1), 'prev10', "...");
            for (var n=startPage; n<=numPages && n<=endPage; n+=1) {
                this.addPageEl('#page-' + (n), n);
            }
            if (endPage < numPages)
                this.addPageEl('#page-' + (endPage+1), 'next10', "...");
            this.addPageEl('#next-page', 'next', this.nextText)
            this.addPageEl('#last-page', 'last', this.lastText)
        }.bind(this);

        this.buildPages();
    };

    var change = function(prop, value) {
        if (prop === 'numItems' || prop === 'pageSize') {
            if (! this.currentPage) this.currentPage = 1;
            this[prop] = value;
            this.numPages = Math.ceil(this.numItems / this.pageSize);
            if (this.currentPage > this.numPages)
                this.currentPage = this.numPages;
            this.buildPages();
        }
        else if (prop === 'currentPage') {
            this.currentPage = value;
            var ul = this.el.firstElementChild;
            var lis = ul.children;
            for (var i=0; i<lis.length; i+=1) {
                if (lis[i].dataset.page == this.currentPage) 
                    lis[i].className = 'active';
                else
                    lis[i].className = '';
            }
        }
    };

    var Pagination = function() {};
    Pagination.prototype.create = create;
    Pagination.prototype.change = change;
    
    return function(el, opt) {
        var pagination = new Pagination();
        pagination.create(el, opt);
        return pagination;
    };

})(window);