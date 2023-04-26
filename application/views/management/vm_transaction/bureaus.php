<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel&#45;heading">
                <i class="fa fa-list fa-lg"></i> <?=$_LOCATION['name'];?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <form id="filter-form" role="form" class="form-inline">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label class="control-label">年度</label>
                                <input type="text" class="form-control" id="year" value="<?=$require->year?>" disabled>
                            </div> 
                            <div class="form-group">
                                <label class="control-label">班期代碼:</label>
                                <input type="text" class="form-control" id="class_no" value="<?=$require->class_no?>" disabled>
                            </div>
                            <div class="form-group">
                                <label class="control-label">班期名稱:</label>
                                <input type="text" class="form-control" value="<?=$require->class_name?>" disabled>
                            </div>
                            <div class="form-group">
                                <label class="control-label">期別:</label>
                                <input type="text" class="form-control" value="<?=$require->term?>" disabled>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /.table head -->
                <table class="table table-bordered table-condensed table-hover">
                    <thead>
                        <tr bgcolor="#8CBBFF">
                            <th class="text-center">序號</th>
                            <th class="text-center">學號</th>
                            <th class="text-center">學員ID</th>
                            <th class="text-center">學員姓名</th>
                            <th class='text-center'>互調(另一期別學員ID)</th>
                            <th class="text-center">換員(新學員ID)</th>
                            <th class='text-center'>換期(更換的期別)</th>
                            <th class="text-center">取消參訓</th>
                        </tr>
                    </thead>
                    <?php if(!in_array('1',$group_id) && !in_array('9', $group_id)) {?>
                    <tbody>
                        <?php foreach($online_apps as $key => $online_app): ?>
                        <?php 
                            $disable = ($online_app->count == 0) ? '' : 'disabled';
                        ?>
                        <form action="<?=base_url("management/vm_transaction/bureaus?year={$online_app->year}&term={$online_app->term}&class_no={$online_app->class_no}&id={$online_app->id}")?>" method="POST" id="form_<?=$key?>">
                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                            <tr class="text-center">
                                <td><?=$key+1?></td>
                                <td><?=$online_app->st_no?></td>
                                <td><?=$online_app->id?></td>
                                <td><?=$online_app->user_name?></td>

                                <?php 
                                    if ($require->sd_change != 1 || $disable){
                                        $exchange_disable = "disabled";
                                    }else{
                                        $exchange_disable = "";
                                    }
                                ?> 

                                <td class="text-center">
                                    <input type="text" name="exchange">
                                    <button name="action" class="btn btn-info " value="exchange" <?=$exchange_disable?> >互調</button>
                                </td>

                                <?php 
                                    if ($require->sd_another != 1 || $disable){
                                        $modify_disable = "disabled";
                                    }else{
                                        $modify_disable = "";
                                    }
                                ?>                                  
                                <td class="text-center">
                                    <input type="text" name="modify">
                                    <button name="action" class="btn btn-info " value="modify" <?=$modify_disable?> >換員</button>
                                </td>
                                <?php 
                                    if ($require->sd_chgterm != 1 || $disable){
                                        $change_term_disable = "disabled";
                                    }else{
                                        $change_term_disable = "";
                                    }
                                ?>  

                                <td class="text-center">
                                    <select name="change_term" id="change_term_<?=$key+1?>">
                                    <option>請選擇期別</option>
                                    <?php foreach($class_all_term_infos as $class_info): ?>
                                        <?php if($class_info->term != $filter['term']): ?>
                                        <option value="<?=$class_info->term?>"> <?=$class_info->term?> </option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                    </select>
                                    <?php if(in_array(1,$group_id)||in_array(1,$group_id)) {?>
                                     <button id="<?=$key?>" name="action" type="button" onclick="_ajax(this);" class="btn btn-info" >換期</button>
                                     <input type="hidden" id="na_<?=$key?>" value="change_term">    
                                     <?php }else{ ?>
                                     <button name="action" class="btn btn-info" value="change_term" <?=$change_term_disable?>>換期</button> 
                                     <?php }?> 
                                </td>

                                <td>
                                    <?php 
                                        if ($require->sd_cancel != 1 || $disable){
                                            $cancel_disable = "disabled";
                                        }else{
                                            $cancel_disable = "";
                                        }
                                    ?>                                      
                                    <button name="action" class="btn btn-info " value="cancel" <?=$cancel_disable?> >取消參訓</button> 
                                </td>
                            </tr>
                        </form>
                        <?php endforeach ?>
                    </tbody>
                    <?php }else{?>
                    <tbody>
                        <?php foreach($online_apps as $key => $online_app): ?>
                        <?php 
                            $disable = ($online_app->count == 0) ? '' : 'disabled';
                        ?>
                        <form action="<?=base_url("management/vm_transaction/bureaus?year={$online_app->year}&term={$online_app->term}&class_no={$online_app->class_no}&id={$online_app->id}")?>" method="POST" id="form_<?=$key?>">
                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                            <tr class="text-center">
                                <td><?=$key+1?></td>
                                <td><?=$online_app->st_no?></td>
                                <td><?=$online_app->id?></td>
                                <td><?=$online_app->user_name?></td>

                                <?php 
                                    if ($require->sd_change != 1 || $disable){
                                        $exchange_disable = "disabled";
                                    }else{
                                        $exchange_disable = "";
                                    }
                                ?> 

                                <td class="text-center">
                                    <input type="text" name="exchange">
                                    <button name="action" class="btn btn-info " value="exchange">互調</button>
                                </td>

                                <?php 
                                    if ($require->sd_another != 1 || $disable){
                                        $modify_disable = "disabled";
                                    }else{
                                        $modify_disable = "";
                                    }
                                ?>                                  
                                <td class="text-center">
                                    <input type="text" name="modify">
                                    <button name="action" class="btn btn-info " value="modify">換員</button>
                                </td>
                                <?php 
                                    if ($require->sd_chgterm != 1 || $disable){
                                        $change_term_disable = "disabled";
                                    }else{
                                        $change_term_disable = "";
                                    }
                                ?>  

                                <td class="text-center">
                                    <select name="change_term" id="change_term_<?=$key?>">
                                    <option>請選擇期別</option>
                                    <?php foreach($class_all_term_infos as $class_info): ?>
                                        <?php if($class_info->term != $filter['term']): ?>
                                        <option value="<?=$class_info->term?>"> <?=$class_info->term?> </option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                    </select>
                                    <?php if(in_array(1,$group_id)||in_array(1,$group_id)) {?>
                                     <button id="<?=$key?>" name="action" type="button" onclick="_ajax(this);" class="btn btn-info" >換期</button>
                                     <input type="hidden" id="na_<?=$key?>" value="change_term">
                                     <?php }else{ ?>
                                     <button name="action" class="btn btn-info" value="change_term" <?=$change_term_disable?>>換期</button> 
                                     <?php }?>        

                                </td>

                                <td>
                                    <?php 
                                        if ($require->sd_cancel != 1 || $disable){
                                            $cancel_disable = "disabled";
                                        }else{
                                            $cancel_disable = "";
                                        }
                                    ?>  

                                    <button name="action" class="btn btn-info " value="cancel">取消參訓</button> 
                                </td>
                            </tr>
                        </form>
                        <?php endforeach ?>
                    </tbody>
                    <?php }?>
                </table>
                <span style="color:red">*已有刷卡紀錄者無法異動</span>
                <button onclick="history.back(-1)" class="btn btn-info">回上一頁</button>
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>

<script type="text/javascript">


function _ajax(obj)
{
    
    var url = '<?=base_url('management/vm_transaction/ajax');?>';
    var class_no=$("#class_no").val();
    var year=$("#year").val();
    var term=$("#change_term_"+obj.id).val();

    $("#na_"+obj.id).attr("name","action");


    var data = {
        '<?=$csrf["name"];?>': '<?=$csrf["hash"];?>',
        'year': year,
        'class_no': class_no,
        'term': term,
    }
    $.ajax({
            
            type: "POST", //傳送方式
            url: url, //傳送目的地
            dataType: "json", //資料格式
            data:data,
            success: function(message) {
                console.log(message);
                if(message=='不能換班'){
                    var r=confirm("超過該班期限制的人數");
                    if (r==true){
                        $("#form_"+obj.id).submit();
                    }else{
                        return false;
                    }
                }else{
                    
                    $("#form_"+obj.id).submit();
                }

            },
            error: function(message) {
                console.log('error');
            }
                    
        });
}

</script>