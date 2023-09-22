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

 public function store(Request $request)
{
    $input = $request->all();
    
    // Assuming the data is passed in an array named 'entries'
    $entries = json_decode($input['form'], true);

    // Validate that 'entries' is an array and not empty
    if (!is_array($entries) || empty($entries)) {
        $status = [
            "status" => 406,
            "msg" => "Entries are required and should be an array."
        ];
        return $status;
    }

    $insertedData = [];

    foreach ($entries as $entry) {
        $type = isset($entry['type']) ? trim($entry['type']) : "0";
        $field = isset($entry['field']) ? trim($entry['field']) : "0";
        $field_value = isset($entry['field_value']) ? trim($entry['field_value']) : "0";
        $month = isset($entry['month']) ? trim($entry['month']) : "0";
        $year = isset($entry['year']) ? trim($entry['year']) : "0";

        // Insert each entry into the database
        $DBstatus = DB::table('mm_demography')->insert([
            'type' => $type,
            'field' => $field,
            'field_value' => $field_value,
            'month' => $month,
            'year' => $year,
        ]);

        if ($DBstatus) {
            $insertedData[] = $entry;
        }
    }

    $this->recordEntryModifyDate(30);

    if (!empty($insertedData)) {
        $status = [
            "status" => 200,
            "msg" => "Entries have been successfully updated",
            "insertedData" => $insertedData
        ];
        return $status;
    } else {
        $status = [
            "status" => 406,
            "msg" => "Failed to insert entries into the database"
        ];
        return $status;
    }
}
