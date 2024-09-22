<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {

        // Check if user is not logged in
        if (!session()->get('logged_in')) {
            // Redirect to login
            return redirect()->to('/SignIn');
        }

        // Check if role is not allowed
        if ($arguments && !in_array(session()->get('role'), $arguments)) {
            // Redirect to unauthorized page or home
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here if needed
    }
}
