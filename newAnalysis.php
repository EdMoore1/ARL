<?php
	/*
	 *	Std Header
	*/
	session_start();
	foreach(glob('classes/*') as $classURI)
		include($classURI);
	$msg = "";
	if (!isset($_SESSION['logged']) || !$_SESSION['logged'])
		die("<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"0; URL=index.php\" />");
	if (isset($_GET['a']) ){
		//Do things
	}
?>
<?php get_header('', true) ?>
		<div id="messageBox"><?=$msg?></div>
		<div id="welcomeBox">
			<h2>New Analysis</h2>
<?php
	if(isset($_GET['step4'])){ ?>
			<p>Step 4</p>
		</div>

	<?php }elseif(isset($_GET['step3'])){ ?>
			<p>Step 3</p>
		</div>

	<?php }elseif(isset($_GET['step2'])){ ?>
			<p>While we're reading your file, could you fill out some information about the file you uploaded (NEEDS REVISION)</p>
		</div>

		<!--PARSE FILE HERE-->

		<form id="">
			Do stuff here
		</form>

	<?php }elseif(isset($_GET['step1'])){ ?>
		<div id="newDialog">
			<form name="newFile" action="newAnalysis.php?step2" method="POST">
				<table id="newFileTable">
					<tr>
						<th>Risk</th>
						<th>Likelihood</th>
						<th>Consequences</th>
						<th>Control (Not sure if we need this)</th>
						<th>Function</th>
					</tr>
				<?php for($i = 0; $i < 8; $i++) {?>
					<tr>
						<td>
							<textarea name="newRisk_risk_<?=$i?>">Is this fixed text or variable text</textarea>
						</td>
						<td>
							<select name="newRisk_likelihood_<?=$i?>">
								<option value="">Please select a Likelihood</option>
								<option value="0">Rare</option>
								<option value="1">Unlikely</option>
								<option value="2">Possible</option>
								<option value="3">Likely</option>
								<option value="4">Almost Certain</option>
							</select>
						</td>
						<td>
							<select name="newRisk_consequences_<?=$i?>">
								<option value="">Please select a Consequence</option>
								<option value="0">Insignificant</option>
								<option value="1">Serious</option>
								<option value="2">Significant</option>
								<option value="3">Major</option>
								<option value="4">Catastrophic</option>
							</select>
						</td>
						<td>
							What goes here?
						</td>
						<td>
							<textarea name="newRisk_function_<?=$i?>">Is this fixed text or variable text</textarea>
						</td>

				<?php } ?>
				</table>
			</form>
		</div>
	<?php }else{ ?>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus consectetur nunc sed lectus porttitor, eu placerat magna ultricies. Quisque nunc lacus,
					tempus eu bibendum nec, fermentum at velit. Vivamus nisl nibh, bibendum vitae est vel, sollicitudin euismod nisl. Vestibulum dictum mauris eget nisi laoreet iaculis.</p>
					<div id="newOptions">
						<div id="newFileLink" onClick="window.location.href= 'newAnalysis.php?step1=1';"></div>
						<form id="newUploadForm" name="newUpload" action="newAnalysis.php?step2" method="POST" enctype="multipart/form-data">
							<div id="uploadForm"><input type="file" name="uploadedFile" id="uploadedFile" onChange="submit()" /></div>
						</form>
					</div>
			<!-- </div> -->


			<script type="text/javascript">
				var dropbox;
				dropbox = document.getElementById("contentWrapper");
				dropbox.addEventListener("dragenter", dragenter, false);
				dropbox.addEventListener("dragover", dragover, false);
				dropbox.addEventListener("drop", drop, false);

				function dragenter(e) {
				  e.stopPropagation();
				  e.preventDefault();
				}

				function dragover(e) {
				  e.stopPropagation();
				  e.preventDefault();
				}

				function drop(e) {
					e.stopPropagation();
					e.preventDefault();

					var dt = e.dataTransfer;
					var files = dt.files;

					handleFiles(files);
				}

				function handleFiles(files) {
					console.log(files);
					if(files.length != 1) {
						alert("Please only upload one file at a time.");
						return;
					}else
						alert("here");

					//Validate the type of format

					//Update and submit the form
					$("#uploadedFile").val(files[0]);
					$("newUpload").submit();
					console.log("end");
				}

				$(function() {
					$( "#newDialog" ).dialog({
						autoOpen: false,
						hide: {effect: "fadeOut", duration: 500},
						draggable: false,
						resizable: false,
						width: 700,
						height: 600,
						position: { my: "top", at: "top", of: window }
					});

					$( "#newFileLink" ).click(function() {
						$( "#newDialog" ).dialog( "open" );
					});
				});
			</script>
	<?php } ?>
<?php get_footer(true) ?>