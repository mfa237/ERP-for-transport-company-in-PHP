<script type = "text/javascript" >
	function validateUpload(){ 

		var uid =  document.forms["frmUpload"]["uid"].value; 
		var title =  document.forms["frmUpload"]["title"].value; 
		var type =  document.forms["frmUpload"]["type"].value; 
		var date =  document.forms["frmUpload"]["date"].value; 
		var img =  document.forms["frmUpload"]["img"].value; 

		if(uid == null || uid == ""){
			alert("uid can't be empty");
			return false;
		}
		if(title == null || title == ""){
			alert("title can't be empty");
			return false;
		}
		if(type == null || type == ""){
			alert("type can't be empty");
			return false;
		}
		if(date == null || date == ""){
			alert("date can't be empty");
			return false;
		}
		if(img == null || img == ""){
			alert("img can't be empty");
			return false;
		}

		return true;
	}
</script>
<?php
include("header.php");
include("class.upload.dao.php");
?>
<form name = "frmUpload" method="POST" action="save.upload.php"  onsubmit = "return validateUpload();">
	<table cellspacing="5" cellpadding="5">
		<?php
		if(isset($_GET["id"])){
			$dao = new DAOupload();
			$vo = $dao->get($_GET["id"]);
		?>
			<tr>
				<td> uid </td>
				<td><input type = "text" name = "uid" value= "<?=$vo->uid?> "/></td>
			</tr>
			<tr>
				<td> title </td>
				<td><input type = "text" name = "title" value= "<?=$vo->title?> "/></td>
			</tr>
			<tr>
				<td> type </td>
				<td><input type = "text" name = "type" value= "<?=$vo->type?> "/></td>
			</tr>
			<tr>
				<td> date </td>
				<td><input type = "text" name = "date" value= "<?=$vo->date?> "/></td>
			</tr>
			<tr>
				<td> img </td>
				<td><input type = "text" name = "img" value= "<?=$vo->img?> "/></td>
			</tr>
			<tr colspan = "2">
				<th><input type = "submit" value= "EDIT"  /></th>
			</tr>
			<input type = "hidden" name = "upload_id" value= "<?=$vo->upload_id?> "/>
		<?}else{?>
			<tr>
				<td> uid </td>
				<td><input type = "text" name = "uid" /></td>
			</tr>
			<tr>
				<td> title </td>
				<td><input type = "text" name = "title" /></td>
			</tr>
			<tr>
				<td> type </td>
				<td><input type = "text" name = "type" /></td>
			</tr>
			<tr>
				<td> date </td>
				<td><input type = "text" name = "date" /></td>
			</tr>
			<tr>
				<td> img </td>
				<td><input type = "text" name = "img" /></td>
			</tr>
			<tr colspan = "2">
				<th><input type = "submit" value= "ADD"  /></th>
			</tr>
		<?}?>
	</table>
</form>
<?
include("footer.php");
?>