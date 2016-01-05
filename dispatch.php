<?php
session_start();
include("class.dispatch.dao.php");
include_once("header.php");
$dao = new DAOdispatch();
?>
<center><b><u><font face ="Britannic Bold"><h1>Dispatch</h1></font></u></b></center><br><br><br>
<a href="form.dispatch.php" class="btn btn-info">Add dispatch</a><br><br>
<table class="table table-striped">
	<tr class ="info">
		<td>#</td>
		<td>Carrier</td>
		<td>Phone</td>
		<td>Pieces</td>
		<td>Space</td>
		<td>Actual Weight</td>
		<td>Assumed Weight</td>
		<td>Type</td>
		<td>Attention</td>
		<td>Reference</td>
		<td>Trailer Id</td>
		<td>Truck Id</td>
		<td>Pay Code</td>
		<td>Pay Type</td>
		<td>Rate</td>
		<td>Total</td>
		<td><b>Edit</b></td>
		<td><b>Delete</b></td>
	</tr>

<?php
$rec_per_page = 10;
if(isset($_GET['page']))
	$page = $_GET['page'];
else
	$page = 1;
$limit1 = ($page-1)*$rec_per_page;
$limit2 = ($page)*$rec_per_page;
$total_recs = $dao->getCount();
$rec = $dao->getAllByUser($_SESSION["uid"],$limit1, $limit2);
$pages = ceil($total_recs/$rec_per_page);
if($page==1)	$prev = $page;
else	$prev=$page-1;

if($page==$pages)	$next = $page;
else	$next=$page+1;
$i = 0;
if($rec) foreach($rec as $row) {
	$i++;
?>
	<tbody>
	<tr>
		<td><? echo $i ?>	</td>
		<td><? echo $row->carrier ?>	</td>
		<td><? echo $row->phone ?>	</td>
		<td><? echo $row->pieces ?>	</td>
		<td><? echo $row->space ?>	</td>
		<td><? echo $row->act_wgt ?>	</td>
		<td><? echo $row->as_wgt ?>	</td>
		<td><? echo $row->type ?>	</td>
		<td><? echo $row->attention ?>	</td>
		<td><? echo $row->reference ?>	</td>
		<td><? echo $row->trailer_id ?>	</td>
		<td><? echo $row->truck_id ?>	</td>
		<td><? echo $row->pay_code ?>	</td>
		<td><? echo $row->pay_type ?>	</td>
		<td><? echo $row->rate ?>	</td>
		<td><? echo $row->total ?>	</td>
		<th><a href='form.dispatch.php?id=<? echo $row->did ?>'><img src="img/edit.png" width = 20 height = 20 /></a></th>
		<th><a href='delete.dispatch.php?id=<? echo $row->did ?>'><img src="img/del.png" width = 20 height = 20/></a></th>
	</tr>
	</tbody>
<?}
else echo "<tr><td colspan='16'><center><br><br><br><b>No Dispatches are added yet.</b></center></td></tr>";
?>
</table>
<?
if($page != 1){
?>&nbsp;&nbsp;<a href="dispatch.php?page=<?=$prev?>" style="margin-right:20px">Prev</a>
<?}
for ($p =1; $p<=$pages ; $p++){
 ?>&nbsp;&nbsp;<a href="dispatch.php?page=<?=$p?>"><?=$p."/".$pages?></a>
<?
}
if($page != $pages){
?><a href="dispatch.php?page=<?=$next?>" style="margin-left:20px">Next</a>
<a href="dispatch.php?page=<?=$pages?>"style="margin-left:12px">Last</a><br />
<?}
?>
<?php
include("footer.php");
?>