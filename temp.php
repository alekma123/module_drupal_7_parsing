<?php
$newReviews = array(
 array(
  "title" => "Valizhan Kuldashev",
  "date" => "11 февраля"
 ),
 array(
  "title" => "Евгений Попков",
  "date" => "29 ноября 2021"
 )
);
  $query = db_select('node', 'n');
  $query->innerJoin('field_data_field_date_created_review', 'dcr', 'n.vid = dcr.entity_id'); 
  $query->fields('n', array('title'));
  $query->fields('dcr', array('field_date_created_review_value'));
  $resQuery = $query->execute()->fetchAll();

$resQuery = convertToArray($resQuery);
 foreach ($newReviews as $key => $nd) { 
     echo $nd["title"].":".$nd["date"].";"."\n";
     if (in_array(array("title" => "Valizhan Kuldashev", "field_date_created_review_value" => "11 февраля" ), $resQuery) ) {
            echo "founded!\n";
         };
  }

  dpm($newReviews);
  dpm($resQuery);


 
function convertToArray($arrayNodes) {
  $result = array();
  foreach ($arrayNodes as $object)
  {
     $result[] = (array) $object;
  }
  return $result;
};
?>