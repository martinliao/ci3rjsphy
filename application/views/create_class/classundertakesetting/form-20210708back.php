        <form id="data-form" method="POST" role="form"  >
          <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
          <div class="edit_data">
            <div class="col-xs-3" >
              <div class="form-group">
                <label>年度：</label>
                <?=$edit_data->year;?>
              </div>
            </div>
            <div class="col-xs-3" >
              <div class="form-group">
                <label>班期代碼：</label>
                <?=$edit_data->class_no;?>
              </div>
            </div>  
            <div class="col-xs-3" >
              <div class="form-group">
                <label>班期名稱：</label>
                <?=$edit_data->class_name;?>
              </div>
            </div>
            <div class="col-xs-3" >
              <div class="form-group">
                <label>期別：</label>
                <?=$edit_data->term;?>
              </div>
            </div>  

            <?php 
              $_checked["apply_type"][0] = ($edit_data->app_type == 0) ? 'checked' : '';
              $_checked["apply_type"][1] = ($edit_data->app_type == 1) ? 'checked' : '';
              $_checked["apply_type"][2] = ($edit_data->app_type == 2) ? 'checked' : '';

              $_checked["repeat_sign"][0] = ($edit_data->repeat_sign == "Y") ? 'checked' : '';
              $_checked["repeat_sign"][1] = ($edit_data->repeat_sign == "N") ? 'checked' : '';
            ?>

            <div class="col-xs-6" >
              <div class="form-group">
                <label class="control-label">報名方式 1：</label>
                <input type="radio" name="app_type" value="0" <?=$_checked["apply_type"][0];?> >開放各單位人事報名
              </div>
            </div> 

            <div class="col-xs-6" >
              <div class="form-group">
                <label class="control-label">同一班期是否可重複報名：</label>
                <input type="radio" name="repeat_sign" value="Y" <?=$_checked["repeat_sign"][0]?> >Yes
                <input type="radio" name="repeat_sign" value="N" <?=$_checked["repeat_sign"][1]?> >No
              </div>
            </div> 

            <div class="col-xs-6" >
              <div class="form-group">
                <label class="control-label">報名方式 2：</label>
                <input type="radio" name="app_type" value="2" <?=$_checked["apply_type"][2];?> >限定某單位人事報名(<span style="color:red">請選擇右邊單位人事</span>)
              </div>
            </div> 

            <div class="col-xs-6" >
              <div class="form-group">
                <label class="control-label">單位人事：</label>
                <a id="limit_beaurau_name" style="text-decoration:none; color: #000;"><?=$edit_data->limit_name;?></a>
                <input type="hidden" name="limit_beaurau" id="limit_beaurau_id" value="<?=$edit_data->limit_beaurau;?>">
                <a onclick="personnelQuery(1)" class="btn btn-success">查詢</a>
                <a onclick="clearBeaurau('limit_beaurau_id', 'limit_beaurau_name')" class="btn btn-primary">清空</a>
              </div>
            </div>       

            <div class="col-xs-6" >
              <div class="form-group">    
                <label class="control-label">報名方式 3：</label>
                <input type="radio" name="app_type" value="1" <?=$_checked["apply_type"][1];?>>承辦單位統一報名(<span style="color:red">此功能暫停使用</span>)
              </div>
            </div>   
            <div class="col-xs-6" >
              <div class="form-group">
                <label class="control-label">承辦單位：</label>
                <a id="req_beaurau_name" style="text-decoration:none; color: #000;"><?=$edit_data->req_name;?></a>
                <input type="hidden" id="req_beaurau_id" name="req_beaurau" value="<?=$edit_data->req_beaurau;?>">
                <a onclick="personnelQuery(2)" class="btn btn-success">查詢</a>
                <a onclick="clearBeaurau('req_beaurau_id', 'req_beaurau_name')" class="btn btn-primary">清空</a>
              </div>
            </div> 

            <div class="col-xs-6" >
              <div class="form-group">
                <label>承辦單位聯絡人：</label>
                <input type="text" name="contactor" class="form-control" value="<?=$edit_data->contactor;?>">              
              </div>
            </div> 

            <div class="col-xs-6" >
              <div class="form-group">
                <label>承辦單位電話：  </label>
                <input type="text" name="tel" class="form-control" value="<?=$edit_data->tel;?>">
              </div>
            </div> 

            <div class="col-xs-6" >
              <label class="control-label">報名起日(西元)：</label>
              <div class="input-group">
                <input type="text" id="test1" name="apply_s_date" class="form-control datepicker" value="<?=!empty($edit_data->apply_s_date)?date('Y-m-d',strtotime($edit_data->apply_s_date)):''?>">
                <span class="input-group-addon" style="cursor: pointer;" id="test2"><i
                                        class="fa fa-calendar"></i></span>
              </div>
            </div>
            <div class="col-xs-6" >
              <label class="control-label">報名迄日(西元)：</label>
              <div class="input-group">
                <input type="text" id="datepicker1"name="apply_e_date" class="form-control form-control datepicker" value="<?=!empty($edit_data->apply_e_date)?date('Y-m-d',strtotime($edit_data->apply_e_date)):''?>">
                <span class="input-group-addon" id="datepicker2" style="cursor: pointer;"><i
                                        class="fa fa-calendar"></i></span>
              </div>
            </div> 
            <div class="col-xs-6" >
              <label class="control-label">報名起日2(西元)：</label>
              <div class="input-group">
                <input type="text" id="datepicker3" name="apply_s_date2" class="form-control form-control datepicker" value="<?=!empty($edit_data->apply_s_date2)?date('Y-m-d',strtotime($edit_data->apply_s_date2)):''?>">
                <span class="input-group-addon" id="datepicker4" style="cursor: pointer;"><i
                                        class="fa fa-calendar"></i></span>
              </div>
            </div> 
            <div class="col-xs-6" >
              <label class="control-label">報名迄日2(西元)：</label>
              <div class="input-group">
                <input type="text" id="datepicker5" name="apply_e_date2" class="form-control form-control datepicker" value="<?=!empty($edit_data->apply_e_date2)?date('Y-m-d',strtotime($edit_data->apply_e_date2)):''?>">
                <span class="input-group-addon" id="datepicker6" style="cursor: pointer;"><i
                                        class="fa fa-calendar"></i></span>
              </div>
            </div> 
            <div class="col-xs-6" >
              <label class="control-label">選員起日(西元)：</label>
              <div class="input-group">
                <input type="text" name="sel_s_date" id="datepicker7" class="form-control form-control datepicker" value="<?=!empty($edit_data->sel_s_date)?date('Y-m-d',strtotime($edit_data->sel_s_date)):''?>">
                <span class="input-group-addon" style="cursor: pointer;" id="datepicker8"><i
                                        class="fa fa-calendar"></i></span>
              </div>
            </div> 
            <div class="col-xs-6" >
              <label class="control-label" >選員迄日(西元)：</label>
              <div class="input-group">
                <input type="text" id="datepicker9" name="sel_e_date" class="form-control form-control datepicker" value="<?=!empty($edit_data->sel_e_date)?date('Y-m-d',strtotime($edit_data->sel_e_date)):''?>">
                <span class="input-group-addon" style="cursor: pointer;" id="datepicker10"><i
                                        class="fa fa-calendar"></i></span>
              </div>
            </div> 
          </div>
        </form>

<script type="text/javascript">
  function personnelQuery(type){
    var url = "<?=base_url('create_class/class_undertake_setting/personnelQuery/')?>" + type;
    var setting = "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,height=530,width=900";
    var query_page = window.open(url, 'personnelQuery' ,setting);
    query_page.focus();
  }

  function filltext(id, value, text, text_value){
    var input_id = document.getElementById(id);
    var input_text = document.getElementById(text);
    input_id.value = value;  
    input_text.innerText = text_value;
  }

  function clearBeaurau(id, text){
    console.log("clear");
    var input_id = document.getElementById(id);
    var input_text = document.getElementById(text);
    input_id.value = "";
    input_text.innerText = "";
  }

$(document).ready(function() {
  $("#test1").datepicker();
  $('#test2').click(function(){
    $("#test1").focus();
  });
  $("#datepicker1").datepicker();
  $('#datepicker2').click(function(){
    $("#datepicker1").focus();
  });
  $("#datepicker3").datepicker();
  $('#datepicker4').click(function(){
    $("#datepicker3").focus();
  });
  $("#datepicker5").datepicker();
  $('#datepicker6').click(function(){
    $("#datepicker5").focus();
  });
  $("#datepicker7").datepicker();
  $('#datepicker8').click(function(){
    $("#datepicker7").focus();
  });
  $("#datepicker9").datepicker();
  $('#datepicker10').click(function(){
    $("#datepicker9").focus();
  });
});
</script>        