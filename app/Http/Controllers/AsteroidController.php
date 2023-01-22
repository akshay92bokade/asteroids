<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;

class AsteroidController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // formatting and validating dates   --- start
        $sDate = date_create($request->start_date);
        $eDate = date_create($request->end_date);

        $diff=date_diff($sDate,$eDate);

        $difference = $diff->format("%R%a");

        if($difference < 0)
        {
            $error = "Start date must less than end date";
            return Redirect::back()->withErrors($error);
        }
        elseif($difference > 7) {
            $error = "Difference between dates must not be greater than 7 days";
            return Redirect::back()->withErrors($error);
        }

        $startDate = date_format($sDate,"Y-m-d");
        $endDate = date_format($eDate,"Y-m-d");
        // formatting and validating dates   --- end

        // getting data from API   --- start
        $dataEnc = "";
        $url = html_entity_decode('https://api.nasa.gov/neo/rest/v1/feed?start_date='.$startDate.'&end_date='.$endDate.'&api_key=DEMO_KEY');
        // echo $url;
        // exit;
        try {
            $dataEnc = file_get_contents($url);
        }
        
        catch(\Exception $e) {
            $error = $e->getMessage();
            return Redirect::back()->withErrors($error);
            exit();
        }
        

        $data = json_decode($dataEnc);
        // getting data from API   --- end

        // dd($data);
        // finding fastest, closest, avg size asteroid   --- start
        $fastestDate = "";
        $fastestSpeed = 0;
        $fastestId = 0;

        $closestDate = "";
        $closestDis = 0;
        $closestId = 0;

        $sizeArray = [];

        $dates = [];
        $count = [];

        foreach($data->near_earth_objects as $k => $v) {

            $dates[] = $k;
            $count[] = sizeof($v);

            foreach($v as $f) {
                $sizeArray[] = $f->estimated_diameter->kilometers->estimated_diameter_max;

                // for fastest
                if($f->close_approach_data[0]->relative_velocity->kilometers_per_hour > $fastestSpeed) {
                    $fastestSpeed = $f->close_approach_data[0]->relative_velocity->kilometers_per_hour;
                    $fastestDate = $k;
                    $fastestId = $f->id;
                }

                // for closest
                if($f->close_approach_data[0]->miss_distance->kilometers < $closestDis || $closestDis == 0) {
                    $closestDis = $f->close_approach_data[0]->miss_distance->kilometers;
                    $closestDate = $k;
                    $closestId = $f->id;
                }
            }

            // dd($k,$v[0]->close_approach_data[0]->relative_velocity->kilometers_per_hour);
        }

        $fastest = [
            'id' => $fastestId,
            'speed' => $fastestSpeed,
            'date' => $fastestDate,
        ];

        $closest = [
            'id' => $closestId,
            'distance' => $closestDis,
            'date' => $closestDate,
        ];

        $size = array_filter($sizeArray);
        $avgSize = 0;
        if(count($size)) {
            $avgSize = array_sum($size)/count($size);
        }

        // finding fastest, closest, avg size asteroid   --- end

        return view('asteroid',compact("fastest", "closest", "avgSize", "dates", "count"));

        // dd($fastest, $closest, $sizeArray, $avgSize);
    }
}
