<xsl:transform version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns="http://www.w3.org/1999/xhtml">
	<xsl:output method="html" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"/>
	<xsl:template match="/">
		
		<html>
			<head>
				<title>issues test</title>
				<link rel="stylesheet" type="text/css" href="main.css" media="screen" />
			</head>
			<body>
				<div id="container">
					<xsl:apply-templates/>
		
				<form action="index.php" method="POST">
					
					<input type="hidden" name="character_input" id="character_input" value="true" />
					
				<div class="information">
					<div class="information_top">information</div>
					<div class="information_bottom">

						<div class="cBoth">
							<div class="cLeft">type</div>
							<div class="cRight"><input type="text" id="type" name="type" size="10" /></div>
						</div>

						<div class="cBoth">
							<div class="cLeft">in build</div>
							<div class="cRight"><input type="text" id="in_build" name="in_build" size="10" /></div>
						</div>

						<div class="cBoth">
							<div class="cLeft">updated in</div>
							<div class="cRight"><input type="text" id="resolved_in" name="resolved_in" size="10" /></div>
						</div>

						<div class="cBoth">
							<div class="cLeft">milestone</div>
							<div class="cRight"><input type="text" id="milestone" name="milestone" size="10" /></div>
						</div>

						<div class="cBoth">
							<div class="cLeft">pertains to</div>
							<div class="cRight"><input type="text" id="pertains_to" name="pertains_to" size="10" /></div>
						</div>

						<div class="cBoth">
							<div class="cLeft">parent issue</div>
							<div class="cRight"><input type="text" id="parent_issue" name="parent_issue" size="10" /></div>
						</div>
						
						<div class="cBoth">
							<div class="cLeft">project</div>
							<div class="cRight"><input type="text" id="project" name="project" size="10" /></div>
						</div>

						<div class="cBoth"></div>

					</div>
				</div>


				<div class="issue">
					<div class="issue_top"><input type="text" id="name" 
						value="Character Name" name="name" size="60" /></div>
					<div class="issue_content">
						<div><textarea name="bio" rows="10" cols="60"></textarea></div>
						<!--<div><input type="text" id="parent1" value="parent1" name="parent1" size="60" /> - parent1</div>
						<div><input type="text" id="parent2" value="parent2" name="parent2" size="60" /> - parent2</div>-->
						<div><input type="text" id="dob" value="dob" name="dob" size="60" /> - dob</div>
						<div><input type="text" id="birth_loc" value="birth_loc" name="birth_loc" size="60" /> - birth_loc</div>
						<div><input type="text" id="hometown" value="hometown" name="hometown" size="60" /> - hometown</div>
						<div><input type="text" id="race" value="race" name="race" size="60" /> - race</div>
						<div><input type="text" id="hair" value="hair" name="hair" size="60" /> - hair</div>
						<div><input type="text" id="eyes" value="eyes" name="eyes" size="60" /> - eyes</div>
						<div><input type="text" id="max_height" value="max_height" name="max_height" size="60" /> - max_height</div>
						<div><input type="text" id="demeanor" value="demeanor" name="demeanor" size="60" /> - demeanor</div>
						<!--
						<div><input type="text" id="significant_other" value="significant_other" name="significant_other" size="60" /> - significant_other</div>
						<div><input type="text" id="marital_status" value="marital_status" name="marital_status" size="60" /> - marital_status</div>
						-->
					</div>
				</div>
				<!--<div class="cBoth">&nbsp;</div>-->

				<input type="submit" />
				</form>
			</div>
		</body>
	</html>
</xsl:template>

<xsl:template match="/root/user" name="a">
	<div class="top_search">
		<form action="index.php" method="POST">
		<input type="hidden" name="searchCheck" id="searchCheck" value="true" />
		<input type="text" name="search" id="search" />
		<input type="submit" value="search" name="searchButton" id="searchButton" />
		</form>
	</div>
	<div class="top_left">
		<a href="index.php">Storms2 Home</a>
		<span> | </span> 
		<a href="?new=true">New</a>
		<span> | Reports [NYI]  </span>
		<!-- get install version somewhere -->

		<xsl:choose>
			<xsl:when test="/root/user/name/text()">
				<xsl:for-each select="/root/user">
					<span>Logged in as: <xsl:value-of select="name"/> | <a href='?logout=true'>Logout</a></span>
				</xsl:for-each>
			</xsl:when>
			<xsl:otherwise>
				<span><a href='?login=true'>Login</a></span>
			</xsl:otherwise>
		</xsl:choose>

	</div>
	<div class="cBoth"></div>
</xsl:template>

</xsl:transform>