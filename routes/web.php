<?php
	


	Route::get('/', function () {
	    return view('welcome');
	});

	Route::get('/hs', function(){
		$client = new HelloSign\Client('8797d3e57882596fd658bc8ce389c6bb1807adb9dfe20ed9512622363d4cb40b');
		$account = new HelloSign\Account;
		$account->setCallbackUrl('http://127.0.0.1:8000/callback');
		$response = $client->updateAccount($account);
		dd($response);
		// $SignatureRequest = $client->getSignatureRequests();
		// $SignatureRequest = $SignatureRequest->toArray();
		// for ($i=0; $i < count($SignatureRequest); $i++) { 
		// 	print_r($SignatureRequest[$i]['signatures']);	
		// }
		// dd($SignatureRequest);
		
		for ($i=0; $i < sizeof($SignatureRequest); $i++) { 
			// print_r($SignatureRequest[$i]['signature_request_id']);
			$client->getFiles($SignatureRequest[$i]['signature_request_id'], storage_path().'/hellosign/'.$SignatureRequest[$i]['title'].'.pdf');
		}
		dd('success');
		// $request = new HelloSign\SignatureRequest;
		// $request->enableTestMode();
		// $request->setTitle('Hello Sign Test');
		// $request->setSubject('Sign request');
		// $request->setMessage('Please Sign on the pdf.');
		// $request->addSigner('akash@soureeasy.com', 'akash', 0);
		// $request->addCC('akash@soureeasy.com');
		// $request->addFile('../Akash_Resume.pdf');
		// $request->addMetadata('custom_id', '1234');
		// $request->addMetadata('custom_text', 'NDA #9');
		// $response = $client->sendSignatureRequest($request);
		// dd($response);
	});
	Route::post('/callback', function(){
		return "asdlfjlasjdf";
	});
