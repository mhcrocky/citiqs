# Change Log

## Version 4.0.1

1. Fix DataTables' bootstrap4 css and js.

## Version 4.0.0

1. Add "defaultPlugins" and "plugins" properties to load various DataTables' plugins.

## Version 3.3.0
1. Add client-side `onBeforeInit` event.

## Version 3.2.1
1. Fix server-side sorting bug
2. Adding dutch (nl) localization for DataTables

## Version 3.2.0
1. Add callable "attributes" map for table, th, tf, tr, td elements in DataTables.
2. Change serverSide's data rendering from using html comment to using custom tag.

## Version 3.1.0
1. Fix server side's request processing
2. Update DataTables' client css, js and resources to latest version

## Version 3.0.0
1. Add ability to display complex headers
2. Add option to only search when clicking enter
3. Add searching mode to use OR operator when searching: searchOnEnter
4. Make server side searching work similarly to client side one: searchMode

## Version 2.5.1

1. Fix the datatables css name

## Version 2.5.0

1. Fix the bs4 theme for DataTables
2. Fix the onReady client event handler

## Version 2.0.0

1. DataTables: Support bootstrap 4


## Version 1.5.0

1. Update footer formatValue
2. Use Utility::jsonEncode() to enable writing anonymous js function in options
3. Add data-order and data-search to DataTables' columns setting like this:
    'columns' => [
        'customerName' => [
            'data-order' => 'customerNumber',
            'data-search' => 'customerFullName',
        ],
    ]
    
## Version 1.2.0

1. DataTables: Add: cssClass option for table, th, tr, td, tf.
2. DataTables: Fix: tfooter -> tfoot.
3. DataTables: Fix: clientEvents like "select" not run.


## Version 1.1.0

1. DataTables:Remove dataStore and use the default dataSource/dataStore f1m Widget
2. DataTables: Adding formatValue capability
3. Improve the client library loading.

## Version 1.0.0

1. Adding `DataTables` widget.