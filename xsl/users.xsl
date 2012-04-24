<?xml version="1.0" encoding="UTF-8" ?>
<xsl:transform version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns="http://www.w3.org/1999/xhtml">
	<xsl:template match="/root/user" name="user_a">
		<div class="top_search">
			<form action="index.php" method="POST">
			<input type="hidden" name="searchCheck" id="searchCheck" value="true"/>
			<input type="text" name="search" id="search"/>
			<input type="submit" value="search" name="searchButton" id="searchButton"/>
			</form>
		</div>
		<div class="top_left">
			<a href="index.php">Storms2 Home</a>
			<span> | </span> 
			<a href="?new=true">New</a>
			<span> | <!--<a href="?reports=report">Reports</a>--> <a href="?character=list">Characters</a> (<a href="?character=new">New</a>) | </span>
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
