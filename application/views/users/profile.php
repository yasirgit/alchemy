<?$CI =& get_instance();?>
<h3>Profile</h3>
Username: <?=$user['username']?><br /> <br />
Last weight: <?=$user['last_weight_kg']." ".$user['weight_measure']?><br/ ><br />
Last weight date: <?=daysToDate($user['last_weight_date_int'])?><br/ ><br />
Goal weight: <?=$user['goal_weight_kg']." ".$user['weight_measure']?><br/ ><br />
Height: <?=$user['height_cm']." ".$user['height_measure']?><br/ ><br />
<a href="/users/edit/<?=$user['username_clean']?>">Edit</a>