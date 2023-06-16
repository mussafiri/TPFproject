//validation ajax

$(document).ready(function(){
    // Listen for form submission event on the form element
    $('#myForm').on('submit', function(event){
        // Prevent the default form submission behaviour
        event.preventDefault();
        
        // Loop through the dynamic inputs
        $('.typehead').each(function(index, element){
            // Validate each input using Laravel's Form Request validation
            $.ajax({
                url: '/validate',
                type: 'POST',
                data: {
                    'rak': $(element).val(),
                    '_token': $('input[name="_token"]').val()
                },
                success: function(response){
                    // If the validation is successful, remove any previous error messages
                    $(element).removeClass('is-invalid');
                    $(element).next('.invalid-feedback').remove();
                },
                error: function(xhr){
                    // If the validation fails, display the error message next to the corresponding input
                    var errors = xhr.responseJSON.errors;
                    $(element).addClass('is-invalid');
                    $(element).after('<div class="invalid-feedback">' + errors.rak[0] + '</div>');
                }
            });
        });
        
        // If all the inputs pass the validation, submit the form
        if($('.typehead.is-invalid').length === 0){
            $(this).unbind('submit').submit();
        }
    });
});

// controller
public function yourControllerMethod(Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'age' => 'required|numeric|between:18,120',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    } else {
        // logic for successful validation
    }
}

