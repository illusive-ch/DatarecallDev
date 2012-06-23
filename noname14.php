<?
if(isset($_GET)){
    $bad = array('base64,insert,update,select,union');
    foreach($_GET as $g){
        $g = strtolower($g);
        foreach($bad as $b){
            $b = strtolower($b);
            if(is_numeric(strrpos($g,$b))){
                return;
            }
        }
    }
}