const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);

 // public function store(Request $request)
 //  {

// $input = $request->all();

    // parse_str($input['form'], $data);
    // for($i = 0; $i < count($data['field_value']); $i++)
    // {
    //   $type = isset($data['type'][$i])? trim($data['type'][$i]):"0";
    //   $field = isset($data['field'][$i])? trim($data['field'][$i]):"0";
    //   $field_value = isset($data['field_value'][$i])? trim($data['field_value'][$i]):"0";
    //   $month = isset($data['month'][$i])? trim($data['month'][$i]):"0";
    //   $year = isset($data['year'][$i])? trim($data['year'][$i]):"0";
    // }

    //   if(@empty($data['month'])){
    //         $status = array(
    //             "status"=>406,
    //             "msg"=>"Month is required!"
    //             );
    //             return $status;
    //       }
    //   if(@empty($data['year'])){
    //     $status = array(
    //         "status"=>406,
    //         "msg"=>"Year is required!"
    //         );
    //         return $status;
    //   }
    //   $DBstatus = DB::table('mm_demography')->insert(
    //     array( 
    //         'type' => $type,            
    //         'field' => $field,
    //         'field_value' => $field_value, 
    //         'month' => $month,
    //         'year' => $year,           
    //       )    
    //   );
        
    //   $this->recordEntryModifyDate(30);
          
    //   if($DBstatus){                
    //     return $status = array(
    //       "status"=>200,
    //       "msg"=>"Major entry has bee successfully updated"
    //     );
    //   }  
