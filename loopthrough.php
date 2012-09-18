<?
    $allFormFields = $hook->getValues(); 
//check to see if this is type 0 user submit
$type = base64_decode($allFormFields['type']);
if(!is_numeric($type)){
    return;
}else{
    if($type == 0){
        $url = $modx->makeUrl(13629);
        $modx->sendRedirect($url);
    }
}
//testing info
//$allFormFields['City'] = 'Anaheim';
//$allFormFields['state'] = 'California';
//$allFormFields['Country'] = 'United States';


//this is a business listing
//echo "<pre>";
//print_r($allFormFields);
//echo "</pre>";
$pid = base64_decode($allFormFields['pid']);
//check if we have the city 

$checkers = array('Country','state','City');
$opid = $pid;
$row['id'] = $pid;
//$row = TRUE;
foreach ($checkers as $key => $value) {
    $value = trim($value);
    if(empty($allFormFields[$value])){
        continue;
    }
    if($row == false){
        $newCity = TRUE;
        continue;
    }
    $c = $modx->newQuery('modResource');
    $c->select('id');
//    echo "Checking {$allFormFields[$value]} WITH PARENT {$row['modResource_id']}<br/>";
    $where = array('LOWER(pagetitle) ="'.strtolower($allFormFields[$value]).'"',
                    'parent'    =>  $row['id']);
                    
    $c->where($where);
    $c->limit(1);
    $stmt = $c->prepare();
//    echo $c->toSql();
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);   

}
//md5 pricing is calculated on number of child md5(ids * 9348378272)
if($newCity){
    //this city is not in our database we are going to be giving them base pricing
    $row['id'] = 13677;
}
//var_dump($childIds);

$url = $modx->makeUrl(28,'','req='.$row['id']);
$modx->sendRedirect($url);
return;
?>