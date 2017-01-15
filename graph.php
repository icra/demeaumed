<!--figure to be included anywhere (needs imports.php)-->

<style>
	.links line { stroke:#999; stroke-opacity: 0.6; }
	.nodes circle { stroke:#fff; stroke-width: 1.5px; }
	.node text { pointer-events: none; font: 10px sans-serif; }
</style>

<script src="https://d3js.org/d3.v4.min.js"></script>

<!--btns zoom-->
<div id=graph_zoom>
	<style>
		#graph_zoom { 
			padding:0.2em;
			border-bottom:1px solid #ccc;
			text-align:center;
		}
		#graph_zoom button { 
			border-radius:1em;
			padding:0.5em 2em;
			background:#abc;
			border:none;
			font-size:18px
		}
	</style>
	Zoom
	&#128270; 
	<button onclick=zoom("-")>-</button>
	<button onclick=zoom("+")>+</button>
	<script>
		function zoom(option)
		{
			var gravetat=parseInt(document.querySelector('svg').getAttribute('gravetat'))
			var augments=250;
			switch(option)
			{
				case "-":
					gravetat-=augments;break;
				case "+":
					gravetat+=augments;break;
				default:return;break;
			}
			createGraph(gravetat)
		}
	</script>
</div>

<svg width="700" height="600"></svg>

<!--create graph-->
<script>
	createGraph() //called in <body onload=init()>
	function createGraph(gravetat)
	{
		gravetat = Math.abs(gravetat)+0.01 || 60;

		//empty element
		document.querySelector('svg').innerHTML="";

		var json = 
		{ 
			nodes: [
				// {"name": "Napoleon", "group": 1},
				// {"name": "Myriel",   "group": 1},
			],
			links: [
				// {"source": "Napoleon", "target": "Myriel", "value": 1},
				// {"source": "Myriel",  "target": "Myriel", "value": 8},
			],
		};

		function existsTank(tank)
		{
			for(var i in Tanks)
			{
				if(Tanks[i].name==tank) return true
			}
			return false
		}

		//add nodes: services and tanks
		for(var i in Tanks)
		{
			json.nodes.push( {name:Tanks[i].name, group:1} )
		}
		for(var node in Nodes)
		{
			//add only if not exists in tanks
			if(!existsTank(node))
				json.nodes.push( {name:node, group:0} )
		}

		//add links
		for(var i in Connections)
		{
			//count the number of links going out from node "from"
			var n_links = (function(){
				var n=0;
				for(var j in Connections)
				{
					if(Connections[i].from==Connections[j].from) 
						n++;
				}
				return n;
			})();
			var link_width_divisor = 350;
			var value=(function(){
				try{
					return Nodes[Connections[i].from].value/link_width_divisor/n_links||1;
				}catch(e){return 1}
			})();

			json.links.push( { source:Connections[i].from, target:Connections[i].to, value:value } )
		}
		
		//draw
		dibuixa(json,gravetat);

		function dibuixa(json,gravetat) 
		{
			gravetat = gravetat || 60;

			var svg = d3.select("svg"),
			width   = +svg.attr("width"),
			height  = +svg.attr("height");

			document.querySelector('svg').setAttribute('gravetat',gravetat)

			var color = d3.scaleOrdinal(d3.schemeCategory20);

			var simulation = d3.forceSimulation()
				.force("link", d3.forceLink().id(function(d){return d.name}))
				.force("charge",d3.forceManyBody())
				.force("center",d3.forceCenter(width/2,height/2))

			var link = svg.append("g")
				.attr("class", "links")
				.selectAll("line")
				.data(json.links)
				.enter().append("line")
				.attr("stroke-width", function(d) { return Math.sqrt(d.value)||1; })


			//controla distancia dels nodes
			simulation.force('charge',d3.forceManyBody().strength(function(){return -1*gravetat}))

			var node = svg.append("g")
				.attr("class","nodes")
				.selectAll("node")
				.data(json.nodes)
				.enter().append("g")
				.attr("class", "node")

			node.append("circle")
				.attr("r", 7)
				.attr("fill", function(d) { return color(d.group); })
				.call(d3.drag()
					.on("start", dragstarted)
					.on("drag", dragged)
					.on("end", dragended));

			node.append("text")
				.attr("dx", 12)
				.attr("dy", ".35em")
				.text(function(d) { return d.name; });

			simulation
				.nodes(json.nodes)
				.on("tick", ticked);

			simulation.force("link")
				.links(json.links);

			function ticked(){
				link
					.attr("x1", function(d) {return d.source.x;})
					.attr("y1", function(d) {return d.source.y;})
					.attr("x2", function(d) {return d.target.x;})
					.attr("y2", function(d) {return d.target.y;});
				node.selectAll('circle')
					.attr("cx", function(d) {return d.x;})
					.attr("cy", function(d) {return d.y;});
				node.selectAll('text')
					.attr("x", function(d) {return d.x;})
					.attr("y", function(d) {return d.y;});
			}

			function dragstarted(d) {
				if (!d3.event.active) simulation.alphaTarget(0.3).restart();
					d.fx = d.x;
					d.fy = d.y;
			}

			function dragged(d) {
				d.fx = d3.event.x;
				d.fy = d3.event.y;
			}

			function dragended(d) {
				if (!d3.event.active) simulation.alphaTarget(0);
				d.fx = null;
				d.fy = null;
			}
		}
	}
</script>
