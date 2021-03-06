<?php
/*****
* First, some generic setup.  It is good to define the policy string as a variable once
* as we are likely to need to reference it later in describing the policy and checking
* reports.  For the same reason, we set the report-uri as a distinct variable and 
* combine it to form the full CSP header.
*****/
$policy_string = "script-src 'self'";
$title = "javascript: uris should not run with policy \"$policy_string\".";

/*****
* The support script report.php will write the report to a temporary file
* It can be tested asynchronously with ../support/checkReport.js*****/
$reportID=rand();
$report_string = "";

header("Content-Security-Policy: $policy_string; $report_string");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
/*****
* Run tests with prefixed headers if requested.
* Note this will not really work for Mozilla, as they use
* the old, pre-1.0 directive grammar and vocabulary
*****/
if($_GET['prefixed'] == 'true') {
	header("X-Content-Security-Policy: $policy_string; $report_string");
	header("X-Webkit-CSP: $policy_string; $report_string");
}
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- Yes, this metadata is important in making these test cases useful
		in assessing conformance.  Please preserve and update it. -->
		<title><?php echo $title ?></title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta description="<?php echo $title ?>" />
		<link rel="author" title="bhill@paypal-inc.com" />
	</head>
	<body>
		<h1><?php echo $title ?></h1>
		<div id=log></div>

	<!-- This is our test case, but we don't expect it to actually execute if CSP is working. -->
	<a href="javascript:alert('failed');"><h3>Click here. If you see a popup, the test has failed.</h3></a>

	</body>
</html>
