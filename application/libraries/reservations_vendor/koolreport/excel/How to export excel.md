# Here are the steps one could make to export a report to excel:

1. Create an excel export file, says MyReportExcelExport.php.

2. Create an export button in the report page (MyReport.view.php).	

3. Set the button inside a form tag (form's method=post), set the button's formaction = MyReportExcelExport.php:

	<form method='post'>
	...
		<button class="btn btn-primary" formaction="MyReportExcelExport.php">Export to Excel</button>
	...
	</form>
	
4. In MyReportExcelExport.php, just include the report class file, create a report instance, run it and call exportToExcel:

	<?php
		ob_start();
		
		require_once "MyReport.php";
		$report = new MyReport();
		$report->run();
		
		ob_clean();
		
		$report->exportToExcel(array(
			'dataStores' => array('MyReportData')
		))
		->toBrowser("MyReport.xlsx");
	?>

5. Because in the report class file MyReport.php, there could be blank lines outside of the <?php ... ?> tag, they are output to the export file together with the excel content as well, which corrupt the excel content so MS Excel couldn't open it. However, if you open the corrupted file, remove those blank lines at the beginning then the file could be opened correctly.
So the solution is either:
	5.a. Remove all blank lines or spaces outside of the <?php ... ?> tag in the report class file.
or:
	5.b. Use ob_start() at the start of the export file, which creates output buffering instead of output rightaway any content, and then ob_clean(), which clears all buffered content, just before calling exportToExcel.

6. Profit.