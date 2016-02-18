// database design
- Account table
- character table - cID linked to aID
- item, equipment, bank table - iID linked to cID
- mobs table - mID linked to cID

// log tables
- unique drop table
- active table - uID linked to cID - beaconpush.com or pusher.com instead?
- chat table - mID linked to cID - beaconpush.com or pusher.com instead?
- levelUp table - lID linked to cID


// beziers
TweenMax.to(e, 10, {
	bezier:{
		curviness:1.25,
		values:[
			{left:400, top:500},
			{left:600, top:800},
			{left:200, top:300}
		],
		autoRotate:true
	},
	ease:Linear.easeIn
});

// sessions
session_start();
if(isset($_SESSION['views'])){
	$_SESSION['views']+=1;
}else{
	$_SESSION['views']=1;
}

later...
<?php echo $_SESSION['views']; ?>

// time
date_default_timezone_set('UTC');
$today = date("Y-m-d");
$time = date("H:i:s");

// connect
$link = mysql_connect('localhost:3360","root","");
if(!$link){
	die('Could not connect: '.mysql_connect_error());
}

$db = mysql_select_db('nevergrind', $link);
if(!$db){
	die('Cannot use ng: '.mysql_error());
}

// clean data
function safe($var){
	return mysql_real_escape_string($var);
}
function clean($var){
	$illegal = array("\\", "/", ":", "*", "?", '"', "'", ">", "<", "|");
	$var = str_replace($illegal, "", $var);
	return $var;
}
$myvar = safe(clean($_POST['myvar']));


//select
$result = mysql_query("
	select name from ng where name='".$name."';
");
$dbName = mysql_result($result, 0);

// select - group by
$result = mysql_query("
	select c.cID,
	c.name,
	c.exp,
	sum(drops) uniques
	from characters c
	left join drops d on d.dID=c.cID
	where season=2 
	group by c.cID 
	order by c.cID
");

// select - time sensitive 1
$result = mysql_query("
	select count(d.dID) drops from dropLog d left join characters c on d.dID=c.cID where c.cID='".$ID."' and w.date>DATE_SUB(CURDATE(), INTERVAL 7 DAY) order by d.dID;
");

// select - time sensitive 2
$result = mysql_query("
	select d.dID, count(d.dID) as drops from dropLog w inner join characters c on d.dID=c.cID where d.season=2 and d.date>DATE_SUB(CURDATE(), INTERVAL 15 DAY) group by d.dID order by drops desc limit 50
");

// select - count rows
if(mysql_num_rows($result)>0){ }

// echo select results
$str = '';
while($row = mysql_fetch_assoc($result)){
	$str.= $row['cID'].'|';
	$str.= $row['cID'].'|';
	$str.= $row['cID'].'|';
	$str.= $row['cID'].'|';
}
echo $string;

// update
update accounts set time=CURRENT_TIMESTAMP where aID=1;

$result = mysql_query("
	update ng set name='".$name."',
	exp='".$exp."',
	gold='".$gold."';	
");

// insert
mysql_query("
	insert into drops (`name`, `hp`, `dam`, `delay`)
	values('".$name."',
	'".$hp."',
	'".$dam."',
	'".$delay."'
	);
");

// hash passwords
function checkPassword(){
	function rand_str($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'){
		$str = '';
		$count = strlen($charset);
		while($length--){
			$str .= $charset[mt_rand(0, $count-1)];
		}
		return $str;
	}
	$hash = '';
	$pw = $_POST['password'];
	if(isset($pw) && !empty($pw) && is_string($pw)){
		$salt = rand_str(rand(100,200));
		$hash = crypt($pw, '$2a$07$'.$salt.'$');
	}
	$hash = crypt($pw);
	$verify = crypt($pw, $hash);
	echo $salt." | ".$hash." | ".$verify;
}

// database cheat sheet
create table test(
	vID int auto_increment primary key,
	title varchar(255),
	duration smallint,
	date date,
	time time,
	hits int,
	sid tinytext,
	primary key (vID),
	foreign key (vID) references videos(vID)
);

// constraints
alter table test modify column vID int not null auto_increment;
alter table test modify column tag tinytext not null;
alter table videos modify column description mediumtext default '' not null;

// add column index
alter table videos add index (project);

// column order
alter table comments modify column name tinytext after sid;

// add column
alter table test add uploadDate date;

// rename column
alter table tbl_help change column help content varchar(200);

// add foreign key
alter table test add foreign key (vID) references test(vID);

// remove foreign key
alter table testTag drop foreign key vID;

// user privileges
update mysql.user set max_questions = 0, max_updates = 0, max_connections = 0 where user='myuser' and host='x.x.x.x';
flush privileges;

date_default_timezone_set('UTC');
$GLOBALS['today'] = date("Y-m-d");
$GLOBALS['time'] = date("H:i:s");

$link = new mysqli("localhost","user","pw","db");

function countRows(){
  global $link;
  $query = "select sid from users";
  $result = $link->query($query);
  $count = $result->num_rows;
  echo $count; 
}
function selectRows(){
  global $link;
  $query = "select timestamp, name, title from watchLog";
  if($result = $link->query($query)){
    $string = '';
    while($row = $result->fetch_assoc()){
      $string .= $row['timestamp']."|";
      $string .= $row['name']."|";
      $string .= $row['title']."|";
    }
    echo $string;
  }
}
function insertRow(){
  global $link;
  $query = "insert into chat (
    message,
    date,
    time
  ) values (
    'test3',
    '".$GLOBALS['today']."',
    '".$GLOBALS['time']."'
  )";
  $link->query($query);
}
function updateRow(){
  global $link;
  $slot = "3420";
  $query = "update chat set message='555' where cID='".$slot."'";
  $link->query($query);
}
call_user_func($_POST['run']);