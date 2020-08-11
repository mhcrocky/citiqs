/**
 * This file contains procedure to export to pdf using phantomjs
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#regular-license
 * @license https://www.koolreport.com/license#extended-license
 */

"use strict";
setTimeout(function(){
    console.log('0;Overtime limit');
    phantom.exit(0);
},5*60*1000);// Max waiting time is 5min

function echo(anything)
{
    console.log("0;"+anything);
    phantom.exit(0);
}


var page = require('webpage').create();
var system = require('system');
var fs = require('fs');
var base64_decode = require('../common/base64_decode');

var source = system.args[1];
var output = system.args[2];
var settings = JSON.parse(base64_decode(system.args[3]));
var expectedLocation = settings.expectedLocation;
var resourceWaiting = settings.resourceWaiting; 

if(Object.keys(settings).length==0)
{
    settings = {
        format:'A4',
        orientation:'Portrait',
        margin:'1in',
    };
}

var os = system.os;

var dpi = settings.dpi?settings.dpi:72;
var viewportRatio = settings.viewportRatio?settings.viewportRatio:2;
var zoom = (os.name=="linux"?0.5:1);
zoom = settings.zoom?settings.zoom:zoom;


var format = {
    "a3":[11.69 , 16.53],
    "a4":[8.26 , 11.69],
    "a5":[5.8 , 8.3],
    "legal":[8.5 , 14],
    "letter":[8.5 , 11],
    "tabloid":[11 , 17]
};

var viewportSize = {};
var paperSize = {};

function toPx(val)
{
    if(typeof val == "string")
    {
        if(val.indexOf("cm")>0)
        {
            return parseFloat(val)*0.393701*dpi;
        }
        else if(val.indexOf("in")>0)
        {
            return parseFloat(val)*dpi;
        }
        else
        {
            return parseFloat(val);//px
        }
    }
    else
    {
        return val;
    }
}


if(settings.format)
{
    var orientation = settings.orientation?settings.orientation.toLowerCase():"portrait";
    if(orientation=="landscape")
    {
        settings.width = Math.round(format[settings.format.toLowerCase()][1]*dpi);
        settings.height = Math.round(format[settings.format.toLowerCase()][0]*dpi);        
    }
    else
    {
        settings.width = Math.round(format[settings.format.toLowerCase()][0]*dpi);
        settings.height = Math.round(format[settings.format.toLowerCase()][1]*dpi);
    }
}
else
{
    if(settings.width)
    {
        settings.width = toPx(settings.width);
    }
    if(settings.height)
    {
        settings.height = toPx(settings.height);
    }
}

paperSize.width = settings.width+"px";
paperSize.height = settings.height+"px";

//echo(JSON.stringify(paperSize));

if (settings.margin)
{
    if(typeof settings.margin == "string")
    {
        settings.margin = {
            top:toPx(settings.margin),
            left:toPx(settings.margin),
            right:toPx(settings.margin),
            bottom:toPx(settings.margin)            
        };
    }
    else if (typeof settings.margin == "number")
    {
        settings.margin = {
            top:settings.margin,
            left:settings.margin,
            right:settings.margin,
            bottom:settings.margin
        };        
    }
    else
    {
        settings.margin = {
            top:(settings.margin.top)?toPx(settings.margin.top):0,
            bottom:(settings.margin.bottom)?toPx(settings.margin.bottom):0,
            left:(settings.margin.left)?toPx(settings.margin.left):0,
            right:(settings.margin.right)?toPx(settings.margin.right):0,
        };
    }
}

if(settings.header)
{
    if(!settings.header.height)
    {
        settings.header.height = "25px";
    }
    if(!settings.header.contents)
    {
        settings.header.contents = "[Header]";
    }
}

if(settings.footer)
{
    if(!settings.footer.height)
    {
        settings.footer.height = "25px";
    }
    if(!settings.footer.contents)
    {
        settings.footer.contents = "[Footer]";
    }
}



function processViewSettings()
{
    var viewSettings = page.evaluate(function(){
        return pdf_export.init();
    });
        
    if(!settings.margin)
    {
        settings.margin = {
            top: toPx(viewSettings.margin.top),
            bottom: toPx(viewSettings.margin.bottom),
            left: toPx(viewSettings.margin.left),
            right: toPx(viewSettings.margin.right)
        } 
    }

    paperSize.margin = {
        top:settings.margin.top,
        bottom:settings.margin.bottom,
        left:settings.margin.left,
        right:settings.margin.right
    };

    viewportSize.width = viewportRatio*(settings.width - settings.margin.left - settings.margin.right);
    viewportSize.height = settings.height;

    if(!settings.header && viewSettings.header)
    {
        settings.header = viewSettings.header;
    }
    if(!settings.footer && viewSettings.footer)
    {
        settings.footer = viewSettings.footer;
    }
    

    if(settings.header)
    {
        paperSize.header = {
            contents:phantom.callback(function(pageNum,numPages){
                return settings.header.contents.replace('{pageNum}',pageNum).replace('{numPages}',numPages);
            }),
            height:settings.header.height
        };
    }
    if(settings.footer)
    {
        paperSize.footer = {
            contents:phantom.callback(function(pageNum,numPages){
                return settings.footer.contents.replace('{pageNum}',pageNum).replace('{numPages}',numPages);
            }),
            height:settings.footer.height
        };
    }
}

function run()
{

    if(!fs.isFile(source))
    {
        console.log("0;Source file not found");
        phantom.exit(0);
        return;
    }
    if(output.substr(-4)!==".pdf")
    {
        console.log("0;The output must be pdf");
        phantom.exit(0);
        return;
    }
    function getTimestamp(){
        return new Date().getTime();
    }
    var lastTimestamp = getTimestamp();

    page.onResourceRequested = function(request) {
        lastTimestamp = getTimestamp();
    };
    page.onResourceReceived = function(response) {
        lastTimestamp = getTimestamp();
    };

    //Read the content and embeded css and js
    var expectedContent = fs.read(source);
    var embeded_css = fs.read(system.args[0].replace("/pdf.js","/embeded.css"));
    var embeded_js = fs.read(system.args[0].replace("/pdf.js","/embeded.js"));

    embeded_css = embeded_css.replace("_zoom_",zoom);
    embeded_js = embeded_js.replace("_zoom_",zoom);

    expectedContent = expectedContent.replace(/(<body\b[^>]*>)/,"$1<###begin###>");
    if(expectedContent.indexOf("<###begin###>")<0)
    {
        expectedContent = "<###begin###>" + expectedContent;
    }
    expectedContent = expectedContent.replace("<###begin###>","<style type='text/css'>"+embeded_css+"</style><###begin###>");
    expectedContent = expectedContent.replace("<###begin###>","<script type='text/javascript'>"+embeded_js+"</script>");


    page.setContent(expectedContent,expectedLocation);

    function renderAndExit()
    {  
        processViewSettings();
        page.viewportSize = viewportSize;
        page.paperSize = paperSize;

        setTimeout(function(){        
            page.render(output);
            console.log("1;"+output);
            phantom.exit(0);
        },500);
    }
    function checkReadyState() {
            setTimeout(function () {
            var curentTimestamp = getTimestamp();
            if(curentTimestamp-lastTimestamp>resourceWaiting){
                renderAndExit();
            }
            else{
                checkReadyState();
            }
        }, 100);
    }
    checkReadyState();
};
run();