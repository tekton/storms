<?xml version="1.0" encoding="UTF-8" ?>
<xsl:transform version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns="http://www.w3.org/1999/xhtml">
	<xsl:output method="html" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"/>

	<xsl:template match="/">
		<html>
			<head>
				<title>issues test</title>
				<link rel="stylesheet" type="text/css" href="../main.css" media="screen" />
			</head>
			<body>
				<div id="install_container">
					<div id="install_title">[stormsV2::installer]</div>
					<div id="install_info_container">
						<form action="storms2_installer.php" method="post">
							<table id="install_table">
								<tbody>
									<tr class="green">
										<td width="30%" class="green">Base Project</td>
										<td><input type="text" name="project" id="project"/></td>
									</tr>
									<div id="project_info">
										<tr class="purple">
											<td>Admin User</td>
											<td><input type="text" name="auser" id="auser"/></td>
										</tr>
										<tr class="purple">
											<td>Admin Display Name</td>
											<td><input type="text" name="adisp" id="adisp"/></td>
										</tr>
										<tr class="purple">
											<td>Admin Pass</td>
											<td><input type="text" name="apass" id="apass"/></td>
										</tr>
										<tr class="purple">
											<td>Admin Pass</td>
											<td><input type="text" name="apass2" id="apass2"/></td>
										</tr>
									</div>
									<div id="database_info">
										<tr class="green">
											<td>Database Host</td>
											<td><input type="text" name="host" id="host"/></td>
										</tr>
										<tr class="green">
											<td>Database Name</td>
											<td><input type="text" name="db" id="db"/></td>
										</tr>
										<tr class="green">
											<td>Database User</td>
											<td><input type="text" name="user" id="user"/></td>
										</tr>
										<tr class="green">
											<td>Database Password</td>
											<td><input type="text" name="pass" id="pass"/></td>
										</tr>
										<tr class="green">
											<td>Database Password</td>
											<td><input type="text" name="pass2" id="pass2"/></td>
										</tr>
										<tr class="green">
											<td>Table Prefix</td>
											<td><input type="text" name="prefix" id="prefix"/></td>
										</tr>
									</div>
								</tbody>
							</table>
							<input type="Submit"/>
						</form>
						<table width="100%">
							<tr>
								<td class="green">Required</td><td class="purple">Optional</td><td class="red">Invalid</td>
							</tr>
						</table>
					</div>
				</div>
			</body>
		</html>
	</xsl:template>
</xsl:transform>