<script type="text/javascript">
  $(document).ready(function(){
    $("select[name='xoops_theme_select']").addClass("form-control");
    $("input[name='query']").addClass("form-control");
    $("input[name='uname']").addClass("form-control");
    $("input[name='pass']").addClass("form-control");


    $('iframe:not([title])').attr('title','iframe content');

    <{php}>
      if(file_exists(XOOPS_ROOT_PATH."/modules/tadtools/mobile_device_detect.php")){
        include_once XOOPS_ROOT_PATH."/modules/tadtools/mobile_device_detect.php";
        $device=mobile_device_detect(true,false,true,true,true,true,true);
        echo "var mobile_device='{$device[0]}';";
      }else{
        echo "var mobile_device='';";
      }
    <{/php}>



  });
</script>

