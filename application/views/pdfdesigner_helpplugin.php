<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>FPDF WYSIWYG Script Generator</title>
	<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
			
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link href="<?php base_url(); ?>assets/pdfdesigner/css/fpdf-designer-style.css" rel="stylesheet">
	<link href="<?php base_url(); ?>assets/pdfdesigner/css/help.css" rel="stylesheet">
</head>

<body class="fpdf-designer-body">
	<div class="m-0 row">
		<div id="fpdf_designer_header" class="col-12">
			FPDF jQuery WYSIWYG Script Editor
		</div>
		<div id="fpdf_designer_elements" class="col p-4" style="max-width:100px;">
			<a href="<?php base_url(); ?>PdfDesigner" class="btn btn-primary fdpf-element" id="send_fpdf">Back</a>
		</div>
		<div id="fpdf_designer_output" class="col p-4" style="max-width:2000px;">
			<h1>Help / Documentation 
					<a href="<?php base_url(); ?>PdfDesigner/help_editor" title="How to use editor">How to use editor</a> | 
					<a href="<?php base_url(); ?>PdfDesigner/help_plugin" title="How to use FPDF editor jQuery plugin">How to use FPDF editor jQuery plugin</a>
			</h1>
			<div id="output_content">
				<p> This editor helps you to create a PHP script to create an FPDF. Without any experimentations.
					Create your PDF, copy the code and paste it into your PHP file. Voila, ready!</p>
				<hr>
				<h2>How to use the jQuery Plugin</h2>
				<p>This editor is a jQuery plugin. The following modules are necessary:</p>
				<ul>
					<li><a href="https://jquery.com/" target="_blank" rel="noopener" title="jQuery">jQuery 2.2+</a></li>
					<li><a href="https://getbootstrap.com/" target="_blank" rel="noopener" title="Bootstrap">Bootstrap</a></li>
					<li><a href="https://craftpip.github.io/jquery-confirm/" target="_blank" rel="noopener" title="jQuery Confirm">jQuery Confirm (MIT)</a></li>
					<li><a href="https://swisnl.github.io/jQuery-contextMenu/" target="_blank" rel="noopener" title="jQuery ContextMenu">jQuery ContextMenu (MIT)</a></li>
					<li><a href="https://github.com/fujaru/jquery-wheelcolorpicker" target="_blank" rel="noopener" title="jQuery Wheelcolorpicker">jQuery Wheelcolorpicker (MIT)</a></li>
				</ul>
				<p><strong>Info:</strong> Due to the PDF paper size this should be opened with a desktop PC. This editor is not suitable for cell phones or tablets.</p>
				<p> The handling is very easy. Simply click on the desired FPDF element in the menu to add it.<br>
					Then drag and drop to the desired position and right-click on the element to open the context menu with the setting options.</p>
								
				<p>You can add PHP script and variables too. Just use the format '{:$php_var:}'</p>
				<p>All elements have all the settings that are specified by FPDF. Further help can be found on <a href="http://www.fpdf.org" target="_blank" rel="noopener" title="FPDF">http://www.fpdf.org</a></p>
				
				<h2>Setup</h2>
				<p>Add jQuery, Bootstrap, jQuery Confirm, jQuery Contextmenu and FPDF Designer in the head of your document</p>
				<div class="help-pre-code">
					<code>
						&lt;head&gt;<br>
						&lt;meta charset="utf-8"&gt;<br>
						&lt;title&gt;FPDF WYSIWYG Script Generator&lt;/title&gt;<br>
						&nbsp;&nbsp;&lt;script src="https://code.jquery.com/jquery-2.2.4.min.js" &gt;&lt;/script&gt;<br>
						&nbsp;&nbsp;&lt;script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" &gt;&lt;/script&gt;<br>
						&nbsp;&nbsp;&lt;script src="<?php base_url(); ?>assets/pdfdesigner/libs/jquery-contextmenu/jquery.contextmenu.min.js"&gt;&lt;/script&gt;<br>
						&nbsp;&nbsp;&lt;script src="<?php base_url(); ?>assets/pdfdesigner/libs/jquery-confirm/jquery.confirm.min.js"&gt;&lt;/script&gt;<br>
						&nbsp;&nbsp;&lt;script src="<?php base_url(); ?>assets/pdfdesigner/libs/jquery-wheelcolorpicker/jquery.wheelcolorpicker-3.0.5.min.js"&gt;&lt;/script&gt;<br>
						&nbsp;&nbsp;&lt;script src="<?php base_url(); ?>assets/pdfdesigner/js/fpdf-designer-contextmenus.min.js"&gt;&lt;/script&gt;<br>
						&nbsp;&nbsp;&lt;script src="<?php base_url(); ?>assets/pdfdesigner/js/jquery.fpdf-designer.min.js"&gt;&lt;/script&gt;<br>
						<br>
						&nbsp;&nbsp;&lt;link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" &gt;<br>
						&nbsp;&nbsp;&lt;link href="<?php base_url(); ?>assets/pdfdesigner/libs/jquery-contextmenu/jquery.contextmenu.min.css" rel="stylesheet"&gt;<br>
						&nbsp;&nbsp;&lt;link href="<?php base_url(); ?>assets/pdfdesigner/libs/jquery-confirm/jquery.confirm.min.css" rel="stylesheet"&gt;<br>
						&nbsp;&nbsp;&lt;link href="<?php base_url(); ?>assets/pdfdesigner/libs/jquery-wheelcolorpicker/jquery.wheelcolorpicker.css" rel="stylesheet"&gt;<br>
						&nbsp;&nbsp;&lt;link href="<?php base_url(); ?>assets/pdfdesigner/css/fpdf-designer-style.min.css" rel="stylesheet"&gt;<br>
						&lt;/head&gt;<br>
					</code>
				</div>
				
				<h2>How to use</h2>
				<p>Just bind the FPDF Designer to an html element</p>
				<div class="help-pre-code">
					<code>
						...<br>
						$(YOUR SELECTOR).fpdf_designer();<br>
						...<br>
					</code>
				</div>
				<p>Adjust your settings <em>(for example)</em></p>
				<div class="help-pre-code">
					<code>
						...<br>
						$(YOUR SELECTOR).fpdf_designer({<br>
						&nbsp;&nbsp;output_container: 'my_selector', /* standard #output_content */<br>
						&nbsp;&nbsp;fpdf_headers: ["AddPage ('P', 'A4')", "SetAutoPageBreak (true, 10)", "SetFont ('Arial', '', 12)"]<br>
						});<br>
						...<br>
					</code>
				</div>
				<h3><strong>Place your elements button</strong></h3>
				<p>Every button needs the identifiers. (data-fpdf="ELEMENT TYPE" data-is-new-element="true")</p>
				<div class="help-pre-code">
					<code>
						...<br>
						&lt;button class="btn btn-light fdpf-element" data-fpdf="cell" data-is-new-element="true"&gt;Cell&lt;/button&gt;<br>
						...<br>
					</code>
				</div>
				<p><em>possible values for data-fpdf</em>: cell, multicell, text, write, rect, link, line, image, ln, setfillcolor, setdrawcolor, settextcolor</p>
				
				<h3><strong>Options:</strong></h3>

				<p><strong>paper_width</strong>: pdf paper size width in mm<br>
				(<em>default</em>: 210, <em>type</em>: number)</p>
				<p><strong>paper_height</strong>: pdf paper size height in mm<br>
				(<em>default</em>: 290, <em>type</em>: number)</p>
				<p><strong>px_per_cm</strong>: pixels per centimeter<br>
				(<em>default</em>: 37.79, <em>type</em>: number)</p>
				<p><strong>px_per_mm</strong>: pixel per millimeter<br>
				(<em>default</em>: 3.779, <em>type</em>: number)</p>
				<p><strong>px_per_point</strong>: pixel per point<br>
				(<em>default</em>: 1.33, <em>type</em>: number)</p>
				<p><strong>decimals</strong>: how many decimals to use<br>
				(<em>default</em>: 0, <em>type</em>: int)</p>
				<p><strong>body_offset</strong>: offset if the bady should have a padding to correct the exact position<br>
				(<em>default</em>: 0, <em>type</em>: number)</p>
				<p><strong>pdf_top_margin</strong>: FPDF top margin<br>
				(<em>default</em>: 10, <em>type</em>: number)</p>
				<p><strong>pdf_left_margin</strong>: FPDF left margin<br>
				(<em>default</em>: 10, <em>type</em>: number))</p>
				<p><strong>pdf_right_margin</strong>: FPDF right margin<br>
				(<em>default</em>: 10, <em>type</em>: number)</p>
				<p><strong>ajax_url</strong>: to send the elements in json format to a script for further processing<br>
				(<em>default</em>: null, <em>type</em>: url/path)</p>
				<p><strong>save_url</strong>: path to the script to save the current design<br>
				(<em>default</em>: null, <em>type</em>: url/path)</p>
				<p><strong>load_url</strong>: path to the script to load a design<br>
				(<em>default</em>: null, <em>type</em>: url/path)</p>
				<p><strong>use_promt</strong>: to specifiy a design name for save and load<br>
				(<em>default</em>: true, <em>type</em>: boolean)</p>
				<p><strong>output_container</strong>: selector for the html element showing the output<br>
				(<em>default</em>: '#output_content', <em>type</em>: string/jquery selector))</p>
				<p><strong>standard_font</strong>: FPDF standard font<br>
				(<em>default</em>: Arial, <em>type</em>: string/font)</p>
				<p><strong>fpdf_headers</strong>: Array with header data for the FPDF script<br>
				(<em>default</em>: ["AddPage ('P', 'A4')", "SetAutoPageBreak (true, 10)", "SetFont ('Arial', '', 12)"], <em>type</em>: array)</p>
				<p><strong>fonts</strong>: fonts that can be used and owned by FPDF</p>
				<p><strong>fontsizes</strong>: fonts which can be used and owned by FPDF</p>
				
				<h3><strong>Events:</strong></h3>
				<p><strong>fpdf.send_start</strong>: is triggered before the ajax request</p>
				<p><strong>fpdf.send_done</strong>: is triggered if the ajax request was successful</p>
				<p><strong>fpdf.send_failed</strong>: is triggered if the ajax request failed</p>
				<p><strong>fpdf.cleared</strong>: is triggered after the editor was cleared</p>
				<p><strong>fpdf.changed</strong>: is triggered after the editor has changed</p>
				<p><strong>fpdf.save_done</strong>: is triggered after save was successful</p>
				<p><strong>fpdf.save_failed</strong>: is triggered if save failed</p>
				<p><strong>fpdf.load_done</strong>: is triggered after load was successful</p>
				<p><strong>fpdf.load_failed</strong>: is triggered if load failed</p>
				<br>				
				<h3><strong>Methods / Functions:</strong></h3>
				<div class="help-pre-code">
					<code>
						$(selector).functionName()<br>
					</code>
				</div>
				<p><strong>$(selector).getElements()</strong>: returns the elements object</p>
				<p><strong>$(selector).sendAjax()</strong>: send the elements object to an ajax request / (<em>required options to be set</em>: ajax_url, <em>send format</em>: json, <em>content</em>: full array of elements)</p>
				<p><strong>$(selector).getAjaxData()</strong>: get the data from the ajax request</p>
				<p><strong>$(selector).saveDesign()</strong>: save the current design (<em>required options to be set</em>: save_url)</p>
				<p><strong>$(selector).loadDesign()</strong>: load a design (<em>required options to be set</em>: load_url)</p>
				<p><strong>$(selector).clearEditor()</strong>: will clear the editor</p>
			</div>
		</div>
	</div>
</body>
</html>
