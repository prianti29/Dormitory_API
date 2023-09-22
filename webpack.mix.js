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





		<div class="col-md-12 mt-4">
			<div class="card">				
				<div class="card-body pt-4 p-3">
					<h5 class="mb-0" style="font-size: 18px">Manual Entry</h5><hr>
					<form id="form" action="{{url('store-form')}}" method="post" enctype="multipart/form-data">	
						<div class="card-body">							
							<div class="row">							
							<h4 class="mb-0" style="font-size: 18px; padding-bottom: 10px; color: blue;">Major</h4>
							<input type="hidden" name="type[]" id="type[]" value="Major">
							<br>	
								<div class="col-sm-2">
									<div class="form-group">
										<label><span style="color: black"><b>CSE</b></span></label>
										<input type="hidden" name="field[]" id="field[]" value="CSE">
										<input type="number" name="field_value[]" id="field_value[]" class="form-control-input" value="">
										<span class="text-danger"  id="cse_error"></span>
									</div>						
								</div>
								
								<!-- <div class="col-sm-1"></div> -->
								<div class="col-sm-2">
									<div class="form-group">
										<label for="hqReview"><span style="color: black"><b>EEE</b></span></label>
										<input type="hidden" name="field[]" id="field[]" value="EEE">
										<input type="number" name="field_value[]" id="field_value[]" class="form-control-input" value="">
										<span class="text-danger"  id="eee_error"></span>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<label for="hqReview"><span style="color: black"><b>IT</b></span></label>
										<input type="hidden" name="field[]" id="field[]" value="IT">
										<input type="number" name="field_value[]" id="field_value[]" class="form-control-input" value="">
										<span class="text-danger"  id="it_error"></span>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<label for="hqReview"><span style="color: black"><b>Diploma</b></span></label>
										<input type="hidden" name="field[]" id="field[]" value="Diploma">
										<input type="number" name="field_value[]" id="field_value[]" class="form-control-input" value="">
										<span class="text-danger"  id="diploma_error"></span>
									</div>
								</div>
								<div class="col-sm-2" style="margin-right: 100px;">
									<div class="form-group">
										<label for="hqReview"><span style="color: black"><b>Others</b></span></label>
										<input type="hidden" name="field[]" id="field[]" value="Major Others">
										<input type="number" name="field_value[]" id="field_value[]" class="form-control-input" value="">
										<span class="text-danger"  id="major_others_error"></span>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<label for="hqReview"><span style="color: black"><b>Year</b><span style="color: red">&nbsp;*</span></span></label>
										<input type="number" min="2000" max="2999" name="year[]" id="year[]" class="form-control-input" value="">
										<span class="text-danger" id="year_error"></span>
									</div>
								</div>
								<div class="col-sm-2" style="margin-right: 34%;">
									<div class="form-group">
										<label for="hqReview"><span style="color: black"><b>Month</b><span style="color: red">&nbsp;*</span></span></label>
										<select  name="month[]" class="form-control-input" id="month[]">
											<option value="1">Jan</option>
											<option value="2">Feb</option>
											<option value="3">Mar</option>
											<option value="4">Apr</option>
											<option value="5">May</option>
											<option value="6">Jun</option>
											<option value="7">Jul</option>
											<option value="8">Aug</option>
											<option value="9">Sep</option>
											<option value="10">Oct</option>
											<option value="11">Nov</option>
											<option value="12">Dec</option>
										</select>				        
										<span class="text-danger" id="mar_error"></span>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group" style="margin-top: 33px;">
										<button type="submit" onclick="form_submit(event)" class="btn btn-info">submit</button>
									</div>
								</div>
							</div>
						</div>
						<!-- /.card-body -->
					</form>					
				</div>
			</div>
		</div>
		</div>
	</div>

</div>
