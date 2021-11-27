<section class="box-typical box-typical-dashboard panel panel-default scrollable"  data-body-height="560">
    <header class="box-typical-header panel-heading">
         <h3 class="panel-title">服務足跡</h3>
         <?php
            if($login != 0){
                echo '<button type="button" class="btn btn-outline-primary btn-sm " style="margin-top:2px;margin-left:5px;color: #0275d8;background-image: none;background-color: transparent;" data-toggle="modal" data-target="#addServiceModal" onclick="getSelect()">留下足跡</button>';
            }
         ?>
    </header>
    <div class="box-typical-body panel-body" id="activityFootprint" onclick="">
        
        <div class="footPrint-card">
            <button class="card-btn-top card-btn-open btn-block" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                <div class="row">
                    <div class="col-xl-8 text-left text-truncate"><span class="btn btn-outline-primary btn-sm " style="color: #F59F00;background-color: transparent;background-image: none;border-color: #F59F00;margin-right: 1em">待辦理</span>樹德科技大學國際同圓社-同圓大世界</div>
                    <div class="col-xl-4 text-right ">2018/07/05～2017/07/10</div>
                    <div></div>
                </div>
            </button>
            <div id="collapse2" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <div class="col-xl-12" style="margin-top: 10px">
                        <article class="box-typical profile-post">
                            <div class="profile-post-header">
                                <div class="user-card-row">
                                    <div class="tbl-row">
                                        <div class="tbl-cell tbl-cell-photo">
                                            <a href="#">
                                                <img src="" alt="">
                                            </a>
                                        </div>
                                        <div class="tbl-cell">
                                            <div class="color-blue-grey-lighter">吳孟賢</div>
                                            <div class="color-blue-grey-lighter">即將於 2018/07/05～2017/07/10 辦理活動</div>
                                            <button type="button" class="btn btn-outline-primary btn-sm " style="color: #28a745;background-color: transparent;background-image: none;border-color: #28a745;" data-toggle="modal" data-target="#overServiceModal">活動結案</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="profile-post-content">
                                <p class="profile-post-content-note">服務內容</p>
                                <p>　　在台灣多元文化的所組成的社會中，新住民儼然已是台灣的一大族群，且不論是語言、飲食、風俗，都與原有的台灣社會有著一定的差距。且在小學教育中，來自不同多元家庭的學子早已佔有一定的比率，在這之中所碰到的自我認同、同儕關係，以及對新住民配偶子女之認知甚至偏見、排擠、霸凌……等等的都是現已面臨的問題。<br>
                                　　於本次的活動裡，本社期望透過不同面向的教育活動，在分享、實作以及遊戲中，融合多元的理念，告訴孩子對於新住民的正確認知，且建立起新住民之子女學子的自我認知。更盼望孩子們在往後的路上，不管是求學或是進入社會，都能保有正確且包容的多元文化觀念。</p>
                                <p class="profile-post-content-note">服務評分</p>
                                <table class="table table-hover">
                                  <tbody>
                                    <tr>
                                      <td style="width: 20%">學校配合度</td>
                                      <td style="width: 30%">
                                        <input id="oneReasonSchool" class="ratin" value="4" data-size="xs">
                                      </td>
                                      <td style="width: 50%">原因原因原因</td>
                                    </tr>
                                    <tr>
                                      <td>學生配合度</td>
                                      <td style="width: 30%">
                                        <input id="oneReasonStudent" class="ratin" value="4" data-size="xs">
                                      </td>
                                      <td>原因原因原因</td>
                                    </tr>
                                    <tr>
                                      <td>交通方便性</td>
                                      <td style="width: 30%">
                                        <input id="oneReasonTraffic" class="ratin" value="4" data-size="xs">
                                      </td>
                                      <td>原因原因原因</td>
                                    </tr>
                                    <tr>
                                      <td>周邊機能性</td>
                                      <td style="width: 30%">
                                        <input id="oneReasonAround" class="ratin" value="4" data-size="xs">
                                      </td>
                                      <td>原因原因原因</td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>

    </div>  
</section><!--.box-typical-dashboard-->
<?php

    if($login != 0){
       $this->load->view("basic/school/service/addService");
       $this->load->view("basic/school/service/overService");
       $this->load->view("basic/school/service/editService");
       $this->load->view("basic/school/service/editComment");
    }

?>
<script>

    thisContrlSchoolNumber = 1;
    //getService();
    function getService(schoolNumber){
      thisContrlSchoolNumber = schoolNumber;
      $.ajax({
        url: '<?php  echo base_url('service/getService') ?>',
        dataType: 'json',
        type:'post',
        data: {schoolNumber : thisContrlSchoolNumber},
        error:function(){
           swal("錯誤", "連線失敗，請重新送出", "error");
        },
        success: function(data){
          var json = data;
          $('#activityFootprint').html('');
          for(i=0;i<json.length;i++){
            addOneActivity(i,json[i]);
          }
        }
      });
    }

    $(document).on('ready', function(){
      $('#oneReasonSchool').rating({displayOnly: true, step: 0.5});
      $('#oneReasonStudent').rating({displayOnly: true, step: 0.5});
      $('#oneReasonTraffic').rating({displayOnly: true, step: 0.5});
      $('#oneReasonAround').rating({displayOnly: true, step: 0.5});
      $('#oneReasonSchool').rating('update', 2.5);
    });

    function addOneActivity(num,data){
      $('#activityFootprint').append('<div class="footPrint-card" id="activiryCard_'+num+'"></div>');
      if(data['type']=="已完成"){
        var thisColor = "#28a745";
      }else{
        var thisColor = "#F59F00";
      }
      $('#activiryCard_'+num).append('<button class="card-btn-top card-btn-open btn-block" data-type="close" data-toggle="collapse" data-target="#collapse'+num+'" aria-c="true" aria-controls="collapse'+num+'" onclick="getOneContent(\''+data['key']+'\','+num+',\''+data['type']+'\',this)"><div class="row"><div class="col-xl-8 text-left text-truncate"><span class="btn btn-outline-primary btn-sm " style="color: '+thisColor+';background-color: transparent;background-image: none;border-color: '+thisColor+';margin-right: 1em">'+data['type']+'</span>'+data['group']+' - '+data['name']+'</div><div class="col-xl-4 text-right ">'+data['startDate']+'～'+data['endDate']+'</div></div></button>');
      $('#activiryCard_'+num).append('<div id="collapse'+num+'" class="collapse" aria-labelledby="heading'+num+'" data-parent="#accordion"><div class="card-body"><div class="col-xl-12" style="margin-top: 10px"><article class="box-typical profile-post" id="activityContent'+num+'" ></article></div></div></div>');
    }


    function getOneContent(key,num,type,object){
      if($(object).data("type") == "close"){
        $('#activityContent'+num).html('');
        $.ajax({
          url: '<?php  echo base_url('service/getOneService') ?>',
          dataType: 'json',
          type:'post',
          data: {footprintKey : key},
          error:function(){
             swal("錯誤", "連線失敗，請重新送出", "error");
          },
          success: function(data){
            var json = data;
            var reasonAll = [['學校配合度','schoolCooperate'],['學生配合度','studentCooperate'],['交通方便性','traffic'],['周邊機能性','around']];
            if(type == "已完成"){
              $('#activityContent'+num).append('<div class="profile-post-header"><div class="user-card-row"><div class="tbl-row"><div class="tbl-cell tbl-cell-photo"><a href="#"><img src="<?php echo base_url('dist/img/user/') ?>'+data['photo']+'" alt=""></a></div><div class="tbl-cell"><div class="color-blue-grey-lighter">'+data['name']+'</div><div class="color-blue-grey-lighter">活動時間'+data['date']+'</div></div></div></div></div>');
              $('#activityContent'+num).append('<div class="profile-post-content"><p class="profile-post-content-note">服務主旨</p><p>'+data['subject']+'</p><p class="profile-post-content-note">心得</p><p>'+data['content']+'</p></div><table class="table table-hover"><tbody id="reasonTable'+num+'"></tbody></table>');
              for(var i = 0 ; i<reasonAll.length ; i++){
                var contentReason = data['reason'][reasonAll[i][1]][1] == "" ? "未填寫給分原因" : data['reason'][reasonAll[i][1]][1];
                $('#reasonTable'+num).append('<tr><td style="width: 20%">'+reasonAll[i][0]+'</td><td style="width: 30%"><input id="one'+reasonAll[i][1]+num+'" class="ratin" value="'+data['reason'][reasonAll[i][1]][0]+'" data-size="XL"></td><td style="width: 50%">'+contentReason+'</td></tr>');
                $('#one'+reasonAll[i][1]+num).rating({displayOnly: true, step: 0.5});
              }
              getContentAllComment(key,num);
            }else{
              $('#activityContent'+num).append('<div class="profile-post-header"><div class="user-card-row"><div class="tbl-row"><div class="tbl-cell tbl-cell-photo"><a href="#"><img src="<?php echo base_url('dist/img/user/') ?>'+data['photo']+'" alt=""></a></div><div class="tbl-cell"><div class="color-blue-grey-lighter">'+data['name']+'</div><div class="color-blue-grey-lighter">即將於'+data['date']+'辦理活動</div>'+data['button']+'</div></div></div></div>');
              $('#activityContent'+num).append('<div class="profile-post-content"><p class="profile-post-content-note">服務主旨</p><p>'+data['subject']+'</p></div>');
            }
          }
        });
        $(object).data("type", "open");
      }else{
        $(object).data("type", "close");
      }
    }
    /*
<div class="comment-rows-container hover-action">
    <div class="comment-row-item">
        
    </div><!--.comment-row-item-->
</div>
*/
    function getContentAllComment(key,num){
      $.ajax({
        url: '<?php  echo base_url('service/getAllComment') ?>',
        dataType: 'json',
        type:'post',
        data: {footprintKey : key,
               viewControll :num},
        error:function(){
           swal("錯誤", "連線失敗，請重新送出", "error");
        },
        success: function(data){
          $('#commentItem'+num).remove();
          $('#commentTextForm'+num).remove();
          $('#activityContent'+num).append('<div class="comment-rows-container hover-action" id="commentItem'+num+'" ></div>');
          if(data.length != 0){
            for(var i = 0 ; i < data.length ; i++){
              $('#commentItem'+num).append('<div class="comment-row-item" id="commentOneItem'+num+"_"+i+'"></div>');
              $('#commentOneItem'+num+"_"+i).append('<div class="avatar-preview avatar-preview-32"><a target="_blank" href="'+data[i]['url']+'"><img src="<?php echo base_url('dist/img/user/') ?>'+data[i]['photo']+'" alt=""></a></div>');
              $('#commentOneItem'+num+"_"+i).append('<div class="tbl comment-row-item-header"><div class="tbl-row"><div class="tbl-cell tbl-cell-name">'+data[i]['name']+'</div><div class="tbl-cell tbl-cell-date">'+data[i]['date']+'</div></div></div>');
              $('#commentOneItem'+num+"_"+i).append('<div class="comment-row-item-content"><p>'+data[i]['content']+'</p>'+data[i]['button']+'</div>');
            }          
          }
          setCommentInput(key,num); 
        }
      })

    }

    function setCommentInput(key,num){
      <?php if($login==0){ ?>
        $('#activityContent'+num).append('<div class="user-card-row" style="margin-bottom: 10px;margin-top: 10px;"><div class="tbl-row"><div class="tbl-cell tbl-cell-photo" style="padding-left: 20px"><a href="#"><img src="<?php echo base_url('dist/img/user/no-user.png') ?>" alt=""></a></div><div class="col-xl-12"><textarea class="form-control" onclick="noUserComment()" rows="3"></textarea></div></div></div>');
        $('#activityContent'+num).append('<div class="box-typical-footer"><div class="tbl"><div class="tbl-row"><div class="tbl-cell"></div><div class="tbl-cell tbl-cell-action"><button type="button" onclick="noUserComment()" class="btn btn-rounded">送出留言</button></div></div></div></div>');
      <?php }else{?>
        $('#activityContent'+num).append('<form id="commentTextForm'+num+'"></form>');
        $('#commentTextForm'+num).append('<div class="user-card-row" style="margin-bottom: 10px;margin-top: 10px;"><div class="tbl-row"><div class="tbl-cell tbl-cell-photo" style="padding-left: 20px"><a href="#"><img src="<?php echo base_url('dist/img/user/').$photo ?>" alt=""></a></div><div class="col-xl-12"><textarea class="form-control" name="content" rows="3"></textarea></div></div></div>');
        $('#commentTextForm'+num).append('<div class="box-typical-footer"><div class="tbl"><div class="tbl-row"><div class="tbl-cell"></div><div class="tbl-cell tbl-cell-action"><button type="button" data-num="'+num+'" data-key="'+key+'"onclick="userComment(this)" class="btn btn-rounded">送出留言</button></div></div></div></div>');
      <?php } ?>

    }

    <?php if($login==0){ ?>

      function noUserComment(){
        swal({
          title: "尚未登入",
          text: "登入後將享有系統的完整功能！要為您轉跳登入畫面嗎？",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
            document.location.href='<?php echo base_url('login'); ?>';
          }
        });
      }

    <?php }else{?>

      function userComment(object){
        var key = $(object).data("key");
        var num = $(object).data("num");
        var formValue = ($('#commentTextForm'+num).serializeArray())[0].value;
        if(formValue == ""){
          swal('錯誤','留言內容不可為空','error');
        }else{
          swal({
            title: "即將送出",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          }).then((willDelete) => {
            if (willDelete) {
              $.ajax({
                url: '<?php  echo base_url('service/addComment') ?>',
                dataType: 'text',
                type:'post',
                data: {content : formValue,
                       footprintKey: key},
                error:function(){
                    swal("錯誤", "連線失敗，請重新送出", "error");
                },
                success: function(data){
                  if(data == 0){
                    swal("錯誤", "留言內容不可為空", "error");
                  }else if (data == 1){
                    getContentAllComment(key,num);
                  }else if (data == 2){
                    swal("注意", "未知的錯誤，請稍後再試", "error");
                  }else if (data == 444){
                    swal({
                      title: '錯誤',
                      text: '本次連線驗證失敗，你沒有操作的權限。',
                      type: 'error',
                      showCancelButton: false,
                      confirmButtonColor: '#3085d6',
                      confirmButtonText: '確定',
                    }).catch(swal.noop).then(function () {
                      document.location.href='<?php echo base_url('home/logout'); ?>';
                    },function(dismiss){
                      if(dismiss==='esc'){
                        document.location.href='<?php echo base_url('home/logout'); ?>';
                      }else if(dismiss==='overlay'){
                        document.location.href='<?php echo base_url('home/logout'); ?>';
                      }
                    });
                  }
                }
              });
            }
          });
        }
      }

      function commentDel(key,object){
        var sfKey = $(object).data("key");
        var num = $(object).data("num");
        swal({
          title: "即將刪除",
          text: "刪除留言無法回覆，確認要刪除嗎？",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: '<?php  echo base_url('service/delComment') ?>',
              dataType: 'text',
              type:'post',
              data: {comentKey: key},
              error:function(){
                  swal("錯誤", "連線失敗，請重新送出", "error");
              },
              success: function(data){
                if(data == 0){
                  swal("注意", "未知的錯誤，請稍後再試", "error");
                }else if (data == 1){
                  getContentAllComment(sfKey,num); 
                }else if (data == 444){
                  swal({
                    title: '錯誤',
                    text: '本次連線驗證失敗，你沒有操作的權限。',
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: '確定',
                  }).catch(swal.noop).then(function () {
                    document.location.href='<?php echo base_url('home/logout'); ?>';
                  },function(dismiss){
                    if(dismiss==='esc'){
                      document.location.href='<?php echo base_url('home/logout'); ?>';
                    }else if(dismiss==='overlay'){
                      document.location.href='<?php echo base_url('home/logout'); ?>';
                    }
                  });
                }
              }
            });
          }
        });
      }

      function commentEdit (key,object){
        var sfKey = $(object).data("key");
        var num = $(object).data("num");
        $('#commentEditDiv').html('<button type="button" data-key="'+sfKey+'" data-num="'+num+'" class="btn btn-primary" id="editCommentSubmit" onclick="editCommentSubmit(\''+key+'\',this)">提交</button>');
        $.ajax({
          url: '<?php  echo base_url('service/getOneComment') ?>',
          dataType: 'json',
          type:'post',
          data: {comentKey: key},
          error:function(){
              swal("錯誤", "無法取得留言內容，請稍後再試", "error");
          },
          success: function(data){
            $('#editCommentInput').val(data['text']);
            $('#editCommentModal').modal('show');
          }
        });
      }

    <?php } ?>



    /*
        <div class="avatar-preview avatar-preview-32">
            <a href="#">
                <img src="<?php  ?>" alt="">
            </a>
        </div>

        <div class="tbl comment-row-item-header">
            <div class="tbl-row">
                <div class="tbl-cell tbl-cell-name">小花</div>
                <div class="tbl-cell tbl-cell-date">2017/07/15 19:00</div>
            </div>
        </div>

        <div class="comment-row-item-content">
            <p>很棒很棒！</p>
            <button type="button" class="comment-row-item-action edit">
                <i class="font-icon font-icon-pencil"></i>
            </button>
            <button type="button" class="comment-row-item-action del">
                <i class="font-icon font-icon-trash"></i>
            </button>
        </div>
    */
    

</script>