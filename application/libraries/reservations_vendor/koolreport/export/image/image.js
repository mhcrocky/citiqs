/**
 * This file contains procedure to export to image using phantomjs
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
    phantom.exit();
},5*60*1000);// Max waiting time is 5min

function echo(anything)
{
    console.log("0;"+anything);
    phantom.exit();
}


var page = require('webpage').create();
var system = require('system');
var fs = require('fs');
var base64_decode = require('../common/base64_decode');
var os = system.os;
var source = system.args[1];
var output = system.args[2];
var params = JSON.parse(base64_decode(system.args[3]));
var expectedLocation = params.expectedLocation;

var pageWidth = (params.width)?parseInt(params.width,10):1920;
var pageHeight = (params.height)?parseInt(params.height,10):pageWidth*3/4;

function run()
{
    if(!fs.isFile(source))
    {
        console.log("0;Source file not found");
        phantom.exit();
        return;
    }
    function getTimestamp(){
        return new Date().getTime();
    }
    var lastTimestamp = getTimestamp();

    page.viewportSize = { width: pageWidth, height: pageHeight};
    if(params.height)
    {
        page.clipRect = { top: 0, left: 0, width: pageWidth, height: pageHeight };
    }
    
    page.onResourceRequested = function(request) {
        lastTimestamp = getTimestamp();
    };
    page.onResourceReceived = function(response) {
        lastTimestamp = getTimestamp();
    };

    //Read the content and embeded css and js
    var expectedContent = fs.read(source);
    var embeded_css = fs.read(system.args[0].replace("/image.js","/embeded.css"));
    var embeded_js = fs.read(system.args[0].replace("/image.js","/embeded.js"));    
    embeded_js = embeded_js.replace("{os.name}",os.name);
    expectedContent = expectedContent.replace(/(<body\b[^>]*>)/,"$1<###begin###>");
    if(expectedContent.indexOf("<###begin###>")<0)
    {
        expectedContent = "<###begin###>" + expectedContent;
    }
    expectedContent = expectedContent.replace("<###begin###>","<style type='text/css'>"+embeded_css+"</style><###begin###>");
    expectedContent = expectedContent.replace("<###begin###>","<script type='text/javascript'>"+embeded_js+"</script>");

    page.setContent(expectedContent, expectedLocation);
    
    function renderAndExit()
    {
        page.evaluate(function(){
            return image_export.init();
        });
        setTimeout(function(){
            page.render(output);
            console.log("1;"+output);
            phantom.exit();
        },500);  
    }
    function checkReadyState() {
        setTimeout(function () {
            var curentTimestamp = getTimestamp();
            if(curentTimestamp-lastTimestamp>1000){
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