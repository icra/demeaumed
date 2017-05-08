<!--navbar on top-->
<div id=navbar>
	<h1 onclick=window.location='index.php'>
		SambaNet
	</h1>

	<a href="water.php"        page=water>1. Water use</a> &#10148; 
	<a href="create.php"       page=create>2. Create Network</a> &#10148; 
	<a href="solveNetwork.php" page=solveNetwork>3. Solve Network</a> &#10148; 
	<a href="loads.php"        page=loads>4. Solve Loads</a> &#10148; 
	<a href="reuse.php"        page=reuse>5. Add water reuse</a> &#10148; 
	<a href="results.php"      page=results>6. Results</a>
</div>

<style>
	#navbar {
		text-align:left;
		padding:1em;
		background:#abc;
		margin:0;
		box-shadow: 0 1px 2px rgba(0,0,0,.1);
	}
	#navbar h1 {
		display:inline-block;
		margin-right:0.5em;
		cursor:pointer;
	}
	#navbar a {
		margin:0 0.3em;
		padding:0.5em;
		border-radius:0.5em;
		text-decoration:none;
		background:#bca;
		box-shadow: 0 1px 2px rgba(0,0,0,.1);
	}
	#navbar a:hover {
		text-decoration:underline;
	}
</style>
