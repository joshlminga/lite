<!DOCTYPE html>
<html>
<head>
<title>menu</title>
<style>
#Menu{
	max-height:570px;
	overflow-y:scroll;
	/*background:red;*/
}
</style>
</head>
<body>
<?php
	$conn = mysqli_connect("localhost","root","","db");
	if (mysqli_connect_errno()) {
		echo "connection failed:" . mysqli_connect_error();
		exit;
	}
	
	function loop_array($array = array(), $parent_id = 0){
		if(!empty($array[$parent_id])){ echo '<ul class="">';
		foreach($array[$parent_id] as $items){
		echo '<li>';
		echo $items['name'];
		loop_array($array, $items['id']);
		echo '</li>'; 
		}
		echo '</ul>'; }
	}

	function displaymenu($conn) {
		$array = array();
		$query = "SELECT * FROM menu";
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_assoc($result)){
			//$array[] = $row;
			$array[$row['parent_id']][] = $row;
		}
		loop_array($array);
		//return $array;
		print_r($array);
	}
	
	//db table cols -- //id, name, parent_id
	
	
?>
<div id="Menu">
  <!--<a class="active" href="http://#">Home</a>-->
  <?php displaymenu($conn); ?>
</div>
</body>
</html>