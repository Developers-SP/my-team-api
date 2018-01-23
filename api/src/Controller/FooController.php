<?php
 
namespace App\Controller;
 
use RestApi\Controller\ApiController;
 
/**
 * Foo Controller
 *
 */
class FooController extends ApiController
{
 
    /**
     * bar method
     *
     * @return Response|null
     */
    public function bar()
	{
	    // movie list
	    $movies = [
	        'Captain America: Civil War',
	        'The Wave',
	        'Deadpool'
	    ];
	 
	    $this->apiResponse['movies'] = $movies;
	}
}