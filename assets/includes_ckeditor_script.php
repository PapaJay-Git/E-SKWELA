<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};
 ?>
<script src="../assets/ckeditor/ckeditor.js"></script>
<script>
//text max length for text area ckeditor
    window.onload = function() {
        CKEDITOR.instances.mytext.on('key',function(event){
            var deleteKey = 46;
            var backspaceKey = 8;
            var keyCode = event.data.keyCode;
            if (keyCode === deleteKey || keyCode === backspaceKey)
                return true;
            else
            {
                var textLimit = 2500;
                var str = CKEDITOR.instances.mytext.getData();
                if (str.length >= textLimit)
                    return false;
            }
        });
    };
</script>
