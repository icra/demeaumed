<!doctype html><html><head><?php include'imports.php'?>

<script>
	/** functions that update visual elements*/
	var Views = 
	{
		update:function()
		{
			//wrapper
			this.updateNodList()
			this.updateConList()
		},

		//update node list
		updateNodList:function()
		{
			var div = document.querySelector('#nodes')
			div.innerHTML="<b>Nodes</b><br>"

			if(Nodes.length==0)
				div.innerHTML="<i style='color:#ccc'>~No nodes</i>"

			var n=1;
			for(var node in Nodes)
			{
				//new div == node
				var con = document.createElement('div')
				div.appendChild(con)
				//get fields
				con.innerHTML=n+". "+node+" ("+Nodes[node].value+")";
				n++;
				console.log(node)
			}
			for(var i in Tanks)
			{
				//new div == node
				var con = document.createElement('div')
				div.appendChild(con)
				//get fields
				con.innerHTML=n+". "+Tanks[i].name;
				n++
			}
		},

		//update connections list
		updateConList:function()
		{
			var div = document.querySelector('#connections')
			div.innerHTML="<b>Connections</b><br>"
			if(Connections.length==0)
				div.innerHTML="<i style='color:#ccc'>~No connections</i>"

			for(var i in Connections)
			{
				//new div == connection
				var con = document.createElement('div')
				div.appendChild(con)
				//get fields
				var from = Connections[i].from
				var to = Connections[i].to
				var tec = Connections[i].tec
				var vol = Connections[i].vol
				var n=parseInt(i)+1;
				con.innerHTML="&emsp;"+n+". "+from+" &rarr; "+to;
			}
		},
	};

	function init()
	{
		Views.update()
		createGraph() //inside graph.php
	}
</script>

<script>
	//Structure of a "Network" object
	/*
		"Network":{
			"Nodes":{
				"Node A":{value:1},
				"Node B":{value:2},
				"Node C":{value:2},
				[...]
			},
			"Connections":[            // [ {},{},{},... ]
				{
					"from":<string>,
					"tec":<string>,
					"to":<string>,
					"vol":<number>
				},
				{
					"from":<string>,
					"tec":<string>,
					"to":<string>,
					"vol":<number>
				},
				[...]
			]
		}
	*/
	//construct the above structure
	var Network = {};
	(function(){
		Network.Connections=Connections; //from 'js/connections.js'
		Network.Nodes=Nodes;             //from 'js/nodes.js' but we need tanks as well ('js/tanks.js')
		Network.Tanks=Tanks;             //they are nodes as well
		/*
		for(var i in Tanks)
		{
			var newNode = {"value":null};
			var newName = Tanks[i].name;
			Network.Nodes[newName]=newNode;
		}
		*/
	})();

	//value means the sum of all outputs
	//solving the network means finding a flow for each connection,which is a new property
	function solveNetwork(Network)
	{
		//find "calculable" connections //NOW
	}

</script>

</head><body onload=init()>
<!--navbar--><?php include'navbar.php'?>
<!--title--><div class=title>3. Solve network: <span class=subtitle>Find flows</span></div>

<!--column-->
<div class=inline style="width:50%">
	<div id=nodes       class=inline style="max-width:50%"></div>
	<div id=connections class=inline style="max-width:50%"></div>

	<div>
		<h1>Calcular</h1>
		<ul>
			<li>Cabals de cada connexió i de cada aparell, i de l'aigua residual (final)
			<li>Calcular estalvis d'aigua reutilitzada
			<li>Calcular concentracions dels contaminants (càrregues)
	</div>
</div>
<!--graph--><div class=inline style="width:50%;border:1px solid #ccc;border-top:none"><?php include'graph.php'?></div>
