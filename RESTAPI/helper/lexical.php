<?php


function getApiFunctions($file_path)
{
    // Read the file contents
    $file_contents = file_get_contents($file_path);

    // Define regular expression pattern to match function declarations
    $pattern = '/\bfunction\s+([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*\(/';

    // Initialize an array to store function names
    $function_names = array();

    // Search for matches
    if (preg_match_all($pattern, $file_contents, $matches)) {
        // Add matched function names to the array
        $function_names = $matches[1];
    }

    return $function_names;
}

function getFillableColumns($file_path, $function_name)
{
    // Read the file contents
    $file_contents = file_get_contents($file_path);

    // Define regular expression pattern to match the function definition
    $pattern = '/function\s+' . preg_quote($function_name) . '\s*\((.*?)\)\s*{([^}]+)}/s';

    // Initialize an array to store fillable variables
    $fillable_variables = [];

    // Search for matches
    if (preg_match($pattern, $file_contents, $matches)) {
        // Extract the content within the function definition
        $function_content = $matches[2];

        // Define regular expression pattern to match $fillable assignment
        $fillable_pattern = '/\$fillable\s*=\s*\[(.*?)\]/s';

        // Search for matches
        if (preg_match($fillable_pattern, $function_content, $fillable_matches)) {
            // Extract fillable variables
            $fillable_content = $fillable_matches[1];

            // Split the content by comma and remove any surrounding whitespace
            $fillable_variables = array_map('trim', explode(',', $fillable_content));
        }
    }

    return $fillable_variables;

}

function getApiHeaders($file_path, $function_name)
{
    // Read the file contents
    $file_contents = file_get_contents($file_path);

    // Define regular expression pattern to match the function definition
    $pattern = '/function\s+' . preg_quote($function_name) . '\s*\((.*?)\)\s*{([^}]+)}/s';

    // Initialize an array to store fillable variables
    $fillable_variables = [];

    // Search for matches
    if (preg_match($pattern, $file_contents, $matches)) {
        // Extract the content within the function definition
        $function_content = $matches[2];

        // Define regular expression pattern to match $params  assignment
        $fillable_pattern = '/\$headers\s*=\s*\[(.*?)\]/s';
         //$params=[];
        // Search for matches
        if (preg_match($fillable_pattern, $function_content, $fillable_matches)) {
            // Extract fillable variables
            $fillable_content = $fillable_matches[1];

            // Split the content by comma and remove any surrounding whitespace
            $fillable_variables = array_map('trim', explode(',', $fillable_content));
        }
    }

    return $fillable_variables;

}


function getApiparams($file_path, $function_name)
{
    // Read the file contents
    $file_contents = file_get_contents($file_path);

    // Define regular expression pattern to match the function definition
    $pattern = '/function\s+' . preg_quote($function_name) . '\s*\((.*?)\)\s*{([^}]+)}/s';

    // Initialize an array to store fillable variables
    $fillable_variables = [];

    // Search for matches
    if (preg_match($pattern, $file_contents, $matches)) {
        // Extract the content within the function definition
        $function_content = $matches[2];

        // Define regular expression pattern to match $params  assignment
        $fillable_pattern = '/\$params\s*=\s*\[(.*?)\]/s';
         //$params=[];
        // Search for matches
        if (preg_match($fillable_pattern, $function_content, $fillable_matches)) {
            // Extract fillable variables
            $fillable_content = $fillable_matches[1];

            // Split the content by comma and remove any surrounding whitespace
            $fillable_variables = array_map('trim', explode(',', $fillable_content));
        }
    }

    return $fillable_variables;

}


function getApiResponse($file_path, $function_name)
{
    // Read the file contents
    $file_contents = file_get_contents($file_path);

    // Define regular expression pattern to match the function definition
    $pattern = '/function\s+' . preg_quote($function_name) . '\s*\((.*?)\)\s*{([^}]+)}/s';

    // Initialize an array to store fillable variables
    $fillable_variables = [];

    // Search for matches
    if (preg_match($pattern, $file_contents, $matches)) {
        // Extract the content within the function definition
        $function_content = $matches[2];

        // Define regular expression pattern to match $fillable assignment
        $fillable_pattern = '/\$response\s*=\s*\[(.*?)\]/s';

        // Search for matches
        if (preg_match($fillable_pattern, $function_content, $fillable_matches)) {
            // Extract fillable variables
            $fillable_content = $fillable_matches[1];

            // Split the content by comma and remove any surrounding whitespace
            $fillable_variables = array_map('trim', explode(',', $fillable_content));
        }
    }

    return $fillable_variables;

}