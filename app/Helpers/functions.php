<?php
use Illuminate\Support\Facades\DB;
use App\Option;

function payTypes(){

    return array(
        'hourly'    => 'Hourlyyy',
        'monthly'   => 'Monthly',
        'contract'  => 'Contract'
    );
}

function socialite_config($name,$returnType)
{
	$option = Option::where([
	    ['title', '=', $name],
	    ['key', '=', $returnType]
	])->first();
	if($option)
	{
		return $option->value;
	}
	
}
function cm_to_inches($cm) {
    return $cm * 0.393701;
}
function kg_to_pounds($ounces){
    return $ounces * 2.20462;
}
function pounds_to_ounces($pounds) {
  return $pounds * 16;
}
function ounces_to_pounds($ounces) {
    return floatval($ounces) * 0.0625;
}
function removeSpecialChar($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

    return $string = str_replace('-', ' ', $string);
}
// function getAramexRate($country, $weight){
//        $weight = ceil($weight);
//         $country=strtoupper($country);
//           $result=AramexRate::where('country',$country)->first();
//           if($weight>1){
//             $remain=$weight-1;
//             $p1=$result['first_pound'];
//             $p2=$result['per_pound'] * $remain;
//             $rates['aramex_rate']=$p1 + $p2;
//           }else if($weight!=0||$weight!=""){
//             $rates['aramex_rate']=$result['first_pound'];
//           }
//           if($weight>2){
//             $rates['aramex_rate'] = getWithTax($rates['aramex_rate'],"Aramax_Express");
//           }else{
//             $rates['aramex_rate'] = addFuelSurcharges($rates['aramex_rate'],"Aramax_Express");
//           }
//           return number_format($rates['aramex_rate'], 2);
// }
// function getWithTax($price,$company){
//   if(is_string($price)==false){
//     $data = DB::table('shipping_taxes')->select('*')->where('company','=',$company)->first();
//     $rate = calculatePercentage($price, $data->fuel_surcharges);
//     $rate = calculatePercentage($rate, $data->tax_percentage);
//     return $rate;
//   }else{
//     return 0;
//   }
// }

?>