<!doctype html><html><head>
<?php include'imports.php'?>
<script>
	/** update visual elements */
	var Views= {
		update:function() {
			//wrapper
			this.updateNodList()
			this.updateConList()
		},
		//update node list
		updateNodList:function() {
			var div = document.querySelector('#nodes')
			if(Nodes.length==0){ div.innerHTML="<i style='color:#ccc'>~No nodes</i>";return}
			div.innerHTML="";
			var table=document.createElement('table');
			div.appendChild(table);
			var newRow=table.insertRow(-1);
			newRow.insertCell(-1).innerHTML="<b>Nodes</b>";
			newRow.insertCell(-1).innerHTML="<b>Name</b>";
			newRow.insertCell(-1).innerHTML="<b>Output (L/day)</b>";
			var n=1;
			for(var node in Nodes) {
				var newRow=table.insertRow(-1);
				newRow.insertCell(-1).innerHTML=n;
				newRow.insertCell(-1).innerHTML=node;
				newRow.insertCell(-1).innerHTML=format(Nodes[node].value);
				n++;
			}
		},
		//update connections list
		updateConList:function() {
			var div = document.querySelector('#connections')
			if(Connections.length==0)
				div.innerHTML="<i style='color:#ccc'>~No connections</i>"
			else{
				var table=document.createElement('table');
				div.appendChild(table);
				//header
				var newRow=table.insertRow(-1);
				newRow.insertCell(-1).innerHTML="<b>Connection</b>";
				newRow.insertCell(-1).innerHTML="<b>Flow (L/day)</b>";
				//body
				for(var i in Connections)
				{
					var from = Connections[i].from;
					var to = Connections[i].to;
					var flow = Connections[i].flow;
					var newRow=table.insertRow(-1);
					newRow.insertCell(-1).innerHTML=from+" &rarr; "+to;
					newRow.insertCell(-1).innerHTML=flow;
				}
			}
		},
	};

	function init() {
		Views.update()
		createGraph() //inside graph.php
		updateCookies()
	}

	//recalculate the flows for current network
	function recalculateFlows()
	{
		Connections.forEach(function(con){con.flow=0})
		updateCookies()
		window.location.reload()
	}
</script>
<!--network solving-->
<script src="solveNodes.js"></script><!--this solves nodes outputs-->
<script src="solveConnections.js"></script><!--this solves connection flows-->
</head><body onload=init()>
<!--navbar--><?php include'navbar.php'?>
<!--title--><div class=title>3. Solve network: <span class=subtitle>Find flows</span></div>
<!--column-->
<div class=inline style="width:50%">
	<div style=padding:0.5em;text-align:center>
	<button 
		onclick=recalculateFlows() 
		style="display:inline-block;margin:auto;padding:1em 4em"
		>Recalculate Flows</button>
	</div>
	<div id=nodes       class=inline style="padding:0.5em;font-size:10px;max-width:50%"></div>
	<div id=connections class=inline style="padding:0.5em;font-size:10px;max-width:50%"></div>
</div>
<!--graph--><div class=inline style="width:50%;border:1px solid #ccc;border-top:none"><?php include'graph.php'?></div>
