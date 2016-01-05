<?php
 /* DAO for dispatch */

include ("class.dispatch.vo.php");

class DAOdispatch { 

	/* gets a vo by did */
	public function get($did){
		/* ensure did is an integer */
		if(!is_numeric($did)) throw  new Exception("did of dispatch must be an integer");

		$result=mysql_query("SELECT * FROM dispatch WHERE did=$did");
		if($result){/*ensure query success*/
			if($row = mysql_fetch_array($result)){/*ensure record*/
				$vo = new dispatch($row['uid'],$row['carrier'],$row['phone'],$row['pieces'],$row['space'],$row['act_wgt'],$row['as_wgt'],$row['type'],$row['attention'],$row['reference'],$row['trailer_id'],$row['truck_id'],$row['pay_code'],$row['pay_type'],$row['rate'],$row['total']);
				$vo->did = $did;
				return $vo;
			}
		}

		return NULL;
	}

	/* returns all vo */
	public function getAll($limit1,$limit2){
		$result=mysql_query("SELECT * FROM dispatch LIMIT " . $limit1 . "," . $limit2 );
		if($result){/*ensure query success*/
			$vlist = array();
			while($row = mysql_fetch_array($result)){/*ensure record*/
				$vo =  new dispatch($row['uid'],$row['carrier'],$row['phone'],$row['pieces'],$row['space'],$row['act_wgt'],$row['as_wgt'],$row['type'],$row['attention'],$row['reference'],$row['trailer_id'],$row['truck_id'],$row['pay_code'],$row['pay_type'],$row['rate'],$row['total']);
				$vo->did = $row['did'];
				$vlist[] = $vo;
			}
			return $vlist;
		}

		return NULL;
	}

	/* returns all vo as per user */
	public function getAllByUser($uid, $limit1,$limit2){
		$result=mysql_query("SELECT * FROM dispatch where uid=$uid LIMIT " . $limit1 . "," . $limit2 );
		if($result){/*ensure query success*/
			$vlist = array();
			while($row = mysql_fetch_array($result)){/*ensure record*/
				$vo = new dispatch($row['uid'],$row['carrier'],$row['phone'],$row['pieces'],$row['space'],$row['act_wgt'],$row['as_wgt'],$row['type'],$row['attention'],$row['reference'],$row['trailer_id'],$row['truck_id'],$row['pay_code'],$row['pay_type'],$row['rate'],$row['total']);
				$vo->did = $row['did'];
				$vlist[] = $vo;
			}
			return $vlist;
		}

		return NULL;
	}

	/* returns number of vo */
	public function getCount(){
		$result = mysql_num_rows(mysql_query("select * from dispatch"));
		return $result;
	}

	/* insert new record in db */
	public function insert(&$vo){
		$q = "INSERT INTO dispatch(did,uid,carrier,phone,pieces,space,act_wgt,as_wgt,type,attention,reference,trailer_id,truck_id,pay_code,pay_type,rate,total) VALUES(' ','$vo->uid', '$vo->carrier','$vo->phone','$vo->pieces','$vo->space','$vo->act_wgt','$vo->as_wgt','$vo->type','$vo->attention','$vo->reference','$vo->trailer_id','$vo->truck_id','$vo->pay_code','$vo->pay_type','$vo->rate','$vo->total')";
		 if(mysql_query($q)){
			$result = mysql_query("Select MAX(did) from dispatch");
			if($row = mysql_fetch_array($result)){
				$vo->did=$row[0];
				return true;
			}
		}
		return false;
	}

	/* update an existing record in db */
	public function update(&$vo){
		return mysql_query("UPDATE dispatch SET uid = '$vo->uid', carrier = '$vo->carrier',phone = '$vo->phone',pieces = '$vo->pieces',space = '$vo->space',act_wgt = '$vo->act_wgt',as_wgt = '$vo->as_wgt',type = '$vo->type',attention = '$vo->attention',reference = '$vo->reference',trailer_id = '$vo->trailer_id',truck_id = '$vo->truck_id',pay_code = '$vo->pay_code',pay_type = '$vo->pay_type',rate = '$vo->rate',total = '$vo->total' WHERE did = $vo->did ");
	}

	/* save the value object in db */
	public function save(&$vo){
		if($vo->did == 0){
			return $this->insert($vo);
		}
		return $this->update($vo);
	}

	/* delete an existing record from db */
	public function del(&$vo){
		if(mysql_query("DELETE FROM dispatch WHERE did=$vo->did")) {
			$vo->did=0;
		}
	}

	/* gets max id from db */
	public function getMaxId(){
		$result = mysql_query("Select MAX(did) from dispatch");
		if($row = mysql_fetch_array($result)){
			return $row[0];
		}
		return NULL;
	}

 }
/* DAOdispatch */
?>
