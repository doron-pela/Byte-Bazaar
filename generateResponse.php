<?php


require __DIR__ . '/vendor/autoload.php'; // remove this line if you use a PHP Framework.

use Orhanerday\OpenAi\OpenAi;

$open_ai = new OpenAi('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');

$complete = $open_ai->completion([
    'model' => 'gpt-3.5-turbo-instruct',
    'prompt' => 'What is programming',
    'temperature' => 0.9,
    'max_tokens' => 150,
    'frequency_penalty' => 0,
    'presence_penalty' => 0.6,
 ]);
 
 if($complete!= null){
    $php_obj = json_decode($complete);
    var_dump($complete); // Show raw response from the API
    exit();
 }

 
?>