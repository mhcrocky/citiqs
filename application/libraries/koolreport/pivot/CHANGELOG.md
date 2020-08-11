# Change Log

## Version 6.3.0

1. add "{finalValue}" option for custom aggregate.

## Version 6.2.1

1. Bug fix for some edge cases.

## Version 6.2.0

1. Fix font-awesome 5 icons
2. Add div wrapper for data field zone of PivotTable
3. Keep PivotMatrix's field state even when data is empty
4. Make PivotUtil's headerMap and map compatible

## Version 6.1.2

1. Revert PivotTable's javascript es6 for it to work with Phantomjs
2. Add pivotRows and pivotColumns to PivotMatrix's javascript object

## Version 6.1.1

1. Fix PivotUtil's headerMap property compatibility
2. Fix PivotMatrix's update when there're multiple matrixes per page

## Version 6.1.0

1. Add "rowCollapseLevels" and "columnCollapseLevels" to PivotMatrix
2. Add class names and attributes to PivotMatrix's elements to support customization
3. Fix some possible js bug in PivotMatrix.js and PivotTable.js
4. Fix mappedNode in PivotUtil's getDataAttributes to show data cells' formatted values
5. Fix PivotMatrix's paging bug with first row

## Version 6.0.1

1. Fix PivotMatrix's Bun template error

## Version 6.0.0

1. Add process Pivot2D to create pivot datastore in normal table format.
2. Add custom aggregate to Pivot and Pivot2D processes.
3. Add "cssClass" map for PivotTable and PivotMatrix.
4. Add "hideGrandTotalRow" and "hideGrandTotalColumn" to PivotTable and PivotMatrix.

## Version 5.0.0

1. Add Bun template for both PivotMatrix and PivotTable.
2. Fix PivotMatrix's hideSubtotalRow when there're a lot of them.

## Version 4.3.0

1. Fix pivot's excel export.

## Version 4.2.0

1. Add 'hideSubtotalRow' and 'hideSubtotalColumn' to PivotTable and PivotMatrix widgets.

## Version 4.1.0

1. Add 'sum percent' and 'count percent' to Pivot process.


## Version 4.0.0

1. PivotMatrix: Fix: getTotalOffset in PivotMatrix.js. 
2. PivotMatrix: Fix: escape quote in header's dataset.node and in json_encode($config). 
3. PivotMatrix: Add: column header, row header and data cell Total css classes. 
4. PivotMatrix: Add: dataset row-field and column-field for data cells. 
5. PivotMatrix: Add: event 'afterFieldMove' AFTER each field move update. 
6. PivotMatrix: Add: expandUptoLevel function. 
7. PivotMatrix: Add: krpmRowHeaderTotal, krpmColumnHeaderTotal, krpmDataCellRowTotal, krpmDataCellColumnTotal, krmpDataCellRowTotalTr class to to help hide subtotal row.  
8. Pivot: Add: command "expand" => level. 


## Version 3.3.0

1. Bug fix: Move field to empty row or column zones.
2. Feature: Add PivotExtract process to extract tabular data from pivot data.

## Version 3.2.0

1. Minor javascript bug fixes.
2. Add property "partialProcessing" for Pivot process to increase speed.
3. Add property 'columnWidth' for PivotMatrix widget.
 
## Version 3.0.1

1. Fix the average calculation in Pivot    

## Version 3.0.0

1. Add PivotMatrix widget for dragging and dropping fields, sorting, paging, scrolling. 
2. Incremental processing: only compute necessary pivot data at the visible level. Compute more when users click expand/collapse.