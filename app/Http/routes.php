<?php
	use App\Http\Requests;

	


	Route::get('/', function () {
	    return view('welcome');
	});

	Route::get('/getPdf', function(){
		$client = new HelloSign\Client('5d787d73dffc85b79b4fdf960fa36751dfa62da2662bdebb95a94854020e953a');
		try {
			$SignatureRequest = $client->getSignatureRequests();
			$SignatureRequest = $SignatureRequest->toArray();
			for ($i=0; $i < sizeof($SignatureRequest); $i++) { 
				$client->getFiles($SignatureRequest[$i]['signature_request_id'], storage_path().'/hellosign/'.$SignatureRequest[$i]['title'].'.pdf');
			}
			dd($SignatureRequest);
		} catch (Exception $e) {
			dd("Failed to get signrequest");
		}
			
		
	});


	Route::post('/testCallback', function(Request $request){
	//	$account = new HelloSign\Account;
	//	$account->setCallbackUrl('http://127.0.0.1:8000/callback');
	//	$response = $client->updateAccount($account);
	//	dd($response);
		dd($request);
	});

	Route::get('/srtemp', function(){
		$client = new HelloSign\Client('5d787d73dffc85b79b4fdf960fa36751dfa62da2662bdebb95a94854020e953a');
		$request = new HelloSign\TemplateSignatureRequest;
		$request->enableTestMode();
		// $request->setTemplateId('42b20e4ad6452f2cba3d574ce99e5e883ce893d5');
		$request->setTitle('algo');
		$request->setSubject('Sign request');
		$request->setMessage('Please Sign on the pdf.');
		$request->setSigner('akash', 'akash@sourceeasy.com',0);
		$request->addFile('../test.pdf');
		$request->addMetadata('custom_id', 'Content id');
		$request->addMetadata('custom_text', 'Content Text');
		// $client_id = '2289998783e6934d615b2673edeaf807';
		$embedded_request = new HelloSign\EmbeddedSignatureRequest($request, $client_id);
		$response = $client->createEmbeddedSignatureRequest($embedded_request);
		dd($response);
	});

	Route::get('/signrequest',function(){
		$client = new HelloSign\Client('5d787d73dffc85b79b4fdf960fa36751dfa62da2662bdebb95a94854020e953a');
		$request = new HelloSign\SignatureRequest;
		$request->enableTestMode();
		$request->setTitle('algo');
		$request->setSubject('Sign request without template');
		$request->setMessage('Please sign this pdf ');
		$request->addSigner('akash@sourceeasy.com', 'akash', 0);
		$request->addSigner(new HelloSign\Signer(array(
		    'name' => 'Probir Gayen',
		    'email_address' => 'probir@sourceeasy.com',
		    'order' => 1
		)));
		$request->addCC('akashsharma.cse2016@sourceeasy.com');
		$request->addFile('../test.pdf');
		$request->addMetadata('custom_id', '1234');
		$request->addMetadata('custom_text', 'custom_text');
		$response = $client->sendSignatureRequest($request);
		dd($response);
	});
