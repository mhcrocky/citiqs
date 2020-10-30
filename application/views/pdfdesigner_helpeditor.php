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
	<link href="<?php base_url(); ?>assets/pdfdesigner/help.css" rel="stylesheet">
</head>

<body class="fpdf-designer-body">
	<div class="m-0 row">
		<div id="fpdf_designer_header" class="col-12">
			FPDF jQuery WYSIWYG Script Editor
		</div>
		<div id="fpdf_designer_elements" class="col p-4" style="max-width:100px;">
			<a href="<?php base_url(); ?>pdfdesigner" class="btn btn-primary fdpf-element" id="send_fpdf">Back</a>
		</div>
		<div id="fpdf_designer_output" class="col p-4" style="max-width:2000px;">
			<h1>Help / Documentation 
					<a href="<?php base_url(); ?>pdfdesigner/help_editor" title="How to use editor">How to use editor</a> | 
					<a href="<?php base_url(); ?>pdfdesigner/help_plugin" title="How to use FPDF editor jQuery plugin">How to use FPDF editor jQuery plugin</a>
			</h1>
			<div id="output_content">
				<p> This editor helps you to create a PHP script to create an FPDF. Without any experimentations.
					Create your PDF, copy the code and paste it into your PHP file. Voila, ready!</p>
				<hr>
				<h2>How to use the editor</h2>
				<p><strong>Info:</strong> Due to the PDF paper size this should be opened with a desktop PC. This editor is not suitable for cell phones or tablets.</p>
				<p> The handling is very easy. Simply click on the desired FPDF element in the menu to add it.<br>
					Then drag and drop to the desired position and right-click on the element to open the context menu with the setting options.</p>
				<p><strong>1. Step:</strong> Click in the menu on the desired element which you want to insert</p>
				<p><strong>2. Step:</strong> After the element is added to the editor you can move it by drag and drop. Just move it to the position where you want to place it.</p>
				<p><strong>3. Step:</strong> Right-click <em>(will open the context menu)</em> on the element to change the current settings.</p>
				<p>With the context menu you get all responding settings for the selected element. More information can be found on <a href="http://www.fpdf.org" target="_blank" rel="noopener" title="FPDF">http://www.fpdf.org</a><br></p>
				<div><strong>Change value:</strong> To change a the value on an element <em>(Cell, Multicell, Link, Text, Write, Image)</em> right-click and select 'Change value', enter the new value and click 'Set'.<br>
				<strong>Delete Element:</strong> You can delete an element on 2 ways:	
				<ul>
					<li>Right-click on the element and then click "Delete" in the context menu</li>
					<li>Drag and drop the element out of the editor</li>
				</ul>	
				<strong>Change colors:</strong> There are 3 invisible elements:	
				<ul>
					<li>SetDrawColor: <em>defines the color used for all drawing operations (lines, rectangles and cell borders)</em></li>
					<li>SetTextColor: <em>defines the color used for text.</em></li>
					<li>SetFillColor: <em>defines the color used for all filling operations (filled rectangles, multicell and cell backgrounds).</em></li>
				</ul>
				With a right-click on these elements you can set grey scale (0-255) or a color value (RGB 0-255).<br>
				If you set one of these elements to the editor will affect all elements below. It means if you set e.g. SetTextColor to red (255, 0 0) all elements below this invisible element will have a red text color until you set a new SetTextColor. (the same with SetDrawColor and SetFillColor).<br>
				<img src="images/invisible.png"	alt="Invisible elements" class="img-fluid mt-2 mb-4">
				<br>
				<strong>Change width:</strong> To change the width (except invisble elements) of an element right-click and select 'Change width', enter the new value and click 'Set'.<br>
				<strong>Change height:</strong> To change the height (except invisble elements) of an element right-click and select 'Change height', enter the new value and click 'Set'.<br>
				<br>					
				Each element has different setting options</div>
				<h4>Setting options</h4>
				<p>
				<strong>Cell</strong>: <em>Delete, Change value, Change width, Change height, Border, Font, Font size, Font style, Set fill, Text align</em><br>
				<strong>MultiCell</strong>: <em>Delete, Change value, Change width, Change height, Border, Font, Font size, Font style, Set fill, Text align</em><br>
				<strong>Text</strong>: <em>Delete, Change value, Change width, Change height, Font, Font size, Font style</em><br>
				<strong>Write</strong>: <em>Delete, Change value, Change height, Font, Font size, Font style</em><br>
				<strong>Rect</strong>: <em>Delete, Change width, Change height, Style</em><br>
				<strong>Link</strong>: <em>Delete, Change link, Change width, Change height, Font, Font size, Font style</em><br>
				<strong>Line</strong>: <em>Delete, Change width, Change height</em><br>	
				<strong>Image</strong>: <em>Delete, Change file, Change width, Change height, Image type</em><br>
				<strong>Ln</strong>: <em>Delete, Change height</em><br>
				<strong>SetDrawColor, SetTextColor, SetFillColor</strong>: <em>Delete, Grey scale, Color value</em><br>
				</p>
				
				<p>You can add PHP script and variables too. Just use the format '{:$php_var:}' as new value</p>
				<img src="images/hello-world.png"	alt="Hello World" class="img-fluid mt-2 mb-4">
				<p>Will generate following output:</p>
				<div class="help-pre-code">
					<code>
						...<br>
						$pdf->Cell(0, 5, 'Hello '.$world, 0, 1, 'L', false);<br>
						...<br>
					</code>
				</div>
				<p>All elements have all the settings that are specified by FPDF. Further help can be found on <a href="http://www.fpdf.org" target="_blank" rel="noopener" title="FPDF">http://www.fpdf.org</a></p>
				
				<hr>
				
			</div>
		</div>
	</div>
</body>
</html>
