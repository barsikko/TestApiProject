<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class UnitNotFoundException extends Exception
{
     /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json('No such product with this parameters, try again', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

}
