<?php
$output = '';
$prop =& $scriptProperties;
print_r($prop);

if(!isset($prop['company_id']) or empty($prop['company_id']) OR !is_numeric($prop['company_id']))
    return $output;

$quip = $modx->getService('quip','Quip',$modx->getOption('quip.core_path',null,$modx->getOption('core_path').'components/quip/').'model/quip/',$scriptProperties);
if (!($quip instanceof Quip)) return $output;
$quip->initialize($modx->context->get('key'));

$c = $modx->newQuery('quipComment');

$c->innerJoin('quipThread','Thread');
$c->leftJoin('modResource','Resource');
$c->where(array(
    'quipComment.resource' => 6,
    'quipComment.deleted' => false,
));

$c->andCondition(array(
    'quipComment.approved' => true,
),null,2);
$c->select(array('total_active' => 'sum(star_total)','total' => 'count(quipComment.id)'));
$stmt = $c->prepare();
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();
$output = $row['total_active'] / $row['total'];
return $output;