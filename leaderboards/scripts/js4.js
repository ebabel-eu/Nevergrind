$.ajaxSetup({
	type:'POST',
	url: 'php/master1.php'
});
g = {};
g.levelMax = [100,276,441,624,825,1044,1281,1536,1809,//10
	2650,3014,3396,3796,4214,5400,5904,6426,6966,7524,
	9100,9744,10406,11086,11784,13750,14534,15336,16156,16994,
	19650,20584,21536,22506,23494,26600,27684,28786,29906,31044,
	34600,35834,37086,38356,39644,44100,45494,46906,48336,49784,
	54750,56304,57876,59466,61074,67100,68824,70566,72326,74104,
	81300,83204,85126,87066,89024,97500,99594,101706,103836,105984,
	115850,118144,120456,122786,125134,135750,138244,140756,143286,145834,
	166800,169614,172446,175296,178164,206550,209754,212976,216216,219474,
	267750,271544,275356,279186,
	283034, //94 - 283034
	676400, //95 - 676400 - 7045176
	3775584, //96 - 3775584 - 7721576
	23652286, //97 - 23652286 - 11497160
	68686338
];
function reportCombos(foo){
	$.ajax({
		url: "php/boards1.php",
		data: { 
			run: 'leaderboardNormalCombos',
			filter: convertLeaderboardClass(foo)
		}
	}).done(function(data){
		writeLeaderboardServer(data, false, 'rating');
	});
} 
function reportHCCombos(foo){
	$.ajax({
		url: "php/boards1.php",
		data: { 
			run: 'leaderboardHardcoreCombos',
			filter: convertLeaderboardClass(foo)
		}
	}).done(function(data){
		writeLeaderboardServer(data, false, 'rating');
	});
}
function reportKills(foo){
	$.ajax({
		url: "php/boards1.php",
		data: { 
			run: 'leaderboardNormal',
			filter: convertLeaderboardClass(foo)
		}
	}).done(function(data){
		writeLeaderboardServer(data, false);
	});
}
function reportHCKills(foo){
	$.ajax({
		url: "php/boards1.php",
		data: { 
			run: 'leaderboardHardcore',
			filter: convertLeaderboardClass(foo)
		}
	}).done(function(data){
		writeLeaderboardServer(data, true);
	});
}
function writeLeaderboardServer(data, hcmode, rating){
	var a=data.split("|");
	a.pop();
	var h4 = "Experience";
	if(rating){
		h4 = "Rating";
	}
	var string=
	"<tr>"+
		"<th width='80px'>Rank</th>"+
		"<th width='400px'>Name</th>"+
		"<th width='120px'>Level</th>"+
		"<th width='140px'>"+h4+"</th>"+
		"<th width='180px'>Class</th>"+
		"<th width='100px'>Race</th>"+
	"</tr>";
	var row=1;
	while(a.length>0){
		var title=a.shift();
		var name=a.shift();
		var lastName=a.shift();
		var finalName = '';
		if(title){
			finalName = title+' '+name;
		}else{
			finalName = name;
		}
		if(lastName){
			finalName += ' '+lastName;
		}
		var lvl = a.shift();
		var e1 = a.shift();
		var level = lvl;
		if(!rating){
			level = setCurrentLevel(e1);
		}
		var exp=e1;
		if(exp>103835784){
			exp = 103835784;
		}
		var job=a.shift();
		var race=a.shift();
		if(hcmode===true){
			var deaths=parseInt(a.shift(),10);
		}
		var linkName = name.replace(/'/g, "%27");
		linkName =  linkName.replace(/"/g, "%22");
		if(hcmode===false ||
		(deaths===0&&hcmode===true)){
			string+="<tr><td>"+row+"</td><td><a href='http://nevergrind.com/nevergrounds/index.php?character="+linkName+"'>"+
			finalName+"</a></td><td>"+
			level+"</td><td>"+
			exp+"</td><td>"+
			job+"</td><td>"+
			race+"</td></tr>";
			row++;
		}else{
			var kek="<tr class='dead'><td>"+row+"</td><td><a href='http://nevergrind.com/nevergrounds/index.php?character="+name+"'>"+finalName+"</a></td><td>"+level+"</td><td>"+exp+"</td><td>"+job+"</td><td>"+race+"</td></tr>";
			string+=kek;
			row++;
		}
	}
	string+="<tr><td>&nbsp;</td></tr>";
	document.getElementById('leaderboardResults').innerHTML=string;
}