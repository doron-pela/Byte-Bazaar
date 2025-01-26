<?php
 
// Initialize cURL session to make the API request
$curl = curl_init();
  
// Set cURL options for the API request
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/:reference",  // Paystack transaction verification endpoint
    CURLOPT_RETURNTRANSFER => true,  // Return the response as a string
    CURLOPT_ENCODING => "",  // Accept any encoding
    CURLOPT_MAXREDIRS => 10,  // Max number of redirects allowed
    CURLOPT_TIMEOUT => 30,  // Set request timeout to 30 seconds
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,  // Use HTTP 1.1 for the request
    CURLOPT_CUSTOMREQUEST => "GET",  // Make a GET request
    CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer sk_test_9f0741282e3278aec2468a7d9320ff00a85423b7",  // Paystack test API key
        "Cache-Control: no-cache",  // Prevent caching of the request
    ),
));
  
// Execute the cURL request and store the response
$response = curl_exec($curl);
// Check for errors in the request
$err = curl_error($curl);

// Close the cURL session
curl_close($curl);
  
// Check if there was an error with the cURL request
if ($err) {
    // If error exists, display the error message
    echo "cURL Error #:" . $err;
} else {
    // If successful, display the response from the Paystack API
    echo $response;
}
?>
