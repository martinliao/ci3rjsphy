<?php
function QueryToArray($query){
  $arrAll = array();
if($query->num_rows() > 0)
{
foreach($query->result_array() as $row)
{
  array_push($arrAll,$row);
}
}
return $arrAll;
}
//include "init.inc.php";
// if ( $user['account'] === 'vitasy') {
// //    $db->debug = true;
// }
// 載入縣市區的對照表
$cityArr = array();
$rs_city = $this->db->query("select CITY, CITY_NAME from co_city");
$rs_city = QueryToArray($rs_city);
if($rs_city) 
for ($i=0; $i < sizeof($rs_city); $i++) {
  $row_city =$rs_city[$i];
  $cityArr[$row_city['CITY']] = $row_city['CITY_NAME'];
}

$subcityArr = array();
$rs_subcity = $this->db->query("select CITY, SUBCITY, SUBCITY_NAME from co_subcity");
$rs_subcity = QueryToArray($rs_subcity);
if($rs_subcity)
for ($i=0; $i < sizeof($rs_subcity); $i++) {
  $row_subcity =$rs_subcity[$i];
  $k = "{$row_subcity['CITY']}-{$row_subcity['SUBCITY']}";
    $subcityArr[$k] = $row_subcity['SUBCITY_NAME'];
} 

function getClassDate1($year, $class_no, $term){

	$rs = $this->db->query("select * from REQUIRE where YEAR = '{$year}' and CLASS_NO = '{$class_no}' and TERM = '{$term}'");
  $rs = QueryToArray($rs);
  if($rs){
    for ($i=0; $i < sizeof($rs); $i++) { 
      $row=$rs[$i];
      return $row['START_DATE1'] . ' ~ ' . $row['END_DATE1'];
    }		
	}
	else return '';
}

function HT_class_type($year, $class_no, $term){
	$item_id = QueryToArray($this->db->query("select HT_CLASS_TYPE from REQUIRE where YEAR = '{$year}' and CLASS_NO = '{$class_no}' and TERM = '{$term}'"))[0]['HT_CLASS_TYPE'];
	$cname = QueryToArray($this->db->query("select DESCRIPTION from CODE_TABLE where TYPE_ID = '07' and ITEM_ID = '{$item_id}'"))[0]['DESCRIPTION'];
	return $cname;
}


require dirname(__FILE__) . "/tcpdf_php4/tcpdf.php";
class MYPDF extends TCPDF {
    // Page footer
    function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('msungstdlight', '', 8);
        // Page number
        $this->Cell(0, 10, $this->getAliasNumPage(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
//$pdf = new TCPDF();
$pdf->setPrintHeader(false);
//$pdf->setPrintFooter(false); // 使用印列頁碼時，$pdf->setPrintFooter(false);這行要mark掉
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->AddPage();
//$pdf->SetMargins(15,15,15,15);
$pdf->SetFont('msungstdlight', '', 8);
$pdf->SetAutoPageBreak(true, 13);
// require_once APPPATH . "views/search_work/course_record_student/fpdf1/pdf_html.php";
// $pdf=new PDF_HTML();
// $pdf->Open();
// $pdf->AddPage();

// $pdf->SetMargins(7,5,10,10);
// $pdf->AddUniCNShwFont('uni');  //fontA 可用習慣名稱
// $pdf->SetFont('uni', '', 8 );          //設定文字格式SetFont('字體名稱', '粗體', SIZE )
// //$setTOP=22;
// $pdf->SetAutoPageBreak(false);

//查詢
//------------------------------------------------------------------------------------
$d1 = trim($s1);
$d2 = trim($s2);

//$mtList   = trim($_REQUEST['mtList']);
$mtList='';
// $year     = trim($_REQUEST['year']);
$year='';
// $class_no = trim($_REQUEST['class_no']);
$class_no='';
// $term     = trim($_REQUEST['term']);
$term='';
$paper_app_seq     = $this->db->escape(trim($_REQUEST['paper_app_seq']));
//$is_status_ok     = trim($_REQUEST['is_status_ok']);

$where1 = "and a.use_date between date('{$d1}') and date('{$d2}')";
$where2="";
$show_app_seq='';
// if ($year!="" && $class_no!="" && $term!="" && $mtList ==''){ // custom by chiahua補上mtList == ''
//   $where2 = "and a.year = '{$year}' and a.class_no = '{$class_no}' and a.term = '{$term}'";
// }
// else{
//   $where2 = "";
//   $arry = explode(",,",$mtList);
//   for ($x=0;$x<count($arry);$x++){
//     if ($arry[$x]!="")
//     {
//       $arryValue = explode("::",$arry[$x]);
//       if ($where2==""){
//         $where2 .= "select '{$arryValue[0]}','{$arryValue[1]}','{$arryValue[2]}' from dual ";
//       }
//       else{
//         $where2 .= "union all select '{$arryValue[0]}','{$arryValue[1]}','{$arryValue[2]}' from dual ";
//       }
//     }
//   }
//   $where2 = "and (a.year, a.class_no, a.term) in ({$where2})";

//   $show_app_seq = $arryValue[3];
// }

if($paper_app_seq != ''){
	$where3 = " and a.seq in ( select seq from hour_app where app_seq = ".$this->db->escape(addslashes($paper_app_seq))." )";
}
else{

}

$sql = "select year, class_no, class_name, term from hour_traffic_tax a " .
       "where 1=1 {$where1} {$where2} {$where3} " .
       "group by year, class_no, class_name, term order by year, class_no, term";

// 來自13C查看清冊
$from_13C = true;

if($from_13C == true){
	$sql = "select year, class_no, class_name, term from hour_traffic_tax a " .
		   "where 1=1 {$where3} " .
		   "group by year, class_no, class_name, term order by year, class_no, term";
}
//echo 'sql:'.$sql;
$rs = $this->db->query($sql);
$rs = QueryToArray($rs);
//sys_log_insert_2(basename(__FILE__),$_SESSION['FUNCTION_ID'],'02','06');
//------------------------------------------------------------------------------------


//PDF
//------------------------------------------------------------------------------------
/*
include ('fpdf1/chinese-unicode.php');
$pdf = new PDF_Unicode();
$pdf->SetAutoPageBreak("on","20");
$pdf->AddUniCNShwFont('uni');
$pdf->SetFont('uni','',12);
$pdf->Open();
$pdf->AddPage("L");
$pdf->SetMargins(15,5,15,10);

$title="臺北市政府公務人員訓練處    ";
$title.= "請款清冊";

//表頭
$pdf->SetFontSize(14);
$pdf->Cell(280,10,$title,0,1,'C');

$pdf->SetFontSize(8);
$pdf->Cell(20,10,"上課日期",1,0,'C');
$pdf->Cell(30,10,"姓名/公司\nID/編號",1,0,'C');
$pdf->Cell(30,10,"銀行分號\n帳號",1,0,'C');
$pdf->Cell(40,10,"地址\ne-mail",1,0,'C');
$pdf->Cell(10,10,"時數",1,0,'C');
$pdf->Cell(20,10,"單價",1,0,'C');
$pdf->Cell(20,10,"鐘點費",1,0,'C');
$pdf->Cell(30,10,"交通費\n(火車莒光)",1,0,'C');
$pdf->Cell(20,10,"合計",1,0,'C');
$pdf->Cell(20,10,"簽章",1,0,'C');
$pdf->Cell(20,10,"備註",1,1,'C');


while($fields = $rs->FetchRow()){
	$pdf->Cell(20,10,$fields['USE_DATE'],1,0,'C');
	$pdf->Cell(30,10,$fields['TEACHER_NAME'],1,0,'C');

	$tmp = $fields['TEACHER_BANK_ID'] . " " . $fields['TEACHER_ACCOUNT'];
	$pdf->Cell(30,10,$tmp,1,0,'C');

	$pdf->Cell(40,10,$fields['TEACHER_ADDR'],1,0,'C');
	$pdf->Cell(10,10,$fields['HRS'],1,0,'C');
	$pdf->Cell(20,10,$fields['UNIT_HOUR_FEE'],1,0,'C');
	$pdf->Cell(20,10,$fields['HOUR_FEE'],1,0,'C');
	$pdf->Cell(30,10,$fields['TRAFFIC_FEE'],1,0,'C');
	$pdf->Cell(20,10,$fields['SUBTOTAL'],1,0,'C');
	$pdf->Cell(20,10,"",1,0,'C');
	$pdf->Cell(20,10,$fields['MODIFYED'],1,1,'C');
}

$pdf->Output();
*/
//------------------------------------------------------------------------------------
?>
<?php
  $outputHTML='';
  $outputHTML .= '<table width="100%">';
  $outputHTML .= '<tr>';
  $outputHTML .= '<td align="center">';
  $outputHTML .= '<font face="標楷體" size="15">臺北市政府公務人員訓練處    請款清冊'. ($show_app_seq != "" ? "(流水號{$show_app_seq})" : ($paper_app_seq != "" ? "(流水號".htmlspecialchars($paper_app_seq, ENT_HTML5|ENT_QUOTES).")" : "")) .'</font><br>';
  $outputHTML .= '</td>';
  $outputHTML .= '</tr>';
  $outputHTML .= '</table>';

  for ($i=0; $i < sizeof($rs); $i++) {
    $fields=$rs[$i]; 
    /*
      $sql = "select * from hour_traffic_tax a where status = '待確認' " .
            "and year = '{$fields['YEAR']}' and class_no = '{$fields['CLASS_NO']}' and term = '{$fields['TERM']}' " .
            "{$where1} AND seq NOT IN (SELECT seq FROM hour_app) order  by USE_DATE ";

      if($from_13C == true){
        $sql = "select * from hour_traffic_tax a where status = '待確認' " .
              "and year = '{$fields['YEAR']}' and class_no = '{$fields['CLASS_NO']}' and term = '{$fields['TERM']}' " .
              "{$where3}  order  by USE_DATE ";
      }
    */
      $sql = "select a.seq, p.course_date, min(p.from_time) from_time, t.teacher_type as teacher, t.name, t.account_name as acct_name
      from hour_traffic_tax a join periodtime p on a.year=p.year and a.term=p.term and a.class_no=p.class_no and a.use_date=p.course_date 
    join room_use cr on a.year=cr.year and a.term=cr.term and a.class_no=cr.class_id and a.teacher_id=cr.teacher_id and cr.use_date = p.course_date and cr.use_period=p.id and cr.room_id=p.room_id 
    join teacher t on t.id=cr.teacher_id and a.teacher_id = t.id and t.teacher_type=cr.isteacher and a.isteacher = t.teacher_type
    where a.status = '待確認' and a.year = '{$fields['year']}' and a.class_no = '{$fields['class_no']}' and a.term = '{$fields['term']}' 
      {$where1} AND a.seq NOT IN (SELECT seq FROM hour_app) group by  a.seq, p.course_date, t.teacher_type, t.name	order by p.course_date, from_time, t.teacher_type desc, t.name ";

    if($from_13C == true){
    $sql = "select a.seq, p.course_date, min(p.from_time) from_time, t.teacher_type as teacher, t.name, t.account_name as acct_name
    from hour_traffic_tax a join periodtime p on a.year=p.year and a.term=p.term and a.class_no=p.class_no and a.use_date=p.course_date 
    join room_use cr on a.year=cr.year and a.term=cr.term and a.class_no=cr.class_id and a.teacher_id=cr.teacher_id and cr.use_date = p.course_date and cr.use_period=p.id and cr.room_id=p.room_id 
    join teacher t on t.id=cr.teacher_id and a.teacher_id = t.id and t.teacher_type=cr.isteacher and a.isteacher = t.teacher_type
          where a.status = '待確認' and a.year = '{$fields['year']}' and a.class_no = '{$fields['class_no']}' and a.term = '{$fields['term']}' 
        {$where3}  group by  a.seq, p.course_date, t.teacher_type, t.name order by p.course_date, from_time, t.teacher_type desc, t.name ";
    }

    //#47552 實體系統-13A及13B已產生流水號的請款清冊、憑證資料沒有by流水號：增加請款流水號的判斷
    //#mis28223 實體系統-13A、13B合併在一個流水號，產出的格式有誤：加入年、班期、期別過濾
    if($paper_app_seq){
    $sql = "select a.seq, p.course_date, min(p.from_time) from_time, t.teacher_type as teacher, t.name, t.account_name as acct_name
    from hour_traffic_tax a join periodtime p on a.year=p.year and a.term=p.term and a.class_no=p.class_no and a.use_date=p.course_date 
    join room_use cr on a.year=cr.year and a.term=cr.term and a.class_no=cr.class_id and a.teacher_id=cr.teacher_id and cr.use_date = p.course_date and cr.use_period=p.id and cr.room_id=p.room_id 
    join teacher t on t.id=cr.teacher_id and a.teacher_id = t.id and t.teacher_type=cr.isteacher and a.isteacher = t.teacher_type
      where a.seq in (select seq from hour_app where app_seq = ".$this->db->escape(addslashes($paper_app_seq))."
      and a.year = '{$fields['year']}'
      and a.class_no = '{$fields['class_no']}'
      and a.term = '{$fields['term']}'
      and a.status != '已設定為不請款'
    group by  a.seq, p.course_date, t.teacher_type, t.name, t.account_name
    order by p.course_date, from_time, t.teacher_type desc, t.name, t.account_name";
    }
    //echo $sql;

    $rs2 = $this->db->query($sql);
    $rs2 = QueryToArray($rs2);

    $classdate='';
    $funsql = $this->db->query("select * from `require` where YEAR = '{$fields['year']}' and CLASS_NO = '{$fields['class_no']}' and TERM = '{$fields['term']}'");
    $funsql = QueryToArray($funsql);
    if($funsql){
        $classdate = $funsql[0]['start_date1'] . ' ~ ' . $funsql[0]['end_date1'];	
    }
    else $classdate = '';

    $classtype='';
    $funitem_id = QueryToArray($this->db->query("select HT_CLASS_TYPE from `require` where YEAR = '{$fields['year']}' and CLASS_NO = '{$fields['class_no']}' and TERM = '{$fields['term']}'"));
    if(sizeof($funitem_id)==0){
      $funitem_id='';
    }else{
      $funitem_id=$funitem_id[0]['HT_CLASS_TYPE'];
    };
    $classtype = QueryToArray($this->db->query("select DESCRIPTION from code_table where TYPE_ID = '07' and ITEM_ID = '{$funitem_id}'"));
    if(sizeof($classtype)==0){
      $classtype='';
    }else{
      $classtype=$classtype[0]['DESCRIPTION'];
    };

    $outputHTML .= '<table width="100%" border="0">';
    $outputHTML .= '<tr height="30">';
    $outputHTML .= '<td align="left">';
    $outputHTML .= '<font face="標楷體" size="12"><br>查詢日期：'.$d1 . ' ~ ' .$d2.'</font>';
    $outputHTML .= '</td>';
    $outputHTML .= '<td align="center">';
    $outputHTML .= '<font face="標楷體" size="13">' . $fields['year'] . "年 " . $fields['class_name'] . ' 第' . $fields['term'] . '期</font><br>';
    $outputHTML .= '<font face="標楷體" size="12">開課日期：'.$classdate.'</font>';
    $outputHTML .= '</td>';
    $outputHTML .= '<td align="right">';
    $outputHTML .= '<font face="標楷體" size="12"><br>班期鐘點費類別：'. $classtype .'</font>';
    $outputHTML .= '</td>';
    $outputHTML .= '</tr>';
    $outputHTML .= '</table>';

    $outputHTML .= '<table border="0" cellspacing="0" cellpadding="0" width="100%"  >';
    $outputHTML .= '<tr>';
    $outputHTML .= '<td >';

    $outputHTML .= '<table border="0" cellspacing="0" cellpadding="2" width="100%" >';
    $outputHTML .= '<tr style="border: 1px solid #333333;">';
    $outputHTML .= '<td style="border: 1px solid #333333; width:70px;" align="center" valign="middle"><font face="標楷體" size="10">上課日期</font></td>';
    $outputHTML .= '<td style="border: 1px solid #333333; width:80px;" align="center"><font face="標楷體" size="10">姓名/公司<br>ID/編號</font></td>';
    $outputHTML .= '<td style="border: 1px solid #333333; width:160px;" align="center"><font face="標楷體" size="10">銀行/郵局分行<br>帳號(帳戶名稱)</font></td>';
    $outputHTML .= '<td style="border: 1px solid #333333; width:225px;" align="center" valign="middle"><font face="標楷體" size="10">地址<br>email</font></td>';
    $outputHTML .= '<td style="border: 1px solid #333333; width:35px;" align="center" valign="middle"><font face="標楷體" size="10">時數</font></td>';
    $outputHTML .= '<td style="border: 1px solid #333333; width:40px;" align="center" valign="middle"><font face="標楷體" size="10">單價</font></td>';
    $outputHTML .= '<td style="border: 1px solid #333333; width:50px;" align="center" valign="middle"><font face="標楷體" size="10">鐘點費</font></td>';
    $outputHTML .= '<td style="border: 1px solid #333333; width:50px;" align="center" valign="middle"><font face="標楷體" size="10">交通費</font></td>';
    $outputHTML .= '<td style="border: 1px solid #333333; width:50px;" align="center" valign="middle"><font face="標楷體" size="10">合計</font></td>';
    $outputHTML .= '<td style="border: 1px solid #333333; width:150px;" align="center" valign="middle"><font face="標楷體" size="10">簽章</font></td>'; // custom by chiahua 加大欄位
    $outputHTML .= '<td style="border: 1px solid #333333; width:80px;" align="center" valign="middle"><font face="標楷體" size="10">備註</font></td>';
    $outputHTML .= '</tr>';
    $total_hour = 0;
    $total_traffic = 0;
    $total_subtotal = 0;
    for ($j=0; $j < sizeof($rs2); $j++) { 
      $seq_data=$rs2[$j];
      $sql = "select a.*,(case when t.ID_TYPE='3' then f.fid else t.id end) as tid from hour_traffic_tax a join teacher t on t.id=a.teacher_id left join fid f on f.id = t.id where seq = '{$seq_data['SEQ']}'"; 
      $rs1 = $this->db->query($sql);
      $rs1 = QueryToArray($rs1); 
        $data=$rs1[0];
        $tid=$data['tid'];	// 身分證(外國人:居留證編號)

        // custom (b) by chiahua 如果狀態不是"請款確認"和"市庫支票"時，要再重新抓取講師的資料
        if($data['status'] != '請款確認' && $data['status'] != '市庫支票'){
        $tb_rs = $this->db->query("select NAME,ACCOUNT,BANKID,ADDR,ACCT_NAME,CITY,SUBCITY from TEACHER where ID = '{$data['teacher_id']}' and TEACHER = '{$data['isteacher']}'");
        //echo "sql:".$sql;
        $tb_rs = QueryToArray($tb_rs);					
        $tb_row = $tb_rs[0];
        $teacher_name = $tb_row['NAME']; // 姓名
        $tb_account = $tb_row['ACCOUNT']; // 銀行帳號
        $tb_BANKID = $tb_row['BANKID']; // 銀行代碼
        $teacher_acct_name = $tb_row['ACCT_NAME']; // 帳戶名稱
        $city = $cityArr[$tb_row['CITY']]; // 縣市
        $subcity = $subcityArr[$tb_row['CITY'] . '-'. $tb_row['SUBCITY']]; // 區
        $teacher_addr = $tb_row['ADDR']; // 地址
        //再找出類型是銀行還是郵局
        $tb_type =  QueryToArray($this->db->query("select MEMO from CODE_TABLE where TYPE_ID=14 and ITEM_ID = '{$tb_BANKID}'"))[0]['MEMO'];

        // 更新請款的銀行帳戶資料
        $bank_sql ="update HOUR_TRAFFIC_TAX set TEACHER_NAME = '{$teacher_name}', TEACHER_BANK_TYPE = '{$tb_type}' , TEACHER_BANK_ID = '{$tb_BANKID}', TEACHER_ACCOUNT = '{$tb_account}', TEACHER_ACCT_NAME = '{$teacher_acct_name}', TEACHER_ADDR = '{$city}{$subcity}{$teacher_addr}' where TEACHER_ID = '{$data['TEACHER_ID']}' and YEAR = '{$fields['YEAR']}' and CLASS_NO = '{$fields['CLASS_NO']}' and TERM = '{$fields['TERM']}'";
        $this->db->query($bank_sql);
        if($db->Affected_Rows() > 0){
          $data['TEACHER_BANK_ID'] = $tb_BANKID;
          $data['TEACHER_ACCOUNT'] = $tb_account;
          $data['TEACHER_NAME']    = $teacher_name;
          $data['TEACHER_ACCT_NAME']= $teacher_acct_name;
          $data['TEACHER_ADDR']    = $city . $subcity . $teacher_addr;
        }
        }
        // custom (e) by chiahua 如果狀態不是"請款確認"時，要再重新抓取講師的資料

        // custom (b) by chiahua 重新抓取鐘點費，更新成最新狀態
        if (trim($data['STATUS']) == "" || trim($data['STATUS']) == "待確認"){

        // custom (b) by chiahua 重新抓取課程的鐘點費類別，避免班期基本資料中的鐘點費類別有異動時，會抓不到對應的資料
        $get_ht_class_type = QueryToArray($this->db->query("select HT_CLASS_TYPE from REQUIRE where YEAR = {$fields['YEAR']} and CLASS_NO = '{$fields['CLASS_NO']}' and TERM = '{$fields['TERM']}'"))[0]['HT_CLASS_TYPE'];

        $this->db->query("update HOUR_TRAFFIC_TAX set HT_CLASS_TYPE = '{$get_ht_class_type}' where YEAR = {$fields['YEAR']} and CLASS_NO = '{$fields['CLASS_NO']}' and TERM = '{$fields['TERM']}' and TEACHER_ID = '{$data['TEACHER_ID']}' and USE_DATE = '{$data['USE_DATE']}' " . (trim($data['STATUS']) == "" ? " and STATUS is null" : " and STATUS = '{$data['STATUS']}'"));
        $data['HT_CLASS_TYPE'] = $get_ht_class_type;

        // custom (e) by chiahua 重新抓取課程的鐘點費類別，避免班期基本資料中的鐘點費類別有異動時，會抓不到對應的資料

        $count_fee = QueryToArray($this->db->query("select count(*) as cnt from HOUR_FEE where CLASS_TYPE_ID = '{$data['HT_CLASS_TYPE']}' and TEACHER_TYPE_ID = '{$data['T_SOURCE']}' and ASSISTANT_TYPE_ID ".(trim($data['A_SCOUCE']) == '' ? 'is null' : "='{$data['A_SCOURCE']}'")." and TYPE = '".($data['ISTEACHER'] == 'Y' ? 1 : 2)."'"))[0]['cnt'];
          if($count_fee == 1){
            $rs_fee = $this->db->query("select * from HOUR_FEE where CLASS_TYPE_ID = '{$data['HT_CLASS_TYPE']}' and TEACHER_TYPE_ID = '{$data['T_SOURCE']}' and ASSISTANT_TYPE_ID ".(trim($data['A_SCOUCE']) == '' ? 'is null' : "='{$data['A_SCOURCE']}'")." and TYPE = '".($data['ISTEACHER'] == 'Y' ? 1 : 2)."'");
            $rs_fee = QueryToArray($rs_fee);
 
              $row_fee=$rs_fee[0];
                // 單價和鐘點費和交通費都沒有被手動更新過才要自動更新
              if($data['UNIT_HOUR_FEE_IS_CHANGED'] == 'N')
                $data['UNIT_HOUR_FEE']	= $row_fee['HOUR_FEE'];
              if($data['HOUR_FEE_IS_CHANGED'] == 'N')
                $data['HOUR_FEE']		= $row_fee['HOUR_FEE'] * $data['HRS'];
              if($data['TRAFFIC_FEE_IS_CHANGED'] == 'N')
                $data['TRAFFIC_FEE']	= $row_fee['TRAFFIC_FEE'];

              // custom by chiahua
              $data['TRAFFIC_FEE'] = ($data['TRAFFIC_FEE'] == "-1" ? 0 : $data['TRAFFIC_FEE']);

              $data['SUBTOTAL']		= $data['HOUR_FEE'] + $data['TRAFFIC_FEE']; // 合計 = 鐘點費+交通費

              $this->db->query("update HOUR_TRAFFIC_TAX set UNIT_HOUR_FEE = {$data['UNIT_HOUR_FEE']}, HOUR_FEE = {$data['HOUR_FEE']}, SUBTOTAL = {$data['SUBTOTAL']} where SEQ = '{$data['SEQ']}'");
            
          }
        }
        // custom (e) by chiahua 重新抓取鐘點費，更新成最新狀態



        $outputHTML .= '<tr style=" line-height:6px;">';
        $outputHTML .= '<td style="border: 1px solid #333333;" align="center"><font face="標楷體" size="10">' . $data['USE_DATE'] . '</font></td>';
        $outputHTML .= '<td style="border: 1px solid #333333;" align="left"><font face="標楷體" size="10">' . $data['TEACHER_NAME']  . '<br>' . $tid  . '</font></td>';
        // custom by chiahua 顯示銀行郵局的中文名稱
        $bank_name = QueryToArray($this->db->query("select DESCRIPTION from CODE_TABLE where TYPE_ID=14 and ITEM_ID = '{$data['TEACHER_BANK_ID']}'"))[0]['DESCRIPTION'];
        $outputHTML .= '<td style="border: 1px solid #333333;" align="left"><font face="標楷體" size="10">' . $bank_name  . '<br>' . $data['TEACHER_ACCOUNT'].'('.$data['TEACHER_ACCT_NAME'] . ')</font></td>';
        $email = QueryToArray($this->db->query("select EMAIL from TEACHER where ID = '{$data['TEACHER_ID']}'"))[0]['EMAIL'];
        $outputHTML .= '<td style="border: 1px solid #333333;" align="left"><font face="標楷體" size="10">' . $data['TEACHER_ADDR'] . '<br>'. $email. '</font></td>';
        $outputHTML .= '<td style="border: 1px solid #333333;" align="center"><font face="標楷體" size="10">' . $data['HRS']  . '</font></td>';
        $outputHTML .= '<td style="border: 1px solid #333333;" align="right"><font face="標楷體" size="10">' . number_format($data['UNIT_HOUR_FEE'],",")  . '</font></td>';
        $outputHTML .= '<td style="border: 1px solid #333333;" align="right"><font face="標楷體" size="10">' . number_format($data['HOUR_FEE'],",")  . '</font></td>';

        $showTrafficFee = number_format($data['TRAFFIC_FEE'],",");
        $outputHTML .= '<td style="border: 1px solid #333333;" align="right"><font face="標楷體" size="10">' . ($showTrafficFee <=0 ? 0 : $showTrafficFee)  . '</font></td>';
        $outputHTML .= '<td style="border: 1px solid #333333;" align="right"><font face="標楷體" size="10">' . number_format($data['SUBTOTAL'],",")  . '</font></td>';
        $outputHTML .= '<td style="border: 1px solid #333333;" align="center"><font face="標楷體" size="10"></font></td>';
        // custom by chiahua 備註欄顯示聘請類別
        if($data['ISTEACHER']=='Y')
        $getDesc = QueryToArray($this->db->query("select DESCRIPTION from CODE_TABLE where ITEM_ID = '{$data['T_SOURCE']}'"))[0]['DESCRIPTION'];
        elseif($data['ISTEACHER']=='N')
        $getDesc = QueryToArray($this->db->query("select DESCRIPTION from CODE_TABLE where ITEM_ID = '{$data['A_SOURCE']}'"))[0]['DESCRIPTION'];
        $outputHTML .= '<td style="border: 1px solid #333333;" align="center"><font face="標楷體" size="10">'.$getDesc.'</font></td>';
        $total_hour = $total_hour + $data['HOUR_FEE'];
        $total_traffic =$total_traffic + ($data['TRAFFIC_FEE'] <=0 ? 0 : $data['TRAFFIC_FEE']);
        $total_subtotal =$total_subtotal + $data['SUBTOTAL'];
        $outputHTML .= '</tr>';

      $outputHTML .= '<tr style=" line-height:8px;">';
      $outputHTML .= '<td style="border: 1px solid #333333;" align="right" colspan="6"><font face="標楷體" size="10">總計</font></td>';
      $outputHTML .= '<td style="border: 1px solid #333333;" align="right"><font face="標楷體" size="10">' . number_format($total_hour) . '</font></td>';
      $outputHTML .= '<td style="border: 1px solid #333333;" align="right"><font face="標楷體" size="10">' . number_format($total_traffic) . '</font></td>';
      $outputHTML .= '<td style="border: 1px solid #333333;" align="right"><font face="標楷體" size="10">' . number_format($total_subtotal) . '</font></td>';
      $outputHTML .= '<td style="border: 1px solid #333333;" align="left" colspan="2"></td>';
      $outputHTML .= '</tr>';
      $outputHTML .= '</table>';

      $outputHTML .= '</td>';
      $outputHTML .= '</tr>';
      $outputHTML .= '<tr><td align="left">';
      //$outputHTML .= '<font face="標楷體" size="10">※當日講師鐘點費超過5,000元(含)以上，須扣取二代健保補充保費2％。</font>';
      $outputHTML .= '<font face="標楷體" size="13">※配合二代健保補充保險費扣取作業，當日講師鐘點費超過23,100元(含)以上，須扣取補充保費1.91％。</font>'; //2019 05 03 鵬 原 超過20,008元 改為 23,100；原 2％ 改為 1.91%
      $outputHTML .= '</td></tr>';
      $outputHTML .= '</table>';

      $outputHTML .= '<br><br>';
      
      }
  }

$pdf->writeHTML($outputHTML);
//$pdf->lastPage();
$pdf->Output('pay03_2.pdf','D');
?>