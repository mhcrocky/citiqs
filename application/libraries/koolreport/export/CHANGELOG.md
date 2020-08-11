# Change Log 

## Version 4.1.0

1. Adding default parameters for pdf() method.
2. `Handler`: Fix the export issue caused by host with port

## Version 4.0.2

1. Add server port to url path

## Version 4.0.1

1. Add default "format" => "A4" if user doesn't specify which format. 

## Version 4.0.0

1. Add option to export to PDF using node.js and chrome headless.

## Version 3.5.0

1. Adding capable of open pdf file on browser by adding $openOnBrowser parameter on toBrowser() function
2. Adding toBase64() function to export file under base64 format
3. Fix the issue of not working when Export package is used on shared host

## Version 3.0.0

1. Adding `resourceWaiting` property to settings so that the milliseconds that PhantomJS will wait for terminating to render.

## Version 2.5.0

1. Add settings() function to facilitate extra settings for Export.
2. Able to set custom location of phantomjs executed file.
3. Able to use the custom temporary folder rather than the default one.
4. Able to set custom dpi
4. Able to set custom zoom ratio

## Version 2.0.0

1. Remove the `useHttp`
2. Solve `ssl` by bypassing the error.

## Version 1.5.0

1. Fix error of not loading resources.
2. Add useHttp variable to parameters for export. This will force phantomjs to use http to load resource if you have trouble with https.


## Version 1.3.0

1. Fix the loading phantomjs

## Version 1.0.0

1. First version