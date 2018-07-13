<?php
/**
 * @Author: Aleksandr Morgun
 * @Email:  a.morgun@2-up.ru
 * @Date:   2017-08-04 21:48:50
 * @Last Modified by:   Aleksandr Morgun
 * @Last Modified time: 2017-08-08 14:37:53
 */
namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        $apiErrors = [];
        foreach ($errors as $field => $message) {
            if (is_array($message)) {
                foreach ($message as $msg) {
                    $apiErrors[] = make_error('validation', $msg, ['field' => $field]);
                }
            }
            else {
                $apiErrors[] = make_error('validation', $message, ['field' => $field]);
            }
        }
        return response($apiErrors, 422);
    }

}
